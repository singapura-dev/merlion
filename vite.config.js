import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: "resources/dist"
    },
    plugins: [
        laravel({
            input: ['resources/assets/css/merlion.css', 'resources/assets/js/merlion.js'],
            refresh: true,
        })
    ],
});
