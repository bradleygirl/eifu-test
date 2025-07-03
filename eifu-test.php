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

/**
 * Check if WooCommerce is active and load dependent files
 */
function eifu_test_maybe_load_woocommerce_features() {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>';
            echo __('EIFU Product Documents requires WooCommerce to be installed and active.', 'eifu-test');
            echo '</p></div>';
        });
        return;
    }
    // Load additional WooCommerce-specific files
    require_once (EIFUD_GLOBAl_DIR . 'includes/product-meta-fields.php');
    require_once (EIFUD_GLOBAl_DIR . 'includes/document-taxonomy.php');
    require_once (EIFUD_GLOBAl_DIR . 'includes/frontend-integration.php');
    require_once (EIFUD_GLOBAl_DIR . 'includes/admin-settings.php');
}
add_action('plugins_loaded', 'MGBdev\\WC_Eifu_Docs\\eifu_test_maybe_load_woocommerce_features', 20);

// Force use of plugin archive template for IFU Documents
add_filter('template_include', function($template) {
    if (is_post_type_archive('eifudoc')) {
        $plugin_template = EIFUD_GLOBAl_DIR . 'templates/archive-eifudoc.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    return $template;
});
