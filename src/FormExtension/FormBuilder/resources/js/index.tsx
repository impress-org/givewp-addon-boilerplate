import ColorsSampleBlock from './Blocks/ColorsSampleBlock';
import {getGiveCoreFormBuilderWindowData} from './window';

const {form} = getGiveCoreFormBuilderWindowData();

console.log(ColorsSampleBlock);

form.blocks.register(ColorsSampleBlock.name, ColorsSampleBlock.settings);
