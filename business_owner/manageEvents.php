<?php
echo $_POST['page'];exit;
if(isset($_POST['page'])){
    //Include pagination class file
    include('Pagination.php');
    
    //Include database configuration file
    include('common.php');
    
    $start = !empty($_POST['page'])?$_POST['page']:0;
    $limit = 15;
    
	echo $itemId = @$_POST['itemId'];
	if($itemId!="")
	{
		$db->delete('tbl_events','id='.$itemId.' and bar_id ='.$_SESSION['bar_id']);  // Table name, WHERE conditions
		$res = $db->getResult(); 	
	}	
	
    //get number of rows
    $queryNum = $db->myconn->query("SELECT COUNT(*) as postNum FROM tbl_events where bar_id=".@$_SESSION['bar_id']);
    $resultNum = $queryNum->fetch_assoc();
    $rowCount = $resultNum['postNum'];
    
    //initialize pagination class
    $pagConfig = array('baseURL'=>'getEvents.php', 'totalRows'=>$rowCount, 'currentPage'=>$start, 'perPage'=>$limit, 'contentDiv'=>'posts_content');
    $pagination =  new Pagination($pagConfig);
    
    //get rows
    $query = $db->myconn->query("SELECT * FROM tbl_events where bar_id=".@$_SESSION['bar_id']." ORDER BY id DESC LIMIT $start,$limit");
    
    if($query->num_rows > 0){ 
        $content = "<div class='posts_list'>
			<table class='table' id='menuItems'>
				<thead>
					<tr>
						<th>No.</th>
						<th>Event Name</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th></th>
					</tr>
				</thead>
				<tbody>";
				
					$i=1;
					while($row = $query->fetch_assoc()){ 
						$postID = $row['id'];
				
				$content .= "<tr>
								<td>". $i."</td>
								<td>".$row['event_name']."</td>
								<td>".$row['event_start']."</td>
								<td>".$row['event_end']."</td>
								<td colspan='2'>
									<form role='form' method='post' action='business_owner_editEvent.php'>
										<input type='hidden' name='event_id' value=".$row['id']." id='event_id' />
										<input class='btn btn-info' type='submit' value='Edit' name='UpdateItem' />
										<input class='btn btn-info' type='button' value='Delete' onclick='manageEvents(".$row['id'].")' name='DeleteItem' />
									</form>
									
								</td>
							</tr>";
				 $i++;} 
				$content .="</tbody>
			</table>
        </div>";
     $content.=$pagination->createLinks(); 
}
echo $content;
}
?>