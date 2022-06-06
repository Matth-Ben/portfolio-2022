import Block from './Block'

export default class Video extends Block {
  onEnterCompleted() {
    this.observer()
  }

  getElems() {
    this.player = this.el.querySelector('.c-video__video')
    this.poster = this.el.querySelector('.c-video__poster')
    this.playButton = this.el.querySelector('.c-video__play')
  }

  events() {
    this.playButton && this.playButton.addEventListener('click', this.onPlayClick.bind(this))
  }

  onPlayClick() {
    this.poster && this.poster.classList.add('a')
    this.player.play()
  }

  observer() {
    const observer = new IntersectionObserver((entries) => {

      entries.forEach((entry) => {
        if (entry.intersectionRatio > 0) {
          if (this.player.paused) this.poster && this.poster.classList.remove('a')
          else {
            this.player.pause()
            this.poster && this.poster.classList.remove('a')
          }
        }
      });
    }, { threshold: 0.05 })

    observer.observe(this.player);
  }
}
