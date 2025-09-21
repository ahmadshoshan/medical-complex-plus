import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),






    ],
    build: {
        rollupOptions: {
            input: {
                voiceAnnouncement: resolve(__dirname, 'resources/js/voice-announcement.js'),
            },
            output: {
                entryFileNames: 'voice-announcement.js',
                assetFileNames: '[name].[ext]',
                dir: 'public/build'
            }
        },
        outDir: 'public/build', // يتأكد من مكان التصدير
        emptyOutDir: false, // لتجنب حذف ملفات أخرى
    },
    // مهم: لأننا نستخدم build مخصص، لا نريد أن يمسح Vite مجلد build تلقائيًا
});
