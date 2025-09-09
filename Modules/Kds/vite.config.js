import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-kds',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-kds',
            input: [
                __dirname + '/../../resources/js/Modules/Kds/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
