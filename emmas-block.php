<?php
/**
 * Plugin Name:     Emma's Block
 * Description:     Example Gutenberg block created by Emma
 * Version:         0.1.0
 * Author:          Emma Humphries
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     emmas-block
 *
 * @package         emmas-block
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function emmas_block_emmas_block_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "emmas-block/emmas-block" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'emmas-block-emmas-block-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);

	$editor_css = 'build/index.css';
	wp_register_style(
		'emmas-block-emmas-block-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'emmas-block-emmas-block-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'emmas-block/emmas-block', array(
		'editor_script' => 'emmas-block-emmas-block-block-editor',
		'editor_style'  => 'emmas-block-emmas-block-block-editor',
		'style'         => 'emmas-block-emmas-block-block',
	) );
}
add_action( 'init', 'emmas_block_emmas_block_block_init' );
