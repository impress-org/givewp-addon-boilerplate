const mix = require('laravel-mix');
const wpPot = require('wp-pot');

mix.setPublicPath('public')
    .sourceMaps(false)

    // admin assets
    .js('src/Domain/resources/js/admin/ADDON_ID-admin.js', 'public/js/')
    .sass('src/Domain/resources/css/admin/ADDON_ID-admin.scss', 'public/css')

    // public assets
    .ts('src/Domain/resources/js/frontend/ADDON_ID.tsx', 'public/js/')
    .sass('src/Domain/resources/css/frontend/ADDON_ID-frontend.scss', 'public/css')

    // utils
    .ts('src/Domain/resources/js/utils/helpers.ts', 'public/js/')

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
        package: 'ADDON_NAME',
        domain: 'ADDON_TEXTDOMAIN',
        destFile: 'languages/ADDON_TEXTDOMAIN.pot',
        relativeTo: './',
        bugReport: 'https://github.com/impress-org/give/issues/new/choose',
        team: 'GiveWP <info@givewp.com>',
    });
}
