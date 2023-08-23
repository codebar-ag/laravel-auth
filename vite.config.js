import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        outDir: 'resources/dist',
        rollupOptions: {
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`
            }
        }
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
            ],
        }),
   ],
});
