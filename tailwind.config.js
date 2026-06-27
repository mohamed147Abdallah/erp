import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    primary: '#6366f1',
                    secondary: '#8b5cf6',
                    accent: '#a78bfa',
                },
            },
            spacing: {
                '4.5': '1.125rem',
            },
            borderRadius: {
                'xl': '0.875rem',
                '2xl': '1rem',
                '3xl': '1.25rem',
            },
            animation: {
                'fade-in-up': 'pageEnter 0.45s cubic-bezier(0.22, 1, 0.36, 1) both',
                'scale-in': 'scaleIn 0.3s cubic-bezier(0.22, 1, 0.36, 1) both',
            },
            keyframes: {
                pageEnter: {
                    '0%': { opacity: '0', transform: 'translateY(12px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.97)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
            },
            boxShadow: {
                'glow-indigo': '0 0 20px rgba(99, 102, 241, 0.4)',
                'glow-sm': '0 0 12px rgba(99, 102, 241, 0.3)',
            },
        },
    },

    plugins: [forms],
};
