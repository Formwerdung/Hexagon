<?php

namespace Formwerdung\Hexagon\Taxonomies;

/**
 * Creates a custom taxonomy, ratings
 */
class Tax extends \Formwerdung\Hexagon\Lib\Taxonomy {
  protected static $name = 'Tax';
  protected static $pl_name = 'Taxs';
  protected static $slug = 'fw-tax';
  public static $hierarchical = true;
}
