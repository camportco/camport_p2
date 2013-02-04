<?php defined('SYSPATH') or die('No direct script access.');

class Model_Country extends ORM {
	public $_table_name = 'country';
	
	public static function getCountryAreaOption() {
		$countries = ORM::factory('Country')->find_all();
		
		$options = array();
		if (LANGUAGE == 'en') {
			foreach ($countries as $country) {
				$options[$country->country_code.','.$country->area] = $country->country;
			}
		}
		else {
			foreach ($countries as $country) {
				$options[$country->country_code.','.$country->area] = $country->country_tc;
			}
		}
		return $options;
	}
}