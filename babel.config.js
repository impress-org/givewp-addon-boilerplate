module.exports = {
	presets: [
		[
			'@babel/preset-env',
			{
				targets: {
					browsers: 'last 2 version, > 0.05%, ie >= 10',
				},
			},
		],
	],
	plugins: [ '@wordpress/babel-plugin-import-jsx-pragma', '@babel/plugin-transform-react-jsx' ],
};
