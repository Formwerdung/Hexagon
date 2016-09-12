<?php

namespace Formwerdung\Hexagon\Lib;

abstract class ShortCodeAtts extends ShortCode {

  protected static $slug;

  /**
   * Default attribute function
   *
   * @since  0.0.3
   * @access protected
   */
  abstract protected static function defaultAtts($atts);

  /**
   * Check attribute function
   *
   * @since  0.0.3
   * @access protected
   */
  abstract protected static function checkAtts($atts);

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
