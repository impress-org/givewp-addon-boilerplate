/**
 * @link https://codex.wordpress.org/Javascript_Reference/wp.media
 * @link https://wordpress.stackexchange.com/a/382291
 */

import React from 'react';
import _ from 'lodash';
import {BaseControl, Button, TextControl} from '@wordpress/components';
import {upload} from '@wordpress/icons';
import {__} from '@wordpress/i18n';

/**
 * @since 3.1.0
 */
export default ({value, onChange}) => {
    // The media library uses Backbone.js, which can conflict with lodash.
    _.noConflict();
    let frame;

    const openMediaLibrary = (event) => {
        event.preventDefault();

        if (frame) {
            frame.open();
            return;
        }

        frame = window.wp.media({
            title: __('Add or upload file', 'give-addon-receipts'),
            button: {
                text: __('Use this media', 'give-addon-receipts'),
            },
            multiple: false, // Set to true to allow multiple files to be selected
        });

        frame.on('select', function () {
            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();

            onChange(attachment.url);
        });

        // Finally, open the modal on click
        frame.open();
    };
    return (
        <BaseControl
            id={'give-addon-settings__logo_upload'}
            label={__('Image URL', 'give-addon-receipts')}
            help={__('Max height of image should be 90px', 'give-addon-receipts')}
        >
            <div className={'give-addon-settings__logo_upload__wrapper'}>
                <TextControl type={'url'} value={value} onChange={onChange} />
                <Button icon={upload} variant={'secondary'} onClick={openMediaLibrary}>
                    {__('Add or upload file', 'give-addon-receipts')}
                </Button>
            </div>
        </BaseControl>
    );
};
