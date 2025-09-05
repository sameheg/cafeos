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
                    if (!data.length) {
                        results.classList.add('tw-hidden');
                        return;
                    }

                    data.forEach((item) => {
                        const li = document.createElement('li');
                        const a = document.createElement('a');
                        a.textContent = item.name;
                        a.href = item.url || '#';
                        li.appendChild(a);
                        results.appendChild(li);
                    });
                    results.classList.remove('tw-hidden');
                });
        }, 300);
    });
});
