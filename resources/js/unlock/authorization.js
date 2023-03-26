/**
 * Unlock authorization page handling
 * 
 */

/**
 * Pull server config variables from the page
 * 
 */
let authConfig = {
    'auth_url': $('#authUrl').val()
};

/**
 * Handles authorization form submission
 * 
 */
$('.submitAuthorization').on('click', function() {
    let authIndex = parseInt($(this).attr('authindex'));

    sendAuthRequest(
        $('.uidInput' + authIndex).val(),
        $('.passwordInput' + authIndex).val(),
        $('.uaidInput' + authIndex).val(),
        $('.uauth' + authIndex)
    );
});

/**
 * Sends authorization request to server and processes the response
 * 
 * @param {String} user_id 
 * @param {String} pass 
 * @param {String} ua_id
 * @param {jQueryElement} parent_element
 */
function sendAuthRequest(user_id, pass, ua_id, parent_element)
{
    axios.post(authConfig.auth_url, { 
        'uaid': ua_id,
        'uid': user_id,
        'password': pass
    }).then(function(res) {
        uAuthSuccess(parent_element);
    }).catch(function(e) {
        if (e.response.data.message) {
            displayToast(e.response.data.message, 'exclamation-circle', 'danger');
        } else {
            displayToast('An unexpected error has occured. Please try again later.', 'exclamation-circle', 'danger');
        }
    });

}

/**
 * Handles transitions and checks after a successful authorization
 * 
 * @param {jQueryElement} ele
 */
function uAuthSuccess(ele)
{
    ele.addClass('uauth-success');
    
    if ($('.uauth-success').length == $('.unlock-auth').length) {
        displayToast('Vault unlock has been authorized! You will be redirected shortly.', 'check2-circle', 'success');
        setTimeout(function() {
            location.reload();
        }, 2000)
    }
}