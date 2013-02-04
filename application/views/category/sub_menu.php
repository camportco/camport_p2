<? echo HTML::style("media/css/index_style.css"); ?>
<? echo HTML::style("media/css/mopBox/mopBox-2.5.css"); ?>
<? echo HTML::style("media/css/ajaxpagination.css"); ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js"></script>
<? echo HTML::script("media/js/mopBox/jquery.pngFix.js"); ?>
<? echo HTML::script("media/js/mopBox/mopBox-2.5.js"); ?>
<? echo HTML::script('media/js/ajaxpagination.js'); ?>

<div>
    <div id="paginate-top-<?=$cat_id?>"> </div>
    <div id="bookcontent-<?=$cat_id?>"> </div>
    <div id="paginate-bottom-<?=$cat_id?>" class="pagination" > </div>
</div>

<!-- For mopbox -->
<div class="hidden">
	<input type="button" id="mopbox"/>
	<div id="prod_detail">
	</div>
</div>

<script type="text/javascript">
	var jq = jQuery.noConflict();
	
	jq(document).ready(function(){
		jq("#mopbox").mopBox({'target':'#prod_detail','w':1000,'h':400});
	});
	
	var bookOnProducts={
	pages: [<? 
			$per_page = 15;
			if ($num_rows <= $per_page) { 
				$num_pages = 1; 
			} else if (($num_rows % $per_page) == 0) { 
				$num_pages = ($num_rows / $per_page);
			} else { 
				$num_pages = ($num_rows / $per_page) + 1; 
			} 
			$num_pages = (int) $num_pages; 
						
			for ($i = 1; $i < $num_pages; $i++) {
				echo "\"../category/show_product?zpage=$i&cat_id=$cat_id\",";
			}
			echo "\"../category/show_product?zpage=$i&cat_id=$cat_id\"";
		?>
	],
	selectedpage: 0 //set page shown by default (0=1st page)
	}
	
	var mybookinstance = new ajaxpageclass.createBook(bookOnProducts, "bookcontent-<?=$cat_id?>", ["paginate-top-<?=$cat_id?>", "paginate-bottom-<?=$cat_id?>"]);
	
	function prod_click(product_id){
		jq("#prod_detail").load("<?=URL::base()?>product/mopbox_form/" + product_id,
			function(){
				jq("#mopbox").click();
			}
		);
	};
</script>
