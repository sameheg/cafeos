function registerCashierShortcuts() {
    window.Alpine.data('cashierShortcuts', () => ({
        handler: null,

        register() {
            this.handler = (event) => {
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
