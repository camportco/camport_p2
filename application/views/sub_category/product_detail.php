<div id="fb-root"></div>

<span id="message"></span>

<div id="det_list">
	<div id="det_content">
		<div id="det_item"> 
			<div id="det_prod_img"><? echo HTML::image(PRODUCT_IMAGE_PATH.$product->product_id.'_s.jpg')?></div>
			<div id="det_prod_desc" class="alignRight">
				<? echo Form::open("cart/direct_buy2", array('id'=>'form1')); ?>
					<input type="hidden" name="id" value="<?=$product->id ?>" />
					<table cellpadding="5" cellspacing="2" style="border-left:3px #006633 solid"  width="100%" height="215">
						<tr><td width="100" bgcolor="#CCCCCC"><? echo __('subcategory.product.label.pid'); ?>:</td><td bgcolor="#EFEFEF"><?=$product->product_id ?></td></tr>
						<tr><td bgcolor="#CCCCCC"><? echo __('subcategory.product.label.name'); ?>:</td><td bgcolor="#EFEFEF"><?=$product->getName() ?></td>
						<tr>
							<td bgcolor="#CCCCCC"><? echo __('subcategory.product.label.price'); ?>:</td>
							<td bgcolor="#EFEFEF"><span <?=$product->isLineThrough() ? 'class="linethrough"' : '' ?>>$<?=GlobalFunction::formatMoney($product->price) ?></span></td>
						</tr>
						<? if ($product->special_price != NULL || $product->discount != NULL) {?>
							<tr><td bgcolor="#CCCCCC"><? echo __('subcategory.product.label.special_offer'); ?>:</td><td bgcolor="#EFEFEF">$<?=GlobalFunction::formatMoney($product->getActualPrice()) ?></td></tr>
						<? }?>
						<tr><td bgcolor="#CCCCCC"><? echo __('subcategory.product.label.gross_weight'); ?>:</td><td bgcolor="#EFEFEF"><?= $product->gross_weight != NULL ? GlobalFunction::formatWeight($product->gross_weight).'kg' : '' ?></td></tr>
						<tr><td bgcolor="#CCCCCC"><? echo __('subcategory.product.label.net_weight'); ?>:</td><td bgcolor="#EFEFEF"><?= $product->net_weight != NULL ? GlobalFunction::formatWeight($product->net_weight).'kg' : '' ?></td></tr>
						<tr>
							<td bgcolor="#CCCCCC"><? echo __('subcategory.product.label.qty'); ?>:</td>
							<td bgcolor="#EFEFEF">
								<? echo Form::select("qty", array("1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5"=>"5", "6"=>"6", "7"=>"7", "8"=>"8", "9"=>"9", "10"=>"10"), 0); ?>
							</td>
						</tr>
						
						<? $colorOptions = $product->getColorOptions();
						if (sizeOf($colorOptions) > 0) {?>
							<tr>
								<td bgcolor="#CCCCCC"><? echo __('subcategory.product.label.color'); ?>:</td>
								<td bgcolor="#EFEFEF">
									<? echo Form::select("color", $colorOptions); ?>
								</td>
							</tr>
						<? }?>
						
						<tr>
							<td bgcolor="#EFEFEF" colspan="2" style="text-align:right">
								<div class="fb-like" data-href="<?=Config::FACEBOOK_URL.'subcategory/product_detail/'.$product->product_id ?>" data-send="false" data-layout="button_count" data-width="40" data-show-faces="true"></div>
								<input type="button" value="<? echo __('subcategory.product.button.buy_checkout'); ?>" onclick="javascript:checkout();"/>
								<input type="button" value="<? echo __('subcategory.product.button.add_to_cart'); ?>" onclick="javascript:addToCart(this);" />
							</td>
						</tr>
					</table>
				<? echo Form::close(); ?>
			</div>
		</div>	
		 
		<div id="det_desc">
				<label><? echo __('subcategory.product.label.description'); ?>:	</label><?=$product->getDesc() ?><br/>
				<br/><label><? echo __('subcategory.product.label.remarks'); ?>: </label><?=$product->getRemark() ?>
		</div>
		
		<div id="prod_det_img">
			<? for ($i = 1; $i <= $product->photo_cnt; $i++) {
				echo HTML::image(PRODUCT_IMAGE_PATH.$product->product_id.'_l_'.$i.'.jpg');	
			}?>
			
			<? if (!empty($product->youtube1)) {?>
				<iframe width="650" height="450" src="<?=$product->youtube1 ?>" frameborder="0" allowfullscreen></iframe>
			<? } ?>
			
			<? if (!empty($product->youtube2)) {?>
				<iframe width="650" height="450" src="<?=$product->youtube2 ?>" frameborder="0" allowfullscreen></iframe>
			<? } ?>
			
			<? if (!empty($product->youtube3)) {?>
				<iframe width="650" height="450" src="<?=$product->youtube3 ?>" frameborder="0" allowfullscreen></iframe>
			<? } ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=192950614067755";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	
	function checkout() {
		document.location = '../../cart/view_cart';
	}
	
	function addToCart(elem) {
		jq.ajax({
			type: 'POST',
			url: '<?=URL::base().'cart/add_to_cart' ?>', 
			data: jq('#form1').serialize(), 
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
