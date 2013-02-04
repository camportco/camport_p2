<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Category extends ORM {
	public $_table_name = 'category';
	
	protected $_has_many = array('subCategories' => array('model' => 'subCategory', 'foreign_key' => 'cat_id'));
	
	protected $_table_columns = array(
			"id" => array("type" => "int"),
			"cat_name" => array("type" => "string"),
			"cat_name_tc" => array("type" => "string"),
			"display_seq" => array("type" => "int"),
	);
}