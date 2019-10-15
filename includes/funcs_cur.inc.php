<? /**************************************************************************************************
* Devloper Name : Pankaj Kumar  																							
* Organization  : Weblink India.net
* Email         : pankajdavim26@gmail.com
* File 			: For Common Functions **************************************************************************************************/
function validate_user(){
	if($_SESSION['sess_stud_id']==''){
		$_SESSION['pageName']=$_SERVER['REQUEST_URI'];
		$_SESSION['sess_msg'] = "You are not logged in. Kindly login first to view the same. Please <a href='login.php?back=".urlencode(str_replace("/sangrock/","",$_SERVER['REQUEST_URI']))."' class='txtSmall BlueTxt'><strong>click here</strong></a> to login.";
		header("Location:msg.php");
		exit;
	}
}
function readmyfile($path)
{
	$text='';
	$fp = @fopen($path,"r");
	while (!@feof($fp))
	{
		$buffer = @fgets($fp, 4096);
		$text.= $buffer;
	}
	@fclose($fp);
	return $text;
}

function validate_form()
{
	return ' onsubmit="return validateForm(this,0,0,0,1,8);" ';
}

function protect_admin_page() {
	$cur_page = basename($_SERVER['PHP_SELF']);
	//echo "<br>cur_page: $cur_page";
	$arr = array(0=>'sub_admin_list.php',2=>'manage-owners.php',3=>'banner_list.php',5=>'add_sub_admin.php',6=>'banner_f.php');
	if($cur_page != 'index.php') {
		if ($_SESSION['sess_admin_id']=='') {
			$_SESSION['sess_msg'] = "Please login first.";
			header('Location: index.php');
			exit;
		}else{
		    if($_SESSION['sess_admin_type']!='Super' && (in_array($cur_page,$arr))){
             set_session_msg("You have not permission to access this page.");
             header('Location: admin_welcome.php');
			 exit;			  
			}
		}
	}else{
	    if($_SESSION['sess_admin_id']!='') {
			header('Location: admin_welcome.php');
			exit;
		}
	} 
}

function yes_no_dropdown()
{
	$arr = array( "Yes" => 'Yes', 'No' => 'No');
	return array_dropdown($arr, $sel_value, $name);
}

function  getCountryDropDown($name,$sel_value,$extra,$choose_one)
{
$arr=array();
$sql="SELECT contId,contName FROM tbl_country_master ";
$rs=db_query($sql);

   if($rs)
   {
      while($line=mysql_fetch_array($rs))
	  {
	    @extract($line);
		$arr[$contId]=$contName;
			
	  }
	  $sel_value	=	($sel_value=="" or $sel_value=="0")?220:$sel_value;
	  $dropdown	=	array_dropdown($arr, $sel_value, $name, $extra,$choose_one);
   }
  
return $dropdown;
}

function  getCountryName($country_id)
{
  $country_name='';
  $row=getDBRow('tbl_country_master',"contId='".$country_id."'",'contName');
  if(is_array($row))
     {
       $country_name=$row['contName'];
     }
 return $country_name; 
}

function getStateDropDown($name,$sel_value,$extra,$country){
  $sql_s=db_query("select state_id,state from tbl_state where country_id='$country' ");
   if(mysql_num_rows($sql_s)>0){
	  $arr=array();
      while($row=mysql_fetch_array($sql_s)){
	    @extract($row);
		$arr[$state]=$state;			
	  }
	  $dropdown	=	array_dropdown($arr, $sel_value, $name, $extra,"Select State");
   }
	return $dropdown;
}


function getDBRow($table,$condition='',$field_list)
{
 if($table!='' && $field_list!='')
   {
      $sql="SELECT $field_list  FROM  $table  ";  
	  if($condition!='')
	   $sql.=" WHERE  $condition ";
	   $rs=db_query($sql);
	   if($rs)
	      {
		    $row=mysql_fetch_array($rs);
			
		  }
   }
return $row;

}

function checkAvailableRecord($table,$field1,$condition){
 if($table!="" && $field1!="" && $condition!=""){
  $sql		=	"select $field1 from $table where $condition";
  $result	=	db_scalar($sql);
 }else{
   $result	=	0;
 }
 return $result;
}

function searchSingleRecord($table,$field1,$field2,$value){

  if($table!="" && $field1!="" && $field2!="" && $value!=""){
    $sql	=	"select $field1 from $table where $field2='".$value."'";
	$result	=	db_scalar($sql);
	return $result;	
  }
}

function fetchRecArr($table,$field1,$condition){
$row_arr	=	array();
  if($table!="" && $field1!=""){
	  $query_res =	db_query("select $field1 from $table where $condition");
	  if(mysql_num_rows($query_res)==1){
		$row_arr=mysql_fetch_assoc($query_res);
	  }
  }
 return $row_arr; 
}

function get_membername($mem_id)
{
   $name='';
   if($mem_id!='' && $mem_id!=0 && $mem_id!=-1){
    $tbl		=	"tbl_user";
	$auto_id	=	"u_id";
	$f1			=	"u_fname,u_lname";
     
   $sql		=	"select $f1  from $tbl where $auto_id='$mem_id'";
   $result	=	db_query($sql);
    if($result)
    {
	   $row=mysql_fetch_array($result);
	    $name=$row[0];
	    $row[1] != '' ? $name.=" ".$row[1]:false;
     }
	}elseif($mem_id==-1) {
	  $name='Admin';
	}
 return ucwords($name);
}

function get_user($u_id,$type){
  if($u_id!="" && $u_id!=0){
	if($type!="Admin"){
	  return get_membername($u_id);
	}else{
	  return get_adminname($u_id);
	}
  }
}

function get_adminname($id){
  if($id!="" && $id!=0){
    $name	=	searchSingleRecord("tbl_admin","admin_name","admin_id",$id);   
	return $name;
  }
}


function count_character($str,$td_len)
{
	$length=strlen($str);
	if($length > $td_len)
	{
	  $i=$td_len;
	  do { 
			$i--;
		}while(substr($str,$i,1)!=" ");
	  return substr($str,0,$i)."...";
	}else{
		return $str;
	}
}


