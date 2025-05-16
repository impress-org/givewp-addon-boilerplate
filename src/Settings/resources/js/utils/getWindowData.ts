import {IGiveAddon} from './interfaces';

declare const window: {
    GiveAddon: IGiveAddon;
} & Window;

export const getWindowData = () => window.GiveAddon;
