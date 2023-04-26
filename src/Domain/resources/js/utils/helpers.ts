import {IADDON_ID} from './interfaces';

declare global {
    interface Window {
        ADDON_ID: IADDON_ID;
    }
}
export const imageUrl = (filename) => `${window.ADDON_ID.imageUrl}${filename}`;