function ADD_CART($pid,$Price,$Qty,$type)
{
    $basket=array();
    $basket1=array();
     if(count($_SESSION['Cart1'])>0)
     {
          
          foreach($_SESSION['Cart1'] as $key=>$value)
          {
               $basket[]=$value["id"]."~".$value["type"];
          // $basket[]=;
          }
		  $xy=$pid."~".$type;
          if(in_array($xy,$basket,true))
          {
          //print_r($basket);
          //echo $Connection_id;
          ///exit();     
          }
          else
          {
               $_SESSION['Cart1'][]=array('id'=>$pid,'Price'=>$Price,"Quantity"=>$Qty,'type'=>$type);
          }
     }
     else
     {
     $_SESSION['Cart1'][]=array('id'=>$pid,'Price'=>$Price,"Quantity"=>$Qty,'type'=>$type);
	
     }
}

function View1_Cart()
{
     echo "<pre>";
     print_r($_SESSION['Cart1']);
}
function Count_Array()
{
     return count($_SESSION[Cart]);
}
function RemoveAndRepairCart($x)
{
     $Cart_new = $_SESSION['Cart1'];
     unset($Cart_new[$x]);
     $new_Cart = array();
     foreach ($Cart_new as $key1=>$val1)
     {
          $new_Cart[]=$val1; 
     }     
     $_SESSION['Cart1']=$new_Cart;
}
function getCartTotalAmount()
{
     $total_amount=0.0;
    
	foreach($_SESSION[Cart1] as $item)
		{
			if(is_array($item))
			{
			 $coaches_order_details_price=$item["Price"];
			 $Quantity=$item["Quantity"];
			 $amount=$Price*$Quantity;
			 $total_amount+=$amount;
			}	 
		
		}     
	return 	$total_amount;
}
function Empty_cart()
{
     $Cart_new = $_SESSION['Cart1'];
     unset($Cart_new);
     $new_Cart = array();
     /*foreach($Cart_new as $key1=>$val1)
     {
          $new_Cart[]=$val1; 
     } */    
     $_SESSION['Cart1']=$new_Cart;
}


function set_session_msg($msg)
{
 $_SESSION['sess_msg']=$msg;
}

function display_sess_msg()
{
 if($_SESSION['sess_msg']!='')  {
  echo '<div class="redcolor">';
  echo "<br>".$_SESSION['sess_msg'];
  unset($_SESSION['sess_msg']) ; 
  echo "</div>";
   }

}

function display_sess_msg1()
{
 if($_SESSION['sess_msg']!='')  {
  echo $_SESSION['sess_msg'];
  unset($_SESSION['sess_msg']) ; 
 }

}

function get_first_paragraph($str){

		if($str!="")	
		{
			$par	=	preg_split('#\s*</?p>\s*#', $str, -1, PREG_SPLIT_NO_EMPTY); 			
			return $par[0];
		}	
}

function sendMail($email_to,$emailto_name,$email_subject,$email_body,$email_from,$reply_to,$html=true,$attachment='')
{
	require_once "class.phpmailer.php";
	$mail = new PHPMailer();
	//$mail->IsSMTP(); // send via SMTP]
	$mail->IsMail(); // send via PHP mail function]
	$mail->Mailer   = "mail"; 
	//$mail->Host   = ""; // SMTP servers
	$mail->From     = $email_from;
	$mail->FromName = SITE_NAME;
	$mail->AddAddress($email_to,$emailto_name); 
	
	$mail->AddReplyTo($reply_to,SITE_NAME);
	//$mail->WordWrap = 50;                              // set word wrap
	$mail->IsHTML($html);                               // send as HTML
	$mail->Subject  =  $email_subject;
	if($attachment!=''){
	  $mail->AddAttachment(UP_FILES_FS_PATH."/attachment/".$attachment);
	}
	$mail->Body     =  $email_body;
	if(!$mail->Send())
	{
		return false;
	}
	else
	{
		return true; 
	}
}

function generateInsertQuery($table){
	if($table!=""){
		$query="select * from $table";
		$result=db_query($query);
		$insert	=	"Insert into $table values(";	
		$i = 0;
		while ($i < mysql_num_fields ($result)) {
		$row = mysql_fetch_field ($result);
		$name	= $row->name;
		$insert	.= " '$$name',";	
		  $i++;
		}	
		$insert	=	substr($insert,0,-1).")";
		return $insert;	
	}
}

function generateUpdateQuery($table){
	if($table!=""){
		$query="select * from $table";
		$result=db_query($query);
		$insert	=	"Update $table set ";	
		$i = 0;
		while ($i < mysql_num_fields ($result)) {
		
		$row = mysql_fetch_field ($result);
		$name	= $row->name;
		$insert	.= " $name='$$name',";	
		  $i++;
		}	
		$insert	=	substr($insert,0,-1);
		return $insert;	
	}
}

function getRandomString($len=6){
$base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
$max=strlen($base)-1;
$code='';
mt_srand((double)microtime()*1000000);
while (strlen($code)<$len+1)
  $code.=$base{mt_rand(0,$max)};
  
return $code;
}

function CreateVerificationKey(){
		$random	=	getRandomString();
		$check	=	checkAvailableRecord("tbl_warehouse","count(*)"," wh_code='$random' ");
		if($check=="" || $check=="0"){
		  return $random;	
		}else{
		  return CreateVerificationKey(); 
		}
}

function aspect_ratio($file_name,$max_width)
{
    $dim = @getimagesize($file_name);
     if($dim[0] > $max_width) 
     {
          $scale=$max_width/$dim[0];
          $height=ceil($scale*$dim[1]);
          $image[w] = $max_width;
          $image[h] = $height;
    }
    else
    {
          $image[w] = $dim[0];
          $image[h] = $dim[1];
    }
     //echo print_r($image);
    return $image;
}


