const path = require('path');

module.exports = {
  entry: './frontend/build/entry.js',
  output: {
    filename: './public/lab.mserrano.js',
    path: path.resolve(__dirname)
  }
};