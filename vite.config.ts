import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin';
import gql from 'vite-plugin-simple-gql';
import vue from '@vitejs/plugin-vue';
// import basicSsl from '@vitejs/plugin-basic-ssl'

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/js/app.ts',
        'resources/css/app.css',
      ],
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
      gql(),
      // basicSsl(),
  ],
  resolve: {
    alias: {
      '@': '/resources/js'
    }
  },
  server: {
    // Unfortunately if you develop with a PHP server running on a different port, you will hit CORS issues.
    // So we blanket allow (dangerous in production but not in dev)
    cors: {
      origin: true
    }
  }
})
