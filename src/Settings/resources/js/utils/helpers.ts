import {IGiveAddon} from './interfaces';

import {getWindowData} from './getWindowData';


export const imageUrl = (filename) => `${getWindowData().GiveAddon.imageUrl}${filename}`;
