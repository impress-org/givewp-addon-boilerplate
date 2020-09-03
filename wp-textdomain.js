const wpTextdomain = require( 'wp-textdomain' );

wpTextdomain( process.argv[ 2 ], {
	domain: 'give-addon-boilerplate',
	fix: true,
} );
