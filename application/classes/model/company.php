<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Company extends ORM {
	public $_table_name = 'company';
	
	protected $_has_many = array('product' => array());
}