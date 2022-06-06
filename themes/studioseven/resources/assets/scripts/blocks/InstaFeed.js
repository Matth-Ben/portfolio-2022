import Block from './Block'
import Instafeed from '../util/Instafeed'
import store from '../util/store'

export default class InstaFeed extends Block {
  init() {
    this.a = window.App

    this.createFeed()
  }

  createFeed() {
    this.feed = new Instafeed(
    {
      accessToken: this.a.instagram.accessToken,
      clientId: this.a.instagram.clientId,
      target: 'instafeed',
      get: 'user',
      userId: this.a.instagram.userId,
      template: '<div class="feed-square"><a href="{{link}}" aria-label="Photo Instagram" target="_blank" rel="noopener"><img src="{{image}}" alt="Photo Instagram"/></a></div>',
      limit: 5,
      sortBy: 'most-recent',
      after: () => {
        store.smoothScroll && store.smoothScroll.update()
      }
    })
    this.feed.run()
  }
}
