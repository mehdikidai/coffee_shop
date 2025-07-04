import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.scss",
                "resources/css/bootstrap.css",
                "resources/js/app.js",
                "resources/js/review.js",
                "resources/css/bootstrap.rtl.min.css",
                "resources/css/review.scss",
            ],
            refresh: true,
        }),
    ],
    css: {
        devSourcemap: false,
    },
});
