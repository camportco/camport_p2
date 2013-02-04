<?php echo View::factory('template/header') ?>

<div id="main">
	<div id="col1">
		<? echo Controller_Main::getCategoryMenu(); ?>
		<? foreach ($advertisements as $advertisement) { ?>
			<iframe width="240" height=" " src="<?=$advertisement->url ?>" frameborder="0" allowfullscreen></iframe>
		<? } ?>
	</div>
	
	<? echo $content; ?>
</div>

<?php echo View::factory('template/footer') ?>
