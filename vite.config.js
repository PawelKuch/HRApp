import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/js/leaves.js', 'resources/js/userLeaves.js',
                'resources/js/workTime.js', 'resources/js/users.js'],
            refresh: true,
        }),
    ],
});
