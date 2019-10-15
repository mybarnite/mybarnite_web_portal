<?php
include_once("../includes/main.inc.php");
?>
<table width="700" align="center" cellpadding="0" cellspacing="0" bgcolor="#fbf6e6">
  <tr>
    <td width="3" align="left" valign="top"><img src="<?=SITE_WS_PATH?>/images/box-tl.jpg" alt="" /></td>
    <td></td>
    <td width="3" align="right" valign="top"><img src="<?=SITE_WS_PATH?>/images/box-tr.jpg" alt="" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" cellpadding="3" cellspacing="0" style="font:11px Arial, Helvetica, sans-serif;">
      <tr>
        <td width="59%" align="left"><strong>Address : </strong><?=site_address()?></td>
        <td width="41%" align="right"><img src="<?=SITE_WS_PATH?>/images/logo1.jpg" alt="" /></td>
      </tr>
    </table>
      <table width="100%" cellspacing="0" cellpadding="3" style="font:11px Arial, Helvetica, sans-serif;">
        <tr>
          <td height="25" colspan="2" align="left" bgcolor="#ede2be" style="font:bold 12px Arial, Helvetica, sans-serif;">Confirm Your Details</td>
        </tr>
        <tr>
          <td align="left" valign="top" style="padding:5px 0 0 10px;"><strong>Billing Address </strong><br />
           <?=order_billing_address($_REQUEST[order_id]);?>
          </td>
          <td align="left" valign="top" style="padding:5px 0 0 0;"><strong>Shipping Address </strong><br />
          <?=order_shipping_address($_REQUEST[order_id]);?>
          </td>
        </tr>
      </table>
      <br />
      <table width="100%" cellpadding="3" cellspacing="0" bgcolor="#EDE2BE" style="font:11px Arial, Helvetica, sans-serif;">
        <tr>
          <td width="50%" height="25" align="left"><strong>Invoice Date :</strong><?=date_format1(order_date($order_id));?></td>
          <td width="50%" align="left"><strong>Invoice no :</strong> <?=$_REQUEST[order_id]?></td>
        </tr>
      </table>
      <br />
      <table width="100%" cellspacing="2" cellpadding="5" style="font:11px Arial, Helvetica, sans-serif;">
        <tr style="font:bold 12px Arial, Helvetica, sans-serif;">
          <td width="7%" bgcolor="#EDE2BE">S No.</td>
          <td width="33%" bgcolor="#EDE2BE">Product Details</td>
          <td width="15%" bgcolor="#EDE2BE">Qty.</td>
          <td width="16%" bgcolor="#EDE2BE">Unit Price</td>
          <td width="15%" bgcolor="#EDE2BE">Sub Total</td>
        </tr>
        <?
        $result=db_query("select * from tbl_order_detail where order_id='$_REQUEST[order_id]'");
       
        $cnt=0;
        while($line_raw=mysql_fetch_array($result)){
	        $cnt++;
	        ($cnt%2==0)?$bgcolor='#fffefc':$bgcolor='';
	        $prodDtl=mysql_fetch_array(db_query("select product_code,product_name from tbl_product where product_id='$line_raw[product_id]'"));
	        $total=$line_raw[product_price]*$line_raw[product_qty];
	        $sub_total+=$total;
        ?>
        <tr>
          <td valign="top" <?=$bgcolor;?>><?=$cnt?>.</td>
          <td valign="top"><strong><?=$prodDtl[product_name]?> (code <?=$prodDtl[product_code]?>)
            </strong>
            <div  style="padding:3px 0;">Color : <?=color_name($line_raw[product_color_id])?> <img src="images/shim.gif" alt="<?=color_name($line_raw[product_color_id])?>" width="20" height="10" class="colorThumb" style="background-color:<?=color_code($line_raw[product_color_id])?>;" /></div>
            <div >Dimension : <?=$line_raw[product_size_dimension]?></div></td>
          <td valign="top"><?=$line_raw[product_qty]?></td>
          <td valign="top"><?=CURRANCY_SYMBOL.$line_raw[product_price]?></td>
          <td valign="top"><?=CURRANCY_SYMBOL.$total?></td>
        </tr>
    <?
   	}
   	?>
        
      </table>
      <table width="100%" cellpadding="4" cellspacing="0"  style="font:bold 11px Arial, Helvetica, sans-serif;">
        <tr>
          <td align="right">Subtotal : <?=CURRANCY_SYMBOL.$sub_total?></td>
        </tr>
        <?
        $orderval=mysql_fetch_array(db_query("select shipping_charges,order_value from tbl_order where order_id='$_REQUEST[order_id]'"));
        ?>
        <tr>
          <td align="right">Shipping Charges : <?=CURRANCY_SYMBOL.$orderval[shipping_charges]?></td>
        </tr>
        <tr>
          <td align="right">Total : <?=CURRANCY_SYMBOL.$orderval[order_value]?></td>
        </tr>
      </table>
      </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="bottom"><img src="<?=SITE_WS_PATH?>/images/box-bl.jpg" alt="" /></td>
    <td></td>
    <td align="right" valign="bottom"><img src="<?=SITE_WS_PATH?>/images/box-br.jpg" alt="" /></td>
  </tr>
</table>
