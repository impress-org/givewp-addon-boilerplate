import metadata from './metadata';
//import Icon from './Icon';
import Edit from './Edit';

const settings = {
    ...metadata,
    // The 'art' string refers to the dashicons-art icon - https://developer.wordpress.org/resource/dashicons/#art
    icon: 'art', //Icon,
    save: () => null,
    edit: Edit,
};

const ColorsSampleBlock = {
    name: settings.name,
    settings,
};

/**
 * @since 1.0.0
 */
export default ColorsSampleBlock;