function change_order($cat_id,$new_order,$id,$type,$parent='')
{		
if($type=='category')
{
	$table_name = "tbl_category";
	$col1       = "cat_order";
	$col2       = "cat_id";
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='package')
{
	$table_name = "tbl_package";
	$col1       = "package_order";
	$col2       = "package_id";
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='product')
{
	$table_name = "tbl_product";
	$col1       = "prod_order";
	$col2       = "prod_id";
	$col3		="prod_cat_id";	
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='artist')
{
	$table_name = "tbl_artists";
	$col1       = "artist_order";
	$col2       = "artist_id";
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='genere')
{
	$table_name = "tbl_music_type";
	$col1       = "mt_order";
	$col2       = "mt_id";
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='testimonial')
{
	$table_name = "tbl_testimonial";
	$col1       = "testimonial_order";
	$col2       = "testimonial_id";
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='file')
{
	$table_name = "tbl_album_files";
	$col1       = "af_order";
	$col2       = "af_id";
	$col3       = "af_a_id";
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='song')
{
	$table_name = "tbl_songs";
	$col1       = "s_order";
	$col2       = "s_id";	
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='album')
{
	$table_name = "tbl_album";
	$col1       = "a_order";
	$col2       = "a_id";	
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='chart'){
	$table_name = "tbl_chart";
	$col1       = "ch_type_order";
	$col2       = "ch_id";	
	$col3       = "ch_type";	
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='spotlight'){
	$table_name = "tbl_spotlight";
	$col1       = "sp_order";
	$col2       = "sp_id";
	$id_head    = "";
	$id_head_value = "";
}elseif($type=='video'){
	$table_name = "tbl_videos";
	$col1       = "v_order";
	$col2       = "v_id";
	$col3       = "v_cat_id";
	$id_head    = "";
	$id_head_value = "";
}

	$sql = " select $col1 from $table_name where $col2='$id'";
	$order_old=db_scalar($sql);

	if(intval($order_old) > intval($new_order))
	{
		if($type=='product' or $type=='chart' or $type=='file' or $type=='video'){
		$sql= "select $col1,$col2 from $table_name where $col1 >='$new_order' and $col1<'$order_old' And $col3='$parent'";
		}else{
		$sql= "select $col1,$col2 from $table_name where $col1 >='$new_order' and $col1<'$order_old'";
		}
		if($id_head_value!='' && $id_head!='') { 
			$sql .= " and $id_head ='$id_head_value' ";
		}
		$sql .= " order by $col1 asc ";
		$result=db_query($sql);
		while($line = mysql_fetch_array($result))
		{
			$orderx = $line[$col1];
			$idx	 = $line[$col2];
			$orderx++;
			if($type=='product' or $type=='chart' or $type=='file' or $type=='video'){
				$sql_update="update $table_name set $col1='$orderx' where $col2='$idx' And $col3='$parent'";
			}else{
				$sql_update="update $table_name set $col1='$orderx' where $col2='$idx'";
			}
			
			db_query($sql_update);
		}
	}
	else
	{
		if($type=='product' or $type=='chart' or $type=='file' or $type=='video'){
		$sql= "select $col1,$col2 from $table_name where $col1>$order_old  and $col1<=$new_order And $col3='$parent'";
		}else{
		 $sql= "select $col1,$col2 from $table_name where $col1>$order_old  and $col1<=$new_order";
		}
		if($id_head_value!='' && $id_head!='') { 
			$sql .= " and $id_head ='$id_head_value' ";
		}
		$sql .= " order by $col1 asc ";
		$result=db_query($sql);
		while($line = mysql_fetch_array($result))
		{
			$orderx  = $line[$col1];
			$idx	 = $line[$col2];
			$orderx--;
		if($type=='product' or $type=='chart' or $type=='file' or $type=='video'){
			$sql_update="update $table_name set $col1='$orderx' where $col2='$idx' And $col3='$parent'";
		}else{
			$sql_update="update $table_name set $col1='$orderx' where $col2='$idx'";
		}	
			db_query($sql_update);
		}
	}
	if($type=='product' or $type=='chart' or $type=='file' or $type=='video'){
		$sql= "update $table_name set $col1='$new_order' where $col2='$id' And $col3='$parent'";
	}else{
		$sql= "update $table_name set $col1='$new_order' where $col2='$id'";
	}	
	
	db_query($sql);
}

///////////////////////function start from here
function showUploadError($code){
$err='';
  if($code!='' && $code!='0'){
    switch($code){
	 case 1:
	   $err	=	"The uploaded file exceeds maximum file size.";
	 break;
	 
	 case 2:
	   $err	=	"The uploaded file exceeds maximum file size.";
	 break;
	 
	 case 3:
	   $err	=	"The uploaded file was only partially uploaded.";
	 break;
	 
	 case 4:
	   $err	=	"No file was uploaded.";
	 break;
	 
	 case 6:
	   $err	=	"Missing a temporary folder.";
	 break;
	 
	 case 7:
	   $err	=	"Failed to write file to disk.";
	 break;
	 
	 case 8:
	   $err	=	"File upload stopped by extension.";
	 break;
	}
  }
  return $err;  
}

function rename_win($oldfile,$newfile) {
   if (!rename($oldfile,$newfile)) {
      if (copy($oldfile,$newfile)) {
         unlink($oldfile);
         return TRUE;
      }
      return FALSE;
   }
   return TRUE;
} 

function emailmsg($id,$subject,$msg,$attach=''){
$str	=	$msg;
//echo $str	;
//exit;
  $res	=	db_query("select nu_name,nu_email from tbl_newsletter where nu_id='$id'");
  if(mysql_num_rows($res)>0){
    $row=mysql_fetch_assoc($res);  
	@extract($row);
    sendMail($nu_email,$nu_name,$subject,$str,ADMIN_EMAIL,ADMIN_EMAIL,$html=true,$attach);
  }
}

function getEventName($id){
 if($id!=''){ 
     $name=ucfirst(searchSingleRecord('tbl_events','event_title','event_id',$id));
     return $name;
 }
}

