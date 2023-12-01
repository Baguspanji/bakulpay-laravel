// purgecss.config.js
const purgecss = require("purgecss");

module.exports = {
  // Konfigurasi PurgeCSS
  content: ["./public/**/*.html", "./public/**/*.js"],
  css: ["./public/assets/css/now-ui-dashboard.css"],
};
