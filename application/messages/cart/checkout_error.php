<?php 
return array
(
        'customer_name' => array (
        	'not_empty' => __('checkout.error.name_require'),
			'GlobalFunction::valid_not_empty' => __('checkout.error.name_require'),
		),
		'email' => array (
			'not_empty' => __('checkout.error.email_require'),
			'GlobalFunction::valid_not_empty' => __('checkout.error.email_require'),
			'email' => __('checkout.error.invalid_email_format'),
		),
		'tel' => array (
				'not_empty' => __('checkout.error.telephone_require'),
				'GlobalFunction::valid_not_empty' => __('checkout.error.telephone_require'),
		),
		'address' => array (
				'not_empty' => __('checkout.error.address_require'),
				'GlobalFunction::valid_not_empty' => __('checkout.error.address_require'),
		),
);
