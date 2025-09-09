import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-loyalty',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-loyalty',
            input: [
                __dirname + '/../../resources/js/Modules/Loyalty/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