function getText1($page_id){
  if($page_id!='' && $page_id!=0){
   $text	=	db_scalar("select page_text from tbl_content where page_id='$page_id'");
  // $text	=	ms_form_value($text);
  }else{
   $text="&nbsp;";
  }
  return $text;
}

function getText2($page_id){
  if($page_id!='' && $page_id!=0){
   $text	=	db_scalar("select page_brief_desc from tbl_content where page_id='$page_id'");
  // $text	=	ms_form_value($text);
  }else{
   $text="&nbsp;";
  }
  return $text;
}

function getmysqldatetime($ap_date){
if($ap_date!=''){
	$dateArr	=	explode(' ',$ap_date);
	$date1		=	explode('/',$dateArr[0]);
	$time1		=	explode(':',$dateArr[1]);
	return $date=$date1[2]."-".$date1[1]."-".$date1[0]." ".$time1[0].":".$time1[1];
}
}

function changedatefrommysqldate($ap_date){
	if($ap_date!='' && $ap_date!='0000-00-00' && $ap_date!='0000-00-00 00:00:00'){
		  $dateArr	=	explode(' ',$ap_date);	
		  $date		=	explode('-',$dateArr[0]);
		  $time		=	explode(':',$dateArr[1]);
		  return $date	=	$date[2]."/".$date[1]."/".$date[0]." ".$time[0].":".$time[1];
	}	  
}
function dateformat($ap_date){
	if($ap_date!='' && $ap_date!='0000-00-00' && $ap_date!='0000-00-00 00:00:00'){
		  $dateArr	=	explode(' ',$ap_date);	
		  $date		=	explode('-',$dateArr[0]);
		  $time		=	explode(':',$dateArr[1]);
		  return $date	=	$date[2]."/".$date[1]."/".$date[0];
	}	  
}

function dateformat_txt($ap_date){
	if($ap_date!='' && $ap_date!='0000-00-00' && $ap_date!='0000-00-00 00:00:00'){
		  $dateArr	=	explode(' ',$ap_date);	
		  $date		=	explode('-',$dateArr[0]);
		  $time		=	explode(':',$dateArr[1]);
		  return $date	=	date("d-M-Y", mktime(0,0,0,$date[1],$date[2],$date[0]));
	}	  
}

