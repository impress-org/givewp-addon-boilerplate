import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import {IGiveAddon} from '../../utils/interfaces';

declare global {
    interface Window {
        GiveAddon: IGiveAddon;
    }
}

ReactDOM.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>,
    document.getElementById('give-addon-react-app')
);
