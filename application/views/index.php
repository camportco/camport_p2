<? 
echo HTML::style("media/css/index_style.css");
echo HTML::script("media/js/index_js.js");

$accessoryLink = "/subcategory/product?cid=".Controller_Subcategory::getCategoryMenuSelectedIdx($accessory->subCategory->cat_id).'&cat_id='.$accessory->subCategory->cat_id;
$insertLink = "/subcategory/product?cid=".Controller_Subcategory::getCategoryMenuSelectedIdx($insert->subCategory->cat_id).'&cat_id='.$insert->subCategory->cat_id;
$bagLink = "/subcategory/product?cid=".Controller_Subcategory::getCategoryMenuSelectedIdx($bag->subCategory->cat_id).'&cat_id='.$bag->subCategory->cat_id;
$strapLink = "/subcategory/product?cid=".Controller_Subcategory::getCategoryMenuSelectedIdx($strap->subCategory->cat_id).'&cat_id='.$strap->subCategory->cat_id;
$caseLink = "/subcategory/product?cid=".Controller_Subcategory::getCategoryMenuSelectedIdx($case->subCategory->cat_id).'&cat_id='.$case->subCategory->cat_id;
?>

<div id="col2">
	<div id="rl">
		<table width="" border="0" cellpadding="10" cellspacing="2">
			<tr>
				<td>
					<!-- Slide Show -->
					<div id="slideshow-container">
						<? foreach ($slideShows as $slideShow) {
							echo HTML::anchor($slideShow->url, HTML::image(IMG_ROOT.'slideshow/'.$slideShow->jpg));
						}?>
					</div>
				</td>
			</tr>
			
			<!-- Display Product -->
			
			<tr>
				<td><br/></td>
			</tr>
			
			<!-- Camera Accessories -->
			<tr>
				<td><? echo HTML::anchor($accessoryLink, GlobalFunction::imageHTML('accessories.png', array('width'=>250, 'height'=>25))); ?></td>
			</tr>
			<tr>
				<td>
				 	<? echo HTML::anchor($accessoryLink, '<div class="imagecenter">'.HTML::image(PRODUCT_IMAGE_PATH.$accessory->product_id.'_l_1.jpg', array('width'=>400)).'</div>');
					?>
				 </td>
 			</tr>
			
			<tr>
				<td></td>
			</tr>
			
			<tr>
				<td align="right"><? echo HTML::anchor($accessoryLink, __('index.label.detail')); ?></td>
			</tr>
			
			<!-- Camera Inserts -->
			<tr>
				<td><? echo HTML::anchor($insertLink, GlobalFunction::imageHTML('inserts.png', array('width'=>250, 'height'=>25))); ?></td>
			</tr>
			<tr>
				<td>
					<? echo HTML::anchor($insertLink, '<div class="imagecenter">'.HTML::image(PRODUCT_IMAGE_PATH.$insert->product_id.'_l_1.jpg', array('width'=>400)).'</div>'); ?>
				</td>
			</tr>

			<tr>
				<td></td>
			</tr>

			<tr>
				<td align="right"><? echo HTML::anchor($insertLink, __('index.label.detail')); ?></td>
			</tr>

			<!-- Camera Bags -->
			<tr>
				<td><? echo HTML::anchor($bagLink, GlobalFunction::imageHTML('bags.png', array('width'=>250, 'height'=>25))); ?></td>
			</tr>

			<tr>
				<td>
					<? echo HTML::anchor($bagLink, '<div class="imagecenter">'.HTML::image(PRODUCT_IMAGE_PATH.$bag->product_id.'_l_1.jpg', array('width'=>400)).'</div>'); ?>
				</td>
			</tr>
			
			<tr>
				<td></td>
			</tr>

			<tr>
				<td align="right"><? echo HTML::anchor($bagLink, __('index.label.detail')); ?></td>
			</tr>
 			
 			<!-- Camera Straps -->
 			<tr>
 				<td><? echo HTML::anchor($strapLink, GlobalFunction::imageHTML('straps.png', array('width'=>250, 'height'=>25))); ?></td>
			</tr>
 
 			<tr>
 				<td>
					<? echo HTML::anchor($strapLink, '<div class="imagecenter">'.HTML::image(PRODUCT_IMAGE_PATH.$strap->product_id.'_l_1.jpg', array('width'=>400)).'</div>'); ?>
				</td>
			</tr>
			
			<tr>
				<td align="right"><? echo HTML::anchor($strapLink, __('index.label.detail')); ?></td>
			</tr>
			
			<!-- Camera Case -->
			<tr>
 				<td><? echo HTML::anchor($caseLink, GlobalFunction::imageHTML('case.png', array('width'=>250, 'height'=>25))); ?></td>
			</tr>
 
 			<tr>
 				<td>
					<? echo HTML::anchor($caseLink, '<div class="imagecenter">'.HTML::image(PRODUCT_IMAGE_PATH.$case->product_id.'_l_1.jpg', array('width'=>400)).'</div>'); ?>
				</td>
			</tr>
			
			<tr>
				<td align="right"><? echo HTML::anchor($caseLink, __('index.label.detail')); ?></td>
			</tr>
		</table>
	</div>
</div>

<div id="col3">
	<div id="left" class="ui-corner-all">
		<h3><? echo __('title.news'); ?></h3>
		<? foreach ($newslinks as $newslink) {?>
			<div>
				<? echo HTML::anchor($newslink->url, $newslink->getContent()); ?>
			</div>
		<? }?>
	</div>
</div>

<script type="text/javascript">
	/*var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-17949120-3']);
	_gaq.push(['_trackPageview']);
	
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();*/
</script>
