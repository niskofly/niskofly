<div id="SVG_container"></div>
<script>
  (function (window, document) {
    "use strict";

    let file = "/img/sprite/sprite.svg",
      revision = 1.3;

    if (
      !document.createElementNS ||
      !document.createElementNS("http://www.w3.org/2000/svg", "svg")
        .createSVGRect
    )
      return true;

    let isLocalStorage =
      "localStorage" in window && window["localStorage"] !== null,
      request,
      data,
      SVG_container = document.getElementById("SVG_container"),
      insertIT = function () {
        SVG_container.insertAdjacentHTML("afterbegin", data);
      },
      insert = function () {
        if (document.body) insertIT();
        else document.addEventListener("DOMContentLoaded", insertIT);
      };

    if (isLocalStorage && localStorage.getItem("inlineSVGrev") == revision) {
      data = localStorage.getItem("inlineSVGdata");
      if (data) {
        insert();
        return true;
      }
    }

    try {
      request = new XMLHttpRequest();
      request.open("GET", file, true);
      request.onload = function () {
        if (request.status >= 200 && request.status < 400) {
          data = request.responseText;
          insert();
          if (isLocalStorage) {
            localStorage.setItem("inlineSVGdata", data);
            localStorage.setItem("inlineSVGrev", revision);
          }
        }
      };
      request.send();
    } catch (e) {
    }
  })(window, document);
</script>
