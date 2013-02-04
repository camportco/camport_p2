<? echo HTML::style("media/css/tablestyle.css"); ?>

<div id="cat_list">	 
	<div id="checkout_content">
		<div id="checkout_heading"><? echo GlobalFunction::imageHTML('order_payment.png'); ?></div>
		<br>
		
		<div id="checkout_step1" width="100%">
			<div id="checkout_thankyou"><? echo __('confirm.text.message1'); ?></div>
			<table  id="hor-zebra" >
			<tbody>
				<tr class="odd"><td width="25%"><label><? echo __('confirm.label.order_number'); ?></label></td><td><?=$invoice->order_number ?></td></tr>
				<tr><td><label><? echo __('confirm.label.email'); ?></label></td><td><?=$invoice->email ?></td></tr>
				<tr class="odd"><td><label><? echo __('confirm.label.payment_due_date'); ?></label></td><td><?=$invoice->getPaymentDueDate() ?></td></tr>
			<tbody/>
			</table>
		</div> 
		
		<div id="checkout_remark" style="text-align:left"><? echo __('confirm.text.note', array(':due_date'=>$invoice->getPaymentDueDate())); ?></div>
		
		<? if ($invoice->payment_method != 'PP') {?>
			<div id="checkout_step2">
				<div id="checkout_heading"> </div>
				<table  id="hor-zebra">
				<tbody>
					<tr class="odd"><td width="25%"><label><? echo __('confirm.label.account_name'); ?></label></td><td><?=Config::ACCOUNT_NAME ?></td></tr>
					<tr><td><label><? echo __('confirm.label.account_number'); ?></label></td><td><?=Config::ACCOUNT_NUMBER ?></td></tr>
					<tr class="odd"><td><label><? echo __('confirm.label.bank_name'); ?></label></td><td><?=Config::BANK_NAME ?></td></tr>
					<tr><td><label><? echo __('confirm.label.bank_address')?></label></td><td><?=Config::BANK_ADDRESS ?></td></tr>
					<tr class="odd"><td><label><? echo __('confirm.label.swift_code'); ?></label></td><td><?=Config::SWIFT_CODE ?></td></tr>
				<tbody/>
				</table>
			</div>
			
			<div id="checkout_important"><? echo __('confirm.text.important_note'); ?></div>
		<? } ?>
		
		<div id="checkout_step2">
			<div id="checkout_heading"> </div>
			<table  id="hor-zebra">
			<tbody>
				<tr class="odd"><td width="25%"><label><? echo __('confirm.label.total_amount'); ?></label></td><td >$<?=GlobalFunction::formatMoney($invoice->total_product_price) ?></td></tr>
				<tr><td><label><? echo __('confirm.label.shipping_charge'); ?></label></td><td>$<?=GlobalFunction::formatMoney($invoice->delivery_cost) ?></td></tr>
				<? if ($invoice->payment_method == 'PP') {?>
					<tr class="odd"><td><label><? echo __('confirm.label.paypal_charge'); ?></label></td><td>$<?=GlobalFunction::formatMoney($invoice->getPayPalCharge()) ?></td></tr>
					<tr><td><label><? echo __('confirm.label.total_payment'); ?></label></td><td>$<?=GlobalFunction::formatMoney($invoice->invoice_total) ?></td></tr>
				<? } else { ?>
					<tr class="odd"><td><label><? echo __('confirm.label.total_payment'); ?></label></td><td>$<?=GlobalFunction::formatMoney($invoice->invoice_total) ?></td></tr>
				<? } ?>
			<tbody/>
			</table>
			
			<? if ($invoice->payment_method != 'PP') {?>
				<div id="checkout_paypal"><? echo __('confirm.text.message2'); ?></div>
			<? } ?>
			
			<? if ($invoice->payment_method == 'PP') {?>
				<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
					<input type="hidden" name="cmd" value="_xclick" />
					<input type="hidden" name="business" value="<?=Config::PAYPAL_ACCOUNT ?>" />
					<input type="hidden" name="currency_code" value="HKD" />
					<input type="hidden" name="item_name" value="CamPort Product" />
					<input type="hidden" name="item_number" value="<?=$invoice->order_number ?>" />
					<input type="hidden" name="amount" value="<?=$invoice->invoice_total ?>" />
					
					<div style="text-align:center">
						<input type="submit" value="<? echo __('confirm.button.paid_by_paypal'); ?>" />
					</div>
				</form>
			<? }?>
			<br>
		</div>
	</div>
</div>

