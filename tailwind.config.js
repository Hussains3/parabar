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
            darkMode: 'class',
            fontFamily: {
                dm: ["DM Sans", "sans-serif"],
                mont: ["Montserrat", "sans-serif"],
                space: ["Space Grotesk", "sans-serif"],
                // tround: ['Tsukimi Rounded', 'sans-serif']
            },
            colors: {
                transparent: "transparent",
                current: "currentColor",
                seagreen: "#15B6A4",
                nblue: "#101827",
                lightblack: "#52525B",
                cream: "#EFEEEA",
                bb: "#3a2c90",
            },
            transitionDelay: {
                125: "125ms",
                175: "175ms",
                225: "225ms",
            },
            keyframes: {
                scroll: {
                    "0%": { transform: "translateX(0)"},
                    "100%": { transform: "translateX(calc(-100% - 1rem))"}
                },
                scrollabs: {
                    "0%": { transform: "translateX(calc(100% + 1rem))"},
                    "100%": {transform: "translateX(0)" }
                },
                marquee: {
                    '100%': { transform: 'translateX(-50%)' }
                },
            },
            animation: {
                scroll: 'scroll 10s linear infinite',
                scrollabs: 'scrollabs',
                marquee: 'marquee var(--marquee-duration) linear infinite',
            },
            backgroundImage: {
                'herobgo': "url('/images/background.jpg')",
            },
        },
    },

    plugins: [forms],
};