function headerInc(){
$var ="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
\"http://www.w3.org/TR/html4/loose.dtd\"><html><head><title>Sangrock Black Belt World</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"sangrock.css\" rel=\"stylesheet\" type=\"text/css\">
<script language=\"javascript1.2\" type=\"text/javascript\" src=\"Scripts/dynamiclayout.js\"></script>
<script language=\"JavaScript\" type=\"text/JavaScript\">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf('#')!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf('?'))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onLoad=\"MM_preloadImages('images/home_o.gif','images/about_o.gif','images/photos_o.gif','images/contact_o.gif')\">
<center><div id=\"layoutBody\"><table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td width=\"35%\" height=\"97\" valign=\"top\" class=\"top_bg\"><a href=\"home.php\"><img src=\"images/logo.jpg\" width=\"333\" height=\"97\" border=\"0\"></a></td>
    <td width=\"65%\" align=\"right\" valign=\"top\" class=\"top_bg\"><img src=\"images/top_img.jpg\" width=\"429\" height=\"97\"></td>
  </tr>
  <tr>
    <td colspan=\"2\">
      <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td width=\"119\" bgcolor=\"#2199B7\"><img src=\"images/topmenu_curv2.gif\" width=\"95\" height=\"28\"></td>
          <td width=\"119\" align=\"right\"  class=\"logo_img\"><img src=\"images/spacer.gif\" width=\"80\" height=\"4\"></td>
          <td width=\"125\" align=\"center\" class=\"topmenu_bg\"><a href=\"home.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image16','','images/home_o.gif',1)\"><img src=\"images/home.gif\" name=\"Image16\" width=\"46\" height=\"17\" border=\"0\"></a></td>
          <td width=\"120\" class=\"topmenu_bg\"><a href=\"about_us.htm\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image17','','images/about_o.gif',1)\"><img src=\"images/about.gif\" name=\"Image17\" width=\"69\" height=\"17\" border=\"0\"></a></td>
          <td width=\"108\" class=\"topmenu_bg\"><a href=\"videos.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image18','','images/videos_o.gif',0)\"><img src=\"images/videos.gif\" name=\"Image18\" width=\"53\" height=\"17\" border=\"0\"></a></td>
          <td width=\"109\" class=\"topmenu_bg\"><a href=\"photos.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image19','','images/photos_o.gif',1)\"><img src=\"images/photos.gif\" name=\"Image19\" width=\"57\" height=\"17\" border=\"0\"></a></td>
          <td width=\"232\" class=\"topmenu_bg\"><a href=\"contact_us.htm\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image20','','images/contact_o.gif',1)\"><img src=\"images/contact.gif\" name=\"Image20\" width=\"88\" height=\"17\" border=\"0\"></a></td>
        </tr>
    </table></td>
  </tr>
</table><!-- #EndLibraryItem --><table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    <tr>
      <td width=\"239\" valign=\"top\" bgcolor=\"#FFFFFF\"><table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  class=\"leftbar_bg\">
      <tr>
        <td width=\"87%\" valign=\"top\"><table width=\"85%\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
          <tr>
            <td><a href=\"home.htm\" class=\"left_menu\">Home</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"about_us.htm\" class=\"left_menu\">About Sangrock</a></td>
          </tr>
         <!-- <tr><td valign=\"top\"><table width=\"95%\"  border=\"0\" align=\"right\" cellpadding=\"2\" cellspacing=\"1\">
                  <tr>
                    <td width=\"13%\"><img src=\"../images/bullet_2.gif\" width=\"14\" height=\"15\"></td>
                    <td width=\"87%\"><a href=\"#\" class=\"left_submenu\">Missoin</a></td>
                  </tr>
                  <tr>
                    <td><img src=\"../images/bullet_2.gif\" width=\"14\" height=\"15\"></td>
                    <td><a href=\"#\" class=\"left_submenu\">Vision</a></td>
                  </tr>
                  <tr>
                    <td><img src=\"../images/bullet_2.gif\" width=\"14\" height=\"15\"></td>
                    <td><a href=\"#\" class=\"left_submenu\">Classes</a></td>
                  </tr>
                </table></td>           
          </tr>--> 
          <tr>
            <td class=\"line\">&nbsp; </td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Korea Tour 2007</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Instructors &amp; Staff</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Training Programs</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Summer Camp 2007</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Class Schedule</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Yoga</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Black Belt Page</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">News</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Black Belt World India</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Birthday Parties</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Demo Team</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Sparring Team</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>
          <tr>
            <td><a href=\"#\" class=\"left_menu\">Contact Us </a></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td width=\"13%\" align=\"right\" valign=\"top\"><img src=\"images/bannner_01.gif\" width=\"31\" height=\"161\"></td>
      </tr>
    </table>
	<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  class=\"leftbar_bg \">
        <tr>
          <td colspan=\"2\">&nbsp;</td>
        </tr>
        <tr>
          <td width=\"90%\" height=\"103\" class=\"border_TW\"><table width=\"85%\"  border=\"0\" align=\"right\" cellpadding=\"4\" cellspacing=\"0\">
              <tr>
                <td colspan=\"2\" class=\"left_head\">Upcoming Events</td>
              </tr>
              <tr>
                <td width=\"36%\" valign=\"top\"><img src=\"images/nevents_img.jpg\" width=\"56\" height=\"51\"></td>
                <td width=\"64%\" valign=\"top\" class=\"left_dsp\">2008 Blackbelt World Festival<br>
                  April 18-19, 2008<br>
                <a href=\"events.htm\" class=\"left_more\">more &gt;</a></td>
              </tr>
                    </table></td>
          <td width=\"10%\" class=\"box_cor\"></td>
        </tr>
        <tr>
          <td class=\"border_TW\"><table width=\"85%\"  border=\"0\" align=\"right\" cellpadding=\"3\" cellspacing=\"0\">
              <tr>
                <td width=\"16%\" class=\"left_head\"><img src=\"images/friend_icon.gif\" width=\"20\" height=\"21\"></td>
                <td width=\"84%\" class=\"left_head\">Refer to a Friend</td>
              </tr>
              <tr>
                <td colspan=\"2\" valign=\"top\"><input name=\"textfield\" type=\"text\" class=\"left_txt_box\" value=\"Enter Your Email ID \" size=\"32\"></td>
              </tr>
              <tr>
                <td colspan=\"2\" valign=\"top\"><input name=\"textfield2\" type=\"text\" class=\"left_txt_box\" value=\"Enter Your Friends Email ID \" size=\"32\"></td>
              </tr>
              <tr>
                <td colspan=\"2\" valign=\"top\"><a href=\"#\"><img src=\"images/send_btn.gif\" width=\"54\" height=\"17\" border=\"0\"></a></td>
              </tr>
          </table></td>
          <td class=\"box_cor2\"></td>
        </tr>
        <tr>
          <td height=\"23\"><img src=\"images/spacer.gif\" width=\"180\" height=\"4\"></td>
          <td height=\"23\" align=\"right\" valign=\"bottom\"><img src=\"images/boc_cor_end.gif\" width=\"24\" height=\"23\"></td>
        </tr>
        <tr>
          <td bgcolor=\"#FFFFFF\">&nbsp;</td>
          <td align=\"right\" valign=\"bottom\" bgcolor=\"#FFFFFF\">&nbsp;</td>
        </tr>
      </table></td>
      <td width=\"753\" valign=\"top\" bgcolor=\"#FFFFFF\"><table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td align=\"right\" bgcolor=\"#315577\"><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"565\" height=\"161\">
            <param name=\"movie\" value=\"header.swf\">
            <param name=\"quality\" value=\"high\">
            <embed src=\"header.swf\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"565\" height=\"161\"></embed>
          </object><script language=\"javascript\" src=\"Scripts/iefix.js\"></script></td>
        </tr>";
		return $var;
}

