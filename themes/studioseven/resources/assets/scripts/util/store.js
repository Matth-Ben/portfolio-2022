export default {
  debug: window.App.debug,
  smoothScroll: null,
  panel: null,
  detect: {
    uA: navigator.userAgent.toLowerCase(),
    get iPadIOS13() {
     return navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1
    },
    get isMobile() {
      return (/mobi|android|tablet|ipad|iphone/).test(this.uA) || this.iPadIOS13
    },
    get isMobileAndroid() {
      return (/android.*mobile/).test(this.uA)
    },
    get isFirefox() {
      return this.uA.indexOf('firefox') > -1
    },
    get isAndroid() {
      return this.isMobileAndroid || !this.isMobileAndroid && (/android/i).test(this.uA)
    },
    get safari() {
        return this.uA.match(/version\/[\d.]+.*safari/)
    },
    get isSafari() {
      return this.safari && !this.isAndroid
    }
  }
}
