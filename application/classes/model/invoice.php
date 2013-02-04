<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Invoice extends ORM {
	public $_table_name = 'invoice';
	
	protected $_belongs_to = array('country' => array('model' => 'country', 'foreign_key' => 'country_code'));
	
	public function getPayPalCharge() {
		return $this->invoice_total - $this->total_product_price - $this->delivery_cost;
	}
	
	public function getPaymentDueDate() {
		/* $date = new DateTime($this->order_date);
		$date->add(new DateInterval('P7D'));
		return $date->format('Y-m-d'); */
		$date = strtotime(date("Y-m-d", strtotime($this->order_date)) . " +7 day");
		return date('Y-m-d', $date);
	}
}