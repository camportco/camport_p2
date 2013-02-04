<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Product extends ORM {
	public $_table_name = 'product';
	
	protected $_belongs_to = array(
								'subCategory' => array('model' => 'subCategory', 'foreign_key' => 'sub_cat_id'),
								'company' => array('model' => 'company', 'foreign_key' => 'company_id')
							);
	
	protected $_table_columns = array(
			"id" => array("type" => "int"),
			"product_id" => array("type" => "string"),
			"company_id" => array("type" => "int"),
			"make_name" => array("type" => "string"),
			"model" => array("type" => "string"),
			"remark" => array("type" => "string"),
			"remark_tc" => array("type" => "string"),
			"name" => array("type" => "string"),
			"name_tc" => array("type" => "string"),
			"pcs" => array("type" => "int"),
			"price" => array("type" => "float"),
			"sup" => array("type" => "string"),
			"colour" => array("type" => "string"),
			"location" => array("type" => "string"),
			"model_no" => array("type" => "string"),
			"year" => array("type" => "string"),
			"cat_id" => array("type" => "int"),
			"cat_name" => array("type" => "string"),
			"sub_cat_id" => array("type" => "int"),
			"desc" => array("type" => "string"),
			"desc_tc" => array("type" => "string"),
			"stock" => array("type" => "int"),
			"material" => array("type" => "string"),
			"display_seq" => array("type" => "int"),
			"sts" => array("type" => "string"),
			"photo_cnt" => array("type" => "int"),
			"gross_weight" => array("type" => "float"),
			"net_weight" => array("type" => "float"),
			"special_price" => array("type" => "float"),
			"discount" => array("type" => "float"),
			"youtube1" => array("type" => "string"),
			"youtube2" => array("type" => "string"),
			"youtube3" => array("type" => "string"),
			"gen_news" => array("type" => "string"),
	);
	
	public function getActualPrice() {
		if ($this->special_price != NULL) {
			return $this->special_price;
		}
		else if ($this->discount != NULL) {
			$discountPrice = $this->price * 1.0 * (100 - $this->discount) / 100.0;
			$discountPrice = ceil($discountPrice * 10) / 10.0;
			return $discountPrice;
		}
		else {
			return $this->price;
		}
	}
	
	public function isLineThrough() {
		return $this->special_price != NULL || $this->discount != NULL;
	}
	
	public function getColorOptions() {
		$options = array();
		
		if (!empty($this->colour)) {
			$colors = explode(',', $this->colour);
			foreach ($colors as $color) {
				$options[$color] = $color;
			}
		}
		return $options;
	}
	
	public function getName() {
		if (LANGUAGE == Constants::LANG_EN) {
			return !GlobalFunction::isEmpty($this->name) ? $this->name : $this->name_tc;
		}
		else {
			return !GlobalFunction::isEmpty($this->name_tc) ? $this->name_tc : $this->name;
		}
	}
	
	public function getDesc() {
		if (LANGUAGE == Constants::LANG_EN) {
			$desc = !GlobalFunction::isEmpty($this->desc) ? $this->desc : $this->desc_tc;
		}
		else {
			$desc = !GlobalFunction::isEmpty($this->desc_tc) ? $this->desc_tc : $this->desc;
		}
		
		if ($desc == NULL) {
			$desc = '';
		}
		else {
			$desc = str_replace( "\r\n", "</p><p>", $desc);
			$desc = "<p>" .$desc. "</p>";
		}
		
		return $desc;
	}
	
	public function getRemark() {
		if (LANGUAGE == Constants::LANG_EN) {
			$remark = !GlobalFunction::isEmpty($this->remark) ? $this->remark : $this->remark_tc;
		}
		else {
			$remark = !GlobalFunction::isEmpty($this->remark_tc) ? $this->remark_tc : $this->remark;
		}
		
		if ($remark == NULL) {
			$remark = '';
		}
		else {
			$remark = str_replace( "\r\n", "</p><p>", $remark);
			$remark = "<p>" .$remark. "</p>";
		}
		
		return $remark;
	}
}
