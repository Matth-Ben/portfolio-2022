import 'whatwg-fetch'
import 'intersection-observer'

import LazyLoad from 'vanilla-lazyload'
import Highway from '@dogstudio/highway'
import { throttle, debounce } from 'throttle-debounce'
import { listen } from 'quicklink'

// Utils
import Loader from './util/Loader'
import Menu from './util/Menu'
import store from './util/store'
import DOMObserver from './util/DOMObserver'
import locomotiveScroll from 'locomotive-scroll'

// Routes
import Page from './routes/Page'

// Transitions
import Fade from './transitions/Fade'

export default class App {

  /**
  * Loads the page
  * then calls `this.start()` when DOM is ready
  */
  constructor() {
    App.globalData = {
      smoothScroll: false
    }

    this.resize = this.resize.bind(this)
    this.scroll = this.scroll.bind(this)
    this.update = this.update.bind(this)

    this.raf = null

    this.resizeDebounced = debounce(100, this.resize)
    this.resizeThrottled = throttle(150, this.resize)

    if (!App.globalData.smoothScroll) {
      this.scrollDebounced = debounce(100, this.scroll)
      this.scrollThrottled = throttle(50, this.scroll)
    }

    store.w = {
      w: window.innerWidth,
      h: window.innerHeight,
      pixelRatio: Math.min(window.devicePixelRatio, 2)
    }

    this.start()
  }

  /**
  * Inits everything that is app-wide
  * ie: Menu, scroll / resize events...
  *
  * @returns {void}
  */
  start() {
    App.globalData.smoothScroll ? this.initSmoothScroll() : this.initDOMObserver()

    this.loader = new Loader()
    this.menu = new Menu()
    this.lazyLoad = new LazyLoad()

    this.initHighway().then(() => {
      this.events()
      this.update()
      window.scrollTo(0, 0)

      // Detach adminbar links
      const adminbarLinks = document.body.querySelectorAll('#wpadminbar a')

      adminbarLinks && App.Highway.detach(adminbarLinks)

      this.loader.play().then(() => {
        store.smoothScroll && store.smoothScroll.update()
        this.checkAnchor()
      })
    })
  }

  initDOMObserver() {
    this.DOMObserver = new DOMObserver(this.observerCallBack)
  }

  initSmoothScroll() {
    /* eslint-disable-next-line */
    store.smoothScroll = new locomotiveScroll({
      el: document.body.querySelector('.js-scroll'),
      smooth: true,
      passive: true,
      inertia: 1.0
    })
  }

  /**
  * Starts an Highway instance
  * with our Views and Transitions
  *
  * @returns {void}
  */
  initHighway() {
    return new Promise((resolve) => {
      App.Highway = new Highway.Core({
        renderers: {
          page: Page
        },
        transitions: { default: Fade }
      })

      this.setCurrentRenderer()
        .then(resolve)
    })
  }

  setCurrentRenderer() {
    return new Promise((resolve) => {
      App.Highway.properties.renderer.then(() => {
        this.currentRenderer = App.Highway.To ? App.Highway.To : App.Highway.From

        resolve(this.currentRenderer)
      })
    })
  }

  resize() {
    store.w = {
      w: window.innerWidth,
      h: window.innerHeight,
      pixelRatio: Math.min(window.devicePixelRatio, 2)
    }

    this.currentRenderer.resize()
    this.menu && this.menu.resize()
  }

  scroll() {
    this.currentRenderer.scroll()
    this.menu && this.menu.scroll()
  }

	update() {
		this.currentRenderer.update()
		requestAnimationFrame(this.update)
	}

  events() {
    window.addEventListener('resize', this.resizeThrottled)
    window.addEventListener('resize', this.resizeDebounced)
    window.addEventListener('orientationchange', this.resize)

    if (store.smoothScroll) {
      store.smoothScroll && store.smoothScroll.on('scroll', this.scroll)
      store.smoothScroll.on('call', (value, way, object) => {
        this.currentRenderer.inView(value, way, object)
      })
    } else {
      window.addEventListener('scroll', this.scrollThrottled)
      window.addEventListener('scroll', this.scrollDebounced)
    }

    App.Highway.on('NAVIGATE_IN', () => {
      this.setCurrentRenderer().then((renderer) => {
        document.title = renderer.properties.page.title
      })

      this.lazyLoad.update()
    })

    App.Highway.on('NAVIGATE_END', ({ to, location }) => {
      if (typeof ga !== 'undefined') {
        ga('set', 'location', location.href);
        ga('set', 'page', location.pathname)
        ga('set', 'title', to.page.title)
        ga('send', 'pageview')
      }

      this.checkAnchor(location)
      listen({ el: to.view })

      if (!App.globalData.smoothScroll) {
        this.DOMObserver = null
        this.initDOMObserver()
      }

      this.detachAdminBarLinks(to)
    })

    window.addEventListener('highwayredirect', (e) => {
      App.Highway.redirect(e.detail.url)
    })
  }

  detachAdminBarLinks(to) {
    const adminBarLinks = document.body.querySelectorAll('#wpadminbar a')
    const newAdminBarLinks = to.page.body.querySelectorAll('#wpadminbar a')

    for (let i = 0; i < newAdminBarLinks.length; i++) adminBarLinks[i].href = newAdminBarLinks[i].href

    App.Highway.detach(adminBarLinks)
  }

  checkAnchor(location = null) {
    const bodyClassSubmit = Array.from(document.body.classList).find((elt) => elt.includes('formsubmit'))
    let anchor = null

    if (location && location.anchor) anchor = location.anchor
    else if (bodyClassSubmit) {
      const validate = document.querySelector('#gform_confirmation_message_' + bodyClassSubmit.split('-')[1])
      const error = document.querySelector('#gform_wrapper_' + bodyClassSubmit.split('-')[1])

      if (validate) anchor = 'gform_confirmation_message_' + bodyClassSubmit.split('-')[1]
      else if (error) anchor = 'gform_wrapper_' + bodyClassSubmit.split('-')[1]
    } else {
      const idx = window.location.href.indexOf('#')

      if (idx !== -1) anchor = window.location.href.substring(idx + 1)
    }

    if (anchor) {
      const el = document.querySelector('#' + anchor)

      if (el) {
        if (store.smoothScroll) {
          store.smoothScroll.scrollTo(el)
          store.smoothScroll.update()
        } else {
          const elRect = el.getBoundingClientRect()

          window.scrollTo(0, elRect.top)
        }
      }
    }
  }
}
