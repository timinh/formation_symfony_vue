import { defineConfig } from "vite";
import { fileURLToPath } from 'node:url';
import symfonyPlugin from "vite-plugin-symfony";
import vue from "@vitejs/plugin-vue";
import VueRouter from 'unplugin-vue-router/vite';
import {quasar, transformAssetUrls} from "@quasar/vite-plugin";
/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
      host: '0.0.0.0',
      cors: true
    },
    plugins: [
        VueRouter({
            routesFolder: ['./assets/pages'],
            extensions: ['.vue'],
        }),
        vue({
            template: { transformAssetUrls }
        }),
        /* react(), // if you're using React */
        symfonyPlugin({
            viteDevServerHostname: 'localhost',
        }),
        quasar({
            sassVariables: fileURLToPath(
                new URL('./assets/css/quasar-variables.sass', import.meta.url)
            )
        })
    ],
    build: {
        rollupOptions: {
            input: {
                app: "./assets/app.js"
            },
        }
    },
});
