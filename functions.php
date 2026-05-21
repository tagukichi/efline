<?php
/**
 * efline テーマのブートストラップ。
 *
 * @package efline
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'EFLINE_THEME_VERSION', '0.1.0' );
define( 'EFLINE_THEME_DIR', get_template_directory() );
define( 'EFLINE_THEME_URI', get_template_directory_uri() );

require_once EFLINE_THEME_DIR . '/inc/setup.php';
require_once EFLINE_THEME_DIR . '/inc/enqueue.php';
require_once EFLINE_THEME_DIR . '/inc/cpt-clinic.php';
require_once EFLINE_THEME_DIR . '/inc/acf.php';
require_once EFLINE_THEME_DIR . '/inc/clinic-helpers.php';
require_once EFLINE_THEME_DIR . '/inc/clinic-archive.php';
