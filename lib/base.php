<?php

namespace Formwerdung\Hexagon\Lib;

abstract class Base {

  /**
   * Constructor. The default is just a call to the register hook callback function.
   *
   * @since  0.0.1
   * @access public
   */
  public function __construct() {
     $this->registerHookCallbacks();
  }

  /**
   * Check for errors in post type and taxonomy classes
   *
   * @since  0.0.1
   * @access protected
   * @return bool
   */
  protected static function checkProperties() {
    if (empty(static::$name) || empty(static::$pl_name) || empty(static::$slug)) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * Enforce use of a function to register all WordPress hook callbacks
   *
   * @since  0.0.1
   * @access public
   */
  abstract public function registerHookCallbacks();
}