function headerInc1(){
$var1='<?include_once(\'includes/main.inc.php\');?>';
$var =$var1."
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
\"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
<title>Sangrock Black Belt World</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link href=\"sangrock.css\" rel=\"stylesheet\" type=\"text/css\">
<script language=\"javascript1.2\" type=\"text/javascript\" src=\"Scripts/dynamiclayout.js\"></script>
<script language=\"JavaScript\"  src=\"js/validation.js\"></script>
<script language=\"JavaScript\" type=\"text/JavaScript\">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf('#')!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf('?'))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}


//-->
</script>
<script language=\"javascript\">
function checkText2(){
if(objId('y_name').value=='Enter Your Name'){

objId('y_name').value='';
}

if(objId('yf_name').value=='Enter your friend Name'){
objId('yf_name').value='';
}

}
</script>
</head>

<body onLoad=\"MM_preloadImages('images/home_o.gif','images/about_o.gif','images/photos_o.gif','images/contact_o.gif')\">
<center><div id=\"layoutBody\"><table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
  <tr>
    <td width=\"35%\" height=\"97\" valign=\"top\" class=\"top_bg\"><a href=\"home.php\"><img src=\"images/logo.jpg\"  border=\"0\"></a></td>
    <td width=\"65%\" align=\"right\" valign=\"top\" class=\"top_bg\"><img src=\"images/top_img.jpg\" width=\"429\" height=\"97\"></td>
  </tr>
  <tr>
    <td colspan=\"2\">
      <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td width=\"119\" bgcolor=\"#2199B7\"><img src=\"images/topmenu_curv2.gif\" width=\"95\" height=\"28\"></td>
          <td width=\"119\" align=\"right\"  class=\"logo_img\"><img src=\"images/spacer.gif\" width=\"80\" height=\"4\"></td>
          <td width=\"125\" align=\"center\" class=\"topmenu_bg\"><a href=\"home.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image16','','images/home_o.gif',1)\"><img src=\"images/home.gif\" name=\"Image16\" width=\"46\" height=\"17\" border=\"0\"></a></td>
          <td width=\"120\" class=\"topmenu_bg\"><a href=\"about_us.htm\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image17','','images/about_o.gif',1)\"><img src=\"images/about.gif\" name=\"Image17\" width=\"69\" height=\"17\" border=\"0\"></a></td>
          <td width=\"108\" class=\"topmenu_bg\"><a href=\"videos.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image18','','images/videos_o.gif',0)\"><img src=\"images/videos.gif\" name=\"Image18\" width=\"53\" height=\"17\" border=\"0\"></a></td>
          <td width=\"109\" class=\"topmenu_bg\"><a href=\"photos.php\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image19','','images/photos_o.gif',1)\"><img src=\"images/photos.gif\" name=\"Image19\" width=\"57\" height=\"17\" border=\"0\"></a></td>
          <td width=\"232\" class=\"topmenu_bg\"><a href=\"contact_us.htm\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image20','','images/contact_o.gif',1)\"><img src=\"images/contact.gif\" name=\"Image20\" width=\"88\" height=\"17\" border=\"0\"></a></td>
        </tr>
    </table></td>
  </tr>
</table>
<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    <tr>
      <td width=\"239\" valign=\"top\" bgcolor=\"#FFFFFF\"><table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  class=\"leftbar_bg \">
      <tr>
        <td width=\"87%\" valign=\"top\">".leftpan()."</td>
        <td width=\"13%\" align=\"right\" valign=\"top\"><img src=\"images/bannner_01.gif\" width=\"31\" height=\"161\"></td>
      </tr>
    </table><table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"  class=\"leftbar_bg \">
        <tr>
          <td colspan=\"2\">&nbsp;</td>
        </tr>
        <tr>
          <td width=\"90%\" height=\"103\" class=\"border_TW\">";
		    $sql_event=db_query("select * from tbl_events where event_status='Active' And Date(event_date)<='".MYSQL_DATE."' order by event_date asc limit 0,1");
				  if(mysql_num_rows($sql_event)>0){
				   $r_event=mysql_fetch_array($sql_event);
				   @extract($r_event);
				   if($event_img!=""){ 				    
								 $v_image2 = 	UP_FILES_WS_PATH."/event/".$event_img;
								 $file_path		 =	show_thumb($v_image2,"56","51","width");
	
								 $im="<a href='event_detail.php?event_id=$event_id'><img src=\"".$file_path."\" alt=''  border=\"0\" /></a>";	
					 }else{
					   $im="&nbsp;";
					 }
				   
			
$var	.=" <table width=\"85%\"  border=\"0\" align=\"right\" cellpadding=\"4\" cellspacing=\"0\">
              <tr>
                <td colspan=\"2\" class=\"left_head\">Upcoming Events</td>
              </tr>
              <tr>
                <td width=\"36%\" valign=\"top\">".$im."</td>
                <td width=\"64%\" valign=\"top\" ><a href=\"event_detail.php?event_id=".$event_id."\" class=\"left_dsp\">".$event_title."</a><br>
                </td>
              </tr>
			   <tr>
                <td valign=\"top\" colspan=\"2\" align=\"right\"><a href=\"events.php\" class=\"left_more\">more &gt;</a></td></tr>
               </table>";
			 }else{
			  $var	.="<a href=\"events.php\" class=\"left_more\">All Events &gt;</a>";		
			 }
$var	.="</td>
          <td width=\"10%\" class=\"box_cor\"></td>
        </tr>
        <tr>
          <td class=\"border_TW\"><table width=\"85%\"  border=\"0\" align=\"right\" cellpadding=\"3\" cellspacing=\"0\"><form name=\"contact\" action=\"refer-friend.php\" method=\"post\" >
              <tr>
                <td width=\"16%\" class=\"left_head\"><img src=\"images/friend_icon.gif\" width=\"20\" height=\"21\"></td>
                <td width=\"84%\" class=\"left_head\">Refer to a Friend</td>
              </tr>
			  <tr>
                <td colspan=\"2\" valign=\"top\"><input name=\"y_name\" type=\"text\"  id=\"y_name\" alt=\"NOBLANK~Your Name~DM~\" value=\"Enter Your Name\" class=\"left_txt_box\" size=\"32\" onClick=\"this.value='';\" onFocus=\"this.value='';\"/></td>
              </tr>
              <tr>
                <td colspan=\"2\" valign=\"top\"><input name=\"y_email\" type=\"text\"  id=\"y_email\" alt=\"NOBLANK~Your Email~DM~EMAIL~Your Email~DM~MAXLENGTH~Your Email~100\" value=\"Enter Your Email ID\" class=\"left_txt_box\" size=\"32\"/></td>
              </tr>
			  <tr>
                <td colspan=\"2\" valign=\"top\">
				<input name=\"yf_name\" type=\"text\" id=\"yf_name\" alt=\"NOBLANK~Friend Name~DM~\" value=\"Enter your friend Name\" class=\"left_txt_box\" size=\"32\" onClick=\"this.value='';\" onFocus=\"this.value='';\"/></td>
              </tr>
			   <tr>
                <td colspan=\"2\" valign=\"top\">
				<input name=\"yf_email\" type=\"text\" id=\"yf_email\" alt=\"NOBLANK~Friend Email~DM~EMAIL~Friend Email~DM~MAXLENGTH~Friend Email~100\" value=\"Enter your friend email id\" class=\"left_txt_box\" size=\"32\" onClick=\"this.value='';\" onFocus=\"this.value='';\"/></td>
              </tr>
            
              <tr>
                <td colspan=\"2\" valign=\"top\"><input type=\"hidden\" name=\"href\" value=".$_SERVER['PHP_SELF'].get_qry_str()."><input type=\"image\" src=\"images/send_btn.gif\" width=\"54\" height=\"17\" border=\"0\" onclick=\"checkText2(); return validate(document.contact);\"><input type=\"hidden\" name=\"refer\"></td>
              </tr></form>
          </table></td>
          <td class=\"box_cor2\"></td>
        </tr>
        <tr>
          <td height=\"23\"><img src=\"images/spacer.gif\" width=\"180\" height=\"4\"></td>
          <td height=\"23\" align=\"right\" valign=\"bottom\"><img src=\"images/boc_cor_end.gif\" width=\"24\" height=\"23\"></td>
        </tr>
        <tr>
          <td bgcolor=\"#FFFFFF\">&nbsp;</td>
          <td align=\"right\" valign=\"bottom\" bgcolor=\"#FFFFFF\">&nbsp;</td>
        </tr>
      </table></td>
      <td width=\"753\" valign=\"top\" bgcolor=\"#FFFFFF\"><table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
        <tr>
          <td align=\"right\" bgcolor=\"#315577\"><object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" width=\"565\" height=\"161\">
            <param name=\"movie\" value=\"header.swf\">
            <param name=\"quality\" value=\"high\">
            <embed src=\"header.swf\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"565\" height=\"161\"></embed>
          </object><script language=\"javascript\" src=\"Scripts/iefix.js\"></script></td>
        </tr>";

return $var;
}





