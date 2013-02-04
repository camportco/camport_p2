<? echo HTML::style("media/css/tablestyle.css"); ?>

	<div id="checkout_content">
		<div id="checkout_heading"><? echo GlobalFunction::imageHTML('items_on_cart.png'); ?></div>
		<? echo Form::open("cart/checkout", array('id'=>'form1')); ?>
			<br>
			<table id="rounded-corner">
			<thead>
				<tr>
					<th scope="col" class="rounded-company"><? echo __('shopping_cart.label.product_id'); ?></th>
					<th scope="col"><? echo __('shopping_cart.label.name'); ?></th>
					<th scope="col"><? echo __('shopping_cart.label.price'); ?></th>
					<th scope="col"><? echo __('shopping_cart.label.qty'); ?></th>
					<th scope="col"><? echo __('shopping_cart.label.total'); ?></th>
					<th scope="col" class="rounded-q4"><? echo __('shopping_cart.label.action'); ?></th></tr>
			<thead/>
			<tbody>
				<? foreach ($cartItems as $idx=>$cartItem) {?>
					<tr>
						<td>
							<? echo HTML::anchor("/subcategory/product_detail/".$cartItem->product_id, HTML::image(PRODUCT_IMAGE_PATH.$cartItem->product_id.'_s.jpg').'<br>'.$cartItem->getFullProductName()); ?>
							<? echo Form::hidden('record_id[]', $cartItem->recordId); ?>
						</td>
						<td><?=$cartItem->name ?></td>
						<td>$<?=GlobalFunction::formatMoney($cartItem->price) ?></td>
						<td><? echo Form::select("qty[]", array("1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5"=>"5", "6"=>"6", "7"=>"7", "8"=>"8", "9"=>"9", "10"=>"10"), $cartItem->qty); ?></td>
						<td>$<?=GlobalFunction::formatMoney($cartItem->total) ?></td>
						<td><input type="button" value="<? echo __('shopping_cart.button.delete'); ?>" onclick="deleteItem(<?=$cartItem->recordId ?>)"/></td>
					</tr>
				<? }?>
				
				<tr>
					<td></td>
					<td colspan="3"><? echo __('shopping_cart.label.total_items', array(':pcs'=>$totalQty)); ?></td>
					<td colspan="2" align="right"><? echo __('shopping_cart.label.total_amount')?>$<?=GlobalFunction::formatMoney($totalProductPrice) ?></td>
				</tr>
					
				<tr>
					<td align="left"><? echo HTML::anchor('/', '<input type="button" value="'.__('shopping_cart.button.continue').'"/>')?></td>
					<td colspan="4"></td>
					<td align="right"><? if (sizeOf($cartItems) > 0) {?><input type="button" value="<? echo __('shopping_cart.button.checkout'); ?>" onclick="checkout()"/><? } ?></td>
				</tr>
			<tbody/>
			</table>
		<? echo Form::close(); ?>
	</div> 

<? echo Form::open("cart/delete_item", array('id'=>'delete_form'));
echo Form::hidden('record_id');
echo Form::close(); ?>

<script type="text/javascript">
	function deleteItem(recordId) {
		jq('#delete_form :hidden').val(recordId);
		jq('#delete_form').submit();
	}

	function checkout() {
		jq('#form1').submit();
	}
</script>
