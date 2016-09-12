<?php
/*
Plugin Name: Hexagon
Plugin URI:  http://formwerdung.ch
Description: Hexagon makes your individual content possible, please do not delete.
Version:     0.0.1
Author:      Formwerdung
Author URI:  http://formwerdung.ch

License:     MIT License
License URI: http://opensource.org/licenses/MIT
*/

namespace Formwerdung;

class Hexagon {

  /**
   * Plugin requires php version
   *
   * @access public
   * @var    string
   */
  public $required_php_version = '5.6';

  /**
   * Plugin requires WordPress version
   *
   * @access public
   * @var    string
   */
  public $required_wp_version = '4.2.4';

  /**
   * Is the requirements problem php
   *
   * @access public
   * @var    bool
   */
  public $is_problem_php = false;

  /**
   * Constructor, pass to bootstrapper
   *
   * @since  0.0.1
   * @access public
   */
  public function __construct() {
    $this->bootstrap();
    register_activation_hook(__FILE__, [$this, '::activate()']);
    // register_deactivation_hook(__FILE__, [$this, '::deactivate()']);
  }

  /**
   * Bootstrapper, loads all the files that are required anyway
   * and the module loader for further checking of features
   *
   * @since  0.0.1
   * @access private
   * @uses   add_action()
   */
  private function bootstrap() {
    if ($this->requirementsMet($this->required_php_version, $this->required_wp_version)) {
      require_once('lib/admin-notice-helper.php');
      require_once('lib/base.php');
      require_once('lib/taxonomy.php');
      require_once('lib/post-type.php');
      require_once('lib/short-code.php');
      // require_once('lib/short-code-atts.php');
      foreach (glob(__DIR__.'/modules/*.php') as $file) {
        require_once($file);
        $basename = basename($file, '.php');
        $class = $this->dashesToCamelCase($basename, true);
        $class = '\Formwerdung\Hexagon\Modules\\' . $class;
        new $class;
      }
    } else {
      add_action('admin_notices', [$this, 'requirementsError']);
    }
  }

  /**
   * Code that runs on activation of plugin.
   *
   * @since  0.0.1
   * @access private
   * @uses   flush_rewrite_rules()
   */
  private function activate() {
    flush_rewrite_rules();
  }

  /**
   * Code that runs on deactivation.
   */
  // public function deactivate() {}

  /**
   * Include requirement error view
   *
   * @since  0.0.5
   * @access public
   * @uses   $wp_version global string
   */
  public function requirementsError() {
    global $wp_version;

    include_once('views/requirements_error.php');
  }

  /**
   * Check if php & wp version requirements are met
   *
   * @since       0.0.1
   * @access      private
   * @uses        $wp_version      global string
   * @param       $req_php_version string
   * @param       $req_wp_version  string
   * @return      bool
   */
  private function requirementsMet($req_php_version, $req_wp_version) {
    global $wp_version;

    if (version_compare(PHP_VERSION, $req_php_version, '<')) {
      $this->is_problem_php = true;
      return false;
    }
    if (version_compare($wp_version, $req_wp_version, '<')) {
      return false;
    }
    return true;
  }

  /**
   * Remove dashes in strings and convert to camel case
   *
   * @url http://stackoverflow.com/questions/2791998/convert-dashes-to-camelcase-in-php
   *
   * @since  0.0.2
   * @access protected
   * @param  $str          string
   * @param  $capFirstChar bool capitalize first character (for class syntax)
   */
  public static function dashesToCamelCase($str, $capFirstChar = false) {
    $string = str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
    if (!$capFirstChar) {
      $string = lcfirst($string);
    }
    return $string;
  }
}

/**
 * Init function
 *
 * @since       0.0.1
 * @access      public
 */
if (!function_exists('hexagon_init')) {
  function hexagon_init() {
    new Hexagon();
  }
}
add_action('after_setup_theme', __NAMESPACE__ . '\\hexagon_init');
