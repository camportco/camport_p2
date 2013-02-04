<? echo HTML::style("media/css/index_style.css"); ?>
<? echo HTML::style("media/css/mopBox/mopBox-2.5.css"); ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js"></script>
<? echo HTML::script("media/js/mopBox/jquery.pngFix.js"); ?>
<? echo HTML::script("media/js/mopBox/mopBox-2.5.js"); ?>

<style type="text/css">

.searchRslt {
	width: 700px;
	text-align: left;
	padding: 10px;
}

.img_s { margin-left: auto; margin-right: auto; display:block; border: 3px solid #eee; padding: 1px; max-width:220px; max-height:130px; }
.searchRslt td, .searchRslt th {vertical-align:top; text-align: left }
.loading td {vertical-align: middle; text-align: center}
</style>

<div class='searchRslt'>
<table cellspacing="20">
<? 
$i = 0;

foreach($products as $product) {
?>
<tr>
    <td width="220">
        <a id="<?='a_prod_'.$i ?>" href="#p">
        <img class="img_s" src="<?=PRODUCT_IMAGE_PATH.$product->product_id.'_s.jpg' ?>" onclick="prod_click('<?=$product->product_id ?>')"/>
        </a>
    </td>
    <td>
        <table>
            <tr><td colspan="2" align="left"><? echo HTML::image("media/images/prod_info.gif", array("width" => "250", "height"=> "25")); ?></td></tr>
            <tr><th width="100"><? echo __('product.serach.label.id');?>:</th><td><?=$product->product_id ?></td></tr>
            <tr><th><? echo __('product.serach.label.name');?>:</th><td><?=$product->getName() ?></td></tr>
            <tr><th><? echo __('product.serach.label.company');?>:</th><td><?=$product->company->company_name ?></td></tr>
            <tr><th><? echo __('product.serach.label.description');?>:</th><td><?=$product->getDesc() ?></td></tr>
            <tr><th><? echo __('product.serach.label.remark');?>:</th><td><?=$product->getRemark() ?></td></tr>
        </table>
    </td>
</tr>
<? $i++;
}?>
</table>
<br>
</div>

<!-- For mopbox -->
<div class="hidden">
	<input type="button" id="mopbox"/>
	<div id="prod_detail">
	</div>
</div>

<script type="text/javascript">
	var jq = jQuery.noConflict();

	// TODO to be uncomment
	/*jq(document).bind("contextmenu",function(e){
	    return false;
	});*/
	
	jq(document).ready(function(){
		jq("#mopbox").mopBox({'target':'#prod_detail','w':1000,'h':400});
	});
	
	function prod_click(product_id){
		jq("#prod_detail").html('<table class=\"loading\"><tr><td width=1000 align=center><? echo HTML::image("media/images/loading.gif")?></td></tr></table>');
		jq("#mopbox").click();
		jq("#prod_detail").load("<?=URL::base() ?>product/mopbox_form/" + product_id,
			function(){
				jq("#mopbox").click();
			}
		);
	};
</script>
