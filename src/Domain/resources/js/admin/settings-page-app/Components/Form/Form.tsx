import React, {useState} from 'react';
import styles from './Form.module.scss';
import Button from './Button';
import {InfoIcon} from '../Icons';
import {__} from '@wordpress/i18n';

interface FormProps {
    setShowModal: Function;
}

const Form = ({setShowModal}: FormProps) => {
    const [submitting, setSubmitting] = useState<boolean>(false);

    function handleSubmit(event) {
        event.preventDefault();
        setSubmitting(true);
        alert('Handle Submitting Here');
        setShowModal(false);
        return false;
    }

    return (
        <form className={styles['formContainer']} onSubmit={handleSubmit}>
            <fieldset className={styles['periodSelectorContainer']}>
                <label htmlFor="moption">
                    Modal Option: <input type="text" id="moption" name="moption" />
                </label>
            </fieldset>
            <div className={styles['submitButtonContainer']}>
                {submitting ? <Button disabled={true}>Disabled Button</Button> : <Button>Enabled Button</Button>}
            </div>
            <div className={styles['formNoticeWrapper']}>
                <InfoIcon
                    label={__(
                        'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        'ADDON_TEXTDOMAIN'
                    )}
                />
            </div>
        </form>
    );
};

export default Form;
