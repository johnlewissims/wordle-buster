import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [
                'resources/js/Components/**/*.vue',  // Add this line
                'resources/js/Components/Forms/**/*.vue',  // And this one
                'resources/**/*.php',
            ],
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
    server: {
        host: '0.0.0.0',
        watch: {
            usePolling: true,
            interval: 1000,
            include: [
                'resources/js/Components/**/*.vue',
                'resources/js/Components/Forms/**/*.vue'
            ]
        }
    }
});
