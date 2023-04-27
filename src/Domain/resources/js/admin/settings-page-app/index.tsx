import React from 'react';
import {createRoot} from 'react-dom/client';
import App from './App';
import {IGiveAddon} from '../../utils/interfaces';

declare global {
    interface Window {
        ADDON_ID: IGiveAddon;
    }
}

const container = document.getElementById('ADDON_ID-settings-page-app');
const root = createRoot(container!);
root.render(<App />);
