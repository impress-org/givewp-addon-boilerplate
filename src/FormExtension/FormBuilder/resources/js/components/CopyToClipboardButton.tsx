import {__} from '@wordpress/i18n';
import {Button} from '@wordpress/components';
import {useCopyToClipboard} from '@wordpress/compose';
import {copy as copyIcon} from '@wordpress/icons';
import type {Ref} from 'react';
import {useState} from 'react';

type CopyClipboardButtonProps = {textToCopy: string};

/**
 * @since 3.1.0
 */
const CopyToClipboardButton = ({textToCopy}: CopyClipboardButtonProps) => {
    const [isCopied, setCopied] = useState(false);
    const ref = useCopyToClipboard(textToCopy, () => {
        setCopied(true);

        return setTimeout(() => setCopied(false), 1000);
    });

    return (
        <Button
            className="givewp-popover-content-settings__copy-button"
            isSmall
            variant="tertiary"
            ref={ref as Ref<HTMLAnchorElement>}
            icon={copyIcon}
        >
            {isCopied ? __('Copied!', 'give-pdf-receipts') : __('Copy Tag', 'give-pdf-receipts')}
        </Button>
    );
};

export default CopyToClipboardButton;
