<?php
class GlobalFunction {
	public static function isEmpty($str) {
		$str = $str === NULL ? NULL : trim($str);
		return empty($str);
	}
	
	public static function formatMoney($price) {
		return number_format($price, Constants::NUMBER_OF_DECIMAL_POINT);
	}
	
	public static function formatWeight($weight) {
		return number_format($weight, Constants::WEIGHT_DECIMAL_POINT);
	}
	
	public static function imageHTML($file, array $attributes = NULL, $protocol = NULL, $index = FALSE) {
		if (LANGUAGE == Constants::LANG_EN) {
			$path = 'media/images/en/'.$file;
		}
		else {
			$path = 'media/images/zh/'.$file;
		}
		return HTML::image($path, $attributes, $protocol, $index);
	}
	
	public static function getPayPalCharge($total) {
		return ceil($total * Constants::PAYPAL_CHARGE_PERCENTAGE * 10) / 10.0;
	}
	
	public static function valid_not_empty($value) {
		if ($value !== NULL) {
			$value = trim($value); 
		}
		
		return !empty($value);
	}
}