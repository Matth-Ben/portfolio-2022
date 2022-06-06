import gsap from 'gsap'
import store from './store'

export default class Loader {
  constructor() {
    this.getElems()
  }

  getElems() {
    store.panel = document.querySelector('.panel')
  }

  play() {
    return new Promise((resolve) => {
      const tl = gsap.timeline({
        onComplete: () => {
          resolve()
        }
      })

      tl.to(store.panel, {
        opacity: 0,
        duration: 0.6,
        ease: 'power3.out'
      })
    })
  }
}
