/** Build: npm run build:css  (hasil assets/tailwind.css ikut di-commit) */
module.exports = {
  content: ['./*.php', './assets/main.js'],
  theme: {
    extend: {
      colors: {
        primary: '#c1121f',
        darkred: '#780000',
      },
    },
  },
  plugins: [],
};
