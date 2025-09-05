document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('admin-search-input');
    const results = document.getElementById('admin-search-results');

    if (!input || !results) {
        return;
    }

    let timer;

    input.addEventListener('keyup', function () {
        clearTimeout(timer);
        const query = this.value.trim();

        if (query.length < 2) {
            results.innerHTML = '';
            results.classList.add('tw-hidden');
            return;
        }

        timer = setTimeout(() => {
            fetch(`/admin-search?query=${encodeURIComponent(query)}`)
                .then((response) => response.json())
                .then((data) => {
                    results.innerHTML = '';
                    const hasResults = Object.values(data).some((items) => items.length);
                    if (!hasResults) {
                        results.classList.add('tw-hidden');
                        return;
                    }

                    Object.entries(data).forEach(([type, items]) => {
                        if (!items.length) {
                            return;
                        }

                        const header = document.createElement('li');
                        header.textContent = type.charAt(0).toUpperCase() + type.slice(1);
                        header.classList.add('tw-font-bold', 'tw-mt-2');
                        results.appendChild(header);

                        items.forEach((item) => {
                            const li = document.createElement('li');
                            const a = document.createElement('a');
                            a.textContent = item.name;
                            a.href = item.url || '#';
                            li.appendChild(a);
                            results.appendChild(li);
                        });
                    });

                    results.classList.remove('tw-hidden');
                });
        }, 300);
    });
});
