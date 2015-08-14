<?php

namespace Formwerdung\Hexagon\Taxonomies;

/**
 * This is a taxonomy which brings a
 */
class TaxNav extends \Formwerdung\Hexagon\Lib\Taxonomy {
  protected static $name = 'TaxNav';
  protected static $pl_name = 'TaxNavs';
  protected static $slug = 'fw-tax-nav';
  public static $hierarchical = true;

  /**
   * Make a nav for every term in the taxonomy
   */
  public static function createTaxonomyNavs() {
    $args = [
      'hide_empty' => false
    ];
    $terms = get_terms(static::$slug, $args);
    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $key = $term->slug.'_navigation';
        $value = $term->name.' Nav';
        $navs[$key] = $value;
      }
      register_nav_menus($navs);
    }
  }

  /**
   * Register callbacks for actions and filters
   *
   * @mvc Controller
   */
  public function registerHookCallbacks() {
    add_action('init', get_called_class().'::createTaxonomy');
    add_action('init', get_called_class().'::createTaxonomyNavs');
  }
}
