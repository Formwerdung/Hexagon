<?php

namespace Formwerdung\Hexagon\Taxonomies;

/**
 * Creates a custom taxonomy, ratings
 */
class Tax extends \Formwerdung\Hexagon\Lib\Taxonomy {
  protected static $tax_name = 'Tax';
  protected static $tax_pl_name = 'Taxs';
  protected static $tax_slug = 'fw-tax';
  public static $hierarchical = true;
}
