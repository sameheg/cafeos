document.addEventListener('alpine:init', () => {
    Alpine.data('cashierShortcuts', () => ({
        register() {
            window.addEventListener('keydown', (event) => {
                if (event.repeat) {
                    return;
                }

                if (event.key === 'F2') {
                    event.preventDefault();
                    event.stopPropagation();
                    this.$dispatch('cashier-checkout');
                }

                if (event.key === 'F4') {
                    event.preventDefault();
                    event.stopPropagation();
                    this.$dispatch('cashier-clear-cart');
                }
            });
        },
    }));
});
