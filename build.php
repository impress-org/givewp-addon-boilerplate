<?php

$name = readline(
	'What is the name of the add-on as shows up in the WP plugin screen? For example, "Give - Funds"' . PHP_EOL .
	'Add-on Name: '
);

$description = readline( 'Please describe the add-on: ' );

$tentativeId        = implode( '-', explode( ' ', strtolower( $name ) ) );
$tentativeConstant  = implode( '_', explode( ' ', strtoupper( $name ) ) );
$tentativeNamespace = str_replace( ' ', '', $name );

$id = readline(
	PHP_EOL . 'What is the ID of the add-on? For example, "give-funds"' . PHP_EOL .
	"Add-on ID (leave empty to use $tentativeId): "
);

$id = empty( $id ) ? $tentativeId : $id;

$textDomain = readline(
	PHP_EOL . 'What is the text domain of the add-on? For example, "give-funds"' . PHP_EOL .
	"Add-on Text Domain (leave empty to use $id): "
);

$textDomain = empty( $textDomain ) ? $id : $textDomain;

$constant = readline(
	PHP_EOL . 'What is the Constant prefix of the add-on? For example, "GIVE_FUNDS"' . PHP_EOL .
	"Add-on Constant (leave empty to use $tentativeConstant): "
);

$constant = empty( $constant ) ? $tentativeConstant : $constant;

$namespace = readline(
	PHP_EOL . 'What is the Namespace of the add-on? For example, "GiveFunds"' . PHP_EOL .
	"Add-on Namespace (leave empty to use $tentativeNamespace): "
);

$namespace = empty( $namespace ) ? $tentativeNamespace : $namespace;

$domain = ucfirst( trim( readline(
	PHP_EOL . 'What is the default domain of the add-on? For example, "Funds"' . PHP_EOL .
	"Add-on Domain: "
) ) );

// Retrieve the files
$files = array_filter( array_merge(
	[
		__DIR__ . '/.phpcs.xml',
		__DIR__ . '/webpack.mix.js',
		__DIR__ . '/composer.json'
	],
	glob( __DIR__ . '/*.php', GLOB_NOSORT ),
	rglob( __DIR__ . '/src/*.php', GLOB_NOSORT )
), static function ( $file ) {
	return $file !== __FILE__;
} );

$replacements = [
	'GiveAddon'         => trim( $namespace ),
	'\\Domain'          => trim( "\\$domain" ),
	'src/Domain'        => trim( "src/$domain" ),
	'ADDON_DOMAIN'      => trim( $domain ),
	'ADDON_NAME'        => trim( $name ),
	'ADDON_CONSTANT'    => trim( $constant ),
	'ADDON_DESCRIPTION' => trim( $description ),
	'ADDON_TEXTDOMAIN'  => trim( $textDomain ),
	'ADDON_ID'          => trim( $id ),
];

foreach ( $files as $file ) {
	replaceInFile( $file, array_keys( $replacements ), array_values( $replacements ) );
}

rename(
	__DIR__ . '/give-addon-boilerplate.php',
	__DIR__ . "/$id.php"
);

rename(
	__DIR__ . '/src/Domain',
	__DIR__ . "/src/$domain"
);

unlink( __FILE__ );

echo( PHP_EOL . PHP_EOL . 'All set!' );

/***** HELPER FUNCTIONS *****/

/**
 * Replaces a string in a file
 *
 * @param string          $filePath
 * @param string|string[] $oldText text to be replaced
 * @param string|string[] $newText new text
 */
function replaceInFile( $filePath, $oldText, $newText ) {
	if ( ! file_exists( $filePath ) ) {
		throw new InvalidArgumentException( "File $filePath does not exist" );
	}

	if ( ! is_writable( $filePath ) ) {
		throw new InvalidArgumentException( "File $filePath does is not writable" );
	}

	$fileContent = file_get_contents( $filePath );
	$fileContent = str_replace( $oldText, $newText, $fileContent );

	file_put_contents( $filePath, $fileContent );
}

/**
 * @param string $pattern
 * @param int    $flags
 *
 * @return string[]|false
 */
function rglob( $pattern, $flags = 0 ) {
	$files = glob( $pattern, $flags );
	foreach ( glob( dirname( $pattern ) . '/*', GLOB_ONLYDIR | GLOB_NOSORT ) as $dir ) {
		$subFiles = rglob( $dir . '/' . basename( $pattern ), $flags );

		if ( ! empty( $subFiles ) ) {
			array_push( $files, ...$subFiles );
		}
	}

	return $files;
}
