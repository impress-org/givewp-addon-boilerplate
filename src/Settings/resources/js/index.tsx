import React from 'react';
import {createRoot} from 'react-dom/client';
import App from './App';


const container = document.getElementById('ADDON_ID-settings-page-app');
const root = createRoot(container!);
root.render(<App />);
