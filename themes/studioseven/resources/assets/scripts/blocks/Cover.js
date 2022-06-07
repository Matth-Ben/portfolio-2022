import Block from './Block'

export default class Cover extends Block {
  onEnterCompleted() {}

  bindMethods() {}

  getElems() {
    this.player = this.el.querySelector('.e-title')
    this.arr = []
  }

  init() {
    this.arr = this.player.textContent.split(' ');
    this.player.innerHTML = '';
    this.arr.forEach((element) => {
      this.player.innerHTML += '<span>' + element + '</span>'
    });
  }

  events() {}

  destroy() {}

  resize() {}

  scroll() {}

  inView() {}

  update() {}
}
