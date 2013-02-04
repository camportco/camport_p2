<? echo HTML::style("media/css/tablestyle.css"); ?>

<?
$countryOptions = Model_Country::getCountryAreaOption();

if ($form->country_area == NULL) {
	foreach ($countryOptions as $key=>$option) {
		$countryArea = $key;
		break;
	}
}
else {
	$countryArea = $form->country_area;
}

$str = explode(',', $countryArea);
if ($str[1] == 'LOCAL') {
	$isLocal = true;
}
else {
	$isLocal = false;
}
?>

<div id="checkout_content">
	<div id="checkout_heading"><? echo GlobalFunction::imageHTML('checkout.png'); ?></div>
	<table id="rounded-corner">
	<thead>
		<tr>
			<th scope="col" class="rounded-company"><? echo __('shopping_cart.label.product_id'); ?></th>
			<th scope="col"><? echo __('shopping_cart.label.name'); ?></th>
			<th scope="col"><? echo __('shopping_cart.label.price'); ?></th>
			<th scope="col"><? echo __('shopping_cart.label.qty'); ?></th>
			<th scope="col" class="rounded-q4"><? echo __('shopping_cart.label.total'); ?></th>
		</tr>
	<thead/>
	<tbody>
		<? foreach ($cartItems as $idx=>$cartItem) {?>
			<tr>
				<td>
					<? echo HTML::anchor("/subcategory/product_detail/".$cartItem->product_id, HTML::image(PRODUCT_IMAGE_PATH.$cartItem->product_id.'_s.jpg').'<br>'.$cartItem->getFullProductName()); ?>
				</td>
				<td><?=$cartItem->name ?></td>
				<td>$<?=GlobalFunction::formatMoney($cartItem->price) ?></td>
				<td><?=$cartItem->qty ?></td>
				<td>$<?=GlobalFunction::formatMoney($cartItem->total) ?></td>
			</tr>
		<? }?>
		
		<tr>
			<td></td>
			<td><? echo __('shopping_cart.label.total_items', array(':pcs'=>$totalQty))?></td>
			<td colspan="3" align="right"><? echo __('shopping_cart.label.total_amount'); ?> $<?=GlobalFunction::formatMoney($form->total_product_price) ?></td>
		</tr>
		
		<tr>
		<td align="left"><? echo HTML::anchor('/cart/view_cart', Form::button('back_to_cart', __('checkout.button.back_to_cart'))); ?></td>
		<td colspan="4">
		</tr>
		<tbody/>
	</table>
</div> 

