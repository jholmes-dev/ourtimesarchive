/**
 * Handles all entry related actions and tracking
 * 
 */
class UnlockEntryHandler
{
    /**
     * Contains all entries returned from the API call
     * 
     * @var {Object}
     */
    #entries;

    /**
     * Current entry index
     * 
     * @var {Integer}
     */
    currentIndex = 0;

    /**
     * Get Entries API endpoint
     * 
     * @var {String}
     */
    getEntriesUrl;


    /**
     * Retrieve entries API URL from input field
     * 
     */
    constructor()
    {
        this.getEntriesUrl = $('#getEntriesUrl').val();
    }


    /**
     * Retrieves and stores entries from the database
     * 
     * @return {Promise}
     */
    async getEntries()
    {
        return axios.get(this.getEntriesUrl).then((res) => {
            this.#entries = res.data;
            return res.status;
        }).catch(function(e) {
            try {
                if (e.response.data.message) {
                    displayToast(e.response.data.message, 'exclamation-circle', 'danger');
                } else {
                    displayToast('An unexpected error has occured. Please try again later.', 'exclamation-circle', 'danger');
                }
            } catch (err) {
                displayToast('An unexpected error has occured. Please try again later.', 'exclamation-circle', 'danger');
            }
            return e.code;
        });
    }


    /**
     * Clears loading icon, and initializes page for first load
     * 
     */
    initPage()
    {
        // TODO:
        //  Add loading icon
        //  Clear loading icon here
        //  Create functions for:
        //   FadeIn
        //   FadeOut
        //   Clear
        //   Load
        // In this function: Clear Loading Icon -> Load -> FadeIn
    }



} // end UnlockEntryHandler

export { UnlockEntryHandler };