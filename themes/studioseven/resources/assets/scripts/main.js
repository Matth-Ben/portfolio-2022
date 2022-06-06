import App from './App'
import store from './util/store'

if (store.debug) {
  import('./util/Grid').then(({ default: Grid }) => {
    store.modules.grid = new Grid()
  })
}

window.addEventListener('load', () => {
  // eslint-disable-next-line no-new
  new App()
})
