export default function getXhr() {
  let xhr = null;
  try {
    xhr = new XMLHttpRequest();
    console.log("Your browser support AJAX!");
  } catch (e) {
    try {
      xhr = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xhr = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {
        console.log("Error: Browser does not support AJAX!");
      }
    }
  }
  return xhr;
}
