import Block from './Block'

export default class SocialMedia extends Block {
  onEnterCompleted() {
    super.onEnterCompleted()

    this.copied = false

    this.bindMethods()
  }

  bindMethods() {
    this.toggle = this.toggle.bind(this)
    this.copyToClipboard = this.copyToClipboard.bind(this)
  }

  getElems() {
    super.getElems()

    this.socialToggler = this.el.querySelector('.social-toggler')
    this.copyLink = this.el.querySelector('.copy')
    if (this.copyLink) this.msg = this.copyLink.querySelector('.msg')
  }

  events() {
    super.events()
  
    this.socialToggler.addEventListener('click', this.toggle)
    if (this.copyLink) this.copyLink.addEventListener('click', this.copyToClipboard)
  }

  toggle() {
    this.el.classList.toggle('show')
  }

  copyToClipboard() {
    if (this.copied) return;
    
    this.copied = true
    const textArea = document.createElement('textarea')
    
    textArea.value = this.copyLink.dataset.link
    this.copyLink.appendChild(textArea);
    textArea.select()
    
    try {
      document.execCommand('copy')
      
      this.msg.innerHTML = 'Copié'
      this.msg.classList.add('visible')
      
      window.setTimeout(() => {
        this.msg.classList.remove('visible')
      }, 2500)
      
      window.setTimeout(() => {
        this.msg.innerHTML = ''
        this.copied = false
      }, 3500)
    } catch (err) {
      this.msg.innerHTML = 'Erreur'
      this.msg.classList.add('visible')
      
      window.setTimeout(() => {
        this.msg.classList.remove('visible')
      }, 2500)
      
      window.setTimeout(() => {
        this.msg.innerHTML = ''
        this.copied = false
      }, 3500)
    }
    
    this.copyLink.removeChild(textArea);
  }

  destroy() {
    super.destroy()

    this.socialToggler.removeEventListener('click', this.toggle)
  }

  resize() {}

  scroll() {}

  update() {}
}
