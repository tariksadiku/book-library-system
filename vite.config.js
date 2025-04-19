import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import react from "@vitejs/plugin-react";
import path from "path";

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: ["resources/js/app.jsx", "resources/css/app.css"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            "@components": path.resolve(__dirname, "resources/js/components"),
            "@hooks": path.resolve(__dirname, "resources/js/hooks"),
        },
    },
});
