import react from '@vitejs/plugin-react-swc';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { defineConfig } from 'vite';

export default defineConfig(config => {
    return {
        plugins: [
            laravel({
                input: [
                    'resources/app/index.tsx',
                ],
                refresh: true,
            }),
            react(),
        ],
        css: {
            postcss: {
                plugins: [
                    tailwindcss(),
                    autoprefixer(),
                ],
            },
            preprocessorOptions: {
                scss: {},
            },
        },
        resolve: {
            alias: {
                '@': path.resolve(__dirname, 'resources/app'),
            },
        },
        optimizeDeps: {
            include: ['react-icons/md'],
            exclude: [],
        },
    };
});
