import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-billing',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-billing',
            input: [
                __dirname + '/../../resources/js/Modules/Billing/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
