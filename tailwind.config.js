import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    daisyui: {
        themes: [
          {
            mytheme: {

   "primary": "#89ce39",

   "secondary": "#e89ef7",

   "accent": "#b59432",

   "neutral": "#EA906C",

   "base-100": "#EEE2DE",

   "info": "#79c1f1",

   "success": "#2cb567",

   "warning": "#9c8002",

   "error": "#f70850",
            },
          },
        ],
      },
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require("daisyui")],
};