<? echo Form::open("cart/confirm", array('id'=>'form1')); ?>
	<? echo Form::hidden('session_id', $form->session_id); ?>
	<div id="checkout_step1">
		<div id="checkout_heading"><? echo __('checkout.title.fill_form'); ?></div>
		
		<? if(isset($errors)) { ?>
			<div class="errorMsg">
			<? foreach($errors as $error) {?>
					<div><?php echo $error; ?></div>	
			<? } ?>
			</div>
		<? }?>
					
		<table id="hor-minimalist-a">
		<thead>
			<tr><th scope="col" class="rounded-company"><? echo __('checkout.title.delivery_information'); ?></th><th></th></tr>
		<thead/>
		<tbody>
			<tr><td width="25%"><label><? echo __('checkout.label.name'); ?><font color="red">*</font></label></td><td><? echo Form::input('customer_name', $form->customer_name); ?></td></tr>
			<tr><td><label><? echo __('checkout.label.email'); ?><font color="red">*</font></label></td><td><? echo Form::input('email', $form->email); ?></td></tr>
			<tr><td><label><? echo __('checkout.label.tel'); ?><font color="red">*</font></label></td><td><? echo Form::input('tel', $form->tel); ?></td></tr>
			<tr>
				<td><label><? echo __('checkout.label.pickup_method'); ?><font color="red">*</font></label></td>
				<td>
					<? echo Form::radio('pick_up_method', 'SH', $form->pick_up_method == 'SH'); echo __('checkout.option.shipping'); ?>
					<? echo Form::radio('pick_up_method', 'SE', $form->pick_up_method == 'SE'); echo __('checkout.option.self_pickup'); ?>
				</td>
			</tr>
		<tbody/>
		</table>
		
		<div id="address" class="desc" <? if ( $form->pick_up_method != 'SH') { ?>style="display: none; " <? } ?>>
		 	<table id="hor-minimalist-a">
		 		<tr><td width="25%"><label><? echo __('checkout.label.address'); ?><font color="red">*</font></label> </td><td><? echo Form::textarea('address', $form->address, array('rows'=>5)); ?></td></tr>
				<tr>
					<td><label><? echo __('checkout.label.country'); ?><font color="red">*</font></label></td>
					<td><? echo Form::select('country_area', $countryOptions, $form->country_area); ?></td>
				</tr>
			</table>
		</div>

		<div id="delivery_method" class="desc" <? if ( $form->pick_up_method != 'SH') { ?>style="display: none;" <? } ?>>
			<table id="hor-minimalist-a">
				<tr>
					<td width="25%"><? echo __('checkout.label.delivery_method'); ?><font color="red">*</font></td>
					<? if ($isLocal) {?>
						<td><? echo Form::select('delivery_method', array('L'=>__('checkout.option.surface')), $form->delivery_method); ?></td>
					<? } else {?>
						<td><? echo Form::select('delivery_method', array('A'=>__('checkout.option.air'), 'E'=>__('checkout.option.ems')), $form->delivery_method); ?></td>
					<? } ?>
				</tr>
			</table>
		</div>
	</div>
	
	<div id="checkout_step2">
		<div id="checkout_heading"> </div>
	 	<table  id="hor-minimalist-a">
		<thead>
			<tr><th scope="col" class="rounded-company"><? echo __('checkout.title.others'); ?></th><th></th></tr>
		<thead/>
		<tbody>
			<tr>
				<td width="25%"><label><? echo __('checkout.label.payment_method'); ?><font color="red">*</font></label></td>
				<td>
					<? 
					if (strpos($form->country_area, 'HK') !== FALSE || $form->pick_up_method == 'SE') {
						echo Form::select('payment_method', array('TT'=>__('checkout.label.bank_transfer'), 'PP'=>'PayPal'), $form->payment_method);
					} else {
						echo Form::select('payment_method', array('PP'=>'PayPal'), $form->payment_method);
					}
					?>
					<span id="pp_remark_1" <? if ($form->payment_method != 'PP') {?>style="display:none"<? } ?> ><? echo __('confirm.text.remarks'); ?></span>
				</td>
			</tr>
		  	<tr><td><label><? echo __('checkout.label.remarks'); ?></label></td><td><? echo Form::textarea('remark', $form->remark, array('rows'=>'3')); ?></td></tr>
		    <tr><td><label><? echo __('checkout.label.shipping_charge'); ?></label></td><td>$<span id="delivery_cost"><?=$form->delivery_cost !== 'N/A' ? GlobalFunction::formatMoney($form->delivery_cost) : 'N/A' ?></span> (<?=$form->total_weight ?>kg)</td></tr>
		    <tr id="tr_paypal_charge" <? if ($form->payment_method != 'PP') {?>style="display:none"<? } ?>>
		    	<td><label><? echo __('checkout.label.paypal_charge'); ?></label></td>
		    	<td>
		    		$<span id="paypal_charge"><?=$form->paypal_charge !== 'N/A' ? GlobalFunction::formatMoney($form->paypal_charge) : 'N/A' ?></span>
		    	</td>
		    </tr>
			<tr>
				<td><label><? echo __('checkout.label.total_payment'); ?></label></td>
				<td>
					$<span id="total_amount"><?=$form->invoice_total !== 'N/A' ? GlobalFunction::formatMoney($form->invoice_total) : 'N/A' ?></span>
				</td>
			</tr>
			<tr><td></td><td align="right"><input type="submit" value="<? echo __('checkout.button.submit'); ?>" /><input type="button" value="<? echo __('checkout.button.reset'); ?>" onclick="this.form.reset()" /></td></tr>
		<tbody/>
		</table>
	</div>
<? echo Form::close(); ?>

<div id="delivery_method_local" style="display:none">
	<? echo Form::select('delivery_method_select_local', array('L'=>__('checkout.option.surface')), NULL, array('id'=>'delivery_method_select_local')); ?>
</div>

<div id="delivery_method_oversea" style="display:none">
	<? echo Form::select('delivery_method_select_oversea', array('A'=>__('checkout.option.air'), 'E'=>__('checkout.option.ems')), NULL, array('id'=>'delivery_method_select_oversea')); ?>
</div>

