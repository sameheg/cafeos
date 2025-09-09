import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-floorplandesigner',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-floorplandesigner',
            input: [
                __dirname + '/../../resources/js/Modules/FloorPlanDesigner/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
