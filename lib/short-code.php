<?php

namespace Formwerdung\Hexagon\Lib;

abstract class ShortCode extends Base {

  protected static $slug;

  /**
   * Markup function
   *
   * @since  0.0.3
   * @access protected
   */
  abstract public static function markup($atts, $content = '');

  /**
   * Enforce use of a function to register all WordPress hook callbacks
   *
   * @since  0.0.3
   * @access public
   */
  public function registerHookCallbacks() {
    add_shortcode(static::$slug, get_called_class() . '::markup');
  }
}
