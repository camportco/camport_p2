<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Company extends Controller_Template {
	public $template = 'template/column1';
	
	public function action_index() {
		$view = View::factory('company/index');
		$this->template->set('content', $view);
	}
}