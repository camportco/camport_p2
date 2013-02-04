<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Newslink extends ORM {
	public $_table_name = 'newslink';
	
	public function getContent() {
		if (LANGUAGE == Constants::LANG_EN) {
			return !GlobalFunction::isEmpty($this->content) ? $this->content : $this->content_tc;
		}
		else {
			return !GlobalFunction::isEmpty($this->content_tc) ? $this->content_tc : $this->content;
		}
	}
}