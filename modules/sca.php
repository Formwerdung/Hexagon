<?php

namespace Formwerdung\Hexagon\Modules;

/**
 * Creates a custom taxonomy, ratings
 */
class Sca extends \Formwerdung\Hexagon\Lib\ShortCodeAtts {

  protected static $slug = 'sca';

  public static function markup($atts, $content = '') {
    $atts = static::defaultAtts($atts);
    $att_class = static::checkAtts($atts);

    return '<div class="shortcode ' . $att_class . '">' . do_shortcode($content) . '</div>';
  }

  protected static function defaultAtts($atts) {
    $atts = shortcode_atts([
      'att' => 'default'
    ], $atts);

    return $atts;
  }

  protected static function checkAtts($atts) {
    switch ($atts['att']) {
      case 'default':
        $att_class = 'shortcode_default';
        break;

      case 'gonzo':
        $att_class = 'shortcode_gonzo';
        break;

      case 'wilder':
        $att_class = 'shortcode_wilder';
        break;

      default:
        $att_class = 'shortcode_default';
        break;
    }
    return $att_class;
  }
}
