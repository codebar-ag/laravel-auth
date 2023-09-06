import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

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
                "resources/css/authcss.css",
                "resources/js/authjs.js",
            ],
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/images',
                    dest: ''
                },
            ],
        }),
   ],
});
