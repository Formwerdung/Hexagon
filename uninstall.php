<?php

// If uninstall not called from WordPress exit
if (!defined('WP_UNINSTALL_PLUGIN'))
  exit();

// Array of Taxonomies
// Enter all Taxonomies here
$taxs = [
  'fw-tax-nav',
  'fw-tax'
];

// Loop through and delete
foreach ($taxs as $tax) {
  // Prepare & excecute SQL, Delete Terms
  $wpdb->get_results($wpdb->prepare("DELETE t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('%s')", $tax));
  // Delete Taxonomy
  $wpdb->delete($wpdb->term_taxonomy, array('taxonomy' => $tax), array('%s'));
}
