import React from 'react';
import styles from './Button.module.scss';

interface ButtonProps {
    children: React.ReactNode | string;
    small?: boolean;
    disabled?: boolean;
    onClick?: () => void | Function;
}

const Button = ({children, small = false, disabled = false, onClick}: ButtonProps) => {
    return (
        <button
            onClick={onClick}
            disabled={disabled}
            className={small ? styles['button'] + ' ' + styles['small'] : styles['button']}
        >
            {children}
        </button>
    );
};

export default Button;
