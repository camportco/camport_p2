<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_SubCategory extends ORM {
	public $_table_name = 'sub_category';
	
	protected $_belongs_to = array('category' => array('model' => 'category', 'foreign_key' => 'cat_id'));
	
	protected $_has_many = array('products' => array('model' => 'product', 'foreign_key' => 'sub_cat_id'));
	
	protected $_table_columns = array(
			"id" => array("type" => "int"),
			"cat_id" => array("type" => "int"),
			"sub_cat_name" => array("type" => "string"),
			"sub_cat_name_tc" => array("type" => "string"),
			"display_seq" => array("type" => "int"),
	);
}