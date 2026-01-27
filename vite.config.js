import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/BusquedaReserva/validar_fecha_busqueda.js'],
            refresh: true,
        }),
    ],
});
