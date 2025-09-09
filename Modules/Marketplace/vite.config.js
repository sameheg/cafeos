import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-marketplace',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-marketplace',
            input: [
                __dirname + '/../../resources/js/Modules/Marketplace/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
