<?php

namespace Formwerdung\Hexagon\Lib;

class PostType extends Base {

  /**
   * @var string name of the post type
   * @access protected
   */
  protected static $post_type_name;

  /**
   * @var string plural name of the post type
   * @access protected
   */
  protected static $post_type_pl_name;

  /**
   * @var string slug of the post type
   * @access protected
   */
  protected static $post_type_slug;

  /**
   * Check for errors in extending classes
   *
   * @since  0.0.1
   * @access protected
   * @return bool
   */
  protected static function checkProperties() {
    if (empty( static::$post_type_name ) || empty( static::$post_type_pl_name ) || empty( static::$post_type_slug )) {
      return false;
    } else {
      return true;
    }
  }

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
      if (!post_type_exists(static::$post_type_slug)) {
        $post_type_params = static::getPostTypeParams();
        $post_type        = register_post_type(static::$post_type_slug, $post_type_params);
        if (is_wp_error($post_type)) {
          \add_notice(__METHOD__ . ' error: ' . $post_type->get_error_message(), 'error');
        }
      }
    } else {
      \add_notice(__METHOD__ . ' error: Required static properties are not all set. No Custom Post Type added.', 'error');
    }
  }

  /**
   * Default implementation of post type parameters, overwritable by extending classes
   *
   * @since  0.0.1
   * @access protected
   * @return array post type parameters
   */
  protected static function getPostTypeParams() {
    $labels = [
      'name'               => static::$post_type_pl_name,
      'singular_name'      => static::$post_type_name,
      'add_new'            => 'Add New',
      'add_new_item'       => 'New ' .    static::$post_type_name,
      'edit'               => 'Edit ' .   static::$post_type_pl_name,
      'edit_item'          => 'Edit ' .   static::$post_type_name,
      'new_item'           => 'New ' .    static::$post_type_name,
      'view'               => 'View ' .   static::$post_type_pl_name,
      'view_item'          => 'View ' .   static::$post_type_name,
      'search_items'       => 'Search ' . static::$post_type_pl_name,
      'not_found'          => 'No ' .     static::$post_type_pl_name . ' found',
      'not_found_in_trash' => 'No ' .     static::$post_type_pl_name . ' found in Trash'
    ];
    $post_type_params = [
      'labels'               => $labels,
      'singular_label'       => static::$post_type_name,
      'public'               => true,
      'exclude_from_search'  => false,
      'publicly_queryable'   => true,
      'show_ui'              => true,
      'show_in_menu'         => true,
      'menu_position'        => 5,
      'menu_icon'            => 'dashicons-editor-video',
      'hierarchical'         => true,
      'capability_type'      => 'post',
      'has_archive'          => true,
      'rewrite'              => array( 'slug' => static::$post_type_name ),
      'query_var'            => true,
      'supports'             => array( 'title', 'editor' )
    ];
    return $post_type_params;
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
