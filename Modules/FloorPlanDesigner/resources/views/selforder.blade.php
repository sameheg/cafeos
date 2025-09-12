<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Self Order - {{ $table->name }}</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 0; padding: 1rem; }
    .card { border: 1px solid #e5e7eb; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; }
    .btn { padding: .6rem 1rem; border: 1px solid #e5e7eb; border-radius: 10px; cursor: pointer; }
    .grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: .75rem; }
    .row { display: flex; gap: .5rem; align-items: center; }
    input, select { padding: .5rem; border: 1px solid #e5e7eb; border-radius: 8px; }
  </style>
</head>
<body>
  <h1>Table: {{ $table->name }}</h1>
  <div class="card">
    <div class="row">
      <label>Guests</label>
      <input id="guests" type="number" value="2" min="1">
    </div>
  </div>
  <div class="card">
    <h3>Menu</h3>
    <div class="grid" id="menu">
      <!-- placeholder menu -->
      <div class="row"><span>Espresso</span><button class="btn" onclick="add('Espresso', 70)">+ Add</button></div>
      <div class="row"><span>Cappuccino</span><button class="btn" onclick="add('Cappuccino', 90)">+ Add</button></div>
      <div class="row"><span>Cheeseburger</span><button class="btn" onclick="add('Cheeseburger', 160)">+ Add</button></div>
      <div class="row"><span>Fries</span><button class="btn" onclick="add('Fries', 60)">+ Add</button></div>
    </div>
  </div>
  <div class="card">
    <h3>Cart</h3>
    <div id="cart"></div>
    <div style="margin-top:.5rem" class="row">
      <strong>Total:</strong> <span id="total">0</span> EGP
    </div>
    <div class="row" style="margin-top:1rem">
      <button class="btn" onclick="checkout()">Start Order</button>
    </div>
  </div>
  <script>
    const cart = [];
    function add(name, price){
      const item = cart.find(i=>i.name===name) || (cart.push({name, price, qty:0}), cart[cart.length-1]);
      item.qty += 1;
      render();
    }
    function render(){
      const c = document.getElementById('cart');
      c.innerHTML = '';
      let total = 0;
      for (const it of cart){
        total += it.price * it.qty;
        const row = document.createElement('div');
        row.className='row';
        row.innerHTML = `<span>${it.name} × ${it.qty}</span> <button class="btn" onclick="dec('${it.name}')">-</button>`;
        c.appendChild(row);
      }
      document.getElementById('total').textContent = total.toFixed(2);
    }
    function dec(name){
      const it = cart.find(i=>i.name===name);
      if(!it) return;
      it.qty -= 1; if (it.qty<=0){ const idx = cart.indexOf(it); cart.splice(idx,1); }
      render();
    }
    async function checkout(){
      const pos_table_id = @json($table->pos_table_id ?: (string)$table->id);
      try{
        const res = await fetch('/api/v1/floorplan/selforder/start', {
          method:'POST', headers:{'Content-Type':'application/json'},
          body: JSON.stringify({ pos_table_id, items: cart })
        });
        const json = await res.json();
        alert('Order created: ' + (json.order_id||'N/A'));
      }catch(e){ alert('Failed'); }
    }
  </script>
</body>
</html>
