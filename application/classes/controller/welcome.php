<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		//i18n::lang('en');
		//$this->response->body('hello, world!');
		$this->response->body(__('hello.message'));
	}

} // End Welcome
