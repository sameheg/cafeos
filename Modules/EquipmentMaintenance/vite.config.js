import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: '../../public/build-equipmentmaintenance',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-equipmentmaintenance',
            input: [
                __dirname + '/../../resources/js/Modules/EquipmentMaintenance/Dashboard.vue',
            ],
            refresh: true,
        }),
    ],
});
