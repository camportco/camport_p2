<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Error extends Controller {

	public $template = 'template/column1';

	public function before()
	{
		parent::before();

		/* $this->template->page = URL::site(rawurldecode(Request::initial()->uri()));

		// Internal request only!
		if ( ! Request::current()->is_initial())
		{
			if ($message = rawurldecode($this->request->param('message')))
			{
				$this->template->message = $message;
			}
		}
		else
		{
			$this->request->action(404);
		} */
		
		$this->response->status((int) $this->request->action());
	}


	public function action_404()
	{
		$view = View::factory('error/404');
		$view->set('errorCode', 404);
		$view->set('description', 'Page not found');
		$this->response->body($view->render());
	}

	public function action_503()
	{
		$view = View::factory('error/common');
		$view->set('errorCode', 503);
		$view->set('description', 'Maintenance Mode');
		$this->response->body($view->render());
	}

	public function action_500()
	{
		$view = View::factory('error/common');
		$view->set('errorCode', 500);
		$view->set('description', 'Internal Server Error');
		$this->response->body($view->render());
	}
}