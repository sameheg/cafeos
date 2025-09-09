import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-selfservicekiosk',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-selfservicekiosk',
            input: [
                __dirname + '/resources/js/kiosk.js',
            ],
            refresh: true,
        }),
    ],
});
