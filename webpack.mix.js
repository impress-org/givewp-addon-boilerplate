const mix = require( 'laravel-mix' );
const wpPot = require( 'wp-pot' );

mix
	.setPublicPath( 'public' )
	.sourceMaps( false )

	// admin assets
	.js( 'src/Addon/resources/js/admin/ADDON_ID-admin.js', 'public/js/' )
	.sass( 'src/Addon/resources/css/admin/ADDON_ID-admin.scss', 'public/css' )

	// public assets
	.js( 'src/Addon/resources/js/frontend/ADDON_ID.js', 'public/js/' )
	.sass( 'src/Addon/resources/css/frontend/ADDON_ID-frontend.scss', 'public/css' );

mix.webpackConfig( {
	externals: {
		$: 'jQuery',
		jquery: 'jQuery',
	},
} );

if ( mix.inProduction() ) {
	wpPot( {
		package: 'ADDON_NAME',
		domain: 'ADDON_TEXTDOMAIN',
		destFile: 'languages/ADDON_TEXTDOMAIN.pot',
		relativeTo: './',
		bugReport: 'https://github.com/impress-org/ADDON_ID/issues/new',
		team: 'GiveWP <info@givewp.com>',
	} );
}
