import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import tailwindcssMotion from 'tailwindcss-motion';

/** @type {import('tailwindcss').Config} */
export default {
//   content: [
//     './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//     './storage/framework/views/*.php',
//     './resources/views/**/*.blade.php',
//   ],
content: [
  './resources/**/*.blade.php',
  './resources/**/*.js',
  './resources/**/*.vue',
],
  safelist: [
  'bg-[#1469b5]/[0.24]',
],
  darkMode: 'selector',
  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
      colors: {
         softBlue: 'rgba(20, 105, 181, 0.24)',
        primary: {
          DEFAULT: '#EE456B',
          50: '#FDEDF1',
          100: '#FCDBE2',
          200: '#F8B5C4',
          300: '#F590A6',
          400: '#F16A89',
          500: '#EE456B',
          600: '#E61544',
          700: '#B21035',
          800: '#7F0C26',
          900: '#4C0716',
          950: '#32050F',
        },
      },
    },
  },

  plugins: [forms, tailwindcssMotion],
};
