(function(){
  "use strict";
  var BASE = "https://cdn.daosmm.com/";
  var tags = document.querySelectorAll("h6");
  for (var i = 0; i < tags.length; i++) {
    var text = tags[i].textContent.trim();
    var match = text.match(/^\[(.+)\]$/);
    if (match) {
      var url = match[1];
      if (url.indexOf(".html") === -1 && url.indexOf(".php") === -1) url += ".html";
      var iframe = document.createElement("iframe");
      iframe.src = BASE + url;
      iframe.style.width = "100%";
      iframe.style.maxWidth = "100%";
      iframe.style.border = "none";
      iframe.style.minHeight = "600px";
      iframe.style.display = "block";
      iframe.loading = "lazy";
      if (window.innerWidth <= 600) {
        iframe.style.minHeight = "750px";
      }
      tags[i].parentNode.replaceChild(iframe, tags[i]);
    }
  }

  // Listen for redirect messages from iframe - navigate parent page
  window.addEventListener("message", function(e) {
    if (e.data && e.data.type === "redirect" && e.data.url) {
      var slug = e.data.url.replace(".html", "");
      window.location.href = "/" + slug + "/";
    }
  });
})();
