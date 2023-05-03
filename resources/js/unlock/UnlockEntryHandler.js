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
     * Tracks the load index number to prevent loading overlap
     * 
     * @var {Integer}
     */
    loadIndex = 0;

    /**
     * Current slideshow image index
     * 
     * @var {Integer}
     */
    slideIndex = 0;

    /**
     * Months of the year for the date function
     * 
     * @var {Array}
     */
    months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

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
     * Returns the entry associated with the current index
     * 
     * @return {Object}
     */
    currentEntry()
    {
        return this.#entries[this.currentIndex];
    }

    
    /**
     * Returns the formatted date associated with the current entry
     * 
     * @return {String}
     */
    getFormattedDate()
    {
        let curDate = new Date(this.currentEntry().date);
        return this.months[curDate.getUTCMonth()] + " " + curDate.getUTCDate() + ", " + curDate.getUTCFullYear();
    }


    /**
     * Clears loading icon, and initializes page for first load
     * 
     */
    initPage()
    {
        $('.entry-loading').fadeOut(1000, () => {
            this.loadEntry();
        });
    }
    

    /**
     * Increases the entry index
     * 
     */
    increaseIndex()
    {
        this.currentIndex = (this.currentIndex >= this.#entries.length - 1) ? 0 : this.currentIndex + 1;
    }
    

    /**
     * Decreases the entry index
     * 
     */
    decreaseIndex()
    {
        this.currentIndex = (this.currentIndex <= 0) ? this.#entries.length - 1 : this.currentIndex - 1;
    }


    /**
     * Sets the index to a specific number
     * 
     * @param {Integer} newIndex
     */
    setIndex(newIndex)
    {
        this.currentIndex = newIndex;
    }

    /**
     * Changes the element index to a specific number, then loads it
     * 
     * @param {Integer} newIndex 
     */
    async loadSpecificEntry(newIndex)
    {
        this.setIndex(newIndex);

        // Load index tracking so we know if another load function has been called during the await
        this.loadIndex++;
        let tempLoadIndex = this.loadIndex;
        await this.fadeEntryOut();
        if (this.loadIndex !== tempLoadIndex) return;

        this.loadEntry();
    }


    /**
     * Increases the entry index the loads it
     * 
     */
    async loadNextEntry()
    {
        this.increaseIndex();
        
        // Load index tracking so we know if another load function has been called during the await
        this.loadIndex++;
        let tempLoadIndex = this.loadIndex;
        await this.fadeEntryOut();
        if (this.loadIndex !== tempLoadIndex) return;

        this.loadEntry();
    }


    /**
     * Decreases the entry index then loads it
     * 
     */
    async loadPreviousEntry()
    {
        this.decreaseIndex();

        // Load index tracking so we know if another load function has been called during the await
        this.loadIndex++;
        let tempLoadIndex = this.loadIndex;
        await this.fadeEntryOut();
        if (this.loadIndex !== tempLoadIndex) return;

        this.loadEntry();
    }


    /**
     * Loads the current entry
     * 
     */
    async loadEntry()
    {
        console.log(this.currentEntry());
        this.clearEntry();

        $('#entry-date').html(this.getFormattedDate());
        $('#entry-title').html(this.currentEntry().title);
        $('#entry-author').html(this.currentEntry().author);
        $('#entry-content').html(this.currentEntry().content);

        this.loadSlideshow();
        await this.loadMap();

        this.fadeEntryIn();
    }


    /**
     * Clears the current entry
     * 
     */
    clearEntry()
    {
        $('#entry-date').html("");
        $('#entry-title').html("");
        $('#entry-author').html("");
        $('#entry-content').html("");
        this.destroySlideshow();
        this.destroyMap();
    }


    /**
     * Handles loading the Google Map related to the location
     * 
     */
    loadMap()
    {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve();
            }, 1);
        });
    }


    /**
     * Resets the map and gets it ready for a new map
     * 
     */
    destroyMap() {
        //
    }


    /**
     * Handles fading the entry in
     * 
     */
    fadeEntryIn()
    {
        $('#entry-inner-wrapper').addClass('load-entry');
    }


    /**
     * Handles fading the entry out
     * 
     * @return {Promise}
     */
    fadeEntryOut()
    {
        $('.load-entry').removeClass('load-entry');

        return new Promise((resolve) => {
            setTimeout(() => {
                resolve();
            }, 600);
        });
    }


    /**
     * Handles loading the images into a slideshow
     * 
     */
    loadSlideshow()
    {
        // Check if the entry has slides, if not then apply a flag class and stop
        if (this.currentEntry().images.length == 0) {
            $('#entry-inner-wrapper').addClass('entry-no-images');
            return;
        } else if (this.currentEntry().images.length == 1) {
            $('#entry-inner-wrapper').addClass('entry-single-image');
        }

        // Create the slides and add them to the DOM
        for (let i = 0; i < this.currentEntry().images.length; i++)
        {
            // Generate main slides
            $('<div>').addClass('entry-assets-image').css({
                'background-image': 'url("' + this.currentEntry().images[i] + '")'
            }).appendTo($('#entry-assets-wrapper'));

            // Generate navigation thumbnails
            let slideThumbnail = $('<div>').addClass('entry-assets-thumbnail').css({
                'background-image': 'url("' + this.currentEntry().images[i] + '")'
            }).attr('slideindex', i);
            
            if (i == 0) {
                slideThumbnail.addClass('active');
            }

            slideThumbnail.appendTo($('#entry-thumbnail-wrapper'));
        }
        /*
        Style slides
        Slide thumbnails
        No slide controls if single image
        Make it all work better
        Lightbox
         */
    }


    /**
     * Resets the slideshow and gets it ready for new slides
     * 
     */
    destroySlideshow()
    {
        this.setSlideIndex(0);
        this.loadSlide();
        this.clearSlideClasses();
        $('#entry-assets-wrapper').html("");
        $('#entry-thumbnail-wrapper').html("");
    }


    /**
     * Increases the slider's index
     * 
     */
    increaseSlideIndex()
    {
        this.slideIndex = (this.slideIndex >= this.currentEntry().images.length - 1) ? 0 : this.slideIndex + 1;
    }


    /**
     * Decreases the slider's index
     * 
     */
    decreaseSlideIndex()
    {
        this.slideIndex = (this.slideIndex <= 0) ? this.currentEntry().images.length - 1 : this.slideIndex - 1;
    }


    /**
     * Sets the slideshow's index to a specific number
     * 
     * @param {Integer} newIndex 
     */
    setSlideIndex(newIndex)
    {
        this.slideIndex = newIndex;
    }


    /**
     * Loads the previous slide in the slideshow
     * 
     */
    loadNextSlide()
    {
        this.increaseSlideIndex();
        this.loadSlide();
    }


    /**
     * Loads a specific slide 
     * 
     */
    loadPreviousSlide()
    {
        this.decreaseSlideIndex();
        this.loadSlide();
    }


    /**
     * Handles updating the slideshow to display the current slide
     * 
     */
    loadSlide()
    {
        $('#entry-assets-wrapper').css({
            'transform': 'translateX(-' + (this.slideIndex * 100) + '%)',
        });

        $('.entry-assets-thumbnail.active').removeClass('active');
        $($('.entry-assets-thumbnail')[this.slideIndex]).addClass('active');
    }

    /**
     * Clears any state classes applied to the slideshow
     * 
     */
    clearSlideClasses()
    {
        $('#entry-inner-wrapper').removeClass('entry-no-images');
        $('#entry-inner-wrapper').removeClass('entry-single-image');
    }


} // end UnlockEntryHandler

export { UnlockEntryHandler };