document.addEventListener('alpine:init', () => {
    Alpine.data('cashierShortcuts', () => ({
        register() {
            window.addEventListener('keydown', (event) => {
                if (event.key === 'F2') {
                    this.$dispatch('cashier-checkout');
                }

                if (event.key === 'F4') {
                    this.$dispatch('cashier-clear-cart');
                }
            });
        },
    }));
});
