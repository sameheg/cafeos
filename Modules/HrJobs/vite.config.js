import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-hrjobs',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-hrjobs',
            input: [
                __dirname + '/../../resources/js/Modules/HrJobs/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
