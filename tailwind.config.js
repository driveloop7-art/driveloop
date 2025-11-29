import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                roboto: ['Roboto', 'sans-serif'],
                sans: ['Roboto', ...defaultTheme.fontFamily.sans],
            },
            skew: {
                '25': '25deg',
            },
        },
    },

    plugins: [forms],
};
