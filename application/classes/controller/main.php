<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Template {
	
	public $template = 'template/column3';
	
	// echo Debug::vars($foo);

	public function action_index() {
		$view = View::factory('index');
		
		// Get advertisement
		$advertisements = ORM::factory('advertisement')->order_by('id')->find_all();
		$this->template->set('advertisements', $advertisements);
		
		// Get slide show
		$slideShows = ORM::factory('slideshow')->order_by('id')->find_all();
		$view->set('slideShows', $slideShows);
		
		// Get product randomly
		$categoryIdMap = $this->getCategoryIdMap();
		
		$accessory = $this->getRandomProduct($categoryIdMap['Camera Accessories']); // Camera Accessories
		$insert = $this->getRandomProduct($categoryIdMap['Camera Inserts']); // Camera Inserts
		$bag = $this->getRandomProduct($categoryIdMap['Camera Bags']); // Camera Bags
		$strap = $this->getRandomProduct($categoryIdMap['Camera Straps']); // Camera Inserts
		$case = $this->getRandomProduct($categoryIdMap['Camera Case']); // Camera Case
		
		$view->set('categoryIdMap', $categoryIdMap);
		$view->set('accessory', $accessory);
		$view->set('insert', $insert);
		$view->set('bag', $bag);
		$view->set('strap', $strap);
		$view->set('case', $case);
		
		// Get news
		$newslinks = ORM::factory('newslink')->order_by('display_seq')->order_by('id','desc')->limit(10)->find_all();
		$view->set('newslinks', $newslinks);
		
		// Display
		$this->template->set('content', $view);
	}
	
	public function action_change_language() {
		$lang = $_POST['lang'];
		
		// Stroe language to cookie
		Cookie::$salt = COOKIE_SALT;
		Cookie::set('lang', $lang, 60*60*24*CART_COOKIE_EXPIRE_DAY);
		
		$this->auto_render = false; // Don't render template
	}
	
	private function getRandomProduct($catId) {
		$query = DB::select(array('FLOOR(RAND() * COUNT("product_id"))', 'offset'))
				->from('product')
				->join('sub_category')->on('sub_category.id', '=', 'product.sub_cat_id')
				->where('product.sts', '=', 'A')
				->where('sub_category.cat_id', '=', $catId);
		$result = $query->execute();
		
		$offset = $result[0]['offset'];
		
		$product = ORM::factory('product')
				->join('sub_category')->on('sub_category.id', '=', 'product.sub_cat_id')
				->where('product.sts', '=', 'A')
				->where('sub_category.cat_id', '=', $catId)
				->offset($offset)
				->find();

		return $product;
	}
	
	private function getCategoryIdMap() {
		$categoryIdMap = Cache::instance()->get('CACHE_CATEGORY_ID_MAP');
		
		if ($categoryIdMap == NULL) {
			$categories = ORM::factory('category')->find_all();
			
			$categoryIdMap = array();
			foreach($categories as $category) {
				$categoryIdMap[$category->cat_name] = $category->id;
			}
			
			Cache::instance()->set('CACHE_CATEGORY_ID_MAP', $categoryIdMap);
		}
		
		return $categoryIdMap;
	}
	
	/* public static function getCategoryMenu() {
		 $categoryMenuView = Cache::instance()->get(Constants::CACHE_CATEGORY_MENU.'_'.LANGUAGE);
		if ($categoryMenuView == NULL) {
			$categories = ORM::factory('category')->order_by('display_seq')->find_all();
			
			$view = View::factory('category_menu_'.LANGUAGE);
			$view->set('categories', $categories);
			$categoryMenuView = $view->render();
			
			Cache::instance()->set(Constants::CACHE_CATEGORY_MENU.'_'.LANGUAGE, $categoryMenuView);
		}
		
		return $categoryMenuView;
	} */
	public static function getCategoryMenu() {
		$subCategories = ORM::factory('subCategory')->with('category')->order_by('category.display_seq')->order_by('subcategory.display_seq')->find_all();
				
		$view = View::factory('category_menu_'.LANGUAGE);
		$view->set('subCategories', $subCategories);
		
		return $view->render();
	}
	
} // End Welcome
