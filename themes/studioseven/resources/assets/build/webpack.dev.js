const { merge } = require('webpack-merge')
const common = require('./webpack.common.js')

module.exports = merge(common, {
  mode: 'development',
  devtool: 'source-map',
  module: {
    rules: [
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          'style-loader',
          'css-loader',
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                parser: 'postcss-safe-parser',
                plugins: [
                  ['autoprefixer']
                ]
              }
            }
          },
          {
            loader: 'sass-loader',
            options: {
              implementation: require.resolve('sass')
            }
          }
        ]
      }
    ]
  }
})
