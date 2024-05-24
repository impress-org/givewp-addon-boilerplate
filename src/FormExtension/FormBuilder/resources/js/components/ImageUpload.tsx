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
            title: __('Add or upload file', 'ADDON_TEXTDOMAIN-receipts'),
            button: {
                text: __('Use this media', 'ADDON_TEXTDOMAIN-receipts'),
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
            id={'ADDON_TEXTDOMAIN-settings__logo_upload'}
            label={__('Image URL', 'ADDON_TEXTDOMAIN-receipts')}
            help={__('Max height of image should be 90px', 'ADDON_TEXTDOMAIN-receipts')}
        >
            <div className={'ADDON_TEXTDOMAIN-settings__logo_upload__wrapper'}>
                <TextControl type={'url'} value={value} onChange={onChange} />
                <Button icon={upload} variant={'secondary'} onClick={openMediaLibrary}>
                    {__('Add or upload file', 'ADDON_TEXTDOMAIN-receipts')}
                </Button>
            </div>
        </BaseControl>
    );
};
