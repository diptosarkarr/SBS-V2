<?php
/**
 * Runs when the plugin is deleted from the Plugins screen: removes the cached card markup
 * (transients named sbs_pc_*) and any scheduled refresh jobs.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

$patterns = array(
	$wpdb->esc_like( '_transient_sbs_pc_' ) . '%',
	$wpdb->esc_like( '_transient_timeout_sbs_pc_' ) . '%',
);
foreach ( $patterns as $pattern ) {
	$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s", $pattern ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
}

wp_unschedule_hook( 'sbs_pricing_cards_refresh' );
