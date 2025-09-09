import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-jobs',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-jobs',
            input: [
                __dirname + '/../../resources/js/Modules/Jobs/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
