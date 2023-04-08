/**
 * Unlock view page
 * 
 */
import { UnlockEntryHandler } from './UnlockEntryHandler';

let entryHandler = new UnlockEntryHandler();
init();

async function init() {
    let res = await entryHandler.getEntries();
}