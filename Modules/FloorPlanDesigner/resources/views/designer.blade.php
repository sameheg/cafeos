<div class="p-6 w-full h-full">
  <h1 class="text-2xl font-semibold mb-4">Floorplan Designer (Pro)</h1>
  <div class="flex gap-4 h-[700px]">
    <!-- Sidebar Palette -->
    <div class="w-48 border rounded p-2 overflow-y-auto bg-gray-50">
      <h2 class="font-bold mb-2">Palette</h2>
      <div class="space-y-2">
        <div draggable="true" class="cursor-move p-2 bg-white border rounded" data-type="table">Table</div>
        <div draggable="true" class="cursor-move p-2 bg-white border rounded" data-type="chair">Chair</div>
        <div draggable="true" class="cursor-move p-2 bg-white border rounded" data-type="bar">Bar</div>
        <div draggable="true" class="cursor-move p-2 bg-white border rounded" data-type="door">Door</div>
        <div draggable="true" class="cursor-move p-2 bg-white border rounded" data-type="stairs">Stairs</div>
      </div>
    </div>
    <!-- Canvas Area -->
    <div class="flex-1 relative border rounded bg-white">
      <canvas id="canvas" width="1000" height="700" class="w-full h-full"></canvas>
    </div>
    <!-- Properties Panel -->
    <div class="w-64 border rounded p-2 bg-gray-50 overflow-y-auto">
      <h2 class="font-bold mb-2">Properties</h2>
      <div id="properties" class="text-sm text-gray-700">Select an element…</div>
      <hr class="my-2">
      <div class="flex flex-col gap-2">
        <button id="undoBtn" class="px-2 py-1 border rounded">Undo</button>
        <button id="redoBtn" class="px-2 py-1 border rounded">Redo</button>
        <button id="exportSvgBtn" class="px-2 py-1 border rounded">Export SVG</button>
        <button id="exportPngBtn" class="px-2 py-1 border rounded">Export PNG</button>
        <button id="saveBtn" class="px-2 py-1 border rounded bg-green-100">Save Plan</button>
      </div>
    </div>
  </div>

  <script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const gridSize = 20;
    let elements = [];
    let history = [];
    let future = [];
    let selected = null;

    function pushHistory(){
      history.push(JSON.stringify(elements));
      if(history.length > 50) history.shift();
      future = [];
    }

    function draw(){
      ctx.clearRect(0,0,canvas.width,canvas.height);
      // Grid
      ctx.strokeStyle = '#eee';
      for(let x=0;x<canvas.width;x+=gridSize){
        ctx.beginPath(); ctx.moveTo(x,0); ctx.lineTo(x,canvas.height); ctx.stroke();
      }
      for(let y=0;y<canvas.height;y+=gridSize){
        ctx.beginPath(); ctx.moveTo(0,y); ctx.lineTo(canvas.width,y); ctx.stroke();
      }
      // Elements
      for(let el of elements){
        ctx.save();
        ctx.translate(el.x, el.y);
        ctx.rotate(el.rotation*Math.PI/180);
        ctx.fillStyle = (selected===el)? '#fbb' : '#ddd';
        ctx.fillRect(-el.w/2, -el.h/2, el.w, el.h);
        ctx.fillStyle = 'black';
        ctx.fillText(el.type, -el.w/4, 4);
        ctx.restore();
      }
    }

    canvas.addEventListener('mousedown', e=>{
      const r=canvas.getBoundingClientRect(); const x=e.clientX-r.left, y=e.clientY-r.top;
      selected=null;
      for(let el of elements){
        const dx=x-el.x, dy=y-el.y;
        if(Math.abs(dx)<el.w/2 && Math.abs(dy)<el.h/2){
          selected=el;
        }
      }
      draw(); renderProps();
    });

    function renderProps(){
      const panel=document.getElementById('properties');
      if(!selected){ panel.innerHTML='Select an element…'; return; }
      panel.innerHTML=`
        <div>Type: ${selected.type}</div>
        <label>X: <input type="number" value="${selected.x}" id="propX"></label>
        <label>Y: <input type="number" value="${selected.y}" id="propY"></label>
        <label>Rotation: <input type="number" value="${selected.rotation}" id="propRot"></label>
        <label>Width: <input type="number" value="${selected.w}" id="propW"></label>
        <label>Height: <input type="number" value="${selected.h}" id="propH"></label>
      `;
      ['propX','propY','propRot','propW','propH'].forEach(id=>{
        document.getElementById(id).onchange=(ev)=>{
          pushHistory();
          if(id==='propX') selected.x=parseInt(ev.target.value);
          if(id==='propY') selected.y=parseInt(ev.target.value);
          if(id==='propRot') selected.rotation=parseInt(ev.target.value);
          if(id==='propW') selected.w=parseInt(ev.target.value);
          if(id==='propH') selected.h=parseInt(ev.target.value);
          draw(); renderProps();
        };
      });
    }

    document.querySelectorAll('[draggable=true]').forEach(el=>{
      el.addEventListener('dragstart', e=>{
        e.dataTransfer.setData('type', el.dataset.type);
      });
    });
    canvas.addEventListener('dragover', e=>e.preventDefault());
    canvas.addEventListener('drop', e=>{
      e.preventDefault();
      const type=e.dataTransfer.getData('type');
      if(!type) return;
      const r=canvas.getBoundingClientRect();
      let x=Math.round((e.clientX-r.left)/gridSize)*gridSize;
      let y=Math.round((e.clientY-r.top)/gridSize)*gridSize;
      let obj={type,x,y,w:60,h:40,rotation:0};
      pushHistory();
      elements.push(obj);
      draw();
    });

    document.getElementById('undoBtn').onclick=()=>{
      if(!history.length) return;
      future.push(JSON.stringify(elements));
      elements=JSON.parse(history.pop());
      draw(); renderProps();
    };
    document.getElementById('redoBtn').onclick=()=>{
      if(!future.length) return;
      history.push(JSON.stringify(elements));
      elements=JSON.parse(future.pop());
      draw(); renderProps();
    };

    function exportSvg(){
      let svg='<svg xmlns="http://www.w3.org/2000/svg" width="'+canvas.width+'" height="'+canvas.height+'">';
      for(let el of elements){
        svg+=`<rect x="${el.x-el.w/2}" y="${el.y-el.h/2}" width="${el.w}" height="${el.h}" transform="rotate(${el.rotation},${el.x},${el.y})" fill="#ddd" stroke="black"/>`;
      }
      svg+='</svg>';
      const blob=new Blob([svg],{type:'image/svg+xml'});
      const url=URL.createObjectURL(blob);
      const a=document.createElement('a'); a.href=url; a.download='floorplan.svg'; a.click();
    }
    document.getElementById('exportSvgBtn').onclick=exportSvg;
    document.getElementById('exportPngBtn').onclick=()=>{
      const url=canvas.toDataURL();
      const a=document.createElement('a'); a.href=url; a.download='floorplan.png'; a.click();
    };

    document.getElementById('saveBtn').onclick=async()=>{
      const planId=new URLSearchParams(location.search).get('id');
      if(!planId){ alert('Missing ?id=<plan-id>'); return; }
      const body={ json_data:{ elements } };
      const res=await fetch(`/api/v1/floorplan/${planId}`, {
        method:'PATCH', headers:{'Content-Type':'application/json'}, body:JSON.stringify(body)
      });
      alert('Saved: '+res.status);
    };

    draw();
  </script>
</div>
