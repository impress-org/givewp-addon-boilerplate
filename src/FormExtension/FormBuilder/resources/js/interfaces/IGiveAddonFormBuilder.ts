import {colorProps} from '../types/ColorProps.ts.off';

/**
 * @since 1.0.0
 */
export interface IGiveAddonFormBuilder {
    colors: colorProps[];
    colorSettingsUrl: string;
    globalOptionsUrl: string;
    sampleTags: {tag: string; desc: string}[];
    previewUrl: string;

    setPdfPreviewUrl: string;
    customPdfPreviewUrl: string;
    templatesPdfTags: string;
    customPdfTags: string;
}
