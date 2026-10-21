<?php
/**
 * Extensible Site Editor experiment integration.
 *
 * Only loaded while the `gutenberg-extensible-site-editor` experiment is
 * enabled (see lib/load.php).
 *
 * @package gutenberg
 */

/**
 * Redirect the Appearance > Design menu to the extensible site editor.
 *
 * @global array $submenu WordPress admin submenu array.
 */
function gutenberg_redirect_to_extensible_site_editor() {
	// Update the Design submenu item to point to the extensible site editor.
	global $submenu;
	if ( $submenu && isset( $submenu['themes.php'] ) ) {
		foreach ( $submenu['themes.php'] as $key => $item ) {
			// Find the Design/site-editor menu item and update its URL.
			if ( isset( $item[2] ) && 'site-editor.php' === $item[2] ) {
				$submenu['themes.php'][ $key ][2] = 'admin.php?page=site-editor-v2';
				break;
			}
		}
	}
}
add_action( 'admin_menu', 'gutenberg_redirect_to_extensible_site_editor', 100 );

/**
 * Unregisters the "Edit" action of pages.
 *
 * The action only signals it was performed: the list showing it opens the
 * editor. The lists of the extensible site editor open an item on click and
 * do not handle the action, so it would do nothing there.
 */
function gutenberg_unregister_extensible_site_editor_edit_post_action() {
	wp_unregister_entity_actions( 'postType', 'page', array( 'edit-post' ) );
}
add_action( 'wp_entity_actions_api_init', 'gutenberg_unregister_extensible_site_editor_edit_post_action' );
