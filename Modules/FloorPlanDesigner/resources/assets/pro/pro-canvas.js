
(() => {
  const state = {
    grid: 20,
    items: [],    // [{id,type:'table'|'chair'|'zone'|'door'|..., x,y,w,h, r, points:[], meta:{name,cap,status}, layer: n}]
    selection: new Set(),
    history: [],
    future: [],
    dragging: null,
    resizing: null,
    rotating: null,
    mode: 'select',
    hoverId: null,
    pan:{x:0,y:0}, zoom:1
  };

  const canvas = document.getElementById('canvas');
  const ctx = canvas.getContext('2d');
  const panel = document.getElementById('props');
  const layersList = document.getElementById('layers');
  const statusPre = document.getElementById('state');
  const snap = v => Math.round(v / state.grid) * state.grid;

  function uid() { return 'i' + Math.random().toString(36).slice(2,9); }

  function pushHistory() {
    state.history.push(JSON.stringify({items: state.items}));
    state.future = [];
  }

  function undo() {
    if (!state.history.length) return;
    state.future.push(JSON.stringify({items: state.items}));
    const prev = JSON.parse(state.history.pop());
    state.items = prev.items;
    draw(); syncPanels();
  }

  function redo() {
    if (!state.future.length) return;
    state.history.push(JSON.stringify({items: state.items}));
    const next = JSON.parse(state.future.pop());
    state.items = next.items;
    draw(); syncPanels();
  }

  function addItem(type) {
    pushHistory();
    const id = uid();
    const base = { id, type, x: snap(60), y: snap(60), w: 80, h: 60, r: 0, layer: state.items.length, meta: { name: type, cap: 2, status: 'available' } };
    if (type === 'zone') {
      base.points = [{x: snap(50), y: snap(50)}, {x: snap(150), y: snap(50)}, {x: snap(150), y: snap(130)}, {x: snap(50), y: snap(130)}];
    }
    state.items.push(base);
    state.selection = new Set([id]);
    draw(); syncPanels();
  }

  function removeSelection() {
    if (!state.selection.size) return;
    pushHistory();
    state.items = state.items.filter(it => !state.selection.has(it.id));
    state.selection.clear();
    draw(); syncPanels();
  }

  function getById(id) { return state.items.find(i => i.id === id); }

  function drawGrid() {
    const step = state.grid, w = canvas.width, h = canvas.height;
    ctx.save();
    ctx.clearRect(0,0,w,h);
    ctx.fillStyle = '#ffffff'; ctx.fillRect(0,0,w,h);
    ctx.strokeStyle = '#eee'; ctx.lineWidth = 1;
    for (let x=0; x<w; x+=step) { ctx.beginPath(); ctx.moveTo(x,0); ctx.lineTo(x,h); ctx.stroke(); }
    for (let y=0; y<h; y+=step) { ctx.beginPath(); ctx.moveTo(0,y); ctx.lineTo(w,y); ctx.stroke(); }
    ctx.restore();
  }

  function drawItem(it) {
    ctx.save();
    ctx.translate(it.x + it.w/2, it.y + it.h/2);
    ctx.rotate(it.r * Math.PI/180);
    const sel = state.selection.has(it.id);
    if (it.type === 'zone' && Array.isArray(it.points)) {
      ctx.beginPath();
      for (let i=0; i<it.points.length; i++) {
        const p = it.points[i];
        ctx[i?'lineTo':'moveTo'](p.x - it.x - it.w/2, p.y - it.y - it.h/2);
      }
      ctx.closePath();
      ctx.fillStyle = sel ? 'rgba(0, 150, 255, 0.15)' : 'rgba(0,0,0,0.06)';
      ctx.fill();
      ctx.lineWidth = 2; ctx.strokeStyle = sel ? '#0ea5e9' : '#444';
      ctx.stroke();
    } else {
      const st = (it.meta && it.meta.status) || 'available';
      const color = st==='occupied' ? 'rgba(239,68,68,0.2)' : (st==='in-progress' ? 'rgba(59,130,246,0.2)' : 'rgba(34,197,94,0.2)');
      ctx.fillStyle = sel ? 'rgba(14,165,233,0.15)' : color;
      ctx.strokeStyle = sel ? '#0ea5e9' : '#333';
      ctx.lineWidth = 2;
      ctx.beginPath();
      ctx.rect(-it.w/2, -it.h/2, it.w, it.h);
      ctx.fill(); ctx.stroke();
      ctx.fillStyle = '#111';
      ctx.font = '12px sans-serif';
      ctx.textAlign = 'center';
      ctx.fillText(it.meta?.name || it.type, 0, 4);
    }
    // handles
    if (sel) {
      // resize corners
      const hs = 6;
      const corners = [[-it.w/2, -it.h/2],[it.w/2, -it.h/2],[it.w/2,it.h/2],[-it.w/2,it.h/2]];
      ctx.fillStyle = '#0ea5e9';
      for (const [cx,cy] of corners) { ctx.fillRect(cx-hs, cy-hs, hs*2, hs*2); }
      // rotate handle (top-center)
      ctx.beginPath();
      ctx.arc(0, -it.h/2-16, 5, 0, Math.PI*2);
      ctx.fill();
    }
    ctx.restore();
  }

  function draw() {
    drawGrid();
    // by layer
    [...state.items].sort((a,b)=>a.layer-b.layer).forEach(drawItem);
    statusPre.textContent = JSON.stringify({items: state.items}, null, 2);
  }

  function hitTest(x,y) {
    // return top-most item id under point
    for (const it of [...state.items].sort((a,b)=>b.layer-a.layer)) {
      // transform point into item's local coords (inverse rotation)
      const cx = it.x + it.w/2, cy = it.y + it.h/2;
      const dx = x - cx, dy = y - cy;
      const ang = -it.r * Math.PI/180;
      const rx = dx*Math.cos(ang) - dy*Math.sin(ang);
      const ry = dx*Math.sin(ang) + dy*Math.cos(ang);
      if (it.type === 'zone' && Array.isArray(it.points)) {
        // simple bbox for hit perf
        const minx = Math.min(...it.points.map(p=>p.x)) - it.x - it.w/2;
        const maxx = Math.max(...it.points.map(p=>p.x)) - it.x - it.w/2;
        const miny = Math.min(...it.points.map(p=>p.y)) - it.y - it.h/2;
        const maxy = Math.max(...it.points.map(p=>p.y)) - it.y - it.h/2;
        if (rx>=minx && rx<=maxx && ry>=miny && ry<=maxy) return it.id;
      } else {
        if (rx >= -it.w/2 && rx <= it.w/2 && ry >= -it.h/2 && ry <= it.h/2) return it.id;
      }
    }
    return null;
  }

  function mousePos(e) {
    const r = canvas.getBoundingClientRect();
    return { x: e.clientX - r.left, y: e.clientY - r.top };
  }

  // Mouse interaction
  let start = null;
  canvas.addEventListener('mousedown', (e) => {
    const {x,y} = mousePos(e);
    const id = hitTest(x,y);
    if (id) {
      if (!e.shiftKey && !state.selection.has(id)) state.selection = new Set([id]);
      if (e.shiftKey && state.selection.has(id)) state.selection.delete(id);
      else if (e.shiftKey) state.selection.add(id);
      start = {x,y, items: [...state.selection].map(sid => ({sid, ...getById(sid) && {}}))};
      state.dragging = { x0:x, y0:y, initial: [...state.selection].map(sid => ({ sid, ox: getById(sid).x, oy: getById(sid).y })) };
      pushHistory();
    } else {
      state.selection.clear();
    }
    draw(); syncPanels();
  });

  canvas.addEventListener('mousemove', (e) => {
    if (!state.dragging) return;
    const {x,y} = mousePos(e);
    const dx = snap(x - state.dragging.x0), dy = snap(y - state.dragging.y0);
    for (const sel of state.dragging.initial) {
      const it = getById(sel.sid);
      it.x = snap(sel.ox + dx);
      it.y = snap(sel.oy + dy);
    }
    draw(); syncPanels();
  });

  window.addEventListener('mouseup', () => { state.dragging=null; state.resizing=null; state.rotating=null; });

  // Keyboard
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Delete') { removeSelection(); }
    if ((e.ctrlKey||e.metaKey) && e.key.toLowerCase()==='z') { e.shiftKey?redo():undo(); }
    if ((e.ctrlKey||e.metaKey) && e.key.toLowerCase()==='y') { redo(); }
    if (['ArrowUp','ArrowDown','ArrowLeft','ArrowRight'].includes(e.key) && state.selection.size) {
      e.preventDefault();
      pushHistory();
      const delta = (e.shiftKey?10:1);
      for (const sid of state.selection) {
        const it = getById(sid);
        if (e.key==='ArrowUp') it.y = snap(it.y - delta);
        if (e.key==='ArrowDown') it.y = snap(it.y + delta);
        if (e.key==='ArrowLeft') it.x = snap(it.x - delta);
        if (e.key==='ArrowRight') it.x = snap(it.x + delta);
      }
      draw(); syncPanels();
    }
  });

  // Sidebar buttons
  document.querySelectorAll('[data-add]').forEach(btn => {
    btn.addEventListener('click', () => addItem(btn.dataset.add));
  });

  document.getElementById('exportSvg').onclick = () => {
    const svg = renderSVG(state.items, canvas.width, canvas.height);
    const blob = new Blob([svg], {type:'image/svg+xml'});
    downloadBlob(blob, 'floorplan.svg');
  };

  document.getElementById('exportPng').onclick = () => {
    const link = document.createElement('a');
    link.download = 'floorplan.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
  };

  function renderSVG(items, w, h) {
    const esc = s => String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;');
    let out = [`<svg xmlns="http://www.w3.org/2000/svg" width="${w}" height="${h}">`];
    out.push(`<rect width="100%" height="100%" fill="white"/>`);
    for (const it of [...items].sort((a,b)=>a.layer-b.layer)) {
      const tr = `transform="translate(${it.x+it.w/2} ${it.y+it.h/2}) rotate(${it.r})"`;
      if (it.type==='zone' && Array.isArray(it.points)) {
        const pts = it.points.map(p => `${p.x - it.x - it.w/2},${p.y - it.y - it.h/2}`).join(' ');
        out.push(`<g ${tr}><polygon points="${esc(pts)}" fill="#f2f2f2" stroke="#333"/></g>`);
      } else {
        out.push(`<g ${tr}><rect x="${-it.w/2}" y="${-it.h/2}" width="${it.w}" height="${it.h}" fill="#f2f2f2" stroke="#333"/></g>`);
      }
    }
    out.push('</svg>');
    return out.join('');
  }

  function downloadBlob(blob, filename) {
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
    URL.revokeObjectURL(link.href);
  }

  // Properties panel & layers
  function syncPanels() {
    // Layers
    layersList.innerHTML = '';
    [...state.items].sort((a,b)=>a.layer-b.layer).forEach(it => {
      const li = document.createElement('li');
      li.className = 'flex items-center justify-between py-1';
      const chk = document.createElement('input');
      chk.type='checkbox'; chk.checked = state.selection.has(it.id);
      chk.onchange = () => {
        if (chk.checked) state.selection.add(it.id); else state.selection.delete(it.id);
        draw();
      };
      const span = document.createElement('span');
      span.textContent = `${it.layer}: ${it.meta?.name || it.type}`;
      li.appendChild(chk); li.appendChild(span);
      layersList.appendChild(li);
    });

    // Props – show first selected
    panel.innerHTML = '';
    const firstId = state.selection.values().next().value;
    if (!firstId) return;
    const it = getById(firstId);
    const fields = [
      ['name', it.meta?.name || ''],
      ['cap', it.meta?.cap ?? 2],
      ['status', it.meta?.status || 'available'],
      ['x', it.x], ['y', it.y], ['w', it.w], ['h', it.h], ['r', it.r],
      ['layer', it.layer],
    ];
    fields.forEach(([k,v]) => {
      const wrap = document.createElement('div'); wrap.className='mb-2';
      const label = document.createElement('label'); label.textContent = k; label.className='text-xs block';
      const inp = document.createElement('input'); inp.className='border rounded px-2 py-1 w-full text-sm'; inp.value = v;
      inp.onchange = () => {
        pushHistory();
        if (['x','y','w','h','r','layer','cap'].includes(k)) {
          const num = +inp.value;
          if (k==='cap') it.meta.cap = num;
          else if (k==='layer') it.layer = num|0;
          else it[k] = num|0;
        } else if (k==='status') { it.meta.status = String(inp.value); }
        else { it.meta.name = String(inp.value); }
        draw(); syncPanels();
      };
      wrap.appendChild(label); wrap.appendChild(inp);
      panel.appendChild(wrap);
    });
  }

  // Save
  document.getElementById('saveBtn').onclick = async () => {
    const planId = new URLSearchParams(location.search).get('id');
    if(!planId){ alert('Missing ?id=<plan-id>'); return; }
    const body = { items: state.items.map(it => ({
      id: it.id || null,
      type: it.type,
      name: it.meta?.name || it.type,
      capacity: it.meta?.cap ?? 2,
      status: it.meta?.status || 'available',
      x: Math.round(it.x), y: Math.round(it.y), w: Math.round(it.w||80), h: Math.round(it.h||60),
      r: Math.round(it.r||0), layer: it.layer||0,
      pos_table_id: it.meta?.pos_table_id || null,
      meta: it.meta || {}
    })) };
    const res = await fetch(`/api/v1/floorplan/${planId}/furniture/batch`, {
      method: 'PATCH', headers:{'Content-Type':'application/json'}, body: JSON.stringify(body)
    });
    alert('Saved: ' + res.status);
  };

  // Load existing data if present (via hidden pre tag)
  try {
    const planIdL = new URLSearchParams(location.search).get('id');
    if(planIdL){
      try{
        const res = await fetch(`/api/v1/floorplan/${planIdL}/furniture`);
        const json = await res.json();
        state.items = (json.data||[]).map(f => ({ id: f.id, type: f.type, x: f.x, y: f.y, w: f.w, h: f.h, r: f.r, layer: f.layer, meta: Object.assign({name:f.name, cap:f.capacity, status:f.status, pos_table_id:f.pos_table_id}, f.meta||{}) }));
      }catch(e){}
    }
  } catch (e) {}

  // Hook buttons
  document.getElementById('undoBtn').onclick = undo;
  document.getElementById('redoBtn').onclick = redo;
  document.getElementById('deleteBtn').onclick = removeSelection;

  draw(); syncPanels();
})();


  // Enterprise+ overlay polling
  async function pollOverlay(){
    const planId = new URLSearchParams(location.search).get('id');
    if(!planId) return;
    try{
      const res = await fetch(`/api/v1/floorplan/${planId}/overlay`);
      const json = await res.json();
      const byId = Object.fromEntries(state.items.map(it=>[it.id,it]));
      (json.data||[]).forEach(f=>{
        const it = byId[f.id] || state.items.find(x=>x.meta?.pos_table_id===f.pos_table_id);
        if (!it) return;
        it.meta = Object.assign({}, it.meta||{}, { name:f.name, cap:f.capacity, status:f.status, pos_table_id:f.pos_table_id, qr_url:f.qr_url });
      });
      draw(); syncPanels();
    }catch(e){}
    setTimeout(pollOverlay, 5000);
  }
  pollOverlay();

  // Color by status inside drawItem