function footerInc(){

$var="</table>    </td>
    </tr>
  </table>
  <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    <tr>
      <td width=\"25%\" bgcolor=\"#660000\"><img src=\"images/spacer.gif\" width=\"202\" height=\"8\"></td>
      <td width=\"75%\" bgcolor=\"#FFFFFF\"><img src=\"images/foot_curv.gif\" width=\"23\" height=\"16\"></td>
    </tr>
    <tr bgcolor=\"#660000\">
      <td height=\"65\" colspan=\"2\">
      	<table width=\"95%\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
      		<tr valign=\"top\">
      			<td width=\"27%\" class=\"txt_9\"><strong>Useful Links:</strong><br><a href=\"http://www.blackbeltworld.com/\" target=\"_blank\" class=\"txt_9\">Black Belt World</a><br><a href=\"http://www.tk.ac.kr\" target=\"_blank\" class=\"txt_9\">Taekyeung College</a>
      			</td>
      			<td width=\"21%\" ><a href=\"training_program.htm\" class=\"txt_10w\"><br>Training Program</a><br><strong><a href=\"#\" class=\"txt_10w\">Class Schedule</a></strong>
      			</td>
      			<td width=\"25%\"><br><a href=\"master_singh.htm\" class=\"txt_10w\">Master Singh</a></td>
      			<td width=\"27%\" class=\"txt_9\">Copyright 2008, All Right Reserved<br><strong>Sangrock Black Belt World</strong><br>website design &amp; developed by <a footerInc/strong></a>
      			</td>
      		</tr>
      	</table>
      </td>
     </tr>
  </table>
</div>
</center>
<script type=\"text/javascript\">
	matchWidth();
</script>
</body>
</html>
";
return $var;
}

function createhtml($id,$name,$title,$desc){

  if($id=='' or $id==0){
    $text	=	headerInc1();
	$text	.="        <tr>
          <td valign=\"top\" class=\"pad_t pad_l1  page_graphx\"><table width=\"99%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr>
                  <td class=\" head \">".$title." </td>
                </tr>
                <tr>
                  <td valign=\"top\" class=\"txt_10\">&nbsp;</td>
                </tr>
                <tr>
                  <td valign=\"top\"><p>".$desc." </p>
                  <p><br>
                    <br>
                  </p>                </td>
                </tr>
              </table></td>
        </tr>";
		$text	.=	footerInc();
    $filename=$name.".htm";
	$path=SITE_FS_PATH."/".$filename;
	$fp=fopen($path,'w');
		if($fp){
		  fwrite($fp,$text);
		}  
  }else{
    $old_file=searchSingleRecord("tbl_links","link_file_name","link_id",$id);
	
	
	$text	=	headerInc1();
	$text	.="        <tr>
          <td valign=\"top\" class=\"pad_t pad_l1  page_graphx\"><table width=\"99%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                <tr>
                  <td class=\" head \">".$title." </td>
                </tr>
                <tr>
                  <td valign=\"top\" class=\"txt_10\">&nbsp;</td>
                </tr>
                <tr>
                  <td valign=\"top\"><p>".$desc." </p>
                  <p><br>
                    <br>
                  </p>                </td>
                </tr>
              </table></td>
        </tr>";
				$text	.=	footerInc();
    $filename=$name.".htm";
	if($filename!=$old_file && $old_file!=''){
		$path=SITE_FS_PATH."/".$filename;
		$fp=fopen($path,'w');
			if($fp){
			  fwrite($fp,$text);
			}
			  $handle	=	SITE_FS_PATH."/".$old_file;
		      //unset($handle);
			  @unlink($handle);
	}else{
	  	$path=SITE_FS_PATH."/".$old_file;
		$fp=fopen($path,'w');
			if($fp){
			  fwrite($fp,$text);
			}

	} 	  
  }

}

function changeAllPage(){
 $sql=db_query("select * from tbl_links where link_status='Active' order by link_id asc");		  
if(mysql_num_rows($sql)>0){
 while($row=mysql_fetch_array($sql)){
 @extract($row);
  createhtml($link_id,$link_file_name,$link_title,$link_desc);
 }
} 
} 


function page_nav($linkid){
$cur_page=basename($_SERVER['PHP_SELF']);
	$res=mysql_fetch_array(db_query("select * from tbl_category where link_id='$linkid' And link_status!='Delete'"));
	$flag=0;
	$linkparent=$linkid;
	while($flag!=1){
		$res1=db_query("select * from tbl_category where link_id='$linkparent' And link_status!='Delete'");
		$record=mysql_fetch_array($res1);
		if($record[link_parent_id]!=0){
			$linkparent=$record[link_parent_id];
			$array.="$record[link_id]~";
		}else{
			if($record[link_id]!=""){
				$array.="$record[link_id]~";
			}
			$flag=1;
		}
	}
	$arr=explode("~",$array);
	$result = array_reverse($arr);
	if($linkid!='' && $linkid!=0){
	echo "<a href='link_list.php'>Manage links</a> ";
	}else{
	echo "Manage links";
	}
	for($i=1;$i<count($result);$i++){
		$res=mysql_fetch_array(db_query("select * from tbl_category where link_id='$result[$i]' And link_status!='Delete'"));
		$x=0;
		if($x==0)
		   if($linkid==$res[link_id] && $cur_page=='link_list.php')	{
		     echo " >> ".$res[link_name];
		   }else{
			echo " >> <a href='classified_list.php?classified_sublink_id=".$res[link_id]."'>".$res[link_name]."</a>";
		   }
		else
			if($cur_page=='link_list.php' or $cur_page=='link_f.php'){
			echo " >> <a href='link_list.php?link_parent_id=".$res[link_id]."'>".$res[link_name]."</a>";
			}elseif($cur_page=='classified_list.php' or $cur_page=='classified_f.php'){
			echo " >> <a href='linkegory_list.php?link_parent_id=".$res[link_id]."'>".$res[link_name]."</a>";      }
	}
}

