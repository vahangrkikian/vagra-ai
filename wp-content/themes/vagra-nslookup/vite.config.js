import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  build: {
    outDir: path.resolve(__dirname, 'assets/js/dist'),
    emptyOutDir: true,
    rollupOptions: {
      input: path.resolve(__dirname, 'src/index.js'),
      output: {
        entryFileNames: 'nsl-islands.js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name][extname]',
        manualChunks: {
          'nsl-shared': ['react', 'react-dom'],
        },
      },
    },
  },
});
