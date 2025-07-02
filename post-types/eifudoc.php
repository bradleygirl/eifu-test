<?php
/**
 * Custom post type
 *
 * @package eifu_test
 */

/**
 * Registers the `eifudoc` post type.
 */
function eifu_test_init() {
	register_post_type(
		'eifudoc',
		array(
			'labels'                => array(
				'name'                  => __( 'EIFU Documents', 'eifu-test' ),
				'singular_name'         => __( 'EIFU Document', 'eifu-test' ),
				'all_items'             => __( 'All EIFU Documents', 'eifu-test' ),
				'archives'              => __( 'EIFU Document Archives', 'eifu-test' ),
				'attributes'            => __( 'EIFU Document Attributes', 'eifu-test' ),
				'insert_into_item'      => __( 'Insert into EIFU Document', 'eifu-test' ),
				'uploaded_to_this_item' => __( 'Uploaded to this EIFU Document', 'eifu-test' ),
				'featured_image'        => _x( 'Featured Image', 'eifudoc', 'eifu-test' ),
				'set_featured_image'    => _x( 'Set featured image', 'eifudoc', 'eifu-test' ),
				'remove_featured_image' => _x( 'Remove featured image', 'eifudoc', 'eifu-test' ),
				'use_featured_image'    => _x( 'Use as featured image', 'eifudoc', 'eifu-test' ),
				'filter_items_list'     => __( 'Filter EIFU Documents list', 'eifu-test' ),
				'items_list_navigation' => __( 'EIFU Documents list navigation', 'eifu-test' ),
				'items_list'            => __( 'EIFU Documents list', 'eifu-test' ),
				'new_item'              => __( 'New EIFU Document', 'eifu-test' ),
				'add_new'               => __( 'Add New', 'eifu-test' ),
				'add_new_item'          => __( 'Add New EIFU Document', 'eifu-test' ),
				'edit_item'             => __( 'Edit EIFU Document', 'eifu-test' ),
				'view_item'             => __( 'View EIFU Document', 'eifu-test' ),
				'view_items'            => __( 'View EIFU Documents', 'eifu-test' ),
				'search_items'          => __( 'Search EIFU Documents', 'eifu-test' ),
				'not_found'             => __( 'No EIFU Documents found', 'eifu-test' ),
				'not_found_in_trash'    => __( 'No EIFU Documents found in trash', 'eifu-test' ),
				'parent_item_colon'     => __( 'Parent EIFU Document:', 'eifu-test' ),
				'menu_name'             => __( 'EIFU Documents', 'eifu-test' ),
			),
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'editor' ),
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-post',
			'show_in_rest'          => true,
			'rest_base'             => 'eifudoc',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		)
	);
}

add_action( 'init', 'eifu_test_init' );

/**
 * Sets the post updated messages for the `eifudoc` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `eifudoc` post type.
 */