function leftpan(){

$var	="<table width=\"85%\"  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
          <tr>
            <td><a href=\"home.php\" class=\"left_menu\">Home</a></td>
          </tr>
          <tr>
            <td class=\"line\">&nbsp;</td>
          </tr>";
		  
$sql=db_query("select * from tbl_links where link_status='Active'And link_parent_id='0' order by link_id asc");		  
if(mysql_num_rows($sql)>0){
 while($row=mysql_fetch_array($sql)){
 @extract($row);
  $var	.="<tr>
            <td><a href=\"".$link_file_name.".htm\" class=\"left_menu\">".$link_title."</a></td>
          </tr>";

$sub=db_query("select * from tbl_links where link_parent_id='$link_id' And link_status='Active' order by link_id asc");
  if(mysql_num_rows($sub)>0){
  $var	.="<tr><td valign=\"top\"><table width=\"95%\"  border=\"0\" align=\"right\" cellpadding=\"2\" cellspacing=\"1\">";
    while($r_s=mysql_fetch_array($sub)){
	  $var .="<tr>
                    <td width=\"13%\"><img src=\"images/bullet_2.gif\" width=\"14\" height=\"15\"></td>
                    <td width=\"87%\"><a href=\"".$r_s['link_file_name'].".htm\" class=\"left_submenu\">".$r_s['link_title']."</a></td>
                  </tr>";
	}
   $var.="</table></td></tr>";
  }
        
  $var	.="<tr>
            <td class=\"line\">&nbsp; </td>
          </tr>";
	}	  
}
 $var	.="</table>";

return $var;
}


function get_size_of_image()
{
		$arr=array();
		$sql_banner=mysql_query("select * from tbl_add_with_us where add_with_display_status='Home' and add_with_banner_image!='' and add_with_status='Active' order by rand()") or die(mysql_error());
		if(mysql_num_rows($sql_banner)>0)
		{
				$result_ban=mysql_fetch_array($sql_banner);
				$cat_image_ban = 	UP_FILES_WS_PATH."/addvertise/".$result_ban['add_with_banner_image'];
				$web_url=$result_ban['add_with_web_url'];
			   $arr=getimagesize($cat_image_ban);
		 
		
				 if(($arr[0]==120) && ($arr[1]==240))
				 {
						  
					$var=$cat_image_ban;
				}
				else
				{
							if(mysql_num_rows($sql_banner)==1)
							{
							return '';
							}
							else
							{
								$var=get_size_of_image();
							}
				}
				return $var.",".$web_url;	
				}
				else return '';
}

function get_size_of_image_bottom()
{
		$arr_btm=array();
		$sql_banner_btm=mysql_query("select add_with_banner_image,add_with_web_url  from tbl_add_with_us where add_with_display_status='Home' and add_with_status='Active' and add_with_banner_image!='' order by rand()") or die(mysql_error());
		if(mysql_num_rows($sql_banner_btm)>0)
		{
					$result_ban_btm=mysql_fetch_array($sql_banner_btm);
					if($result_ban_btm['add_with_banner_image']!='')
					{
					$cat_image_ban_btm = 	UP_FILES_WS_PATH."/addvertise/".$result_ban_btm['add_with_banner_image'];
			  $web_url=$result_ban_btm['add_with_web_url'];
			
				   $arr_btm=getimagesize($cat_image_ban_btm);
			 
					
								 if(($arr_btm[0]==468) && ($arr_btm[1]==60))
								 {
										  
									$var=$cat_image_ban_btm;
								 }
								else
								{   
								
									if(mysql_num_rows($sql_banner_btm)==1)
									{
									return '';
									}
									else
									{
										$var=get_size_of_image_bottom();
									}
								
									
								}
						}
						else
						{
						$var=get_size_of_image_bottom();
						//return '';
						}
			return $var.",".$web_url;	
			}
			else
			return '';
}



function get_size_of_image_ineer()
{
		$arr_btm=array();
		$sql_banner_btm=mysql_query("select * from tbl_add_with_us where add_with_display_status='In' and add_with_banner_image!='' and add_with_status='Active' order by rand() ") or die(mysql_error());
		if(mysql_num_rows($sql_banner_btm)>0)
		{
		$result_ban_btm=mysql_fetch_array($sql_banner_btm);
		if($result_ban_btm['add_with_banner_image']!='')
		{
					$cat_image_ban_btm = 	UP_FILES_WS_PATH."/addvertise/".$result_ban_btm['add_with_banner_image'];
					$web_url=$result_ban_btm['add_with_web_url'];
				   $arr_btm=getimagesize($cat_image_ban_btm);
			 
					
							 if(($arr_btm[0]==120) && ($arr_btm[1]==240))
							 {
									  
								$var=$cat_image_ban_btm;
							}
							else
							{ 
							
							if(mysql_num_rows($sql_banner_btm)==1)
							{
							return '';
							}
							else
							{
								$var=get_size_of_image_ineer();
							}
							
							
								
							}
				  }
				  else
				  {
				  $var=get_size_of_image_ineer();
				 // return '';
				  }
				  return $var.",".$web_url;
	}
	else
	return '';

}
?>