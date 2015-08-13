<?php

namespace Formwerdung\Hexagon\Lib;

/**
 * Abstract class to implement base methods, best practices for all classes
 */
abstract class Base {

    /**
     * Constructor
     *
     * @mvc Controller
     */
    public function __construct() {
      $this->registerHookCallbacks();
    }

  /**
   * Register callbacks for actions and filters
   *
   * @mvc Controller
   */
  abstract public function registerHookCallbacks();
}
