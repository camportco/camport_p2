<?php
class Model_Cart_CartItem {
	const RECORD_DELIMITER = '|';
	const FIELD_DELIMITER = ',';
	
	public $recordId;
	public $id;
	public $color;
	public $qty;
	
	public $product_id;
	public $name;
	public $gross_weight;
	public $price;
	public $total;
	
	public function convertToCookieString() {
		return $this->recordId.Model_Cart_CartItem::FIELD_DELIMITER.$this->id.Model_Cart_CartItem::FIELD_DELIMITER.$this->color.Model_Cart_CartItem::FIELD_DELIMITER.$this->qty;
	}
	
	public static function parse($cookieString) {
		$elements = explode(Model_Cart_CartItem::FIELD_DELIMITER, $cookieString);
		
		$cartItem = new Model_Cart_CartItem();
		$cartItem->recordId = $elements[0];
		$cartItem->id = $elements[1];
		$cartItem->color = $elements[2];
		$cartItem->qty = $elements[3];
		
		return $cartItem;
	}
	
	public function getFullProductName() {
		if (!empty($this->color)) {
			return $this->product_id.'('.$this->color.')';
		}
		else {
			return $this->product_id;
		}
	}
}