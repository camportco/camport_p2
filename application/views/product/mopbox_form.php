<? for ($j = 1; $j <= $product->photo_cnt; $j++) { ?>
<div class="mb">
    <table width="980">
    <tr>
        <td width="600">
            <a href="<?=PRODUCT_IMAGE_PATH.$product->product_id.'_l_'.$j.".jpg"?>" target="_blank">
            <img height="350" id="mbimg_<?=$j?>" class="mbimg" src="<?=PRODUCT_IMAGE_PATH.$product->product_id.'_l_'.$j.".jpg"?>"/>
            </a>
        </td>
        <? if ($j == 1) {?>
        <td>
            <table>
            	<tr><td colspan="2" align="left"><? echo HTML::image('media/images/prod_info.gif', array('width'=>250, 'height'=>25)); ?></td></tr>
                <tr><th width="100"><? echo __('product.serach.label.id'); ?>:</th><td><?=$product->product_id ?></td></tr>
                <tr><th><? echo __('product.serach.label.name'); ?>:</th><td><?=$product->getName() ?></td></tr>
                <tr><th><? echo __('product.serach.label.company'); ?>:</th><td><?=$product->company->company_name ?></td></tr>
                <tr><th><? echo __('product.serach.label.description'); ?>:</th><td><?=$product->getDesc() ?></td></tr>
                <tr><th><? echo __('product.serach.label.remark'); ?>:</th><td><?=$product->getRemark() ?></td></tr>
            </table>
        </td>
        <? }?>
    </tr>
    </table>
</div>
<? }?>
