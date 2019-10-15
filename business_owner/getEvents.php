<?php


    //Include pagination class file
    
    
    //Include database configuration file
    include('common.php');
    
    
	$itemId = @$_POST['itemId'];
	if($itemId!="")
	{
		$db->delete('tbl_events','id='.$itemId.' and bar_id ='.$_SESSION['bar_id']);  // Table name, WHERE conditions
		$res = $db->getResult(); 	
	}	
	
    //get number of rows
    /* $queryNum = $db->myconn->query("SELECT COUNT(*) as postNum FROM tbl_events where bar_id=".@$_SESSION['bar_id']);
    $resultNum = $queryNum->fetch_assoc();
    $rowCount = $resultNum['postNum'];
    $numPages = ceil($rowCount / 3);
    $currentPage = ($numPages - 1) * 3;
    //initialize pagination class
    $pagConfig = array('baseURL'=>'getEvents.php', 'totalRows'=>$rowCount, 'currentPage'=>$start, 'perPage'=>$limit, 'contentDiv'=>'posts_content');
    $pagination =  new Pagination($pagConfig); */
    
    //get rows
    $query = $db->myconn->query("SELECT * FROM tbl_events where bar_id=".@$_SESSION['bar_id']." ORDER BY id DESC");
    
    if($query->num_rows > 0){ 
        $content = "";
				
				
					while($row = $query->fetch_assoc())
					{ 
							$postID = $row['id'];
							
							$db->select('tbl_event_gallery','id,file_path',NULL,'event_id='.$row['id'],'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
							$images = $db->getResult();
							if($row['is_availableForBooking']=="Available"){
								$available = "readonly";
								
							}
							if($row['is_availableForBooking']=="Booked"){
								$booked = "readonly";
								
							}
							$content .= "<div class='panel panel-default'>
											<div class='panel-heading' data-toggle='collapse' data-target='#collapse'".$row['id']."'>
												<h2 class='anel-title'>
													<a data-toggle='collapse'  href='#collapse".$row['id']."'>".$row['event_name']."</a>
												</h2>
											</div>
											<div id='collapse".$row['id']."'  class='panel-collapse collapse'>
												<div class='panel-body'>
													<div class='span7' style='padding: 10px;margin-left:0px'>".$row['event_description']."</div> 
													
														
													<div class='span6 imageHolder' style='padding-bottom: 10px;'>";
													
													if(!empty($images))
														
									$content .= 	"<ul class='img-list'  id='image_container_".$row['id']."'>";
													
														$i=1;
														foreach($images as $image)
														{	
									$content .= 	"	    <li>
																<a  accordion-toggle href='javascript:void(0);' onclick='delete_event_image(".$image['id'].",".$row['id']."'>
																  <img src='".$image['file_path']."' width='150' height='150' />
																  <span class='text-content'><span><i class='fa fa-trash-o fa-3x' aria-hidden='true'></i></span></span>
																</a>
															  </li>";
															 
															
														
														$i++;
														}
														
									$content .= 	"</ul>";	
														
					}									
													
									$content .= 	"</div>									
														<div class='span2'>
															<form role='form' method='post' action='business_owner_editEvent.php'>
																<input type='hidden' name='event_id' value='".$row['id']."' id='event_id' />
																<input class='btn btn-info bg-pink' type='submit' value='Edit' name='UpdateItem' />
																<input class='btn btn-info bg-pink' type='button' value='Delete' onclick='manageEvents(".$row['id'].")' name='DeleteItem' />
																<input style='border: none;' class='btn btn-danger pull-right' type='button' value='Fully Booked' onclick=isAvailableForBooking(".$row['id'].",'Booked') name='booked' ".@$booked." />
																<input style='border: none;' class='btn btn-success pull-right' type='button' value='Booking Available' onclick=isAvailableForBooking(".$row['id'].",'Available') name='availforbook' ".@$available." />
															</form>
														</div>			
													</div>
											</div>
											
										</div>";
				} 
				$content .="</tbody>
			</table>
        </div>";
     //echo $content.= $pagination->createLinks(); 
	 echo $content;



?>