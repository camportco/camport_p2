<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Category extends Controller_Template {
	
	public $template = 'template/column1';
	
	public function action_menu() {
		$categories = ORM::factory('category')->order_by('display_seq')->find_all();
		
		// Determine selected tab
		$cid = $this->request->param('id');
		if (empty($cid)) {
			$cid = 0;
		}
		
		$view = View::factory('category/menu');
		$view->set('categories', $categories);
		$view->set('cid', $cid);
		$this->template->set('content', $view);
	}
	
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
	 * List out products.
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
}
