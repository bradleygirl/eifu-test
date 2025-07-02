<?php
/**
 * Plugin Name:     Eifu Test
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     eifu-test
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Eifu_Test
 */

// Your code starts here.
namespace MGBdev\WC_Eifu_Docs;

// Exit if accessed directly
if ( !defined( 'ABSPATH' )) exit;

define('EIFUD_GLOBAl_VERSION', '1.0.0');
define('EIFUD_GLOBAl_NAME', 'eifud-global');
define('EIFUD_GLOBAl_ABSPATH', __DIR__);
define('EIFUD_GLOBAl_BASE_NAME', plugin_basename(__FILE__));
define('EIFUD_GLOBAl_DIR', plugin_dir_path(__FILE__));
define('EIFUD_GLOBAl_URL', plugin_dir_url(__FILE__));

/*include(EIFUD_GLOBAl_DIR . 'inc/utilities-functions.php');
require EIFUD_GLOBAl_DIR . 'admin/hwcf-table.php';
require EIFUD_GLOBAl_DIR . 'admin/hwcf-admin.php';*/


require_once (EIFUD_GLOBAl_DIR . 'post-types/eifudoc.php');
require (EIFUD_GLOBAl_DIR . 'blocks/eifu-doc-block.php');

add_action('before_woocommerce_init', function () {
    // Check if the FeaturesUtil class exists in the \Automattic\WooCommerce\Utilities namespace.
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        // Declare compatibility with custom order tables using the FeaturesUtil class.
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});
