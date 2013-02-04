<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Subcategory extends Controller_Template {
	
	public $template = 'template/column2';
	
// ************************************** PRODUCT menu ******************************************************

	/**
	 * For PRODUCT main menu.
	 */
	public function action_sub_menu() {
		$cat_id = $_GET['cat_id'];
		
		// Count # of products
		$num_rows = ORM::factory('product')->with('subCategory')
					->where('subCategory.cat_id', '=', $cat_id)
					->where('product.sts', '=', 'A')
					->count_all();
		
		$view = View::factory('category/sub_menu');
		$view->set('cat_id', $cat_id);
		$view->set('num_rows', $num_rows);
		
		$this->auto_render = false; // Don't render template
		$this->response->body($view);
		
		/* $this->template = View::factory('template/blank');
		$this->template->set('content', $view); */
	}
	
	/**
	 * List out products by caregory.
	 * Support paging
	 */
	public function action_show_product() {
		if (isset($_GET['cat_id'])) {
			$cat_id = $_GET['cat_id'];
		}
		else {
			$cat_id = '';
		}
	
		if (isset($_GET['zpage'])) {
			$zpage = $_GET['zpage'];
		}
		else {
			$zpage = '';
		}
	
		if (isset($_GET['divId'])) {
			$divId = $_GET['divId'];
		}
		else {
			$divId = '';
		}
	
		$products = ORM::factory('product')->with('company')->with('subCategory')
		->where('subCategory.cat_id', '=', $cat_id)
		->where('product.sts', '=', 'A')
		->order_by('company.display_seq')
		->order_by('product.display_seq')
		->order_by('product.id', 'desc')
		->limit(15)
		->offset(15*($zpage-1))
		->find_all();
	
		$view = View::factory('category/show_product');
		$view->set('zpage', $zpage);
		$view->set('cat_id', $cat_id);
		$view->set('products', $products);
		$view->set('divId', $divId);
		
		$this->auto_render = false; // Don't render template
		$this->response->body($view);
		
		/* $this->template = View::factory('template/blank');
		$this->template->set('content', $view); */
	}
// ************************************** End of PRODUCT menu ******************************************************	

	/**
	 * List out product by category / sub-category.
	 */
	public function action_product() {
	
		if (isset($_GET['cat_id'])) {
			$catId = $_GET['cat_id'];
		}
		else {
			$catId = NULL;
		}
	
		if (isset($_GET['sub_cat_id'])) {
			$subCatId = $_GET['sub_cat_id'];
		}
		else {
			$subCatId = NULL;
		}

		if (isset($_GET['cid'])) {
			$cid = $_GET['cid'];
		}
		else {
			$cid = 0;
		}
	
		if (isset($_GET['zpage'])) {
			$zpage = $_GET['zpage'];
		}
		else {
			$zpage = 1;
		}
	
		if (isset($_GET['num_rows'])) {
			$num_rows = $_GET['num_rows'];
		}
		else {
			// Count # of products
			if ($catId != NULL) {
				// All products
				$num_rows = ORM::factory('product')->with('subCategory')
				->where('subCategory.cat_id', '=', $catId)
				->where('product.sts', '=', 'A')
				->count_all();
	
			}
			else {
				$num_rows = ORM::factory('product')->with('subCategory')
				->where('sub_cat_id', '=', $subCatId)
				->where('product.sts', '=', 'A')
				->count_all();
			}
		}
	
	
		if ($catId != NULL) {
			// All prodcuts
			$products = ORM::factory('product')->with('subCategory')
			->where('subCategory.cat_id', '=', $catId)
			->where('product.sts', '=', 'A')
			->order_by('display_seq')
			->order_by('product_id')
			->limit(RECORD_PER_PAGE)
			->offset(RECORD_PER_PAGE*($zpage-1))
			->find_all();
		}
		else {
			$products = ORM::factory('product')->with('subCategory')
			->where('sub_cat_id', '=', $subCatId)
			->where('product.sts', '=', 'A')
			->order_by('display_seq')
			->order_by('product_id')
			->limit(RECORD_PER_PAGE)
			->offset(RECORD_PER_PAGE*($zpage-1))
			->find_all();
		}
	
		$pages = new Pagination();
		$pages->currPage = $zpage;
		$pages->itemCount = $num_rows;
		$pages->pageSize = RECORD_PER_PAGE;
		$pages->url = $catId != NULL ? '/subcategory/product?cat_id='.$catId : '/subcategory/product?sub_cat_id='.$subCatId;
	
		$pager = new SimplePager();
		$pager->pages = $pages;
	
		$view = View::factory('sub_category/product_list');
		$view->set('pager', $pager->generate());
		$view->set('products', $products);
		$this->template->set('content', $view);
		$this->template->set('cid', $cid); // Default selected category menu
	}
	
	public function action_product_detail() {
		$productId = $this->request->param('id');

		$product = ORM::factory('product')->with('subCategory')->where('product.product_id', '=', $productId)->find();
		
		$cid = Controller_Subcategory::getCategoryMenuSelectedIdx($product->subCategory->cat_id);
	
		$view = View::factory('sub_category/product_detail');
		$view->set('product', $product);
		$this->template->set('content', $view);
		$this->template->set('cid', $cid);
		$this->template->set('headerTitle', $product->name);
		$this->template->set('metaDescription', $product->name);
		$this->template->set('metaKeywords', $product->product_id);
	}
	
	public static function getCategoryMenuSelectedIdx($categoryId) {
		$categoryMenuIndex = Cache::instance()->get('CACHE_CATEGORY_MENU_INDEX');
		if ($categoryMenuIndex == NULL) {
			$categories = ORM::factory('category')->order_by('display_seq')->find_all();
			
			$idx = 0;
			$categoryMenuIndex = array();
			foreach ($categories as $category) {
				$categoryMenuIndex[$category->id] = $idx++;
			}
			
			Cache::instance()->set('CACHE_CATEGORY_MENU_INDEX', $categoryMenuIndex);
		}
		
		return $categoryMenuIndex[$categoryId];
	}
}
