import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/app.auth.css',
                'resources/js/app.js',
                'resources/js/app.auth.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js',
            '@': '/resources/js',
        },
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        cors: true,
        hmr: {
            host: 'localhost',
        },
    },
});
