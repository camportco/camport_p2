<div id="tabs">
	<ul>
    	<? 
    	if (LANGUAGE == 'en') {
    	foreach($categories as $category) {?>
			<li><a href="sub_menu?cat_id=<?=$category->id ?>"><?=$category->cat_name?></a></li>
        <? } 
    	} else { 
    		foreach($categories as $category) {?>
    		<li><a href="sub_menu?cat_id=<?=$category->id ?>"><?=$category->cat_name_tc?></a></li>
    	<? }
    	}?>
	</ul>
</div>

<script type="text/javascript">
	jq(function() {
		jq("#tabs").tabs(
			{
			 selected: <?=$cid?>
			}
		);
	});
</script>