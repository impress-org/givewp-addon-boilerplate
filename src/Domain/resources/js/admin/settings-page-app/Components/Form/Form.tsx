import React, {useState} from 'react';
import styles from './Form.module.scss';
import Button from './Button';
import {InfoIcon} from '../Icons';
import {__} from '@wordpress/i18n';
import PeriodSelector from './PeriodSelector';

interface FormProps {
    setShowModal: Function;
}

const Form = ({setShowModal}: FormProps) => {
    const [startDate, setStartDate] = useState(null);
    const [endDate, setEndDate] = useState(null);
    const [submitting, setSubmitting] = useState<boolean>(false);
    const locale = window.ADDON_ID.locale;

    function handleSubmit(event) {
        event.preventDefault();
        setSubmitting(true);
        console.log('startDate: ', startDate);
        console.log('endDate: ', endDate);
        alert('Handle Submitting Here');
        setShowModal(false);
        return false;
    }

    function setDates(startDate, endDate) {
        setStartDate(startDate);
        setEndDate(endDate);
    }

    return (
        <form className={styles['formContainer']} onSubmit={handleSubmit}>
            <fieldset className={styles['periodSelectorContainer']}>
                <PeriodSelector startDate={startDate} endDate={endDate} setDates={setDates} locale={locale} />
            </fieldset>
            <div className={styles['submitButtonContainer']}>
                {submitting || !startDate || !endDate ? (
                    <Button disabled={true}>Disabled Button</Button>
                ) : (
                    <Button>Enabled Button</Button>
                )}
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
