/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./components/*/*/*.{php,html,js}",
    "./template-parts/*.{php,html,js}",
    "./*.{php,html,js}",
    "./*/*.{php,html,js}",
    "./*/*/*.{php,html,js}"
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: "#1D4ED8",  // Color primario principal
          light: "#3B82F6",    // Variación más clara del color primario
          dark: "#1E3A8A",     // Variación más oscura del color primario
        },
        secondary: {
          DEFAULT: "#F59E0B",  // Color secundario principal
          light: "#FBBF24",    // Variación más clara del color secundario
          dark: "#B45309",     // Variación más oscura del color secundario
        },
        text: {
          DEFAULT: "#1b1b1c",   // Negro suave, sin ser completamente puro
          old: "#1A1A1A",   // Negro suave, sin ser completamente puro
          light: "#595959",     // Gris oscuro para una opción más clara
          dark: "#404040", 
          lightX2: "#707070"     // Un tono de negro muy profundo, ideal para buen contraste
        },
        background: {
          DEFAULT: "#F3F4F6",  // Fondo general de la página
          light: "#FFFFFF",    // Fondo claro, como para tarjetas o secciones
          dark: "#E5E7EB",     // Fondo oscuro
        },
        accent: {
          DEFAULT: "#10B98x1",  // Color de acento para resaltar elementos
          green: "#198754",    // Acento en tono más claro
          blue: "#04785x7",     // Acento en tono más oscuro
        },
        myWhite:{
          DEFAULT: "#ffffff",
          bg: "#f7f7f7"
        },
        myBlack:{
          DEFAULT: "#1A1A1A",
        }
        
      },
      fontFamily: {
        montserrat: ['Montserrat', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/line-clamp'),
    require('tailwindcss-animated')
  ],
};
