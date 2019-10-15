<?php include'../includes/config.php'; ?>
<?php $getOrder = mysql_query("SELECT * FROM `register` WHERE id = '".$_REQUEST['uid']."'"); $getorder_result = mysql_fetch_array($getOrder); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Report of <?php echo $getorder_result['firstname'].' '.$getorder_result['lastname']; ?></title>
<link href="../style.css" rel="stylesheet" type="text/css" />
</head>

<body style="padding:0 10px;">

<div style="padding:10px 0;">  
  <div style="border:#e1e0e0 1px solid; background-color:#f8f8f8; padding:5px 12px 0 12px;">
	<div style="text-align:center; font-size:20px; color:#333; padding-bottom:5px; font-family:'MyriadPro-Semibold';">Tax Invoice / Report</div>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%" class="texts">
        <div style="padding-bottom:6px;"><strong>Name &amp; Address</strong></div>
        <div><?php echo $getorder_result['prefix'].' '.$getorder_result['firstname'].' '.$getorder_result['lastname']; ?></div>
        <div style="font-size:13px; padding:3px 0; color:#333;"><?php echo $getorder_result['address1']; ?>, <?php echo $getorder_result['address2']; ?>, <?php $country = mysql_fetch_array(mysql_query("SELECT * FROM `country` WHERE country_id = '".$getorder_result['country']."'")); echo $country['short_name']; ?>, <?php echo $getorder_result['state']; ?>, <?php echo $getorder_result['city']; ?>, <?php echo $getorder_result['zip_code']; ?></div>
        <hr />
        <div>Seller:&nbsp;&nbsp;&nbsp;<?php echo $getorder_result['id']; ?></div>
        <div>Order Date:&nbsp;&nbsp;&nbsp;<?php echo $getorder_result['date']; ?></div>
        <div>Total Orders: <?php $checkCartVal2 = mysql_query("SELECT SUM(quantity) AS COST FROM `orders` WHERE orderid = '".$_REQUEST['order_id']."'"); $cartArrayVal2 = mysql_fetch_array($checkCartVal2); ?> <?php echo number_format($cartArrayVal2[0]); ?></div>
        <div>Payble Amount:&nbsp;&nbsp;&nbsp;<?php $checkCartVal1 = mysql_query("SELECT SUM(total_price) AS COST FROM `orders` WHERE orderid = '".$_REQUEST['order_id']."'"); $cartArrayVal1 = mysql_fetch_array($checkCartVal1); ?><strong style="font-size:20px;"><span style="font-family:'Rupee_Foradian';">`</span> <?php echo number_format($cartArrayVal1[0]); ?></strong></div>
        <div>From: <strong>20/01/2015</strong> To <strong>20/02/2016</strong></strong></div>
        </td>
        <td width="40%" align="right" valign="top" style="font-family:'MyriadPro-Regular'; font-size:14px; color:#333; line-height:20px;">Payment Method: <strong>Bank Transfer</strong><div>Customer Care: <strong>+91.9696345345</strong></div><div>Support Team: <strong>info@basicfeet.com</strong></div><hr /></td></td>
      </tr>
    </table>
  </div>
  <div style="clear:both;">&nbsp;</div>
  <div style="border:#e1e0e0 1px solid; background-color:#FFF; padding:12px 12px 12px 12px;">
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="texts">
              <tr>
                <td width="44%" align="left" valign="middle"><strong>Description</strong></td>
                <td width="6%" align="center" valign="middle"><strong>Size</strong></td>
                <td width="6%" align="center" valign="middle"><strong>Qty</strong></td>
                <td width="10%" align="center" valign="middle"><strong>Price</strong></td>
                <td width="10%" align="center" valign="middle"><strong>Shipping</strong></td>
                <td width="10%" align="center" valign="middle"><strong>Discount</strong></td>
                <td width="10%" align="center" valign="middle"><strong>Total</strong></td>
              </tr>
            </table>
    
			<div style="border-bottom:#e2ecf5 1px solid; margin:5px 0 6px 0; padding:50px; text-align:center; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#666;">Oops! We are unable to retrive any transaction with in this dates.</div>
    
    		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="texts">
              <tr>
                <td width="44%" height="24" valign="bottom"><strong>All Values are in INR Currency</strong></td>
                <td width="6%" height="24" align="center" valign="middle">&nbsp;</td>
                <td width="6%" height="24" align="center" valign="middle">&nbsp;</td>
                <td width="10%" height="24" align="center" valign="middle">&nbsp;</td>
                <td width="10%" height="24" align="center" valign="middle">&nbsp;</td>
                <td width="10%" height="24" align="right" valign="bottom"><strong>Total Price</strong>:</td>
                <td width="10%" height="24" align="center" valign="bottom" style="font-weight:bold;"><span style="font-family:'Rupee_Foradian';">`</span> <?php echo number_format($cartArrayVal1[0]); ?></strong></td>
              </tr>
            </table>
    
  </div>
  	<div style="clear:both; padding:10px 0 0 0; line-height:16px; font-size:10px;" class="texts">For more information on Returns please refer to our Return Policy which can be found at <strong>www.basicfeet.com</strong><div><strong>Declaration:</strong> The goods sold are intended for end user consumption/retail sale and not for resale.<br />Product Ordered Through: <strong>www.basicfeet.com</strong><br /><strong>This is a computer generated invoice, No signature required.</strong></div></div>
</div>

</body>
</html>