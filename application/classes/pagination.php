<?php
class Pagination {
	public $currPage;
	public $itemCount;
	public $pageSize;
	public $url='';
	
	public function getPageCount() {
		return (int)(($this->itemCount + $this->pageSize - 1) / $this->pageSize);
	}
}