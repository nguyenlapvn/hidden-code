<?php
/** A WordPress Plugin
 *
 * @link              https://nguyenlap.net
 * @since             1.0.0
 * @package           Hidden_Code
 *
 * @wordpress-plugin
 * Plugin Name:       Hidden Code
 * Plugin URI:        https://nguyenlap.net
 * Description:       git
 * Version:           0.0.1
 * Author:            Nguyen lap
 * Author URI:        https://nguyenlap.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hidden-code
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'HIDDEN_CODE_VERSION', '0.0.1' );
define( 'HIDDEN_CODE_DIR', plugin_dir_path( __FILE__ ) );
define( 'HIDDEN_CODE_PLUGIN_URI', plugin_dir_url( __FILE__ ) );

add_action('wp_enqueue_scripts', 'enqueue_assets');
function enqueue_assets() {
    wp_enqueue_style('style-hidden-code', HIDDEN_CODE_PLUGIN_URI . '/assets/style.css', array(), HIDDEN_CODE_VERSION);
    wp_enqueue_script('script-hidden-code', HIDDEN_CODE_PLUGIN_URI . '/assets/script.js', array(), HIDDEN_CODE_VERSION, true);
}

add_shortcode( 'hidden-code', 'render_hidden_code' );
function render_hidden_code( $atts ) {
    $attributes = shortcode_atts( array(
        'code' => null,
        'time' => 30,
        'text' => null,
        'color' => '#fff',
        'background' => '#ff0000'
    ), $atts, 'hidden_code' );
    
    $is_background_color = is_hex_color( $attributes['background'] );
    $is_text_color       = is_hex_color( $attributes['color'] );
    $time                = absint( $attributes['time'] );
    $code                = sanitize_text_field( $attributes['code'] );
    $text                = sanitize_text_field( $attributes['text'] );

    if( $is_background_color && $is_text_color && $time > 0 && ! empty( $code ) && ! empty( $text )) {
        return sprintf(
            '<div data-code="%2$s" data-count-time="%1$s" class="hidden-code">'
            .'<span class="hidden-code__button" style="background-color: %3$s; color: %4$s">%5$s</span>'
            .'</div>',
            absint( $attributes['time'] ),
            sanitize_text_field( $attributes['code'] ),
            esc_attr( $attributes['background'] ),
            esc_attr( $attributes['color'] ),
            sanitize_text_field( $attributes['text'] )
        );
    }

    return '<!-- Hidden code: Incorrect parameters (color, time, code, text) -->';
}

function is_hex_color( $color ) {
    return preg_match( '/^#([a-f0-9]{6}|[a-f0-9]{3})\b$/', $color );
}