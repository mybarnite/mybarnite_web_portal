<? 
/*****************************************************************************************************
* Devloper Name  : Kanhaiya Lal Yadav
* Designer Name  : Krishna Kumar (wsi.kissna@gmail.com)
* Company  Name  : Creative Web Solutions PVT. LTD.
* Website  url   : Websitesolutionsindia.com, creativewebsolutions.co,
* Email          : wsi.kanhaiya@gmail.com,kaddy.global@gmail.com
* File           : For Configuration Setting
******************************************************************************************************/
// Fuctions file forsite to implement & work : Created 08 December 2012

 function GET_CURRENT_URL(){

$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$chk_url  =  explode("/",$url);
return $chk_url[5];
}


// funtion to authenticating all the page to open directly here

function PAGE_PROHIBITTED($authenticate){
       
       if($authenticate!=1){
               
             //  include(FILE_NOT_FOUND);			 			 ?>			 			 <script>window.location.href='login.php'</script>			 			 <?php 
               exit;
       }
       
}

	
	 function sluggify($url)
{
   
   $url = strtolower($url);
   $url = strip_tags($url);
   $url = stripslashes($url);
   $url = html_entity_decode($url);
   $url = str_replace('\'', '', $url);
   $match = '/[^a-z0-9]+/';
   $replace = '-';
   $url = preg_replace($match, $replace, $url);
   $url = trim($url, '-');
   return $url;
}
	
	function file_ext($file_name)
	{
		$path_parts = pathinfo($file_name);
		$ext = strtolower($path_parts["extension"]);
		return $ext;
	}
	
function GetSiteRoot()
	{
		$query_per=mysql_query("select * from tbl_prefrences");
   $fetch_per= mysql_fetch_array($query_per);
 echo $fetch_per['site_base_url'];
	}
?>