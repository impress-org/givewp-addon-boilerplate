import {IGiveCore} from './interfaces/IGiveCore';
import {IGiveAddonFormBuilder} from './interfaces/IGiveAddonFormBuilder';

declare const window: {
    givewp: IGiveCore;
    GiveAddon: IGiveAddonFormBuilder;
} & Window;

/**
 * @since 1.0.0
 */
export function getGiveAddonFormBuilderWindowData() {
    return window.GiveAddon;
}
