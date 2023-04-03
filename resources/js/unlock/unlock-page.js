/**
 * Unlock view page
 * 
 */

/**
 * Pull server config variables from the page
 * 
 */
let authConfig = {
    'get_entries_url': $('#getEntriesUrl').val(),
    'unlock_id': $('#unlockId').val()
};


axios.get(authConfig.get_entries_url, { 
    'unlock_id': authConfig.unlock_id
}).then(function(res) {
    console.log(res.data);
}).catch(function(e) {

    try {
        if (e.response.data.message) {
            displayToast(e.response.data.message, 'exclamation-circle', 'danger');
        } else {
            displayToast('An unexpected error has occured. Please try again later.', 'exclamation-circle', 'danger');
        }
    } catch (err)
    {
        displayToast('An unexpected error has occured. Please try again later.', 'exclamation-circle', 'danger');
    }

});