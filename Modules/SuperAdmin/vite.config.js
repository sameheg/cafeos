import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-superadmin',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-superadmin',
            input: [
                __dirname + '/../../resources/js/Modules/SuperAdmin/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
