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
                display: ['Poppins', 'sans-serif'],
                sans: ['Plus Jakarta Sans', 'sans-serif'],
                mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
            },
            colors: {
                brand: {
                    cyan: {
                        50:  '#EAFBFF',
                        100: '#CEF3FF',
                        200: '#A0E8FF',
                        300: '#6DD9FF',
                        400: '#43CBFF',
                        500: '#31C3FF',
                        600: '#0FA8E8',
                        700: '#0B85BA',
                        800: '#0A6690',
                        900: '#0A506F',
                    },
                    indigo: {
                        50:  '#EEF2FF',
                        100: '#E0E7FF',
                        200: '#C3D0FF',
                        300: '#9FB2FE',
                        400: '#6D8AFC',
                        500: '#2A5DF9',
                        600: '#1B45DB',
                        700: '#1636AD',
                        800: '#142C87',
                        900: '#12246B',
                    },
                },
                slate: {
                    50:  '#F7F8FA',
                    100: '#EEF1F5',
                    200: '#DFE3EA',
                    300: '#C4CAD4',
                    400: '#9AA3B2',
                    500: '#6B7280',
                    600: '#4B5468',
                    700: '#333B4F',
                    800: '#1F2536',
                    900: '#12172E',
                },
                success: { 500: '#16B364', 100: '#DBFAE8' },
                warning: { 500: '#F59E0B', 100: '#FEF3C7' },
                danger:  { 500: '#EF4444', 100: '#FEE2E2' },
                info:    { 500: '#31C3FF', 100: '#EAFBFF' },
            },
            backgroundImage: {
                'brand-gradient': 'linear-gradient(135deg, #31C3FF 0%, #2A5DF9 100%)',
            },
            borderRadius: {
                sm: '6px',
                DEFAULT: '8px',
                md: '10px',
                lg: '12px',
                xl: '16px',
                '2xl': '20px',
            },
            boxShadow: {
                xs: '0 1px 2px rgba(18, 23, 46, 0.05)',
                sm: '0 2px 6px rgba(18, 23, 46, 0.06)',
                md: '0 6px 16px rgba(42, 93, 249, 0.08)',
                lg: '0 12px 28px rgba(42, 93, 249, 0.12)',
            },
        },
    },

    plugins: [forms],
};
