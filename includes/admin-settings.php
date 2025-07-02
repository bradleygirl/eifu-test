<?php
/**
 * WooCommerce settings integration
 */

namespace MGBdev\WC_Eifu_Docs;

/**
 * Add settings tab to WooCommerce
 */
function add_documents_settings_tab($tabs) {
    $tabs['documents'] = __('Product Documents', 'eifu-test');
    return $tabs;
}
add_filter('woocommerce_settings_tabs_array', __NAMESPACE__ . '\\add_documents_settings_tab', 50);

/**
 * Settings tab content
 */
function documents_settings_tab_content() {
    woocommerce_admin_fields(get_documents_settings());
}
add_action('woocommerce_settings_documents', __NAMESPACE__ . '\\documents_settings_tab_content');

/**
 * Save settings
 */
function save_documents_settings() {
    woocommerce_update_options(get_documents_settings());
}
add_action('woocommerce_update_options_documents', __NAMESPACE__ . '\\save_documents_settings');

/**
 * Get settings array
 */
function get_documents_settings() {
    return array(
        'section_title' => array(
            'name' => __('Product Documents Settings', 'eifu-test'),
            'type' => 'title',
            'desc' => __('Configure how product documents are displayed and managed.', 'eifu-test'),
            'id' => 'eifu_documents_section_title'
        ),
        'enable_downloads' => array(
            'name' => __('Enable Download Tracking', 'eifu-test'),
            'type' => 'checkbox',
            'desc' => __('Track when documents are downloaded', 'eifu-test'),
            'id' => 'eifu_enable_download_tracking'
        ),
        'default_display_location' => array(
            'name' => __('Default Display Location', 'eifu-test'),
            'type' => 'select',
            'options' => array(
                'tabs' => __('Product Tabs', 'eifu-test'),
                'description' => __('After Description', 'eifu-test'),
                'summary' => __('After Summary', 'eifu-test')
            ),
            'id' => 'eifu_default_display_location'
        ),
        'section_end' => array(
            'type' => 'sectionend',
            'id' => 'eifu_documents_section_end'
        )
    );
} 