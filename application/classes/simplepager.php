<?php
class SimplePager {
	public $header = '';
	public $footer = '';
	public $pages;
	
	const CSS_PAGE = 'pagination';
	const CSS_HIDDEN_PAGE='hidden'; // hidden
	const CSS_SELECTED_PAGE='currentpage'; // current
	const CSS_PREVIOUS_PAGE = '';
	const CSS_INTERNAL_PAGE = '';
	const CSS_NEXT_PAGE = '';
	const SHOW_EACH_SIDE = 3;
	
	public function generate()
	{
		$this->prevPageLabel = '<';
		$this->nextPageLabel = 'next >';
		
		//
		// here we call our createPageButtons
		//
		$buttons=$this->createPageButtons();
		//
		// if there is nothing to display return
		if(empty($buttons))
			return;
		//
		// display the buttons
		//
		$text = "<div class='".self::CSS_PAGE."'>";
		$text .= $this->header; // if any
		$text .= implode("&nbsp;",$buttons);
		$text .= $this->footer;  // if any
		$text .= "</div>";
		
		return $text;
	}
	
	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		$pageCount = $this->pages->getPageCount();
		
		if ($pageCount <= 1) {
			return array();
		}

		$currentPage = $this->pages->currPage; // currentPage is calculated in getPageRange()
		$buttons=array();

		// prev page
		if (($page = $currentPage - 1) < 1) {
			$page = 1;
		}

		$buttons[] = $this->createPageButton($this->prevPageLabel, $page, self::CSS_PREVIOUS_PAGE, $currentPage<=0, false);
		
		// internal pages
		$eitherside = (self::SHOW_EACH_SIDE + 1) / 2;
		if($currentPage >= $eitherside) {
			$start = $currentPage - $eitherside + 1;
			if ($start > $pageCount - self::SHOW_EACH_SIDE - $eitherside) {
				$start = $pageCount - self::SHOW_EACH_SIDE - $eitherside + 1;
				
				if ($start <= 0) {
					$start = 1;
				}
			}
		}
		else {
			$start = 1;
		}
		
		if($currentPage + $eitherside <= $pageCount) {
			$end = $currentPage + $eitherside;
			
			if ($end < self::SHOW_EACH_SIDE + $eitherside) {
				$end = self::SHOW_EACH_SIDE + $eitherside;
				
				if ($end > $pageCount) {
					$end = $pageCount;
				}
			}
		}
		else {
			$end = $pageCount;
		}
		
		if ($start > 1) {
			// first page
			$buttons[]=$this->createPageButton('1', 1, self::CSS_INTERNAL_PAGE, false, $currentPage==1);
		}
		
		if ($start > 2) {
			$buttons[] = " .... ";
		}
		
		for ($i = $start; $i <= $end; $i++) {
			$buttons[]=$this->createPageButton($i, $i,self::CSS_INTERNAL_PAGE,false, $i==$currentPage);
		}
		if($end != $pageCount) {
			if ($end < $pageCount - 1) {
				$buttons[] = " .... ";
			}
			
			// last page
			if ($pageCount > 1) {
				$buttons[]=$this->createPageButton($pageCount, $pageCount, self::CSS_INTERNAL_PAGE, false, $currentPage==$pageCount);
			}
		}

		// next page
		if (($page = $currentPage + 1) > $pageCount) {
			$page = $pageCount;
		}
		
		$buttons[] = $this->createPageButton($this->nextPageLabel, $page, self::CSS_NEXT_PAGE, $currentPage>=$pageCount, false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string the text label for the button
	 * @param integer the page number
	 * @param string the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean whether this page button is visible
	 * @param boolean whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		//
		// CSS_HIDDEN_PAGE and CSS_SELECTED_PAGE
		// are constants that we use to apply our styles
		//
		if($hidden || $selected)
			$class=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		$class .= ' number';

		return HTML::anchor($this->pages->url.'&zpage='.$page.'&num_rows='.$this->pages->itemCount, $label, array('class'=>$class));
	}
}

?>