(function($){


	
});	

function deleteMutipleSubUsers()
{
	if ($('.chkbox:checked').length != 0) 
	{
		var SelectedIDs = [];
		$('.chkbox:checked').each(function (i) {
			SelectedIDs.push($(this).attr('id'));
		});
		var Ids = SelectedIDs.join(";")
	}
	
	 $.ajax({
		url : "http://mybarnite.com/business_owner/deleteSubUser.php",
		type: "POST",
		data :{ Ids :Ids, action : 'Multiple' },
		
		success: function(result)
		{	
			//alert(result);
			window.location="sub_user.php";	
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
		}
	});	
	
}

function deleteSubUser(id)
{
	//alert(role);
	$.ajax({
		url : "http://mybarnite.com/business_owner/deleteSubUser.php",
		type: "POST",
		data :{ subuser_id:id},
		
		success: function(result)
		{	
			
			window.location="sub_user.php";	
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			
		}
	});
}

function changeAccountStatus(id,accountStatus,role)
{
	//alert(role);
	$.ajax({
		url : "http://mybarnite.com/business_owner/changeAccountStatus.php",
		type: "POST",
		data :{ id:id,accountStatus:accountStatus,role:role},
		
		success: function(result)
		{		//alert(result);
				if(role==1)
					{
						window.location="business_owner_account.php";	
					}
					if(role==2)
					{
						window.location="account.php";	
					}		
			
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			
		}
	});
}

function deleteAccount(id,role)
{	
			
			$.ajax({
				url : "http://mybarnite.com/business_owner/deleteAccountDetails.php",
				type: "POST",
				data :{ id:id,role:role},
				
				success: function(result)
				{	
					if(role==1)
					{
						window.location="business_owner_account.php";	
					}
					if(role==2)
					{
						window.location="account.php";	
					}					
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					
				}
			});
		
}

function isAvailableForBooking(id,action)
	{
		
		$.ajax({
				url : "isAvailableForBooking.php",
				type: "POST",
				data :{ eventid: id, action:action},
				
				success: function(result)
				{	
					
					$("#title"+id).html(result);
					getBookingStatus(id);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					
				}
			});
	}
function getBookingStatus(id)
{
	$.ajax({
				url : "getBookingStatus.php",
				type: "POST",
				data :{ eventid: id},
				
				success: function(result)
				{	
					
					$("#form"+id).html(result);
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					
				}
			});
}
function manageEvents(id)
	{
		//alert(id);
		$.ajax({
				url : "getEvents.php",
				type: "POST",
				data :{ itemId: id},
				
				success: function(result)
				{	
					
					//data - response from server
					//$("#posts_content").html(result);
					//alert(result);
					window.location = "business_owner_events.php";
					scrollTop: $("#posts_list").offset().top
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$("#posts_content").html("<div class='alert alert-danger'>System error occured.</div>");
				}
			});
	}
	 
function delete_event_image(id,event_id)
	{
			$.ajax({
				url : "deleteEventImage.php",
				type: "POST",
				data :{ img_id: id,event_id:event_id },
				
				success: function(result)
				{	
					//$("#image_container_"+event_id).html(result);
					$(".img-list").html(result);
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
				}
			});
	} 
function event_logo_image(id,logo_image,event_id)
{
		//alert(id+" = "+logo_image);
		$.ajax({
			url : "eventLogoImage.php",
			type: "POST",
			data :{ img_id: id,status:logo_image,event_id:event_id,user:"Owner"},
			
			success: function(result)
			{	
			
				//alert(result);
				//data - response from server
				$("#image_container_"+event_id).html(result);
				//window.location="business_owner_gallary.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
			}
		}); 
}	
function cancel_order(id,event_id,owner_id)
	{
		//alert(id+" = "+logo_image);
		$.ajax({
			url : "cancel_order.php",
			type: "POST",
			data :{ id: id,owner_id:owner_id,action:"Cancel"},
			
			success: function(result)
			{	
			
				window.location="business_owner_orders.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				
			}
		}); 
	}	
	function delete_order(id,owner_id)
	{
		
		$.ajax({
			url : "cancel_order.php",
			type: "POST",
			data :{ id: id,owner_id:owner_id,action:"Delete"},
			
			success: function(result)
			{	
			
				window.location="business_owner_orders.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				
			}
		}); 
	}
function deleteSubscription(id,ownerid,barid)
	{
			$.ajax({
				url : "deleteSubscription.php",
				type: "POST",
				data :{ id: id,ownerid:ownerid,barid:barid },
				
				success: function(result)
				{	
					//alert(result);
					//$("#image_container_"+event_id).html(result);
					window.location="business_owner_subscription.php";
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
				}
			});
	} 
	
	
	
function gettotalpurchase()
{
	
	var startdate = $("#startdate").val();
	var enddate = $("#enddate").val();
	date1=new Date(startdate.split("/")[2], startdate.split("/")[0], startdate.split("/")[1]);
	date2=new Date(enddate.split("/")[2], enddate.split("/")[0], enddate.split("/")[1]);
	if(date1>date2)
	{
		$("#msg").html("please select proper dates!").show().fadeOut( 8000 );return false;
	}
	else
	{
		$.ajax({
			url : "gettotalpurchase.php",
			type: "POST",
			data :{ startdate:startdate ,enddate:enddate},
			
			success: function(result)
			{	
				//alert(result);
				//console.log(result);
				
				$("#amount").html("&#8356; "+result)
				//window.location="business_owner_orders.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				
			}
		});
	}		
	
}	
function deletePromotion(id)
{
	
	$.ajax({
				url : "deletePromotion.php",
				type: "POST",
				data :{ id: id},
				
				success: function(result)
				{	
					   window.location="business_owner_promotions.php";
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
				}
			});
}

function checkCouponCode(code,action,id)
	{
		$.ajax({
				url : "checkCouponCode.php",
				type: "POST",
				data :{code:code,action:action,id:id},
				success: function(result)
				{	
					//alert(result);
					
					$("#generate").html(result);
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					
				}
			});
	}
	
	
	function generateCouponCode(code,action,id)
	{
		$.ajax({
				url : "generateCouponCode.php",
				type: "POST",
				data :{code:code,action:action,id:id},
				success: function(result)
				{	
					//alert(result);
					$("#code").val(result);
					$("#generate").html('<i class="fa fa-check pink" style="font-size:20px;"></i>');
					
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					
				}
			});
	}
	function selectAll(source) {
		checkboxes = document.getElementsByName('chk[]');
		for(var i in checkboxes)
			checkboxes[i].checked = source.checked;
			
	}