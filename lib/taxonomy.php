<?php

namespace Formwerdung\Hexagon\Lib;

class Taxonomy extends Base {
  protected static $tax_name;
  protected static $tax_pl_name;
  protected static $tax_slug;
  public static $hierarchical = true;

  /**
   * Check for error in extending classes
   *
   * @mvc Controller
   */
  protected static function checkProperties() {
    if (empty( static::$tax_name ) || empty( static::$tax_pl_name ) || empty( static::$tax_slug )) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * Registers the custom post type
   *
   * @mvc Controller
   */
  public static function createTaxonomy() {
    if (static::checkProperties()) {
      if (! taxonomy_exists(static::$tax_slug)) {
        $tax_params   = static::getTaxonomyParams(static::$hierarchical);
        $tax_objs  = static::getTaxonomyObjectTypes();
        register_taxonomy(static::$tax_slug, $tax_objs, $tax_params);
      }
    } else {
      add_notice(__METHOD__ . ' error: Required static properties are not all set. No Taxonomy added.', 'error');
    }
  }

  /**
   * Register callbacks for actions and filters
   *
   * @mvc Controller
   */
  public function registerHookCallbacks() {
    add_action('init', get_called_class() . '::createTaxonomy');
  }

  /**
   * Defines the parameters for the custom taxonomy
   *
   * @mvc Model
   *
   * @return array
   */
  protected static function getTaxonomyParams($hierarchical = true) {
    $tax_labels = array(
      'name'                       => static::$tax_pl_name,
      'singular_name'              => static::$tax_name,
      'search_items'               => static::$tax_pl_name.' durchsuchen',
      'all_items'                  => 'Alle '.static::$tax_pl_name,
      'edit_item'                  => static::$tax_name.' bearbeiten',
      'update_item'                => static::$tax_name.' aktualisieren',
      'add_new_item'               => 'Neues '.static::$tax_name,
      'new_item_name'              => 'Neues '.static::$tax_name,
      'popular_items'              => 'Populäre '.static::$tax_pl_name,
      'separate_items_with_commas' => 'Mehrere '.static::$tax_pl_name.' mit Kommas trennen',
      'add_or_remove_items'        => static::$tax_pl_name.' hinzufügen oder entfernen',
      'choose_from_most_used'      => null,
      'not_found'                  => 'Keine '.static::$tax_pl_name.' gefunden'
    );

    $tax_params = array(
      'hierarchical'      => $hierarchical,
      'labels'            => $tax_labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' ),
    );

    return $tax_params;
  }

  /**
   * Defines which post type objects the taxonomy is going to be added to
   *
   * @mvc Model
   *
   * @return array
   */
  protected static function getTaxonomyObjectTypes() {
    $tax_objs = [
      'post'
    ];

    return $tax_objs;
  }
}
