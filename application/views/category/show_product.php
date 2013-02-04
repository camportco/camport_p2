<div id="prod">
<?	$i = 0;
	foreach($products as $product) {
?>
    <a id="<?='a_prod_'.$divId.'_'.$i ?>" href="#p"><img src="<?=PRODUCT_IMAGE_PATH.$product->product_id ?>_s.jpg" width="220" height="130" class="graphic" onclick="prod_click('<?=$product->product_id ?>')"/></a>
<? $i++; } ?>
</div>
