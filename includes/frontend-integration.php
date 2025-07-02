<?php
/**
 * Frontend display of product documents
 */

namespace MGBdev\WC_Eifu_Docs;

require_once dirname(__FILE__, 2) . '/includes/admin-settings.php';

/**
 * Add documents tab to product tabs
 */
function add_documents_product_tab($tabs) {
    global $product;
    
    $documents = get_post_meta($product->get_id(), '_product_documents', true);
    if (!empty($documents)) {
        $tabs['documents'] = array(
            'title' => __('Documents', 'eifu-test'),
            'priority' => 25,
            'callback' => __NAMESPACE__ . '\\render_documents_tab_content'
        );
    }
    
    return $tabs;
}
add_filter('woocommerce_product_tabs', __NAMESPACE__ . '\\add_documents_product_tab');

/**
 * Render documents tab content
 */
function render_documents_tab_content() {
    global $product;
    
    $documents = get_post_meta($product->get_id(), '_product_documents', true);
    if (empty($documents)) {
        return;
    }
    
    echo '<div class="product-documents">';
    echo '<h3>' . __('Product Documents', 'eifu-test') . '</h3>';
    
    $langs = function_exists('MGBdev\\WC_Eifu_Docs\\eifu_get_supported_languages') ? \MGBdev\WC_Eifu_Docs\eifu_get_supported_languages() : array('ENG'=>'English');
    foreach ($documents as $doc_id) {
        $document = get_post($doc_id);
        if (!$document) continue;
        
        $base_url = get_post_meta($doc_id, '_document_base_url', true);
        $checked_langs = get_post_meta($doc_id, '_document_languages', true);
        if (!is_array($checked_langs)) $checked_langs = array();
        $file_size = get_post_meta($doc_id, '_document_file_size', true);
        
        echo '<div class="document-item">';
        echo '<h4><a href="' . get_permalink($doc_id) . '">' . esc_html($document->post_title) . '</a></h4>';
        if ($document->post_excerpt) {
            echo '<p>' . esc_html($document->post_excerpt) . '</p>';
        }
        if ($base_url && $checked_langs) {
            echo '<ul class="document-download-menu">';
            foreach ($checked_langs as $code) {
                $label = isset($langs[$code]) ? $langs[$code] : $code;
                $download_url = trailingslashit($base_url);
                // Remove trailing slash for file name
                $download_url = rtrim($download_url, '/');
                $download_url .= '_' . $code . '.pdf';
                echo '<li><a href="' . esc_url($download_url) . '" class="button" target="_blank">' . esc_html($label) . ' (' . esc_html($code) . ')';
                if ($file_size) {
                    echo ' - ' . esc_html($file_size);
                }
                echo '</a></li>';
            }
            echo '</ul>';
        }
        echo '</div>';
    }
    
    echo '</div>';
}

/**
 * Track document downloads
 */
function track_document_download() {
    if (isset($_GET['download_doc']) && is_numeric($_GET['download_doc'])) {
        $doc_id = intval($_GET['download_doc']);
        $count = get_post_meta($doc_id, '_document_download_count', true);
        update_post_meta($doc_id, '_document_download_count', intval($count) + 1);
    }
}
add_action('init', __NAMESPACE__ . '\\track_document_download'); 