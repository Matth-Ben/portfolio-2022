export default class Grid {
  constructor() {
    this.getElems()
    this.addEvents()
  }

  getElems() {
    this.grid = document.querySelector('.grid')
  }

  addEvents() {
    document.addEventListener('keydown', (e) => {
      this.grid && this.grid.classList.toggle('g', !this.grid.classList.contains('g') && e.key === 'g')
    })
  }
}

