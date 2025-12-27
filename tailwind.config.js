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
                body: ['Rubik', 'sans-serif']
            },
            colors: {
                brandCream: '#FDFBF7',
                brandRed: '#791F1F',
                brandBlue: '#0A2463',
                brandLightBlue: '#BFD4F9',
                brandLight: '#F3F4F6',
                backgroundLight: '#FCFCFC',
                backgroundDark: '#111721',
                textMain: '#1A1A1A'
            }
        }
    },

    plugins: [forms, aspectRatio,]
};
