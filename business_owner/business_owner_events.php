<?php
include('template-parts/header.php');
include('Pagination.php');
?>

<?php
$db->select('tbl_businessowner_subscription', '*', null, 'bar_id =' . $_SESSION['bar_id'] . ' and is_active="Active"', 'id DESC');
$getRows = $db->getResult();
$countRows = count($getRows);


$db->select('bars_list', '*', null, 'id =' . $_SESSION['bar_id'] . ' and is_payasyougo=""', 'id DESC');
$getPayasyougoNull = $db->getResult();
$countPayasyougoNull = count($getPayasyougoNull);
if ($countPayasyougoNull == 0) {
    if ($countRows > 0) {
        $array = array(
            'is_payasyougo' => '2'
        );

        $db->update('bars_list', $array, 'id=' . $_SESSION['bar_id']);
        $is_res = $db->myconn->affected_rows;
    }
}

$db->select('bars_list', '*', null, 'id =' . $_SESSION['bar_id'] . ' and is_payasyougo!=""', 'id DESC');
$getPayasyougo = $db->getResult();
$countPayasyougo = count($getPayasyougo);

if (isset($_POST['AddEvent'])) {


    $eventName = $db->escapeString($_POST['event_name']);
    $eventDescription = $db->escapeString($_POST['event_description']);
    $eventStart = @date('Y-m-d', strtotime($db->escapeString($_POST['event_startdate'])));
    $eventEnd = @date('Y-m-d', @strtotime($db->escapeString($_POST['event_enddate'])));
    $start_time = $db->escapeString($_POST['start_time']);
    $end_time = $db->escapeString($_POST['end_time']);

    $start = @strtotime($eventStart . " " . $start_time);
    $end = @strtotime($eventEnd . " " . $end_time);
    $event_price_vip = $db->escapeString($_POST['event_price_vip']);
    $event_price_basic = $db->escapeString($_POST['event_price_basic']);
    $cancellation_policy = $db->escapeString($_POST['cancellation_policy']);
    $free_event = $db->escapeString($_POST['free_event']);

    $eventtype = $db->escapeString($_POST['eventtype']);

    $db->insert('tbl_events', array('bar_id' => $_SESSION['bar_id'], 'event_name' => $eventName, 'event_description' => $eventDescription, 'event_start' => $eventStart, 'event_end' => $eventEnd, 'event_price_vip' => $event_price_vip, 'event_price_basic' => $event_price_basic, 'cancellation_policy' => $cancellation_policy, 'start_time' => $start_time, 'end_time' => $end_time, 'event_starttimestamp' => $start, 'event_endtimestamp' => $end, 'eventtype' => $eventtype, 'free_event' => $free_event));  // Table name, column names and respective values
    $res = $db->getResult();
    $lastInsertedId = $res[0];

    $sql = "SELECT u.email, u.name from user_register as u join bars_list as b on b.Owner_id = u.id where b.id = " . $_SESSION['bar_id'];
    $exe = $db->myconn->query($sql);
    $userDetails = $exe->fetch_assoc();


    $email = $userDetails['email'];
    //$to1 = $email;
    //$to1 = 'vidhi.scrumbees@gmail.com';
    $to1 = 'info@mybarnite.com';
    $subject1 = 'Mybarnite - New event ';
    $from1 = $email;

    // To send HTML mail, the Content-type header must be set
    $headers1 = 'MIME-Version: 1.0' . "\r\n";
    $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Create email headers
    $headers1 .= 'From: ' . $from1 . "\r\n" .
        'Reply-To: ' . $from1 . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Compose a simple HTML email message
    $message1 = "<html>";
    $message1 .= "<head><title>Mybarnite</title></head>";
    $message1 .= "<body>";
    $message1 .= "Dear Admin,<br/><br/>";
    $message1 .= "New event has been posted , you can find below details :<br/><br/>";
    $message1 .= "Event name : $eventName<br/>";
    $message1 .= "Event type : $eventtype<br/>";
    $message1 .= "Thank you for joining our website.<br/><br/>";
    $message1 .= "Mybarnite Limited<br/>Email: info@mybarnite.com<br/>URL: mybarnite.com<br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
    $message1 .= "</body></html>";

    if (mail($to1, $subject1, $message1, $headers1)) {
        $_SESSION['msg'] = "<div class='alert alert-success'>Data inserted successfully.</div>";
    } else {
        $_SESSION['msg'] = "<div class='alert alert-success'>It seem there is some issue while sending email.</div>";
    }

    /* if($lastInsertedId!="")
    {
        $_SESSION['msg']="<div class='alert alert-success'>Data inserted successfully.</div>";	
    } */

    if ($lastInsertedId != "") {
        global $flag;
        $valid_formats = array("jpg", "png", "gif");
        $path = "uploaded_files/"; // Upload directory
        $count = 0;

        // Loop $_FILES to exeicute all files
        $total = count($_FILES['files']['name']);
        // Loop through each file
        for ($i = 0; $i < $total; $i++) {
            $new_filename = time() . "-" . $_FILES['files']['name'][$i];
            if ($_FILES['files']['error'][$i] == 0) {
                if (!in_array(pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION), $valid_formats)) {
                    $_SESSION['msg'] = "<div class='alert alert-danger'>Event added successfully  but  image can not be uploaded with invalid format.</div>";
                    $flag = 1;
                    // Skip invalid file formats
                } else { // No error found! Move uploaded files 
                    if ($flag != 1) {
                        $new_filename = time() . "-" . $_FILES['files']['name'][$i];
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $path . $new_filename))
                            $count++; // Number of successfully uploaded file
                        //$db->insert('tbl_event_gallery',array('bar_id'=>$_SESSION['bar_id'],'event_id'=>$lastInsertedId,'file_name'=>$eventDescription,'file_path'=>$eventStart,'status'=>$eventEnd,'logo_image'=>$start_time));  // Table name, column names and respective values
                        $db->insert('tbl_event_gallery', array('bar_id' => $_SESSION['bar_id'], 'event_id' => $lastInsertedId, 'file_name' => $new_filename, 'file_path' => $path . $new_filename, 'status' => 1, 'logo_image' => 0));  // Table name, column names and respective values
                        $res1 = $db->getResult();
                        if ($res1 != "") {
                            $flag = 0;
                            $_SESSION['msg'] = "<div class='alert alert-success'>Data has been uploaded successfully, Your uploads will get published after admin approval.</div>";
                        }
                    }


                }
            }
        }

    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Data can not be added.</div>";
    }


}


