const textToCopy = document.querySelector(".csgo");

textToCopy.onclick = function() {
  document.execCommand("copy");
}

textToCopy.addEventListener("copy", function(onClick) {
    onClick.preventDefault();
  if (onClick.clipboardData) {
    onClick.clipboardData.setData("text/plain", textToCopy.textContent);
    console.log(onClick.clipboardData.getData("text"))
  }
});