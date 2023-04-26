import {IGiveAddon} from './interfaces';

declare global {
    interface Window {
        ADDON_ID: IGiveAddon;
    }
}
export const imageUrl = (filename) => `${window.ADDON_ID.imageUrl}${filename}`;
