<?php

namespace Formwerdung\Hexagon\Modules;

class TaxNav extends \Formwerdung\Hexagon\Lib\Taxonomy {
  protected static $name = 'TaxNav';
  protected static $pl_name = 'TaxNavs';
  protected static $slug = 'fw-tax-nav';
  public static $hierarchical = true;

  /**
   * Make a nav for every term in the taxonomy
   *
   * @since  0.0.1
   * @access public
   * @uses   get_terms()
   * @uses   is_wp_error()
   * @uses   register_nav_menus()
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
   * @since  0.0.1
   * @access protected
   * @uses   add_action()
   */
  public function registerHookCallbacks() {
    add_action('init', get_called_class().'::createTaxonomy');
    add_action('init', get_called_class().'::createTaxonomyNavs');
  }
}
