<?php
/**
 * Theme bootstrap.
 *
 * @package Observatorio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/enqueue.php';
require_once get_template_directory() . '/inc/post-types.php';
require_once get_template_directory() . '/inc/acf.php';

/** Return editable home copy, with a default before the option is saved. */
function observatorio_home_copy( $section, $field, $default ) {
    $value = function_exists( 'get_field' ) ? get_field( 'home_' . $section . '_' . $field, 'option' ) : null;
    return is_string( $value ) ? $value : $default;
}
