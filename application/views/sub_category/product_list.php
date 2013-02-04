<? echo HTML::style("media/css/ajaxpagination.css"); ?>

<span id="message"></span>

<div id="cat_list">
	<div id="paging"><? echo $pager; ?></div>
	<div id="cat_content">
		<? foreach ($products as $idx=>$product) {?>
			<div class="cat_item <?=$idx%2==0 ? 'grey_bg' : ''?>"> 
				<div class="alignLeft"><? echo HTML::anchor("/subcategory/product_detail/".$product->product_id, HTML::image(PRODUCT_IMAGE_PATH.$product->product_id.'_s.jpg')); ?></div>
				
				<div class="cat_prod_desc alignRight">
					<? echo Form::open("cart/direct_buy"); ?>
						<? echo Form::hidden('id', $product->id); ?>
						<? echo __('subcategory.product.label.pid'); ?>: <?=$product->product_id ?><br />
						<? echo __('subcategory.product.label.name'); ?>: <?=$product->getName() ?><br />
						<span <?=$product->isLineThrough() ? 'class="linethrough"' : '' ?>><? echo __('subcategory.product.label.price'); ?>: $<?=GlobalFunction::formatMoney($product->price) ?> </span><br />
						<? if ($product->special_price != NULL || $product->discount != NULL) {?>
							<? echo __('subcategory.product.label.special_offer'); ?>: $<?=GlobalFunction::formatMoney($product->getActualPrice()) ?><br />
						<? }?>
						<? echo __('subcategory.product.label.qty'); ?>: <? echo Form::select("qty", array("1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5"=>"5", "6"=>"6", "7"=>"7", "8"=>"8", "9"=>"9", "10"=>"10"), 0); ?><br />
						
						<? $options = $product->getColorOptions();
						if (sizeOf($options) > 0) {?>
							<? echo __('subcategory.product.label.color'); ?>:<? echo Form::select("color", $options) ?><br />
						<? } ?>
						
						<input type="button" name="buy_and_checkout" value="<? echo __('subcategory.product.button.buy_checkout'); ?>" onclick="javascript:checkout(this);" />
						<input type="button" value="<? echo __('subcategory.product.button.add_to_cart'); ?>" onclick="javascript:addToCart(this);" />
					<? echo Form::close(); ?>
				</div>
			</div>
		<? }?>
	</div>
</div>

<script type="text/javascript">
	function checkout(elem) {
		document.location = '../cart/view_cart';
	}
	
	function addToCart(elem) {
		jq.ajax({
			type: 'POST',
			url: '<?=URL::base().'cart/add_to_cart' ?>', 
			data: jq(elem).parent().serialize(), 
			success: function(data) {
					jq('#message').html('<div class="successMsg"><? echo __('subcategory.message.add_to_cart_success'); ?></div><br>');
					jq('#header_qty').html(data); // Update QTY displayed in header
				},
			error: function(data) {
					jq('#message').html('<div class="errorMsg"><? echo __('subcategory.message.add_to_cart_fail'); ?></div><br>');
				}
		});
	}
</script>
