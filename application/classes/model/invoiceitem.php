<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_InvoiceItem extends ORM {
	public $_table_name = 'invoice_item';
	
	protected $_belongs_to = array('invoice=' => array('model' => 'invoice', 'foreign_key' => 'invoice_id'));
}