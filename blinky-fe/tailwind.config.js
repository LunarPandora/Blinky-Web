/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx,vue}",
  ],
  theme: {
    extend: {
      colors: {
        "darkbrown": "#3D3D3D",
        "darkpurple": "#221d66",
        "darkslate": "#090721",
        "leafgreen": "#578E7E",
        "lightgreen": "#b5e8da",
        "softcream": "#FFFAEC",
        "cream": "#F5ECD5",
        "softred": "#C96868",
        "softbrown": "#d9ccba"
        // "w"
      }
    },
  },
  plugins: [],
}