function eifu_test_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['eifudoc'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'EIFU Document updated. <a target="_blank" href="%s">View EIFU Document</a>', 'eifu-test' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'eifu-test' ),
		3  => __( 'Custom field deleted.', 'eifu-test' ),
		4  => __( 'EIFU Document updated.', 'eifu-test' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'EIFU Document restored to revision from %s', 'eifu-test' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'EIFU Document published. <a href="%s">View EIFU Document</a>', 'eifu-test' ), esc_url( $permalink ) ),
		7  => __( 'EIFU Document saved.', 'eifu-test' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'EIFU Document submitted. <a target="_blank" href="%s">Preview EIFU Document</a>', 'eifu-test' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'EIFU Document scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview EIFU Document</a>', 'eifu-test' ), date_i18n( __( 'M j, Y @ G:i', 'eifu-test' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'EIFU Document draft updated. <a target="_blank" href="%s">Preview EIFU Document</a>', 'eifu-test' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}

add_filter( 'post_updated_messages', 'eifu_test_updated_messages' );

/**
 * Sets the bulk post updated messages for the `eifudoc` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `eifudoc` post type.
 */
function eifu_test_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['eifudoc'] = array(
		/* translators: %s: Number of EIFU Documents. */
		'updated'   => _n( '%s EIFU Document updated.', '%s EIFU Documents updated.', $bulk_counts['updated'], 'eifu-test' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 EIFU Document not updated, somebody is editing it.', 'eifu-test' ) :
						/* translators: %s: Number of EIFU Documents. */
						_n( '%s EIFU Document not updated, somebody is editing it.', '%s EIFU Documents not updated, somebody is editing them.', $bulk_counts['locked'], 'eifu-test' ),
		/* translators: %s: Number of EIFU Documents. */
		'deleted'   => _n( '%s EIFU Document permanently deleted.', '%s EIFU Documents permanently deleted.', $bulk_counts['deleted'], 'eifu-test' ),
		/* translators: %s: Number of EIFU Documents. */
		'trashed'   => _n( '%s EIFU Document moved to the Trash.', '%s EIFU Documents moved to the Trash.', $bulk_counts['trashed'], 'eifu-test' ),
		/* translators: %s: Number of EIFU Documents. */
		'untrashed' => _n( '%s EIFU Document restored from the Trash.', '%s EIFU Documents restored from the Trash.', $bulk_counts['untrashed'], 'eifu-test' ),
	);

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'eifu_test_bulk_updated_messages', 10, 2 );

/**
 * Add custom meta boxes for documents
 */
function add_document_meta_boxes() {
	add_meta_box(
		'document_details',
		__('Document Details', 'eifu-test'),
		'render_document_details_meta_box',
		'eifudoc',
		'normal',
		'default'
	);
}
add_action('add_meta_boxes', 'add_document_meta_boxes');

/**
 * Render document details meta box
 */
function render_document_details_meta_box($post) {
	wp_nonce_field('save_document_details', 'document_details_nonce');
	$base_url = get_post_meta($post->ID, '_document_base_url', true);
	$file_size = get_post_meta($post->ID, '_document_file_size', true);
	$download_count = get_post_meta($post->ID, '_document_download_count', true);
	$checked_langs = get_post_meta($post->ID, '_document_languages', true);
	if (!is_array($checked_langs)) $checked_langs = array();
	$langs = function_exists('MGBdev\\WC_Eifu_Docs\\eifu_get_supported_languages') ? \MGBdev\WC_Eifu_Docs\eifu_get_supported_languages() : array('ENG'=>'English');
	echo '<table class="form-table">';
	echo '<tr><th><label for="document_base_url">' . __('Document Base URL', 'eifu-test') . '</label></th>';
	echo '<td><input type="url" id="document_base_url" name="document_base_url" value="' . esc_url($base_url) . '" class="regular-text" placeholder="https://example.com/path/to/file" /></td></tr>';
	echo '<tr><th>' . __('Available Languages', 'eifu-test') . '</th>';
	echo '<td>';
	foreach ($langs as $code => $label) {
		$checked = in_array($code, $checked_langs) ? 'checked' : '';
		echo '<label style="display:inline-block;margin-right:12px;">';
		echo '<input type="checkbox" name="document_languages[]" value="' . esc_attr($code) . '" ' . $checked . '> ' . esc_html($label) . ' (' . esc_html($code) . ')';
		echo '</label>';
	}
	echo '</td></tr>';
	echo '<tr><th><label for="document_file_size">' . __('File Size', 'eifu-test') . '</label></th>';
	echo '<td><input type="text" id="document_file_size" name="document_file_size" value="' . esc_attr($file_size) . '" class="regular-text" /></td></tr>';
	echo '<tr><th>' . __('Download Count', 'eifu-test') . '</th>';
	echo '<td>' . intval($download_count) . '</td></tr>';
	echo '</table>';
}

/**
 * Save document details meta
 */
function save_document_details_meta($post_id) {
	if (!isset($_POST['document_details_nonce']) || 
		!wp_verify_nonce($_POST['document_details_nonce'], 'save_document_details')) {
		return;
	}
	
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	
	update_post_meta($post_id, '_document_base_url', sanitize_url($_POST['document_base_url']));
	$langs = isset($_POST['document_languages']) ? array_map('sanitize_text_field', (array)$_POST['document_languages']) : array();
	update_post_meta($post_id, '_document_languages', $langs);
	update_post_meta($post_id, '_document_file_size', sanitize_text_field($_POST['document_file_size']));
}
add_action('save_post', 'save_document_details_meta');
