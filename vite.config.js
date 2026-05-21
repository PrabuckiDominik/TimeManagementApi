import { defineConfig, loadEnv, } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import path from 'path'

export default ({ mode }) => {
    process.env = { ...process.env, ...loadEnv(mode, process.cwd()) }

    return defineConfig({
        build: {
            outDir: './public/build/',
        },
        server: {
          host: true,
          port: Number(process.env.DOCKER_VITE_PORT ?? 5174),
          strictPort: true,
          origin: `http://${process.env.VITE_DEV_SERVER_DOCKER_HOST_NAME}:${process.env.DOCKER_VITE_PORT ?? 5174}`,
          cors: true,
        },
      resolve: {
        alias: {
          "@": path.resolve(__dirname, "resources/js"),
        },
      },
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.ts'],
                refresh: true,
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
    })
}
