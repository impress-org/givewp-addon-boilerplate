import {ColorOptionProps} from '../types/ColorOptionProps';

/**
 * @since 1.0.0
 */
export interface IGiveAddonFormBuilder {
    colors: ColorOptionProps[];
    colorSettingsUrl: string;
    globalOptionsUrl: string;
    sampleTags: {tag: string; desc: string}[];
    previewUrl: string;
}
