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
                '35': '35deg',
            },
            colors: {
                dl: {
                    DEFAULT: "#C91843",
                    two: "#9B1B39",
                    three: "#870027",
                    four: "#720F29",
                    txtone: "#282828",
                    txttwo: "#111111",
                }
            }
        },
    },

    plugins: [forms],
};
