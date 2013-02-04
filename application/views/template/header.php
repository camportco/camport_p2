<?
// Get QTY from cookie
$cartQty = Controller_Cart::getCartItemQty();

if (!isset($headerTitle)) {
	$headerTitle = 'Camport Camera Accessories Home';
}

if (!isset($metaDescription)) {
	$metaDescription = 'camport camera accessories';
}

if (!isset($metaKeywords)) {
	$metaKeywords = 'camport camera accessories';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<? echo HTML::style("media/css/style.css"); ?>
	<? echo HTML::style("media/css/base/ui.all.css"); ?>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.js"></script></head>

	<title><?=$headerTitle ?></title>
	
	<meta name="description" content="<?=$metaDescription ?>" />
	<meta name="keywords" content="<?=$metaKeywords ?>" />
</head>
<body>
	<div id="container">
		<div id="content">
			<div id="top">
				<p>
					<a href="javascript:changeLang('zh')">中</a>
					<a href="javascript:changeLang('en')">ENG</a>
				</p>
			</div>
			
			<!-- Header -->
			<div id="header">
				<div id="logo">
					<? echo HTML::anchor('/', HTML::image(IMG_ROOT.'images/logo.gif')); ?>
				</div>

				<ul id="menu">
					<li><? echo HTML::anchor('/', __('menu.home')); ?></li>
					<li><? echo HTML::anchor('/company', __('menu.contact_us')); ?></li>
					<li><a href="http://www.facebook.com/pages/Camport-Camera-Accessories/118725218184695" target="_blank"><? echo HTML::image('media/images/facebook_followfb_camport.gif', array('height'=>'32')); ?></a></li>
					<li id="searchEngine">
						<? echo Form::open("product/search_by_keyword", array('id'=>'search_engine', 'method'=>'get')); ?>
							<p><input class="searchfield ui-corner-all" name="keyword" type="text" id="keywords" value="<? echo __('tip.serach_keywords'); ?>" onfocus="document.forms['search_engine'].keywords.value='';" onblur="if (document.forms['search_engine'].keywords.value == '') document.forms['search_engine'].keywords.value='<? echo __('tip.serach_keywords'); ?>';" />
							<input class="searchbutton ui-corner-all" name="submit" type="submit" value="<? echo __('index.button.serach'); ?>" /></p>
						<? echo Form::close(); ?>
					</li>
					<li id=""></li>
					<li id="rightAlign"><span id="header_qty"><?=$cartQty ?></span> <? echo __('index.label.qty'); ?> <? echo HTML::anchor('cart/view_cart', HTML::image('media/images/shopping_cart.png'), array('title'=>__('tip.shopping_cart'))) ?></li>
				</ul>
			</div>
			
<script type="text/javascript">
	var jq = jQuery.noConflict();
	function changeLang(lang) {
		jq.ajax({
			url: "<?=URL::base().'main/change_language'?>",
			data: {lang: lang},
			type: 'POST',
			success: function(data) {
				//document.location.reload(true);
				document.location = '<?='http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>'
			}
		});
	}
</script>