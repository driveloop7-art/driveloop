import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        watch: {
            ignored: [
                '**/node_modules/**',
                '**/vendor/**',
                '**/storage/**',
            ]
        }
    },
    plugins: [
        laravel({
<<<<<<< HEAD
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/BusquedaReserva/validar_fecha_busqueda.js'],
=======
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/validar_fecha_busqueda.js'],
>>>>>>> 60cac1d1ed254d15451019046f924bcd1985a63c
            refresh: true,
        }),
    ],
});
