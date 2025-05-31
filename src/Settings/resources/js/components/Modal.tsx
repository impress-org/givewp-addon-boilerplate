import React from 'react';
import styles from './Modal.module.scss';
import {CloseIcon} from './Icons';

interface ModalProps {
    title: string;
    children: React.ReactNode;
    showModal: boolean;
    setShowModal: Function;
}

const Modal = ({title, children, showModal, setShowModal}: ModalProps) => {
    function handleOutsideClick(event) {
        if (event.target === event.currentTarget) {
            setShowModal(false);
        }
    }

    return (
        <div
            className={styles['modal']}
            style={showModal ? {display: 'flex'} : {display: 'none'}}
            onClick={handleOutsideClick}
        >
            <div className={styles['modalContent']}>
                <div className={styles['modalHeader']}>
                    <p className={styles['modalTitle']}>{title}</p>
                    <p className={styles['modalClose']} onClick={() => setShowModal(false)}>
                        <CloseIcon />
                    </p>
                </div>
                <div className={styles['modalBody']}>{children}</div>
            </div>
        </div>
    );
};

export default Modal;
