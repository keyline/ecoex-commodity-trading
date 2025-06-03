document.documentElement.classList.add("no-scroll");
document.body.classList.add("no-scroll");

window.addEventListener("load", function () {
  var loader = document.getElementById("loader");
  if (loader) {
    loader.style.display = "none";
  }
  var content = document.getElementById("main");
  if (content) {
    content.style.display = "block";
  }
  document.documentElement.classList.remove("no-scroll");
  document.body.classList.remove("no-scroll");
});
