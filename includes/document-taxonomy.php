<?php
/**
 * Document taxonomy registration and management
 */

namespace MGBdev\WC_Eifu_Docs;

/**
 * Register document categories taxonomy
 */
function register_document_taxonomy() {
    register_taxonomy(
        'document_category',
        'eifudoc',
        array(
            'labels' => array(
                'name' => __('Document Categories', 'eifu-test'),
                'singular_name' => __('Document Category', 'eifu-test'),
                'menu_name' => __('Categories', 'eifu-test'),
            ),
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'document-category'),
        )
    );

    // Document tags
    register_taxonomy(
        'document_tag',
        'eifudoc',
        array(
            'labels' => array(
                'name' => __('Document Tags', 'eifu-test'),
                'singular_name' => __('Document Tag', 'eifu-test'),
            ),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'document-tag'),
        )
    );
}
add_action('init', __NAMESPACE__ . '\\register_document_taxonomy'); 