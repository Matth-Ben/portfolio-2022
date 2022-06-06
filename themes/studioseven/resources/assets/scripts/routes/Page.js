import Highway from '@dogstudio/highway'
import { browser } from '../util/browserInfo'
import blockList from '../blocks/blockList'
import store from '../util/store'

export default class Page extends Highway.Renderer {
  isEdge() {
    return browser.name === 'Microsoft Edge'
  }

  isIE() {
    return browser.name === 'Internet Explorer'
  }

  checkEdgeElems() {
    if (!this.isEdge()) return

    const elems = document.querySelectorAll('.checkEdge')

    for (let i = 0; i < elems.length; i++) {
        elems[i].classList.add('isEdge')
    }
  }

  checkIEElems() {
    if (!this.isIE()) return

    const elems = document.querySelectorAll('.checkIE')

    for (let i = 0; i < elems.length; i++) {
        elems[i].classList.add('isIE')
    }
  }

  isSafari() {
    return browser.name === 'Safari'
  }

  checkSafariElems() {
    if (!this.isSafari()) return

    const elems = document.querySelectorAll('.checkSafari')

    for (let i = 0; i < elems.length; i++) {
      elems[i].classList.add('isSafari')
    }
  }

  /**
  * NOTE: `this.props` is an object passed in
  * parameter when calling `super.onEnter()`
  * from a child Page
  *
  * @param {Boolean} props - An object with a `hasMap` key, if `true`, Google Map will init on this page
  *
  * @returns {void}
  */
  onEnter(props = {}) {
    this.view = this.wrap.lastElementChild

    this.props = props

    this.checkEdgeElems()
    this.checkIEElems()
    this.checkSafariElems()

    this.blockList = blockList
    this.blocks = []
    if (this.blockList && this.blockList.length) this.initBlocks()
  }

  initBlocks() {
    store.detect.isMobile && (this.blockList = this.blockList.filter((e) => e.mobile !== false))

    for (let i = 0; i < this.blockList.length; i++) {
      const foundBlocks = this.view.querySelectorAll('.' + this.blockList[i].name)
      const block = {
        name: this.blockList[i].name,
        instances: []
      }

      for (let j = 0; j < foundBlocks.length; j++) {
        const { fileName, hasMobileBlock } = this.blockList[i]
        const file = store.detect.isMobile && hasMobileBlock ? 'mobile/' + fileName : fileName

        // eslint-disable-next-line no-loop-func
        import('../blocks/' + file).then(({ default: BlockInstance }) => {
          block.instances.push({
            el: foundBlocks[j],
            class: new BlockInstance(foundBlocks[j])
          })
        })
      }

      this.blocks.push(block)
    }
  }

  onEnterCompleted() {
    for (let i = 0; i < this.blocks.length; i++) {
      for (let j = 0; j < this.blocks[i].instances.length; j++) {
        this.blocks[i].instances[j].class.onEnterCompleted()
      }
    }
  }

  onLeave() {
    for (let i = 0; i < this.blocks.length; i++) {
      for (let j = 0; j < this.blocks[i].instances.length; j++) {
        if (!this.blocks[i].instances[j].class.destroyLast) this.blocks[i].instances[j].class.destroy()
      }
    }
  }

  onLeaveCompleted() {
    // Destroy blocks with `destroyLast` property set to `true`
    for (let i = 0; i < this.blocks.length; i++) {
      for (let j = 0; j < this.blocks[i].instances.length; j++) {
        if (this.blocks[i].instances[j].class.destroyLast) this.blocks[i].instances[j].class.destroy()
      }
    }
  }

  resize() {
    for (let i = 0; i < this.blocks.length; i++) {
      for (let j = 0; j < this.blocks[i].instances.length; j++) {
        this.blocks[i].instances[j].class.resize()
      }
    }
  }

  scroll(e) {
    for (let i = 0; i < this.blocks.length; i++) {
      for (let j = 0; j < this.blocks[i].instances.length; j++) {
        this.blocks[i].instances[j].class.scroll(e)
      }
    }
  }

  inView(value, way, object) {
    for (let i = 0; i < this.blocks.length; i++) {
      for (let j = 0; j < this.blocks[i].instances.length; j++) {
        if (this.blocks[i].instances[j].el === object.el) this.blocks[i].instances[j].class.inView(value, way, object)
      }
    }
  }

  update() {
    if (this.blocks) {
      for (let i = 0; i < this.blocks.length; i++) {
        for (let j = 0; j < this.blocks[i].instances.length; j++) {
          this.blocks[i].instances[j].class.update()
        }
      }
    }
  }
}
