import {BlockConfiguration} from '@wordpress/blocks';

/**
 * @since 1.0.0
 */
export interface IGiveCore {
    form: {
        blocks: {
            register: (name: string, settings: BlockConfiguration) => void;
        };
        slots: any;
    };
}
