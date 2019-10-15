<? include('header_panel.php');
?>  
<script  language="javascript">
var site_ws_path='<?=SITE_WS_PATH?>';
</script>
<script type="text/javascript" src="js/ajax.js"></script>
   <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" bgcolor="#3274a9"><img src="images/news-icon.gif" width="31" height="28" hspace="5"></td>
                <td width="94%"bgcolor="#3274a9"><span class="head2"><strong>Search by Location </strong></span></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td valign="top" class="blue_border" >
		   <form action="company.php" method="post" name="location" onsubmit="return validate(this);">
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="inner line left news-inn">
                  <table width="100%" border="0" cellspacing="10" cellpadding="0">
				    <? 
	                 $sql_state=mysql_query("select * from tbl_state  where country_id='98' order by state") or die(mysql_error());
					 $sql_city=mysql_query("select * from tbl_city  order by city_name") or die(mysql_error());
	 
	                   ?>
                    <tr>
                      <th width="102" rowspan="4" align="right" valign="top"><img src="images/magin.gif" width="120" height="80" /> </th>
                      <th width="181" align="right" valign="top"> Select State : </th>
                      <td width="319" valign="top"><select name="u_state" id="u_state" class="list-inn"   onChange="return send_city_request(this.value,7,'',1,1);" title="NOBLANK~Name Of State~DM~">
					   <option value="">---Select State---</option>
					  <?  while($fetch_state=mysql_fetch_array($sql_state))
	                  {
					  ?>
					  <option value="<?=$fetch_state['state_id']?>"><?=$fetch_state['state']?></option>
                         <? }?>
                      </select></td>
                    </tr>
                    <tr>
                      <th align="right"> Select City: </th>
                      <td>  <select name="u_city" id="u_city" class="list-inn"   onChange="return send_city_request(this.value,7,'',1);">
					   <option value="">---Select City---</option>
					
                      </select></td>
                    </tr><input type="hidden" name="city_name_new" value="">
                    <tr>
                      <td align="right"><strong>Keywords : </strong></td>
                      <td><input type="text" name="kewwords" class="field-inn" value=""></td>
                    </tr>
                    <tr>
                      <td height="34" align="right">&nbsp;</td>
                      <td><input name="location" type="submit" class="button" value="Submit"></td>
                    </tr>
                  </table>
				  </form>
				  
				  </td>
            </tr>
          </table></td>
        </tr>
      </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" bgcolor="#3274a9"><img src="images/news-icon.gif" width="31" height="28" hspace="5"></td>
                <td width="94%"bgcolor="#3274a9"><span class="head2"><strong>Search By Product </strong></span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td valign="top" class="blue_border" ><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="inner line left news-inn">
				 <form action="company.php" method="post" name="product" onsubmit="return validate(this);">
                  <table width="100%" border="0" cellspacing="10" cellpadding="0">
                    <tr>
                      <th width="102" rowspan="3" align="right" valign="top"><img src="images/magin.gif" width="120" height="80" /> </th>
                      <th width="181" align="right" valign="top"> Select Category : </th>
                      <td width="319" valign="top"><? 
	                 $sql_category=mysql_query("select * from tbl_category   where cat_status='Active' order by cat_name ") or die(mysql_error());
	 
	                   ?>
					   
						<select name="category" class="list-inn"  >
                            <option value=''>---Select Category---</option>
							
							
					  <?  while($fetch_category=mysql_fetch_array($sql_category))
	                  {
					  ?>
						  <option value="<?=$fetch_category['cat_id']?>"><?=$fetch_category['cat_name']?></option>
                         <? }?>
						 
                        </select></td>
                    </tr>
                    
                    <tr>
                      <td align="right"><strong>Keywords : </strong></td>
                      <td><input type="text" name="keywrds" class="field-inn" value=""></td>
                    </tr>
                    <tr>
                      <td height="34" align="right">&nbsp;</td>
                      <td><input name="product" type="submit" class="button" value="Submit"></td>
                    </tr>
                </table>
				</form>
				</td>
              </tr>
          </table></td>
        </tr>
      </table>
      <br>
      <br>    <? include('footer.php');?>