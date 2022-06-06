/* eslint-disable */
const favicons = require('favicons')
const fs = require('fs')
const source = 'resources/assets/images/medias/favicon.png'
const path = 'resources/assets/images/favicons/'
const name = 'Studio Seven'
const themeColor = '#fff'

const configuration = {
  path: '/', // Path for overriding default icons path. `string`
  appName: name, // Your application's name. `string`
  appShortName: name, // Your application's short_name. `string`. Optional. If not set, appName will be used
  appDescription: '', // Your application's description. `string`
  developerName: 'Studio Seven', // Your (or your developer's) name. `string`
  developerURL: 'https://studio-seven.fr', // Your (or your developer's) URL. `string`
  dir: 'auto', // Primary text direction for name, short_name, and description
  lang: 'en-US', // Primary language for name and short_name
  background: '#fff', // Background colour for flattened icons. `string`
  theme_color: themeColor, // Theme color user for example in Android's task switcher. `string`
  appleStatusBarStyle: 'black-translucent', // Style for Apple status bar: "black-translucent", "default", "black". `string`
  display: 'standalone', // Preferred display mode: "fullscreen", "standalone", "minimal-ui" or "browser". `string`
  orientation: 'any', // Default orientation: "any", "natural", "portrait" or "landscape". `string`
  scope: '/', // set of URLs that the browser considers within your app
  start_url: '/', // Start URL when launching the application from a device. `string`
  preferRelatedApplications: false, // Should the browser prompt the user to install the native companion app. `boolean`
  relatedApplications: undefined, // Information about the native companion apps. This will only be used if `preferRelatedApplications` is `true`. `Array<{ id: string, url: string, platform: string }>`
  version: '1.0', // Your application's version string. `string`
  pixel_art: false, // Keeps pixels "sharp" when scaling up, for pixel art.  Only supported in offline mode.
  loadManifestWithCredentials: false, // Browsers don't send cookies when fetching a manifest, enable this to fix that. `boolean`
  manifestMaskable: false, // Maskable source image(s) for manifest.json. "true" to use default source. More information at https://web.dev/maskable-icon/. `boolean`, `string`, `buffer` or array of `string`
  icons: {
    android: true,
    appleIcon: true,
    favicons: true,
    windows: true,
    appleStartup: false,
    yandex: false
  }
}

const callback = function (error, response) {
  if (error) {
    console.log(error.message)

    return
  }

  response.images.forEach((image) => {
    fs.writeFile(path + image.name, image.contents, () => {
      console.log('🏞 Added favicon : ' + image.name)
    })
  })

  response.files.forEach((file) => {
    if (file.name === 'manifest.webmanifest') {
      const content = file.contents.replace(/"src": "/g, '"src": ".')

      fs.writeFile(path + file.name, content, () => {
        console.log('📂 Added file : ' + file.name)
      })
    } else {
      fs.writeFile(path + file.name, file.contents, () => {
        console.log('📂 Added file : ' + file.name)
      })
    }
  })
}

favicons.default(source, configuration, callback)
