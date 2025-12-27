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
                brandBlue: '#0A2463', // Keep existing deep blue for primary actions
                brandLightBlue: '#BFD4F9', // Add the light blue from About page
                textMain: '#1A1A1A'
            }
        }
    },

    plugins: [forms, aspectRatio,]
};
