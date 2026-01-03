import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import aspectRatio from '@tailwindcss/aspect-ratio';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php', './storage/framework/views/*.php', './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    'Inter',
                    ...defaultTheme.fontFamily.sans
                ],
                serif: [
                    'Playfair Display', 'Cormorant Infant', 'serif'
                ],
                display: [
                    'Cormorant Infant', 'serif'
                ],
                body: [
                    'Rubik', 'sans-serif'
                ],
                'serif-brand': [
                    'Cormorant Infant', 'serif'
                ],
                'sans-brand': ['Rubik', 'sans-serif']
            },
            colors: {
                brandCream: '#FDFBF7',
                brandRed: '#791F1F',
                brandBlue: '#0A2463',
                brandLightBlue: '#BFD4F9',
                brandLight: '#F3F4F6',
                backgroundLight: '#FCFCFC',
                backgroundDark: '#111721',
                textMain: '#1A1A1A',
                // Loading Screen Colors
                primary: "#bed3f9",
                "manee-text": "#111318",
                "manee-subtext": "#616f89"
            },
            animation: {
                "pulse-slow": "pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite",
                "fade-in-up": "fadeInUp 1s ease-out forwards"
            },
            keyframes: {
                fadeInUp: {
                    "0%": {
                        opacity: "0",
                        transform: "translateY(10px)"
                    },
                    "100%": {
                        opacity: "1",
                        transform: "translateY(0)"
                    }
                }
            }
        }
    },

    plugins: [forms, aspectRatio,]
};