<div id="payment_method_hk" style="display:none">
	<? echo Form::select('payment_method_select_hk', array('TT'=>__('checkout.label.bank_transfer'), 'PP'=>'PayPal'), NULL, array('id'=>'payment_method_select_hk')); ?>
</div>

<div id="payment_method_oversea" style="display:none">
	<? echo Form::select('payment_method_select_oversea', array('PP'=>'PayPal'), NULL, array('id'=>'payment_method_select_oversea')); ?>
</div>

<? 
if (isset($action) && $action == 'reconfirm') {
	echo Form::open("cart/confirm", array('id'=>'resubmit_form'));
	
	foreach ($_POST as $key=>$value) {
		echo Form::hidden($key, $value);
	}
	
	echo Form::hidden('action', 'reconfirm');
?>
	
<?
	echo Form::close(); 
}?>

<script type="text/javascript">
	jq(function() {
		<? if(isset($errors)) {
			foreach($errors as $error_key=>$error) {?>
				jq("input:text[name='<?=$error_key ?>']").addClass('error_input');
				jq("textarea[name='<?=$error_key ?>']").addClass('error_input');
			<? }
		}?>
		
		jq("input:radio[name='pick_up_method']").change(function() {
			changePickUpMethod();
		});

		jq("select[name='country_area']").change(function() {
			changeCountry();
			updatePrice();
		});

		jq("select[name='delivery_method']").change(function() {
			updatePrice();
		});

		jq("select[name='payment_method']").change(function() {
			changePaymentMethod(this);
		});
	});

	function changePickUpMethod() {
		if (jq("input:radio[name='pick_up_method']:checked").val() == 'SH') {
			// Shipping
			jq('#address').show();
			jq('#delivery_method').show();

			updatePrice();

			changeCountry();
		}
		else {
			// Self-pick
			jq('#address').hide();
			jq('#delivery_method').hide();

			jq('#delivery_cost').html('0');
			jq('#total_amount').html('<?=$form->total_product_price ?>');

			jq('select[name="payment_method"]').html(jq('#payment_method_select_hk').html());
			changePaymentMethod(jq('select[name="payment_method"]'));
		}
	}

	function changeCountry() {
		var countryArea = jq("select[name='country_area'] option:selected").val().split(",");
		var country = countryArea[0]; 
		var area = countryArea[1];
		
		if (area == 'LOCAL') {
			// Local
			jq('select[name="delivery_method"]').html(jq('#delivery_method_select_local').html());
		}
		else {
			// Oversea
			jq('select[name="delivery_method"]').html(jq('#delivery_method_select_oversea').html());
		}

		if (country == 'HK') {
			jq('select[name="payment_method"]').html(jq('#payment_method_select_hk').html());
		}
		else {
			jq('select[name="payment_method"]').html(jq('#payment_method_select_oversea').html());
		}
		changePaymentMethod(jq('select[name="payment_method"]'));
	}
	
	function changePaymentMethod(elem) {
		if (jq(elem).val() == 'PP') {
			jq('#pp_remark_1').show();
			jq('#tr_paypal_charge').show();
		}
		else {
			jq('#pp_remark_1').hide();
			jq('#tr_paypal_charge').hide();
		}

		updatePrice();
	}

	function updatePrice() {
		var countryArea = jq("select[name='country_area'] option:selected").val();
		var countryCode = countryArea.split(",")[0];
		
		jq.getJSON('<?=URL::base() ?>cart/get_price_detail', 
				{session_id: jq("input:hidden[name='session_id']").val(),
					product_total: <?=$form->total_product_price ?>,
					pick_up_method: jq("input:radio[name='pick_up_method']:checked").val(),
					payment_method: jq("select[name='payment_method'] option:selected").val(),
					country_code: countryCode, 
					delivery_method: jq("select[name='delivery_method'] option:selected").val()
				}, 
				function(data) {
					jq('#delivery_cost').html(data.shipping_fee);
					jq('#paypal_charge').html(data.paypal_charge);
					jq('#total_amount').html(data.actual_total_price);
				}
		);
	}

	<? if (isset($action) && $action == 'reconfirm') { ?>
	function changeLang(lang) {
		jq.ajax({
			url: "<?=URL::base().'main/change_language'?>",
			data: {lang: lang},
			type: 'POST',
			success: function(data) {
				jq('#resubmit_form').submit();
			}
		});
	}
	<? } ?>

</script>
