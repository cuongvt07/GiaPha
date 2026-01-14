/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
        serif: ['Be Vietnam Pro', 'ui-serif', 'Georgia'],
      },
      colors: {
        primary: {
          50: '#fdf2f2',
          100: '#fde3e3',
          200: '#fbd0d0',
          300: '#f6abab',
          400: '#ef7a7a',
          500: '#e04f4f',
          600: '#c41e3a', // Brand Red
          700: '#a3172e',
          800: '#881628',
          900: '#711826',
          950: '#3e0911',
        },
        secondary: {
          50: '#fffaeb',
          100: '#fef0c7',
          200: '#fde08a',
          300: '#fcd34d',
          400: '#fbbf24',
          500: '#ffd700', // Brand Gold
          600: '#d97706',
          700: '#b45309',
          800: '#92400e',
          900: '#78350f',
          950: '#451a03',
        },
        gender: {
          male: '#3b82f6', // Blue 500
          female: '#ec4899', // Pink 500
        },
        status: {
          alive: '#22c55e', // Green 500
          deceased: '#6b7280', // Gray 500
        }
      },
      boxShadow: {
        'card': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
        'card-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
      }
    },
  },
  plugins: [],
}
