import { defineConfig } from 'vite'
import path from 'path'
import tailwind from '@tailwindcss/postcss'
import autoprefixer from 'autoprefixer'

export default defineConfig({
  css: {
    postcss: {
      plugins: [tailwind, autoprefixer()]
    }
  },
  build: {
    rollupOptions: {
      input: {
        app: path.resolve(__dirname, 'src/resources/js/app.js'),
        style: path.resolve(__dirname, 'src/resources/css/app.css'),
      },
      output: {
        dir: path.resolve(__dirname, 'src/public/dist'),
        entryFileNames: '[name].js',
        assetFileNames: '[name].[ext]',
      },
    },
    outDir: path.resolve(__dirname, 'src/public/dist'),
    emptyOutDir: true,
  }
})