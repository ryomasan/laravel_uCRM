const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                fadeInOut: 'fadeInOut 1s ease-in-out',
            },
            keyframes: {
                fadeInOut: {
                    '0%': { opacity: 0 },
                    '30%': { opacity: 1 }, 
                    '70%': { opacity: 1 }, 
                    '100%': { opacity: 0 },
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
