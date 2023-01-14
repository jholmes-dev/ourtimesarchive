import './bootstrap';
import $ from 'jquery';
window.$ = $;

// Initialize and display all server-passed toasts
var toastElList = [].slice.call(document.querySelectorAll('.toast'))
var toastList = toastElList.map(function (toastEl) {
  return new bootstrap.Toast(toastEl, { 'delay': 10000 })
});

for (let i = 0; i < toastList.length; i++) {
    toastList[i].show();
}

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl)
})

/** 
 * Creates and displays toast messages from input variables
 *
 * @param String message : The toast message
 * @param String icon : The toast icon, passed as a Bootstrap icon unique class, without the leading 'bs-'
 * @param String background : The toast background color, passed as a Bootstrap background class, without the leading 'bs-'
 * @param Boolean autohide : Whether the toast should hide automatically after a set duration
 * @param Integer delay : The delay in ms before the toast autohides
 */
function displayToast(message, icon = 'info-circle', background = 'info', autohide = true, delay = 10000)
{
	// Create HTML
	let toastParent = $('<div>').addClass('toast align-items-center text-white border-0 bg-' + background).attr({
		'role': 'alert',
		'aria-live': 'assertive',
		'aria-atomic': 'true'
	});
	let toastInner = $('<div>').addClass('d-flex');
	let toastBody = $('<div>').addClass('toast-body');
	let toastIcon = $('<i>').addClass('bi fs-4 me-2 lh-1 bi-' + icon);
	let toastContent = $('<span>').html(message);
	let toastButton = $('<button>').addClass('btn-close btn-close-white me-2 m-auto').attr({
		'data-bs-dismiss': 'toast',
		'aria-label': 'close'
	});

	// Assemble
	toastIcon.appendTo(toastBody);
	toastContent.appendTo(toastBody);
	toastBody.appendTo(toastInner);
	toastButton.appendTo(toastInner);
	toastInner.appendTo(toastParent);

	// Attach to DOM
	$('#mainToastContainer').append(toastParent);

	// Activate as toast and show
	let toastElement = new bootstrap.Toast(toastParent, {
		'delay': delay,
		'autohide': autohide
	});
	toastElement.show();

}
window.displayToast = displayToast;