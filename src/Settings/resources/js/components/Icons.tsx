import React from 'react';
import styles from './Icons.module.scss';
import {imageUrl} from '../../../utils/helpers';

export const InfoIcon = ({label}) => {
    return (
        <span className={styles['iconContainer']}>
            <img src={imageUrl('InfoIcon.svg')} alt={label} />
            <label>{label}</label>
        </span>
    );
};

export const CloseIcon = () => {
    return <img src={imageUrl('CloseIcon.svg')} alt="Close" />;
};
