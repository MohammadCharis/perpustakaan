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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#EAF1FF',
                    100: '#DCE8FF',
                    200: '#BFD3FF',
                    300: '#93B4FF',
                    400: '#5F8FFF',
                    500: '#3A7BFF',
                    600: '#2979FF',
                    700: '#1F63D6',
                    800: '#174FB0',
                    900: '#103B86',
                    DEFAULT: '#2979FF',
                },
                'brand-dark': '#1F63D6',
                'brand-soft': '#EAF1FF',
                ink: '#111111',
                canvas: '#F4F4F5',
                surface: '#FFFFFF',
                line: '#E5E7EB',
                muted: '#6B7280',
                status: {
                    success: '#16A34A',
                    warning: '#CA8A04',
                    danger: '#DC2626',
                    info: '#2563eb',
                },
                'login-blue': '#2979FF',
                'login-bg': '#E9EAEC',
                'login-surface': '#FBFBFC',
                'login-title': '#5A5A5A',
                'login-line': '#D2D4D8',
                'login-muted': '#A3A6AD',
                'login-shape': '#E8E9EB',
            },
        },
    },

    plugins: [forms],
};
