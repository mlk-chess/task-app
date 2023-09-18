/** @type {import('tailwindcss').Config} */
module.exports = {
  theme: {
    screens: {
      sm: '380px',
      md : '768px',
      lg: '976px',
      xl: '1440px',
    }
  },
  content: [
    './src/**/*.{vue,js,ts}',
  ],
  plugins: [require('daisyui')],

  daisyui: {
    themes: ["lemonade", "night"],
  },

};

