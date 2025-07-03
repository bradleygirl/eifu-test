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
				'name'                  => __( 'IFU Documents', 'eifu-test' ),
				'singular_name'         => __( 'IFU Document', 'eifu-test' ),
				'all_items'             => __( 'All IFU Documents', 'eifu-test' ),
				'archives'              => __( 'IFU Document Archives', 'eifu-test' ),
				'attributes'            => __( 'IFU Document Attributes', 'eifu-test' ),
				'insert_into_item'      => __( 'Insert into IFU Document', 'eifu-test' ),
				'uploaded_to_this_item' => __( 'Uploaded to this IFU Document', 'eifu-test' ),
				'featured_image'        => _x( 'Featured Image', 'eifudoc', 'eifu-test' ),
				'set_featured_image'    => _x( 'Set featured image', 'eifudoc', 'eifu-test' ),
				'remove_featured_image' => _x( 'Remove featured image', 'eifudoc', 'eifu-test' ),
				'use_featured_image'    => _x( 'Use as featured image', 'eifudoc', 'eifu-test' ),
				'filter_items_list'     => __( 'Filter IFU Documents list', 'eifu-test' ),
				'items_list_navigation' => __( 'IFU Documents list navigation', 'eifu-test' ),
				'items_list'            => __( 'IFU Documents list', 'eifu-test' ),
				'new_item'              => __( 'New IFU Document', 'eifu-test' ),
				'add_new'               => __( 'Add New', 'eifu-test' ),
				'add_new_item'          => __( 'Add New IFU Document', 'eifu-test' ),
				'edit_item'             => __( 'Edit IFU Document', 'eifu-test' ),
				'view_item'             => __( 'View IFU Document', 'eifu-test' ),
				'view_items'            => __( 'View IFU Documents', 'eifu-test' ),
				'search_items'          => __( 'Search IFU Documents', 'eifu-test' ),
				'not_found'             => __( 'No IFU Documents found', 'eifu-test' ),
				'not_found_in_trash'    => __( 'No IFU Documents found in trash', 'eifu-test' ),
				'parent_item_colon'     => __( 'Parent IFU Document:', 'eifu-test' ),
				'menu_name'             => __( 'IFU Documents', 'eifu-test' ),
			),
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => array( 'title', 'editor' ),
			'has_archive'           => true,
			'rewrite'               => array('slug' => 'eifu', 'with_front' => false),
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
		1  => sprintf( __( 'IFU Document updated. <a target="_blank" href="%s">View IFU Document</a>', 'eifu-test' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'eifu-test' ),
		3  => __( 'Custom field deleted.', 'eifu-test' ),
		4  => __( 'IFU Document updated.', 'eifu-test' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'IFU Document restored to revision from %s', 'eifu-test' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'IFU Document published. <a href="%s">View IFU Document</a>', 'eifu-test' ), esc_url( $permalink ) ),
		7  => __( 'IFU Document saved.', 'eifu-test' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'IFU Document submitted. <a target="_blank" href="%s">Preview IFU Document</a>', 'eifu-test' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'IFU Document scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview IFU Document</a>', 'eifu-test' ), date_i18n( __( 'M j, Y @ G:i', 'eifu-test' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'IFU Document draft updated. <a target="_blank" href="%s">Preview IFU Document</a>', 'eifu-test' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
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
		/* translators: %s: Number of IFU Documents. */
		'updated'   => _n( '%s IFU Document updated.', '%s IFU Documents updated.', $bulk_counts['updated'], 'eifu-test' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 IFU Document not updated, somebody is editing it.', 'eifu-test' ) :
						/* translators: %s: Number of IFU Documents. */
						_n( '%s IFU Document not updated, somebody is editing it.', '%s IFU Documents not updated, somebody is editing them.', $bulk_counts['locked'], 'eifu-test' ),
		/* translators: %s: Number of IFU Documents. */
		'deleted'   => _n( '%s IFU Document permanently deleted.', '%s IFU Documents permanently deleted.', $bulk_counts['deleted'], 'eifu-test' ),
		/* translators: %s: Number of IFU Documents. */
		'trashed'   => _n( '%s IFU Document moved to the Trash.', '%s IFU Documents moved to the Trash.', $bulk_counts['trashed'], 'eifu-test' ),
		/* translators: %s: Number of IFU Documents. */
		'untrashed' => _n( '%s IFU Document restored from the Trash.', '%s IFU Documents restored from the Trash.', $bulk_counts['untrashed'], 'eifu-test' ),
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
	// English options
	$eng_usa_checked = get_post_meta($post->ID, '_document_eng_usa_checked', true);
	$eng_usa_url = get_post_meta($post->ID, '_document_eng_usa_url', true);
	$eng_ce_checked = get_post_meta($post->ID, '_document_eng_ce_checked', true);
	$eng_ce_url = get_post_meta($post->ID, '_document_eng_ce_url', true);
	$eng_base_choice = get_post_meta($post->ID, '_document_eng_base_choice', true); // 'usa' or 'ce'
	$file_size = get_post_meta($post->ID, '_document_file_size', true);
	$download_count = get_post_meta($post->ID, '_document_download_count', true);
	$checked_langs = get_post_meta($post->ID, '_document_languages', true);
	if (!is_array($checked_langs)) $checked_langs = array();
	$langs = function_exists('MGBdev\\WC_Eifu_Docs\\eifu_get_supported_languages') ? \MGBdev\WC_Eifu_Docs\eifu_get_supported_languages() : array();
	// Use submitted values if available (for immediate UI feedback)
	if (isset($_POST['document_eng_usa_checked'])) $eng_usa_checked = 1;
	if (isset($_POST['document_eng_ce_checked'])) $eng_ce_checked = 1;
	if (isset($_POST['document_eng_base_choice'])) $eng_base_choice = $_POST['document_eng_base_choice'];
	// Determine which radio should be checked by default
	if (!$eng_base_choice) {
		if ($eng_usa_checked && !$eng_ce_checked) $eng_base_choice = 'usa';
		elseif ($eng_ce_checked && !$eng_usa_checked) $eng_base_choice = 'ce';
	}
	echo '<table class="form-table">';
	// English language field group
	echo '<tr><th colspan="2"><h4>' . __('English language file URLs', 'eifu-test') . '</h4></th></tr>';
	echo '<tr><td colspan="2">';
	echo '<div id="eifu-english-group">';
	// English-USA
	echo '<div style="margin-bottom:8px;">';
	echo '<label><input type="checkbox" id="eifu-eng-usa" name="document_eng_usa_checked" value="1" ' . ($eng_usa_checked ? 'checked' : '') . '> ' . __('English-USA available', 'eifu-test') . '</label> ';
	echo '<input type="url" name="document_eng_usa_url" value="' . esc_url($eng_usa_url) . '" class="regular-text" placeholder="https://example.com/path/to/file" style="min-width:300px;" />';
	echo '</div>';
	// English-CE
	echo '<div style="margin-bottom:8px;">';
	echo '<label><input type="checkbox" id="eifu-eng-ce" name="document_eng_ce_checked" value="1" ' . ($eng_ce_checked ? 'checked' : '') . '> ' . __('English-CE available', 'eifu-test') . '</label> ';
	echo '<input type="url" name="document_eng_ce_url" value="' . esc_url($eng_ce_url) . '" class="regular-text" placeholder="https://example.com/path/to/file" style="min-width:300px;" />';
	echo '</div>';
	// Radio row (always present, but hidden unless both checked)
	$radio_style = ($eng_usa_checked && $eng_ce_checked) ? '' : 'display:none;';
	echo '<div id="eifu-eng-base-row" style="margin-bottom:8px;' . $radio_style . '">';
	echo '<strong>' . __('Base URL for Other Languages', 'eifu-test') . '</strong><br>';
	echo '<label><input type="radio" name="document_eng_base_choice" value="usa" ' . ($eng_base_choice==="usa" ? 'checked' : '') . ' ' . (!$eng_usa_checked ? 'disabled' : '') . '> ' . __('Use English-USA base URL', 'eifu-test') . '</label><br>';
	echo '<label><input type="radio" name="document_eng_base_choice" value="ce" ' . ($eng_base_choice==="ce" ? 'checked' : '') . ' ' . (!$eng_ce_checked ? 'disabled' : '') . '> ' . __('Use English-CE base URL', 'eifu-test') . '</label>';
	echo '</div>';
	echo '</div>';
	echo '</td></tr>';
	// Other languages
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
	// JS for radio show/hide
	echo '<script>
	(function(){
	  function updateRadioRow() {
		var usa = document.getElementById("eifu-eng-usa").checked;
		var ce = document.getElementById("eifu-eng-ce").checked;
		var row = document.getElementById("eifu-eng-base-row");
		if (usa && ce) { row.style.display = ""; }
		else { row.style.display = "none"; }
	  }
	  document.getElementById("eifu-eng-usa").addEventListener("change", updateRadioRow);
	  document.getElementById("eifu-eng-ce").addEventListener("change", updateRadioRow);
	  document.addEventListener("DOMContentLoaded", updateRadioRow);
	})();
	</script>';
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
	
	$eng_usa_checked = !empty($_POST['document_eng_usa_checked']);
	$eng_ce_checked = !empty($_POST['document_eng_ce_checked']);
	// Require at least one English option
	if (!$eng_usa_checked && !$eng_ce_checked) {
		add_action('admin_notices', 'eifu_doc_admin_notice_required_english');
		// Prevent save by returning early
		remove_action('save_post', 'save_document_details_meta'); // Prevent infinite loop
		wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));
		add_action('save_post', 'save_document_details_meta');
		return;
	}
	update_post_meta($post_id, '_document_eng_usa_checked', $eng_usa_checked ? 1 : 0);
	update_post_meta($post_id, '_document_eng_usa_url', sanitize_url($_POST['document_eng_usa_url']));
	update_post_meta($post_id, '_document_eng_ce_checked', $eng_ce_checked ? 1 : 0);
	update_post_meta($post_id, '_document_eng_ce_url', sanitize_url($_POST['document_eng_ce_url']));
	if ($eng_usa_checked && $eng_ce_checked) {
		$choice = isset($_POST['document_eng_base_choice']) && in_array($_POST['document_eng_base_choice'], ['usa','ce']) ? $_POST['document_eng_base_choice'] : 'usa';
		update_post_meta($post_id, '_document_eng_base_choice', $choice);
	} else {
		delete_post_meta($post_id, '_document_eng_base_choice');
	}
	$langs = isset($_POST['document_languages']) ? array_map('sanitize_text_field', (array)$_POST['document_languages']) : array();
	update_post_meta($post_id, '_document_languages', $langs);
	update_post_meta($post_id, '_document_file_size', sanitize_text_field($_POST['document_file_size']));
}
add_action('save_post', 'save_document_details_meta');

// Add admin notice for required English option
function eifu_doc_admin_notice_required_english() {
	echo '<div class="notice notice-error is-dismissible"><p>' . __('You must check at least one English language option (English-USA or English-CE) to save this IFU Document.', 'eifu-test') . '</p></div>';
}

// Flush rewrite rules on plugin activation
function eifu_test_flush_rewrite() {
	flush_rewrite_rules();
}
register_activation_hook( dirname(__FILE__, 2) . '/eifu-test.php', 'eifu_test_flush_rewrite' );
