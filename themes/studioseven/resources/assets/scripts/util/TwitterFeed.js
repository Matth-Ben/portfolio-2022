class TwitterFeed {
  constructor() {
    this.getDatas()
  }

  /**
   * Connect to a custom endpoint and return all the datas for each tweets
   * @returns {Array} An array of data for each tweets
   */
  getDatas() {
    return new Promise((resolve) => {
      const xmlhttp = new XMLHttpRequest()
      const url = window.location.origin + '/wp-json/studioseven/v1/twitterfeed/'

      xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
          this.tweets = JSON.parse(xmlhttp.responseText)
          resolve(this.tweets)
        }
      }

      xmlhttp.open('GET', url, true)
      xmlhttp.onerror = () => {
        console.log('🚨 An error occurred during the AJAX request of twitter feed.')
      }
      xmlhttp.send()
    })
  }
}
export default TwitterFeed
