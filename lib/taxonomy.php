<?php

namespace Formwerdung\Hexagon\Lib;

class Taxonomy extends Base {

  /**
   * @var string name of the post type
   * @access protected
   */
  protected static $name;

  /**
   * @var string plural name of the post type
   * @access protected
   */
  protected static $pl_name;

  /**
   * @var string slug of the post type
   * @access protected
   */
  protected static $slug;

  /**
   * @var bool is the taxonomy hierarchical
   * @access protected
   */
  protected static $hierarchical = true;

  /**
   * @var array which object types the taxonomy will be added to.
   * @access protected
   */
  protected static $objs = [];

  /**
   * Registers the custom post type
   *
   * @since  0.0.1
   * @access public
   * @uses   taxonomy_exists()
   * @uses   register_taxonomy()
   */
  public static function createTaxonomy() {
    if (static::checkProperties()) {
      if (!taxonomy_exists(static::$slug)) {
        $params = static::getTaxonomyParams(static::$hierarchical);
        $objs   = static::getTaxonomyObjectTypes();
        register_taxonomy(static::$slug, $objs, $params);
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
   * Default implementation of taxonomy parameters
   *
   * @since  0.0.1
   * @access protected
   * @return array taxonomy parameters
   */
  protected static function getTaxonomyParams($hierarchical = true) {
    $labels = array(
      'name'                       => static::$pl_name,
      'singular_name'              => static::$name,
      'search_items'               => static::$pl_name.' durchsuchen',
      'all_items'                  => 'Alle '.static::$pl_name,
      'edit_item'                  => static::$name.' bearbeiten',
      'update_item'                => static::$name.' aktualisieren',
      'add_new_item'               => 'Neues '.static::$name,
      'new_item_name'              => 'Neues '.static::$name,
      'popular_items'              => 'Populäre '.static::$pl_name,
      'separate_items_with_commas' => 'Mehrere '.static::$pl_name.' mit Kommas trennen',
      'add_or_remove_items'        => static::$pl_name.' hinzufügen oder entfernen',
      'choose_from_most_used'      => null,
      'not_found'                  => 'Keine '.static::$pl_name.' gefunden'
    );
    $params = array(
      'hierarchical'      => $hierarchical,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' ),
    );
    return $params;
  }

  /**
   * Defines which post type objects the taxonomy is going to be added to
   *
   * @since  0.0.1
   * @access protected
   * @return array post type objects
   */
  protected static function getTaxonomyObjectTypes() {
    if (static::$objs) {
      $objs = static::$objs;
    } else {
      $objs = [
        'post'
      ];
    }
    return $objs;
  }
}
