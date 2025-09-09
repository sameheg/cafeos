import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-notifications',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-notifications',
            input: [
                __dirname + '/../../resources/js/Modules/Notifications/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
