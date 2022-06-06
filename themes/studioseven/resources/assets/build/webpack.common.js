/* eslint-disable */
const url = require('url')
const config = require('./config')
const webpack = require('webpack')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
const ESLintPlugin = require('eslint-webpack-plugin')
const StyleLintPlugin = require('stylelint-webpack-plugin')
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const CopyPlugin = require("copy-webpack-plugin")

const target = process.env.DEVURL || config.devUrl
const assetsFilenames = config.enabled.cacheBusting ? config.cacheBusting : '[name]'

/**
 * We do this to enable injection over SSL.
 */
 if (url.parse(target).protocol === 'https:') {
  process.env.NODE_TLS_REJECT_UNAUTHORIZED = 0;

  config.proxyUrl = config.proxyUrl.replace('http:', 'https:');
}

let webpackConfig = {
  context: config.paths.assets,
  entry: config.entry,
  stats: false,
  output: {
    path: config.paths.dist,
    publicPath: config.publicPath,
    filename: `scripts/${assetsFilenames}.js`
  },
  externals: {
    jquery: 'jQuery'
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: [/node_modules(?![/|\\](bootstrap|foundation-sites))/],
        use: [
          { loader: 'cache-loader' },
          {
            loader: 'buble-loader',
            options: { objectAssign: 'Object.assign' }
          }
        ]
      },
      {
        test: /\.css$/,
        include: config.paths.assets,
        use: [
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
        ]
      },
      {
        test: /\.(woff(2)?|eot|ttf|otf|)$/,
        type: 'asset',
        generator: {
          filename: 'fonts/[hash][ext][query]'
        }
      },
      {
        test: /\.(?:ico|gif|png|jpg|jpeg|svg)$/i,
        type: 'asset/resource',
        generator: {
          filename: 'images/[name][ext][query]'
        }
      }
    ]
  },
  plugins: [
    new CopyPlugin({
      patterns: [
        {
          from: 'images/favicons',
          to: 'images/favicons'
        }
      ]
    }),
    new CleanWebpackPlugin({ verbose: false }),
    new HtmlWebpackPlugin(),
    new webpack.NoEmitOnErrorsPlugin(),
    new webpack.HotModuleReplacementPlugin(),
    new BrowserSyncPlugin({
      files: ['resources/views/**/*.blade.php'],
      host: 'localhost',
      port: 3000,
      open: true,
      watch: config.watch,
      proxy: {
        target: config.devUrl
      }
    }, {
      reload: true,
      // injectCss: true
    }),
    new ESLintPlugin({
      failOnWarning: false,
      failOnError: true,
    }),
    new StyleLintPlugin({
      failOnError: !config.enabled.watcher,
      syntax: 'scss',
    }),
    new FriendlyErrorsWebpackPlugin()
  ],
  resolve: {
    modules: [
      config.paths.assets,
      'node_modules'
    ],
    enforceExtension: false
  }
}

module.exports = webpackConfig
