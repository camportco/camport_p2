<div id="accordion">
	<?
	$idx = -1;
	$isFirst = true;
	$prevCatId = 0;
	foreach ($subCategories as $subCategory) {
		if ($prevCatId != $subCategory->cat_id) {
			if (!$isFirst) {
				echo '</div>';
			}
			$isFirst = false;
			$prevCatId = $subCategory->cat_id;
			$idx++;
		?>
		<h3><a href="#"><?=$subCategory->category->cat_name_tc ?></a></h3>
		
		<div>
		<? echo HTML::anchor('/subcategory/product?cid='.$idx.'&cat_id='.$subCategory->cat_id, __('index.label.all_products')).'<br>';
		}
		echo HTML::anchor('/subcategory/product?cid='.$idx.'&sub_cat_id='.$subCategory->id, $subCategory->sub_cat_name_tc).'<br>';
	}?>

	</div>
</div>

<br>
<br>
<br>

<script type="text/javascript">
	jq(function() {
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		jq( "#accordion" ).accordion({
			icons: icons
		});
		jq( "#toggle" ).button().toggle(function() {
			jq( "#accordion" ).accordion( "option", "icons", false );
		}, function() {
			jq( "#accordion" ).accordion( "option", "icons", icons );
		});
	});
</script>