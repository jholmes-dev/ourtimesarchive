/**
 * Unlock view page
 * 
 */
import { UnlockEntryHandler } from './UnlockEntryHandler';

let entryHandler = new UnlockEntryHandler();
init();

async function init() {
    let res = await entryHandler.getEntries();
    entryHandler.initPage();
}

$('#nextEntry').on('click', function() {
    entryHandler.loadNextEntry();
});
$('#prevEntry').on('click', function() {
    entryHandler.loadPreviousEntry();
});

$('#nextSlide').on('click', function() {
    entryHandler.loadNextSlide();
});
$('#prevSlide').on('click', function() {
    entryHandler.loadPreviousSlide();
});

$('#entry-thumbnail-wrapper').on('click', '.entry-assets-thumbnail', function() {
    entryHandler.setSlideIndex( Number($(this).attr('slideindex')) );
    entryHandler.loadSlide();
});