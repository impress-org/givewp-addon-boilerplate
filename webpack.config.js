/**
 * External Dependencies
 */
const path = require('path');

/**
 * WordPress Dependencies
 */
const defaultConfig = require('@wordpress/scripts/config/webpack.config.js');

/**
 * Custom config
 */
module.exports = {
    ...defaultConfig,
    entry: {
        GiveAddonFormBuilderExtension: srcPath('FormExtension/FormBuilder/resources/js/index.tsx'),
        GiveAddonFormBuilderExtensionGlobalStyle: srcPath('FormExtension/FormBuilder/resources/css/index.scss'),
        GiveAddonOffSiteGateway: srcPath('OffSiteGateway/Gateway/resources/OffSiteGateway.tsx'),
        settings: srcPath('Domain/resources/js/admin/settings-page-app/index.tsx'),
        adminJs: srcPath('Domain/resources/js/admin/index.tsx'),
        adminCss: srcPath('Domain/resources/css/admin/index.scss'),
    },
};

/**
 * Helper for getting the path to the src directory.
 *
 * @param {string} relativePath
 * @returns {string}
 */
function srcPath(relativePath) {
    return path.resolve(process.cwd(), 'src', relativePath);
}
