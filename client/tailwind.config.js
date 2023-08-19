/** @type {import('tailwindcss').Config} */
module.exports = {
  theme: {
    screens: {
      sm: '380px'
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

