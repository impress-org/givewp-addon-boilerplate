import React, {useState} from 'react';
import Button from './Components/Form/Button';
import {__} from '@wordpress/i18n';
import Modal from './Components/Modal';
import Form from './Components/Form/Form';

function App() {
    const [showModal, setShowModal] = useState(false);

    function handleOnClick(event) {
        event.preventDefault();
        setShowModal(true);
        return false;
    }

    return (
        <div className="App">
            <h2>React App</h2>
            <Modal title={__('Modal Title', 'ADDON_TEXTDOMAIN')} showModal={showModal} setShowModal={setShowModal}>
                <Form setShowModal={setShowModal} />
            </Modal>
            <a href={'#'} onClick={handleOnClick}>
                {__('Click here to see a sample modal', 'ADDON_TEXTDOMAIN')}
            </a>
            <br />
            <br />
            <label htmlFor="soption">Sample Option: </label>
            <input type="text" id="soption" name="soption" />
            <br />
            <br />
            <Button small={true} onClick={() => alert('Handle Submitting Here')}>
                {__('Save', 'ADDON_TEXTDOMAIN')}
            </Button>
        </div>
    );
}

export default App;
