/**
 * JS file for handling a single image upload field
 * 
 */


$('#imageUpload').on('change', function(e) {

    let files = e.target.files,
        maxSize = parseInt($(this).attr('data-max-size'));

    if (!files[0].type.match('image.*')) {
        displayToast('Only images are accepted for upload', 'exclamation-circle', 'danger');
        resetImageUpload();
        return;
    }

    if (files[0].size > maxSize) {
        displayToast('Image exceeds size restriction of ' + Math.round(maxSize / 1024 / 1024) + 'Mb', 'exclamation-circle', 'danger');
        resetImageUpload();
        return;
    }

    loadImageElement(files[0]);

});

/**
 * Handles image insertion into the dom including loading handling
 * 
 * @param File image : JavaScript File containing image data
 */
function loadImageElement(image)
{
    // Clear container and hold container height
    $('#imageUploadLabel').html('').addClass('iul-holdheight');

    // Add spinner
    let tmpSpinner = $('<div class="spinner-border text-primary"></div>');
    $('#imageUploadLabel').append(tmpSpinner);

    // Start image load
    let reader = new FileReader();
    reader.onload = function (e) {
        tmpSpinner.after(generateImageElement(e.target.result));
        tmpSpinner.remove();
        $('#imageUploadLabel').removeClass('iul-holdheight');
    }
    reader.readAsDataURL(image);
}

/**
 * Resets the image upload label to default state
 * 
 */
function resetImageUpload()
{
    $('#imageUpload').val('');
    $('#imageUploadLabel').html('<i class="upload-icon bi bi-plus-circle"></i>').addClass('iul-holdheight');
}

/**
 * Generates an HTML element to show the preview of uploaded images
 * Returns the jQuery selector for direct insertion into the DOM
 * 
 * <div class="image-upload">
 *     <div class="image-spinner-wrapper"><div class="spinner-border text-primary"></div></div>
 *     <div class="image-upload-preview"></div>
 *     <div class="image-upload-delete"><i class="bi bi-x-circle-fill"></i></div>
 * </div>
 * 
 * @param File imgData : JavaScript File containing image data
 * @return jQuerySelector
 */
function generateImageElement(imgData)
{
    let containerElement = $('<div>').addClass('image-upload');
    
    // The image container
    $('<img>').attr({
        'class': 'image-upload-preview',
        'src': imgData
    }).appendTo(containerElement);

    return containerElement;
}