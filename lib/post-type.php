<?php

namespace Formwerdung\Hexagon\Lib;

class PostType extends Base {

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
   * @var string genericons menu item id (the WordPress default is the post icon)
   * @access protected
   */
  protected static $menu_icon;

  /**
   * Registers the custom post type
   *
   * @since  0.0.1
   * @access public
   * @uses   post_type_exists()
   * @uses   register_post_type()
   * @uses   is_wp_error
   * @uses   get_error_message()
   */
  public static function createPostType() {
    if (static::checkProperties()) {
      if (!post_type_exists(static::$slug)) {
        $params = static::getPostTypeParams();
        $post_type        = register_post_type(static::$slug, $params);
        if (is_wp_error($post_type)) {
          \add_notice(__METHOD__ . ' error: ' . $post_type->get_error_message(), 'error');
        }
      }
    } else {
      \add_notice(__METHOD__ . ' error: Required static properties are not all set. No Custom Post Type added.', 'error');
    }
  }

  /**
   * Default implementation of post type parameters
   *
   * @since  0.0.1
   * @access protected
   * @return array post type parameters
   */
  protected static function getPostTypeParams() {
    $labels = [
      'name'               => static::$pl_name,
      'singular_name'      => static::$name,
      'add_new'            => 'Neu hinzufügen',
      'add_new_item'       => 'Neuer ' .  static::$name,
      'edit'               => static::$pl_name . ' bearbeiten',
      'edit_item'          => static::$name    . ' bearbeiten',
      'new_item'           => 'Neuer ' .  static::$name,
      'view'               => static::$pl_name . ' ansehen',
      'view_item'          => static::$name    . ' ansehen',
      'search_items'       => static::$pl_name . ' durchsuchen',
      'not_found'          => 'Keine ' .     static::$pl_name . ' gefunden',
      'not_found_in_trash' => 'Keine ' .     static::$pl_name . ' im Mülleimer gefunden'
    ];
    $params = [
      'labels'               => $labels,
      'singular_label'       => static::$name,
      'public'               => true,
      'exclude_from_search'  => false,
      'publicly_queryable'   => true,
      'show_ui'              => true,
      'show_in_menu'         => true,
      'menu_position'        => 5,
      'menu_icon'            => static::$menu_icon,
      'hierarchical'         => true,
      'capability_type'      => 'post',
      'has_archive'          => true,
      'rewrite'              => array( 'slug' => static::$name ),
      'query_var'            => true,
      'supports'             => array( 'title', 'editor' )
    ];
    return $params;
  }

  /**
   * Register callback implementation for custom post type
   *
   * @since  0.0.1
   * @access public
   * @uses   add_action()
   */
  public function registerHookCallbacks() {
    add_action('init', get_called_class() . '::createPostType');
  }
}
