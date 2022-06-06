export default class DOMObserver {
  constructor(callback) {
    this.observers = []
    this.callback = callback

    this.getElems()
    this.initObservers()
  }

  getElems() {
    this.observableElts = document.body.querySelectorAll('.js-observer')
  }

  initObservers() {
    for (let i = 0; i < this.observableElts.length; i++) {
      const observableElt = this.observableElts[i]
      const config = { threshold: parseFloat(observableElt.dataset.threshold) || 0.25 }
      const observer = new IntersectionObserver((entries) => {
        for (let j = 0; j < entries.length; j++) {
          if (entries[j].intersectionRatio > 0) {
            this.onObserve(observer)
            this.unobserve(observer)
          }
        }
      }, config)

      observableElt.classList.remove('js-observer')
      observer.observe(observableElt)

      this.observers.push({
        observer,
        target: observableElt
      })
    }
  }

  onObserve(intersectionObserver) {
    const observer = this.observers.filter((anObserver) => anObserver.observer === intersectionObserver)[0]

    if (!observer) return

    observer.target.classList.add('visible')

    this.callback && this.callback(observer.target)
  }

  unobserve(intersectionObserver = null) {
    const observers = intersectionObserver ? this.observers.filter((observer) => observer.observer === intersectionObserver) : this.observers

    if (!observers.length) return

    for (let i = 0; i < observers.length; i++) {
      observers[i].observer.unobserve(observers[i].target)
    }
  }
}
