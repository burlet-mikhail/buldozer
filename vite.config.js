import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        https: false,
        host: 'buldozer.local',
    },
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/js/app.js',
                'resources/scss/libs.scss',
                'resources/scss/main.scss'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        }
    }
});
