const mix = require( 'laravel-mix' );
const wpPot = require( 'wp-pot' );

mix
	.setPublicPath( 'public' )
	.sourceMaps( false )

	// admin assets
	.js( 'src/Addon/resources/js/admin/give-addon-admin.js', 'public/js/' )
	.sass( 'src/Addon/resources/css/admin/give-addon-admin.scss', 'public/css' )

	// public assets
	.js( 'src/Addon/resources/js/frontend/give-addon.js', 'public/js/' )
	.sass( 'src/Addon/resources/css/frontend/give-addon-frontend.scss', 'public/css' );

mix.webpackConfig( {
	externals: {
		$: 'jQuery',
		jquery: 'jQuery',
	},
} );

if ( mix.inProduction() ) {
	wpPot( {
		package: 'Give-Addon-Boilerplate',
		domain: 'give-addon',
		destFile: 'languages/give-addon.pot',
		relativeTo: './',
		bugReport: 'https://github.com/impress-org/Give-addon/issues/new',
		team: 'GiveWP <info@givewp.com>',
	} );
}
