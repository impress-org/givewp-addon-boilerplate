const mix = require( 'laravel-mix' );
const wpPot = require( 'wp-pot' );

mix
	.setPublicPath( 'public' )
	.sourceMaps( false )

	// admin assets
	.js( 'src/Domain/resources/js/admin/ADDON_ID-admin.js', 'public/js/' )
	.sass( 'src/Domain/resources/css/admin/ADDON_ID-admin.scss', 'public/css' )

	// public assets
	.js( 'src/Domain/resources/js/frontend/ADDON_ID.js', 'public/js/' )
	.sass( 'src/Domain/resources/css/frontend/ADDON_ID-frontend.scss', 'public/css' )

	// images
	.copy( 'src/Domain/resources/images/*.{jpg,jpeg,png,gif}', 'public/images' );

mix.webpackConfig( {
	externals: {
		$: 'jQuery',
		jquery: 'jQuery',
	},
} );
