import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import vue from '@vitejs/plugin-vue';
import VueRouter from 'unplugin-vue-router/vite';
import { fileURLToPath } from 'node:url'
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
        // Required to listen on all interfaces
        host: '0.0.0.0',
        cors: true
    },
    plugins: [
        VueRouter({
            routesFolder: ['./assets/Pages'],
            extensions: ['.vue'],
        }),
        vue({
            template: { transformAssetUrls }
        }),
        quasar({
            sassVariables: fileURLToPath(
                new URL('./assets/css/quasar-variables.sass', import.meta.url)
            )
        }),
        symfonyPlugin({
            viteDevServerHostname: 'localhost',
        }),
    ],
    build: {
        rollupOptions: {
            input: {
                app: "./assets/app.js"
            },
        }
    },
});
