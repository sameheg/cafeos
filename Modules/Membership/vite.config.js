import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-membership',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-membership',
            input: [
                __dirname + '/../../resources/js/Modules/Membership/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
