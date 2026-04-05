import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  publicDir: false,
  build: {
    outDir: 'public/build',
    rollupOptions: {
      input: ['resources/css/app.css'],
    },
    manifest: true,
  },
});
