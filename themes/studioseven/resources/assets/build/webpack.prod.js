const { merge } = require('webpack-merge')
const common = require('./webpack.common.js')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

const prodConfig = (env) => {
  // eslint-disable-next-line global-require
  const optimization = env.production ? require('./webpack.optimize').optimization : {}

  return {
    mode: 'production',
    plugins: [
      new MiniCssExtractPlugin({
        filename: 'styles/[name].css'
      })
    ],
    module: {
      rules: [
        {
          test: /\.(sa|sc|c)ss$/,
          use: [
            MiniCssExtractPlugin.loader,
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
    },
    optimization
  }
}

module.exports = (env) => merge(common, prodConfig(env))

// module.exports = merge(common, {
//   mode: 'production',
//   plugins: [
//     new MiniCssExtractPlugin({
//       filename: 'styles/[name].css'
//     })
//   ],
//   module: {
//     rules: [
//       {
//         test: /\.(sa|sc|c)ss$/,
//         use: [
//           MiniCssExtractPlugin.loader,
//           'css-loader',
//           {
//             loader: 'postcss-loader',
//             options: {
//               postcssOptions: {
//                 parser: 'postcss-safe-parser',
//                 plugins: [
//                   ['autoprefixer']
//                 ]
//               }
//             }
//           },
//           {
//             loader: 'sass-loader',
//             options: {
//               implementation: require.resolve('sass')
//             }
//           }
//         ]
//       }
//     ]
//   },
//   optimization: {
//     minimizer: [
//       new ImageMinimizerPlugin({
//         minimizer: {
//           implementation: ImageMinimizerPlugin.squooshMinify,
//           options: {
//             encodeOptions: {
//               mozjpeg: {
//                 // That setting might be close to lossless, but it’s not guaranteed
//                 // https://github.com/GoogleChromeLabs/squoosh/issues/85
//                 quality: 100
//               },
//               webp: {
//                 lossless: 1
//               },
//               avif: {
//                 // https://github.com/GoogleChromeLabs/squoosh/blob/dev/codecs/avif/enc/README.md
//                 cqLevel: 0
//               }
//             }
//           }
//         }
//       })
//     ]
//   }
// })
