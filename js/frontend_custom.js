(function($){

	
	
	
			
});	
function delete_image(id)
	{
			$.ajax({
				url : "deleteUserImage.php",
				type: "POST",
				data :{ img_id: id },
				
				success: function(result)
				{	
					
					//$("#gallery").html(result);
					window.location="user_gallery.php";
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
				}
			});
	}
function addToFavourite(id,barid,action)	
{
	$.ajax({		
		url : "ajax/addToFavourite.php",
		type: "POST",
		data :{ id:id, barid: barid ,action : action},
		success: function(result)
		{	
			window.location = "myfavourites.php";
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
		}
	});	
}
function event_logo_image(id,logo_image)
	{
		//alert(id+" = "+logo_image);
		$.ajax({
			url : "eventLogoImage.php",
			type: "POST",
			data :{ img_id: id,status:logo_image},
			
			success: function(result)
			{	
			
				//alert(result);
				//data - response from server
				$(".img-list").html(result);
				//window.location="business_owner_gallary.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
			}
		}); 
	}

	function cancel_order(id,user_id)
	{
		//alert(id+" = "+logo_image);
		$.ajax({
			url : "cancel_order.php",
			type: "POST",
			data :{ id: id,user_id:user_id,action:"Cancel"},
			
			success: function(result)
			{	
			
				//alert(result);
				//data - response from server
				//$(".img-list").html(result);
				window.location="orders.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
			}
		}); 
	}	
	function delete_order(id,user_id)
	{
		//alert(id+" = "+logo_image);
		$.ajax({
			url : "cancel_order.php",
			type: "POST",
			data :{ id: id,user_id:user_id,action:"Delete"},
			
			success: function(result)
			{	
			
				//alert(result);
				//data - response from server
				//$(".img-list").html(result);
				window.location="orders.php";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				//$("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
			}
		}); 
	}	
	
	
	