const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            gridTemplateColumns:
                {
                    '40/60': '40% 60%',
                },
            backgroundImage: {
                'background': "url('/img/background.jpg')",
            }
        },
    },

    daisyui: {
        themes: [
            {
                mytheme: {

                    // "primary": "#570DF8",
                    "primary": "#3D4451",

                    "secondary": "#F000B8",

                    "accent": "#37CDBE",

                    "neutral": "#3D4451",

                    "base-100": "#FFFFFF",

                    "info": "#3ABFF8",

                    "success": "#36D399",

                    "warning": "#FBBD23",

                    "error": "#F87272",
                },
            },
        ],
    },
    plugins: [require('@tailwindcss/forms'), require("daisyui")],
};
