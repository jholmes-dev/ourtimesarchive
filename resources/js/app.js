import './bootstrap';
import $ from 'jquery';
window.$ = $;

var toastElList = [].slice.call(document.querySelectorAll('.toast'))
var toastList = toastElList.map(function (toastEl) {
  return new bootstrap.Toast(toastEl, 'show')
});

for (let i = 0; i < toastList.length; i++) {
    toastList[i].show();
}