/**
 * Unlock authorization page handling
 * 
 */


axios.post(authConfig.auth_url, {
    'uaid': 1,
    'uid': 1,
    'password': 'root'
}).then(function(res) {
    console.log(res);
});

// Sends a user's auth request to the API for verification
function sendAuthRequest(user, pass)
{
    //
}