const mix = require('laravel-mix');
const wpPot = require('wp-pot');

mix.setPublicPath('public')
    .sourceMaps(false)

    /**
     * admin assets - example of how to create a settings page using a React App.
     */
    .ts('src/Domain/resources/js/admin/settings-page-app/index.tsx', 'public/js/ADDON_ID-settings-page-app.js')

    // admin assets
    .ts('src/Domain/resources/js/admin/ADDON_ID-admin.ts', 'public/js/')
    .sass('src/Domain/resources/css/admin/ADDON_ID-admin.scss', 'public/css')

    // frontend assets
    .js('src/Domain/resources/js/frontend/ADDON_ID-frontend.js', 'public/js/')
    .sass('src/Domain/resources/css/frontend/ADDON_ID-frontend.scss', 'public/css')

    // images
    .copy('src/Domain/resources/images/*.{jpg,jpeg,png,gif,svg}', 'public/images');

mix.webpackConfig({
    externals: {
        $: 'jQuery',
        jquery: 'jQuery',
    },
});

mix.options({
    // Don't perform any css url rewriting by default
    processCssUrls: false,

    // Prevent LICENSE files from showing up in JS builds
    terser: {
        extractComments: (astNode, comment) => false,
        terserOptions: {
            format: {
                comments: false,
            },
        },
    },
});

if (mix.inProduction()) {
    wpPot({
        package: 'ADDON_ID',
        domain: 'ADDON_TEXTDOMAIN',
        destFile: 'languages/ADDON_TEXTDOMAIN.pot',
        relativeTo: './',
        bugReport: 'https://github.com/impress-org/give/issues/new/choose',
        team: 'GiveWP <info@givewp.com>',
    });
}
