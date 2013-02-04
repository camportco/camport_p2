<?php $view = View::factory('template/header');
if (isset($headerTitle)) {
	$view->set('headerTitle', $headerTitle);
}

if (isset($metaDescription)) {
	$view->set('metaDescription', $metaDescription);
}

if (isset($metaKeywords)) {
	$view->set('metaKeywords', $metaKeywords);
}

echo $view;
?>

<div id="main">
	<div id="col1">
		<? echo Controller_Main::getCategoryMenu(); ?>
	</div>
	
	<div id="cat_list">
		<? echo $content; ?>
	</div>
</div>

<script type="text/javascript">
	jq(function() {
		jq("#accordion").accordion('activate', <?=isset($cid) ? $cid : 0 ?>);
	});
</script>

<?php echo View::factory('template/footer') ?>
