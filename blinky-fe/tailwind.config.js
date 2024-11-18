/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx,vue}",
  ],
  theme: {
    extend: {
      colors: {
        "indigo": "#5A4FDF",
        "darkpurple": "#221d66",
        "lapizblue": "#19154f",
        "blueprism": "#201a75",
        "darkslate": "#090721",
        // "w"
      }
    },
  },
  plugins: [],
}

