import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            // output: [
            //     "public/build/assets/app-DbUhecoo.css",
            //     "public/build/assets/app-z-Rg4TxU.js",
            // ],
            refresh: true,
        }),
    ],
    server: {
        https: true,
        hmr: {
            host: "magical-bold-jackal.ngrok-free.app",
            protocol: "wss",
        },
    },
});
