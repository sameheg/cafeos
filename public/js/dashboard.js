document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('dashboard-widgets');
    if (!container || typeof Sortable === 'undefined') {
        return;
    }

    new Sortable(container, {
        animation: 150,
        onEnd: () => {
            const order = Array.from(container.children).map(child => child.getAttribute('data-widget'));
            fetch('/dashboard/widgets-order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ widgets: order })
            });
        }
    });
});