?>
<!--==============================Map=================================-->
<script type="text/javascript" src="js/custom.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">


</header>
<div class="padcontent"></div>
<!--==============================Content=================================-->


<section id="content" class="main-content">
    <div class="container" id="events_container">
        <?php
        if (isset($_SESSION['business_owner_id'])) {

            if (isset($_SESSION['bar_id'])) {
                $db->select('bars_list', '*', null, 'bar_id =' . $_SESSION['bar_id'], 'id DESC');
                $getBar = $db->getResult();
                $countBar = count($getBar);
                if ($countBar > 0) {
                    $limit = 15;
                    //get number of rows
                    $queryNum = $db->myconn->query("SELECT COUNT(*) as postNum FROM tbl_events where bar_id=" . @$_SESSION['bar_id']);
                    $resultNum = $queryNum->fetch_assoc();
                    $rowCount = $resultNum['postNum'];
                    $numPages = ceil($rowCount / 3);
                    $currentPage = ($numPages - 1) * 3;
                    //initialize pagination class
                    $pagConfig = array('baseURL' => 'getEvents.php', 'totalRows' => $rowCount, 'perPage' => $limit, 'contentDiv' => 'posts_content');
                    $pagination = new Pagination($pagConfig);

                    //get rows
                    //$query = $db->myconn->query("select p.id,p.event_name,p.event_description,p.event_start,p.event_end,p.start_time,p.end_time, group_concat(pi.file_path) as images from tbl_events p join tbl_event_gallery pi on p.id = pi.event_id group by p.id");
                    $query = $db->myconn->query("SELECT * FROM tbl_events where bar_id=" . @$_SESSION['bar_id'] . " ORDER BY id DESC LIMIT $limit");
                    ?>

                    <div class="row">
                        <div class="clearfix ">
                            <div class="span4"></div>
                            <div class="span3">
                                <h2>Add Event</h2>

                            </div>
                            <div class="span5 pink" style="font-size: 16px;"><input type="checkbox"
                                                                                    class="form-control chkbox"
                                                                                    id="freeEventOption"
                                                                                    name="freeEventOption"
                                                                                    style="vertical-align:top"> Free
                                Entry
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="span3"></div>
                        <div class="span6">
                            <div class="event-form">

                                <?php

                                if (isset($_SESSION['msg'])) {
                                    ?>
                                    <div class="control-group"><?php echo $_SESSION['msg']; ?></div>
                                    <?php

                                    unset($_SESSION['msg']);
                                    unset($_SESSION['success_msg']);
                                }
                                if (isset($_SESSION['success_msg'])) {
                                    echo $_SESSION['success_msg'];
                                    unset($_SESSION['msg']);
                                    unset($_SESSION['success_msg']);
                                }
                                ?>
                                <?php
                                if ($countRows == 0 && $countPayasyougo == 0) {
                                    ?>
                                    <div class="alert alert-danger" style="font-size:15px;">For adding new event you
                                        need to either choose Pay as you go option or purchase subscription! For that
                                        please - <a href="business_owner_subscription.php">click here</a></div>
                                    <?php
                                }
                                ?>
                                <form class="form-inline" role="form" id="bar_events" method="post"
                                      enctype="multipart/form-data">

                                    <input type="hidden" class="form-control" id="free_event" name="free_event"
                                           value="">
                                    <div class="form-group">
                                        <label for="event_name" class="pull-left">Event name :</label>
                                        <input type="text" class="form-control" id="event_name" name="event_name"
                                               required placeholder="Event Name...">
                                    </div>
                                    <div class="form-group">
                                        <label for="event_description" class="pull-left">Description :</label>
                                        <textarea class="form-group" id="event_description" name="event_description"
                                                  placeholder="Event Description..."></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="event_startdate" class="pull-left date start">Event starts :</label>
                                        <input type="text" required class="form-control date start pull-left"
                                               id="event_startdate" name="event_startdate" placeholder="mm/dd/yyyy"/>
                                        <input type="text" class="time start" id="timepicker1" name="start_time"
                                               placeholder="Starting time..."/>
                                    </div>
                                    <div class="form-group">
                                        <label for="event_startdate" class="pull-left">Event ends :</label>
                                        <input type="text" required class="form-control  date end pull-left"
                                               id="event_enddate" name="event_enddate" placeholder="mm/dd/yyyy"/>
                                        <input type="text" class="time end" id="timepicker2" name="end_time"
                                               placeholder="Ending time..."/>
                                    </div>

                                    <div class="form-group" id="vip">
                                        <label for="event_name" class="pull-left">Price - VIP (&pound;):</label>
                                        <input type="number" class="form-control" id="event_price_vip"
                                               name="event_price_vip" placeholder="Event Price...">
                                    </div>
                                    <div class="form-group" id="basic">
                                        <label for="event_name" class="pull-left">Price - Basic (&pound;):</label>
                                        <input type="number" class="form-control" id="event_price_basic"
                                               name="event_price_basic" placeholder="Event Price...">
                                    </div>
                                    <div class="form-group">
                                        <label for="event_name" class="pull-left">Cancellation:</label>
                                        <select class="form-control" id="cancellation_policy"
                                                name="cancellation_policy">
                                            <option value="1">Free cancellation</option>
                                            <option value="2">Cancellation Policy</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="eventtype" class="pull-left">Event Type:</label>
                                        <select name="eventtype" id="eventtype" class="form-control">
                                            <option value="latest">Latest Event</option>
                                            <option value="upcoming">Upcoming Event</option>
                                            <option value="special">Special Event</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="event_name" class="pull-left">Upload image :</label>
                                        <input type="file" id="file" name="files[]" multiple="multiple"
                                               accept="image/*"/>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                        if ($countRows == 0 && $countPayasyougo == 0) {
                                            ?>
                                            <button type="submit" id="AddEvent" name="AddEvent" value="Add Event"
                                                    class="btn btn-info submitEvent bg-pink" disabled="disabled"
                                                    style="opacity:0.5 !important">Add
                                            </button>
                                        <?php } else {
                                            ?>
                                            <button type="submit" id="AddEvent" name="AddEvent" value="Add Event"
                                                    class="btn btn-info submitEvent bg-pink">Add
                                            </button>
                                            <?php
                                        }
                                        ?>
                                        <button type="button" id="reset" name="reset" value="reset"
                                                class="btn btn-info submitEvent bg-pink">Reset
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>
                    <hr>
                    <?php
                    if ($query->num_rows > 0) {
                        ?>
                        <div class="row">
                            <div class="clearfix ">
                                <div class="span5"></div>
                                <div class="span6">
                                    <h2>Events</h2>

                                </div>
                                <div class="span5"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="span2"></div>
                            <div class="span8">


                                <div class="panel-group" id="post_contents">
                                    <?php

                                    while ($row = $query->fetch_assoc()) {
                                        $postID = $row['id'];

                                        $db->select('tbl_event_gallery', 'id,file_path,file_name,logo_image', NULL, 'event_id=' . $row['id'] . ' and is_published = 1', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
                                        $images = $db->getResult();
                                        /* echo "<pre>";
                                        print_r($images); */
                                        $isAvailable = ($row['is_availableForBooking'] == "Booked") ? "<a href='#' class='pull-right' style='color:#ff0000;font-size:12px;margin:0;'>Fully Booked</a>" : "<a href='#' class='pull-right' style='color:#3c763d;font-size:12px;margin:0;'>Available For Booking</a>";

                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading" data-toggle="collapse"
                                                 data-target="#collapse<?php echo $row['id']; ?>">
                                                <h2 class="panel-title" id="title<?php echo $row['id']; ?>">
                                                    <a data-toggle="collapse"
                                                       href="#collapse<?php echo $row['id']; ?>"><?php echo $row['event_name']; ?> </a>
                                                    <?php echo $isAvailable; ?>
                                                </h2>
                                            </div>
                                            <div id="collapse<?php echo $row['id']; ?>" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <div class="span7"
                                                         style="padding: 10px;margin-left:0px"><?php echo $row['event_description']; ?></div>
                                                    <div class="span7" style="padding: 10px;margin-left:0px">
                                                        <h6>Event Timings :</h6>
                                                        <p>
                                                            Event Date
                                                            : <?php echo @date("m/d/Y", @strtotime($row['event_start'])) . " - " . @date("m/d/Y", @strtotime($row['event_end'])); ?>
                                                        </p>
                                                        <p>
                                                            Event Timings
                                                            : <?php echo $row['start_time'] . " - " . $row['end_time']; ?>
                                                        </p>
                                                        <?php if ($row['free_event'] != '1') { ?>
                                                            <p>
                                                                VIP Price
                                                                (&pound;): <?php echo ($row['event_price_vip']) ? $row['event_price_vip'] : '0.00'; ?>
                                                            </p>
                                                            <p>
                                                                Basic Price
                                                                (&pound;): <?php echo ($row['event_price_basic']) ? $row['event_price_basic'] : '0.00'; ?>
                                                            </p>
                                                        <?php } ?>

                                                        <?php if ($row['free_event'] == '1') { ?>
                                                            <p>
                                                                Free entry: Yes
                                                            </p>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <p>
                                                                Free entry: No
                                                            </p>
                                                            <?php
                                                        }
                                                        ?>
                                                        <p>
                                                            Cancellation
                                                            policy: <?php echo ($row['cancellation_policy'] == 1) ? "Free Cancellation" : "Cancellation Policy"; ?>
                                                        </p>
                                                    </div>

                                                    <div class="span6 imageHolder" style="padding-bottom: 10px;">
                                                        <?php
                                                        if (!empty($images)) {
                                                            ?>
                                                            <ul class="img-list"
                                                                id="image_container_<?php echo $row['id']; ?>">
                                                                <?php
                                                                $i = 1;
                                                                foreach ($images as $image) {
                                                                    if (file_exists($image['file_path'])) {
                                                                        $caption = ($image['logo_image'] == 1 ? "REMOVE LOGO" : "MAKE LOGO");
                                                                        ?>

                                                                        <li>
                                                                            <a accordion-toggle
                                                                               href="javascript:void(0);">
                                                                                <img src="<?php echo $image['file_path']; ?>"
                                                                                     width="150" height="150"/>
                                                                                <?php if ($image['logo_image'] == 1) { ?>
                                                                                    <div class="cssarrow"><i
                                                                                                class="fa fa-check fa-2x"
                                                                                                style="position: absolute;top: 1px;right: -47px;color: white;"
                                                                                                aria-hidden="true"></i>
                                                                                    </div>
                                                                                <?php } ?>
                                                                                <span class="text-content">
																<span onclick="delete_event_image(<?php echo $image['id']; ?>,<?php echo $row['id']; ?>);"><i
                                                                            class="fa fa-trash-o fa-3x"
                                                                            aria-hidden="true"></i></span>
																<span onclick="event_logo_image(<?php echo $image['id']; ?>,<?php echo $image['logo_image']; ?>,<?php echo $row['id']; ?>);"><?php echo $caption; ?></span>
															</span>
                                                                            </a>
                                                                        </li>


                                                                        <?php
                                                                    }

                                                                    $i++;
                                                                }
                                                                ?>
                                                            </ul>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="span6">
                                                        <form role='form' method='post'
                                                              id="form<?php echo $row['id']; ?>"
                                                              action='business_owner_editEvent.php'>
                                                            <input type='hidden' name='event_id'
                                                                   value="<?php echo $row['id']; ?>" id='event_id'/>
                                                            <input style="border: none;" class='btn btn-info bg-pink'
                                                                   type='submit' value='Edit' name='UpdateItem'/>
                                                            <input style="border: none;" class='btn btn-info bg-pink'
                                                                   type='button' value='Delete'
                                                                   onclick='manageEvents(<?php echo $row['id']; ?>,<?php echo $currentPage; ?>)'
                                                                   name='DeleteItem'/>
                                                            <input style="border: none;"
                                                                   class='btn btn-danger pull-right' type='button'
                                                                   value='Fully Booked'
                                                                   onclick='isAvailableForBooking(<?php echo $row['id']; ?>,"Booked")'
                                                                   name='booked' <?php echo $isDisable = ($row['is_availableForBooking'] == "Booked") ? "readonly" : ""; ?> />
                                                            <input style="border: none;"
                                                                   class='btn btn-success pull-right' type='button'
                                                                   value='Booking Available'
                                                                   onclick='isAvailableForBooking(<?php echo $row['id']; ?>,"Available")'
                                                                   name='availforbook' <?php echo $isDisable = ($row['is_availableForBooking'] == "Available") ? "readonly" : ""; ?> />
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="panel-body"></div>
                                            </div>

                                        </div>

                                        <?php
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>

                        <?php
                    }
                }
            } else {
                ?>
                <div class="row text-center">
                    <div class="span12">
                        <h5 class="alert alert-danger h5-notregisteredbar">You can not able to access this page because
                            your Bar / Business has not been registered yet.<br/> Please <a
                                    href="business_owner_edit_profile.php"> register your Business </a> here.</h5>

                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="row ">
                <div class="clearfix ">
                    <div class="span12">
                        <h5>You are not Logged in yet. Please <a href="business_owner_signin.php">login </a></h5>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</section>


<?php include 'template-parts/footer.php'; ?>
<script>
    $('#bar_events .time').timepicker({
        'showDuration': true,
        'timeFormat': 'g:ia'
    });

    $('#bar_events .date').datepicker({
        'format': 'mm/dd/yyyy',
        'autoclose': true
    });

    $('#bar_events').datepair();
</script>

<script>

    $(document).ready(function () {

        $('#freeEventOption').click(function () {
            if (!$(this).is(':checked')) {
                // alert('unchecked');
                $("#vip").css("display", "block");
                $("#basic").css("display", "block");
                $("#free_event").val("0");
            } else {
                //alert('checked');
                $("#vip").css("display", "none");
                $("#basic").css("display", "none");
                $("#free_event").val("1");
            }
        });

        <?php
        if($countRows == 0 && $countPayasyougo == 0)
        {
        ?>
        $('#myModal').modal('show');
        $("input[name='subType']").click(function () {
            subType = this.value;
            //alert(subType);

            if (subType == '1') {
                $.ajax({
                    url: "<?php echo SITE_PATH;?>business_owner/changeSubscription.php",
                    type: "POST",
                    data: {user: "Owner", subType: subType},

                    success: function (result) {
                        //alert(result);
                        //console.log(result);
                        window.location = "business_owner_events.php";
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            }
            if (subType == '2') {
                window.location = "business_owner_subscription.php";
            }


        });
        <?php
        }
        ?>

        $("#reset").click(function () {
            $.ajax({
                url: "removeSession.php",
                type: "POST",
                success: function (result) {
                    window.location = "business_owner_events.php";
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });

        });
    });
</script>