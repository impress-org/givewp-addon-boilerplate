import {IGiveCore} from './interfaces/IGiveCore';
import {IGiveAddonFormBuilder} from './interfaces/IGiveAddonFormBuilder';

declare const window: {
    givewp: IGiveCore;
    GiveAddonFormBuilder: IGiveAddonFormBuilder;
} & Window;

/**
 * @since 1.0.0
 */
export function getGiveCoreFormBuilderWindowData() {
    return window.givewp;
}

/**
 * @since 1.0.0
 */
export function getGiveAddonFormBuilderWindowData() {
    console.log(window.GiveAddonFormBuilder);
    return window.GiveAddonFormBuilder;
}
