<div id="SVG_container"></div>
<script>
  (function (window, document) {
    'use strict'

    const file = '/img/sprite/sprite.svg'
    const revision = 1
    let data

    if (
      !document.createElementNS ||
      !document.createElementNS('http://www.w3.org/2000/svg', 'svg')
        .createSVGRect
    )
      return true

    const isLocalStorage = 'localStorage' in window && window.localStorage !== null

    if (isLocalStorage && localStorage.getItem('inlineSVGrev') === revision) {
      const data = localStorage.getItem('inlineSVGdata')
      if (data) {
        insert()
        return true
      }
    }

    function insertIT() {
      document.getElementById('SVG_container').insertAdjacentHTML('afterbegin', data)
    }

    function insert() {
      if (document.body) insertIT()
      else document.addEventListener('DOMContentLoaded', insertIT)
    }

    try {
      const request = new XMLHttpRequest()
      request.open('GET', file, true)
      request.onload = function () {
        if (request.status >= 200 && request.status < 400) {
          data = request.responseText
          insert()
          if (isLocalStorage) {
            localStorage.setItem('inlineSVGdata', data)
            localStorage.setItem('inlineSVGrev', revision)
          }
        }
      }
      request.send()
    } catch (e) {
    }
  })(window, document)
</script>
