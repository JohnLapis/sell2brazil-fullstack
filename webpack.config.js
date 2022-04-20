const { VueLoaderPlugin } = require("vue-loader");
const path = require('path');

module.exports = {
  entry: path.resolve('./resources/js/main.js'),
  output: {
    path: path.resolve('./public/js'),
    filename: 'main.js',
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: "babel-loader",
      },
      {
        test: /\.vue$/,
        exclude: /node_modules/,
        loader: "vue-loader",
      },
      {
        test: /\.css$/,
        exclude: /node_modules/,
        use: [
          'vue-style-loader',
          'css-loader'
        ]
      },
      {
        test: /\.(json5?|ya?ml)$/,
        type: 'javascript/auto',
        exclude: /node_modules/,
        loader: '@intlify/vue-i18n-loader'
      },
      {
        resourceQuery: /blockType=i18n/,
        type: 'javascript/auto',
        exclude: /node_modules/,
        loader: '@intlify/vue-i18n-loader'
      },
    ],
  },
  plugins: [
    new VueLoaderPlugin(),
  ],
}
