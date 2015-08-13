<?php

namespace Formwerdung\Hexagon\Taxonomies;

/**
 * Creates a custom taxonomy, ratings
 */
class Cpt extends \Formwerdung\Hexagon\Lib\PostType {
  protected static $post_type_name = 'Like a Post';
  protected static $post_type_pl_name = 'Like a Posts';
  protected static $post_type_slug = 'fw-like-post';
}
