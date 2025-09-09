document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('canvas');
    const addTable = document.getElementById('add-table');
    const addChair = document.getElementById('add-chair');
    const save = document.getElementById('save-layout');

    const layout = window.initialLayout || [];
    layout.forEach(item => {
        canvas.appendChild(createItem(item.type, item.x, item.y));
    });

    function createItem(type, x = 0, y = 0) {
        const el = document.createElement('div');
        el.classList.add('item', type);
        el.textContent = type === 'table' ? 'T' : 'C';
        el.style.position = 'absolute';
        el.style.left = x + 'px';
        el.style.top = y + 'px';
        el.draggable = true;
        el.dataset.type = type;
        el.addEventListener('dragend', dragEnd);
        return el;
    }

    function dragEnd(e) {
        const rect = canvas.getBoundingClientRect();
        e.target.style.left = e.pageX - rect.left - 25 + 'px';
        e.target.style.top = e.pageY - rect.top - 25 + 'px';
    }

    addTable.addEventListener('click', () => canvas.appendChild(createItem('table')));
    addChair.addEventListener('click', () => canvas.appendChild(createItem('chair')));

    save.addEventListener('click', () => {
        const items = Array.from(canvas.querySelectorAll('.item')).map(el => ({
            type: el.dataset.type,
            x: parseInt(el.style.left, 10) || 0,
            y: parseInt(el.style.top, 10) || 0,
        }));
        fetch('floor-plan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ layout: JSON.stringify(items) })
        });
    });
});
