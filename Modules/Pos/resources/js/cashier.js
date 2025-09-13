function registerCashierShortcuts() {
    window.Alpine.data('cashierShortcuts', () => ({
        handler: null,

        register() {
            this.handler = (event) => {
                if (event.key === 'F2') {
                    this.$dispatch('cashier-checkout');
                }

                if (event.key === 'F4') {
                    this.$dispatch('cashier-clear-cart');
                }
            };

            window.addEventListener('keydown', this.handler);
        },

        destroy() {
            if (this.handler) {
                window.removeEventListener('keydown', this.handler);
            }
        },
    }));
}

if (window.Alpine) {
    registerCashierShortcuts();
} else {
    document.addEventListener('alpine:init', registerCashierShortcuts);
}
