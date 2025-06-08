import laravel from 'laravel-vite-plugin';
import path from 'path';
import { defineConfig } from 'vite';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/main.jsx'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    }
});
