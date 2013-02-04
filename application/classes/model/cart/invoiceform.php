<?php
class Model_Cart_InvoiceForm extends Model_Invoice {
	public $session_id;
	public $country_area;
	public $total_weight;
	public $paypal_charge;
	
	public function populate($post) {
		parent::values($post);
		
		$this->session_id = $post['session_id'];
		$this->country_area = $post['country_area'];
	}
	
	public function getCountryCode() {
		$str = explode(',', $this->country_area);
		return $str[0];
	}
}