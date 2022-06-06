import gsap from 'gsap'
import BaseTransition from './baseTransition'
import store from '../util/store'

export default class Fade extends BaseTransition {
  constructor(e) {
    super(e)
  }

  hideLoader() {
    return new Promise((resolve) => {
      const tl = gsap.timeline({
        onStart: () => {
          this.scrollToTop()
        },
        onComplete: () => {
          store.smoothScroll && store.smoothScroll.update()
          this.resetScroll()
          resolve()
        }
      })

      tl.to(store.panel, {
        opacity: 0,
        duration: 0.35,
        ease: 'power3.out'
      }, 0)
    })
  }

  showLoader() {
    return new Promise((resolve) => {
      gsap.to(store.panel, {
        opacity: 1,
        duration: 0.35,
        ease: 'power3.out',
        onComplete: () => {
          resolve()
        }
      })
    })
  }
}
