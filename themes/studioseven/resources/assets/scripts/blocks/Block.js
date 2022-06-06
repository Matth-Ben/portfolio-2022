export default class Block {
  constructor(el, destroyLast) {
    this.el = el;
    this.destroyLast = destroyLast;

    this.bindMethods()
    this.getElems()
    this.init()
    this.events()
  }

  onEnterCompleted() {}

  bindMethods() {}

  getElems() {}

  init() {}

  events() {}

  destroy() {}

  resize() {}

  scroll() {}

  inView() {}

  update() {}
}
