import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-procurement',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-procurement',
            input: [
                __dirname + '/../../resources/js/Modules/Procurement/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
