import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import vue from "@vitejs/plugin-vue";
/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
    server: {
      host: '0.0.0.0',
      cors: true
    },
    plugins: [
        vue(),
        /* react(), // if you're using React */
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
