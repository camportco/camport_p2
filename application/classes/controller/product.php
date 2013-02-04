<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Product extends Controller_Template {
	
	public $template = 'template/column1';
	
	public function action_mopbox_form() {
		$product_id = $this->request->param('id');
		$product = ORM::factory('product')->where('product_id', '=', $product_id)->find();
		
		$view = View::factory('product/mopbox_form');
		$view->set('product', $product);
		
		$this->auto_render = false; // Don't render template
		$this->response->body($view);
		
		/* $this->template = View::factory('template/blank');
		$this->template->set('content', $view); */
	}
	
	/**
	 * Serach product by product ID
	 */
	public function action_search() {
		$productIds = explode('/', $this->request->param('id'));
		
		$products = ORM::factory('product')->where('product_id', 'in', $productIds)->find_all();
		
		$view = View::factory('product/search');
		$view->set('products', $products);
		$this->template->set('content', $view);
	}
	
	public function action_search_by_keyword() {
		$keyword = trim($_GET['keyword']);
		
		$keywords = explode(' ', $keyword);
		
		if (isset($_GET['zpage'])) {
			$zpage = $_GET['zpage'];
		}
		else {
			$zpage = 1;
		}
		
		// SQL
		if (isset($_GET['num_rows'])) {
			$num_rows = $_GET['num_rows'];
		}
		else {
			$query = $this->getSerachByKeywordQuery($keywords);
			
			$num_rows = $query->count_all();
		}
		
		$query = $this->getSerachByKeywordQuery($keywords);
		
		$products = $query
					->order_by('display_seq')
					->order_by('product_id')
					->limit(RECORD_PER_PAGE)
					->offset(RECORD_PER_PAGE*($zpage-1))
					->find_all();
		
		$pages = new Pagination();
		$pages->currPage = $zpage;
		$pages->itemCount = $num_rows;
		$pages->pageSize = RECORD_PER_PAGE;
		$pages->url = '/product/search_by_keyword?keyword='.urlencode($_GET['keyword']);
		
		$pager = new SimplePager();
		$pager->pages = $pages;
		
		$view = View::factory('sub_category/product_list');
		$view->set('pager', $pager->generate());
		$view->set('products', $products);
		
		$this->template = View::factory('template/column2');
		$this->template->set('content', $view);
	}
	
	private function getSerachByKeywordQuery($keywords) {
		/* $query = ORM::factory('product')
			->where('product.sts', '=', 'A')
			->where_open()
			->or_where('product_id', 'like', '%'.$keyword.'%')
			->or_where('remark', 'like', '%'.$keyword.'%')
			->or_where('remark_tc', 'like', '%'.$keyword.'%')
			->or_where('name', 'like', '%'.$keyword.'%')
			->or_where('name_tc', 'like', '%'.$keyword.'%')
			->or_where('desc', 'like', '%'.$keyword.'%')
			->or_where('desc_tc', 'like', '%'.$keyword.'%')
			->where_close(); */
		
		$query = ORM::factory('product')
			->where('product.sts', '=', 'A');
		
		foreach($keywords as $keyword) {
			$query->and_where_open()
				->or_where('product_id', 'like', '%'.$keyword.'%')
				->or_where('remark', 'like', '%'.$keyword.'%')
				->or_where('remark_tc', 'like', '%'.$keyword.'%')
				->or_where('name', 'like', '%'.$keyword.'%')
				->or_where('name_tc', 'like', '%'.$keyword.'%')
				->or_where('desc', 'like', '%'.$keyword.'%')
				->or_where('desc_tc', 'like', '%'.$keyword.'%')
				->and_where_close();
		}
		
		return $query;
	
	}
}