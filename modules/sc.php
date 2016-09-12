<?php

namespace Formwerdung\Hexagon\Modules;

/**
 * Creates a custom taxonomy, ratings
 */
class Sc extends \Formwerdung\Hexagon\Lib\ShortCode {

  protected static $slug = 'sc';

  public static function markup($atts, $content = '') {
    return '<div class="shortcode">' . do_shortcode($content) . '</div>';
  }
}
