import {IGiveAddon} from './interfaces';

declare global {
    interface Window {
        GiveAddon: IGiveAddon;
    }
}
export const imageUrl = (filename) => `${window.GiveAddon.imageUrl}${filename}`;
