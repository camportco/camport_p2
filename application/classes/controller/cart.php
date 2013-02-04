<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cart extends Controller_Template {
	
	public $template = 'template/column2';
	
	public function action_view_cart() {
		// Retrieve items in shopping cart from cookie
		$cookieCartItemString = Cookie::get(Constants::COOKIE_CART_ITEM, '');
		
		$this->showCartItem($cookieCartItemString);
	}
	
	/**
	 * Ajax call - add item to cart
	 */
	public function action_add_to_cart() {
		$id = $this->request->post('id');
		$color = $this->request->post('color');
		$qty = $this->request->post('qty');
		
		$this->addToCart($id, $color, $qty);
		
		$this->auto_render = false;
		$this->response->body(Controller_Cart::getCartItemQty()); // Retrieve updated QTY
	}
	
	/* public function action_direct_buy() {
		$id = $this->request->post('id');
		$color = $this->request->post('color');
		$qty = $this->request->post('qty');
		
		if ($id === NULL) {
			// Language change
			$cookieCartItemString = Cookie::get(Constants::COOKIE_CART_ITEM, '');
		}
		else {
			$cookieCartItemString = $this->addToCart($id, $color, $qty);
		}
		
		$this->showCartItem($cookieCartItemString);
	}
	
	public function action_direct_buy2() {
		$this->action_direct_buy();
	} */
	
	public function action_delete_item() {
		$recordId = $this->request->post('record_id');
		
		$newCookieString = '';
		$totalQty = 0;
		
		$cookieCartItemString = Cookie::get(Constants::COOKIE_CART_ITEM, '');
		if ($cookieCartItemString != '') {
			$cookieStrings = explode(Model_Cart_CartItem::RECORD_DELIMITER, $cookieCartItemString);
			foreach ($cookieStrings as $cookieString) {
				$cartItem = Model_Cart_CartItem::parse($cookieString);
				
				if ($cartItem->recordId != $recordId) {
					if ($newCookieString == '') {
						$newCookieString = $cookieString;
					}
					else {
						$newCookieString .= Model_Cart_CartItem::RECORD_DELIMITER.$cookieString;
					}
					
					$totalQty += $cartItem->qty;
				}
			}
		}
		
		Cookie::set(Constants::COOKIE_CART_ITEM, $newCookieString, 60*60*24*CART_COOKIE_EXPIRE_DAY);
		
		// Store QTY to session
		$session = Session::instance();
		$session->set(Constants::SESSION_CART_QTY, $totalQty);

		$this->showCartItem($newCookieString);
	}
	
	private function addToCart($id, $color, $qty) {
		$newItem = new Model_Cart_CartItem();
		$newItem->id = $id;
		$newItem->color = $color;
		$newItem->qty = $qty;
		
		$actualQty = $qty;
		
		// Get next record ID
		$lastRecordId = 0;
		$isExist = false;
		$newCookieCartItemString = '';
		$cookieCartItemString = Cookie::get(Constants::COOKIE_CART_ITEM, '');
		if ($cookieCartItemString != '') {
			$cookieStrings = explode(Model_Cart_CartItem::RECORD_DELIMITER, $cookieCartItemString);
			foreach ($cookieStrings as $cookieString) {
				$cartItem = Model_Cart_CartItem::parse($cookieString);
				if ($cartItem->id == $id && $cartItem->color == $color) {
					// Product already added
					$isExist = true;
					
					if ($cartItem->qty + $qty > 10) {
						$actualQty = 10 - $cartItem->qty;
						$cartItem->qty = 10;
					}
					else {
						$cartItem->qty += $qty;
					}
				}
				
				if ($cartItem->recordId > $lastRecordId) {
					$lastRecordId = $cartItem->recordId;
				}
				
				// Store new item to cookie
				if ($newCookieCartItemString == '') {
					$newCookieCartItemString = $cartItem->convertToCookieString();
				}
				else {
					$newCookieCartItemString .= Model_Cart_CartItem::RECORD_DELIMITER.$cartItem->convertToCookieString();
				}
			}
		}
		
		if (!$isExist) {
			$newItem->recordId = $lastRecordId + 1;
			
			// Store new item to cookie
			if ($newCookieCartItemString == '') {
				$newCookieCartItemString = $newItem->convertToCookieString();
			}
			else {
				$newCookieCartItemString .= Model_Cart_CartItem::RECORD_DELIMITER.$newItem->convertToCookieString();
			}
		}
		
		Cookie::set(Constants::COOKIE_CART_ITEM, $newCookieCartItemString, 60*60*24*CART_COOKIE_EXPIRE_DAY);
		
		// Update QTY in session
		$totalQty = Controller_Cart::getCartItemQty();
		$totalQty += $actualQty;
		$session = Session::instance();
		$session->set(Constants::SESSION_CART_QTY, $totalQty);
		
		return $newCookieCartItemString;
	}
	
	private function showCartItem($cookieCartItemString) {
		$cartItems = $this->getCartItemsFromCookie($cookieCartItemString);
		
		$totalQty = 0;
		$totalProductPrice = 0;
		foreach ($cartItems as $cartItem) {
			$totalQty += $cartItem->qty;
			$totalProductPrice += $cartItem->total;
		}
		
		$view = View::factory('cart/shopping_cart');
		$view->set('cartItems', $cartItems);
		$view->set('totalQty', $totalQty);
		$view->set('totalProductPrice', $totalProductPrice);
		$this->template->set('content', $view);
	}
	
	private function getCartItemsFromCookie($cookieCartItemString) {
		$cartItems = array();
		if ($cookieCartItemString != '') {
			$cookieStrings = explode(Model_Cart_CartItem::RECORD_DELIMITER, $cookieCartItemString); // format: {id},{color},{qty}|{id},{color},{qty}|...
			foreach ($cookieStrings as $cookieString) {
				$cartItem = Model_Cart_CartItem::parse($cookieString);
		
				$product = ORM::factory('product')->where('id', '=', $cartItem->id)->find();
		
				$cartItem->product_id = $product->product_id;
				$cartItem->name = $product->name;
				$cartItem->gross_weight = $product->gross_weight;
				$cartItem->price = $product->getActualPrice();
				$cartItem->total = $product->getActualPrice() * $cartItem->qty;
				
				$cartItems[] = $cartItem;
			}
		}
		return $cartItems;
	}
	
	public static function getCartItemQty() {
		$session = Session::instance();
		$totalQty = $session->get(Constants::SESSION_CART_QTY, NULL);
		
		if ($totalQty === NULL) {
			$totalQty = 0;
			$cookieCartItemString = Cookie::get(Constants::COOKIE_CART_ITEM, '');
			if ($cookieCartItemString != '') {
				$cookieStrings = explode(Model_Cart_CartItem::RECORD_DELIMITER, $cookieCartItemString);
				foreach ($cookieStrings as $cookieString) {
					$cartItem = Model_Cart_CartItem::parse($cookieString);
					$totalQty += $cartItem->qty;
				}
			}
			
			$session->set(Constants::SESSION_CART_QTY, $totalQty);
		}

		return $totalQty;
	} 
	
// -----------------------------------------------------------------------------

	public function action_checkout() {
		$recordIds = $this->request->post('record_id');
		$qtys = $this->request->post('qty');
		
		if ($recordIds != NULL) {
			// Update QTY
			$totalQty = 0;
			$newQtys = array();
			foreach ($recordIds as $idx=>$recordId) {
				$newQtys[$recordId] = $qtys[$idx];
				$totalQty += $qtys[$idx];
			}
			
			// Update QTY to session
			$session = Session::instance();
			$session->set(Constants::SESSION_CART_QTY, $totalQty);
			
			$newCookieString = '';
			$cookieCartItemString = Cookie::get(Constants::COOKIE_CART_ITEM, '');
			if ($cookieCartItemString != '') {
				$cookieStrings = explode(Model_Cart_CartItem::RECORD_DELIMITER, $cookieCartItemString);
				foreach ($cookieStrings as $cookieString) {
					$cartItem = Model_Cart_CartItem::parse($cookieString);
					
					if (array_key_exists($cartItem->recordId, $newQtys)) {
						$cartItem->qty = $newQtys[$cartItem->recordId];
						$cookieString = $cartItem->convertToCookieString();
					}
			
					if ($newCookieString == '') {
						$newCookieString = $cookieString;
					}
					else {
						$newCookieString .= Model_Cart_CartItem::RECORD_DELIMITER.$cookieString;
					}
				}
			}
			
			Cookie::set(Constants::COOKIE_CART_ITEM, $newCookieString, 60*60*24*CART_COOKIE_EXPIRE_DAY);
		}
		else {
			$newCookieString = Cookie::get(Constants::COOKIE_CART_ITEM);
		}
		
		$cartItems = $this->getCartItemsFromCookie($newCookieString);
		
		// Store the cart items in session
		$session = Session::instance();
		$sessionId = $session->get('SESSION_CHECKOUT_SEESION_ID', 0);
		$sessionId = $sessionId + 1;
		$session->set(Constants::SESSION_CHECKOUT_SEESION_ID, $sessionId);
		$session->set(Constants::SESSION_CHECKOUT_CART_ITEMS, $cartItems);
		
		// Get total product amount
		$totalQty = 0;
		$totalProductPrice = 0;
		$totalWeight = 0;
		foreach ($cartItems as $cartItem) {
			$totalQty += $cartItem->qty;
			$totalProductPrice += $cartItem->total;
			$totalWeight += $cartItem->gross_weight * $cartItem->qty;
		}
		
		// Calculate shipping charge
		$country = 'HK';
		$area = 'LOCAL';
		$deliveryMethod = 'L';
		$deliveryCost = $this->calculateDeliveryCost($country, $deliveryMethod, $totalWeight);
		
		// Set default form values
		$form = new Model_Cart_InvoiceForm();
		$form->session_id = $sessionId;
		$form->pick_up_method = 'SH'; // Shipping by default
		$form->country_area = $country.','.$area;
		$form->delivery_method = $deliveryMethod;
		$form->total_product_price = $totalProductPrice;
		$form->total_weight = $totalWeight;
		
		if ($deliveryCost === NULL) {
			$form->delivery_cost = 'N/A';
			$form->invoice_total = 'N/A';
		}
		else {
			$form->delivery_cost = $deliveryCost;
			$form->invoice_total = $totalProductPrice + $deliveryCost;
		}
		
		$view = View::factory('cart/checkout');
		$view->set('cartItems', $cartItems);
		$view->set('totalQty', $totalQty);
		$view->set('form', $form);
		$this->template->set('content', $view);
	}
	
	public function action_confirm() {
		$session = Session::instance();
		
		if (isset($_POST['action']) && $_POST['action'] == 'reconfirm') {
			// Language changes during validting user input
		}
		else if (!isset($_POST['session_id'])) {
			// Language changes after creating invoice
			$invoiceId = $session->get(Constants::SESSION_INVOICE_ID);
			
			$invoice = ORM::factory('invoice')->where('id', '=', $invoiceId)->find();
			
			$view = View::factory('cart/order_confirm');
			$view->set('invoice', $invoice);
			$this->template->set('content', $view);
			return;
		}
		
		// Start process
		$form = new Model_Cart_InvoiceForm();
		$form->populate($_POST);
		
		$cartItems = $session->get(Constants::SESSION_CHECKOUT_CART_ITEMS);
		
		$totalQty = 0;
		$totalProductPrice = 0;
		$totalWeight = 0;
		if ($cartItems != NULL) {
			foreach ($cartItems as $cartItem) {
				$totalQty += $cartItem->qty;
				$totalProductPrice += $cartItem->total;
				$totalWeight += $cartItem->gross_weight * $cartItem->qty;
			}
		}
		else {
			$cartItems = array();
		}
		
		// Validation
		$validation = Validation::factory($_POST)
					->rule('session_id', 'Controller_Cart::is_current_session')
					->rule('customer_name', 'not_empty')
					->rule('customer_name', 'GlobalFunction::valid_not_empty')
					->rule('email', 'not_empty')
					->rule('email', 'GlobalFunction::valid_not_empty')
					->rule('email', 'email')
					->rule('tel', 'GlobalFunction::valid_not_empty')
					->rule('tel', 'not_empty')
					->rule('pick_up_method', 'not_empty')
					->rule('payment_method', 'not_empty');
		
		if ($form->pick_up_method == 'SH') {
			// Shipping
			$validation =$validation
					->rule('address', 'not_empty')
					->rule('address', 'GlobalFunction::valid_not_empty')
					->rule('country_area', 'not_empty')
					->rule('delivery_method', 'not_empty');
		}
		
		$paypalCharge = 0;
		$isValidDeliveryCost = true;
		$deliveryCost = 0;
		if ($validation->check()) {
			// Valid dadta
			if ($form->pick_up_method == 'SE') {
				// Self-pick
				$form->address = NULL;
				$form->country_code = NULL;
				$form->delivery_method = NULL;
			}
			else {
				// Shipping
				$str = explode(',', $form->country_area);
				$form->country_code = $str[0];
				
				// Calculate postal fee
				$fee = $this->calculateDeliveryCost($form->getCountryCode(), $form->delivery_method, $totalWeight);
				
				if ($fee === NULL) {
					$isValidDeliveryCost = false;
				}
				else {
					$deliveryCost = $fee;
				}
			}
			
			$form->total_product_price = $totalProductPrice;
			$form->delivery_cost = $deliveryCost;
			
			if ($isValidDeliveryCost) {
				// Generate order number (format: YYYY0000)
				$currentOrderNumber = ORM::factory('invoice')->select(array(DB::expr("MAX(order_number)"), 'current_order_number'))->where('order_number', 'like', date('Y').'%')->find()->current_order_number;
				$seq = substr($currentOrderNumber, 4);
				$form->order_number = date('Y').str_pad((int)$seq + 1, 4, '0', STR_PAD_LEFT);
				
				// Calculate paypal charge
				if ($form->payment_method == 'PP') {
					$paypalCharge = GlobalFunction::getPayPalCharge($totalProductPrice + $deliveryCost);
				}
				else {
					$paypalCharge = 0;
				}
				
				$form->invoice_total = $form->total_product_price + $deliveryCost + $paypalCharge; 
				$form->email_sts = 'R';
				$form->ip = $_SERVER['REMOTE_ADDR'];
				$invoice = $form->save();
				
				$invoiceId = $invoice->id;
				
				// Create invoice item
				foreach ($cartItems as $cartItem) {
					$invoiceItem = new Model_InvoiceItem();
					$invoiceItem->invoice_id = $invoice->id;
					$invoiceItem->order_number = $invoice->order_number;
					$invoiceItem->product_cd = $cartItem->product_id;
					$invoiceItem->color = $cartItem->color;
					$invoiceItem->qty = $cartItem->qty;
					$invoiceItem->unit_price = $cartItem->price;
					
					$invoiceItem->save();
				}
				
				// Retrieve saved invoice
				$invoice = ORM::factory('invoice')->where('id', '=', $invoiceId)->find();
				
				// Store invoice ID in session
				$session->set(Constants::SESSION_INVOICE_ID, $invoiceId);
				
				// TODO
				// Remove cookie
				Cookie::delete(Constants::COOKIE_CART_ITEM);
				
				// Clear QTY in session
				$session = Session::instance();
				$session->set(Constants::SESSION_CART_QTY, 0);
				
				// Clear cart items in session
				$session->delete(Constants::SESSION_CHECKOUT_CART_ITEMS);
				
				$view = View::factory('cart/order_confirm');
				$view->set('invoice', $invoice);
				$this->template->set('content', $view);
				
				return;
			}
		}

		// **************** Invalid data ****************
			
		//setup the errors
		$errors = $validation->errors('cart/checkout_error');
		
		$deliveryCost = 0;
		if (!$isValidDeliveryCost) {
			if ($errors == NULL) {
				$errors['postal_fee'] = __('checkout.error.no_shipping_charge');
			}
			
			$deliveryCost = NULL;
		}
		else {
			// Calculate postal fee
			if ($form->pick_up_method == 'SH') {
				$deliveryCost = $this->calculateDeliveryCost($form->getCountryCode(), $form->delivery_method, $totalWeight);
			}
		}
		
		$form->total_product_price = $totalProductPrice;
		$form->delivery_cost = $deliveryCost === NULL ? 'N/A' : $deliveryCost;
		
		if ($deliveryCost !== NULL) {
			// Calculate paypal charge
			if ($form->payment_method == 'PP') {
				$paypalCharge = GlobalFunction::getPayPalCharge($totalProductPrice + $deliveryCost);
			}
			else {
				$paypalCharge = 0;
			}
			
			$form->paypal_charge = $paypalCharge;
			$form->invoice_total = $totalProductPrice + $deliveryCost + $paypalCharge;
		}
		else {
			$form->paypal_charge = 'N/A';
			$form->invoice_total = 'N/A';
		}
		
		$view = View::factory('cart/checkout');
		$view->set('errors', $errors);
		$view->set('cartItems', $cartItems);
		$view->set('totalQty', $totalQty);
		$view->set('form', $form);
		$view->set('action', 'reconfirm');
		$this->template->set('content', $view);
	}
	
	public static function is_current_session($sessionId) {
		$session = Session::instance();
		$currentSessionId = $session->get(Constants::SESSION_CHECKOUT_SEESION_ID);
		if ($currentSessionId == $sessionId) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function action_get_price_detail() {
		$sessionId = $_GET['session_id'];
		$productTotal = $_GET['product_total'];
		$pickUpMethod = $_GET['pick_up_method'];
		$paymentMethod = $_GET['payment_method'];
		
		$paypalCharge = 0;
		$shippingFee = 0;
		if ($pickUpMethod == 'SH') {
			// Shipping
			$deliveryMethod = $_GET['delivery_method'];
			$countryCode = $_GET['country_code'];
			
			$session = Session::instance();
			$currentSessionId = $session->get(Constants::SESSION_CHECKOUT_SEESION_ID);
			if ($currentSessionId != $sessionId) {
				// No session is found
				$this->response->body(json_encode(array('fee' => 'N/A')));
				return;
			}
			
			$cartItems = $session->get(Constants::SESSION_CHECKOUT_CART_ITEMS);
			
			$totalWeight = 0;
			foreach ($cartItems as $cartItem) {
				$totalWeight += empty($cartItem->gross_weight) ? 0 : $cartItem->gross_weight * $cartItem->qty;
			}
			
			$shippingFee = $this->calculateDeliveryCost($countryCode, $deliveryMethod, $totalWeight);
		}
			
		$this->auto_render = false; // Don't render template
		
		if ($shippingFee !== NULL) {
			if ($paymentMethod == 'PP') {
				$paypalCharge = GlobalFunction::getPayPalCharge($productTotal + $shippingFee);
			}
			
			$actualTotalPrice = $productTotal + $shippingFee + $paypalCharge;
			
			$this->response->body(json_encode(
					array('shipping_fee' => number_format($shippingFee, Constants::NUMBER_OF_DECIMAL_POINT),
							'paypal_charge' => number_format($paypalCharge, Constants::NUMBER_OF_DECIMAL_POINT),
							'actual_total_price' => number_format($actualTotalPrice, Constants::NUMBER_OF_DECIMAL_POINT))
					));
		}
		else {
			$this->response->body(json_encode(
					array('shipping_fee' => 'N/A',
						'paypal_charge' => 'N/A',
						'actual_total_price' => 'N/A')
					));
		}
		
		 /* $this->template = View::factory('template/blank');
		 $this->template->set('content', json_encode(array('fee' => $fee))); */
	}
	
	private function calculateDeliveryCost($countryCode, $deliveryMethod, $weight) {
		$weight = ceil($weight); // Round up
		
		$postalFee = ORM::factory('postalFee')
				->where('country_code', '=', $countryCode)
				->where('postalfee.delivery_method', '=', $deliveryMethod)
				->where('postalfee.gram_from', '<=', $weight)
				->where('postalfee.gram_to', '>=', $weight)
				->find();
		
		if ($postalFee != NULL) {
			return $postalFee->price;
		}
		else {
			return NULL;
		}
	}

}
