<?php
include('template-parts/header.php');

$id = @$_SESSION['business_owner_id'];

$db->select('user_register', '*', NULL, 'id="' . $id . '" and r_id="1"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$result = $db->getResult();
$_SESSION['msg'] = "";

$db->select('bars_list', '*', NULL, 'Owner_id="' . $id . '"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
$barDetails = $db->getResult();

if ($barDetails[0]['free_booking'] == 1) {
    //if it free booking	
    $barDetails[0]['entry_fee'] = 0;
}

?>

<?php
if (isset($_POST['editprofile'])) {

    /* echo "<pre>";
    print_r($_POST);
    exit; */

    //$name = $db->escapeString($_POST['name']);
    //$email = $db->escapeString($_POST['email']);
    //$password = isset($_POST['password']) ? $db->escapeString($_POST['password']) : "";
    $number = $db->escapeString($_POST['number']);
    $barname = $db->escapeString($_POST['barname']);
    $category_searched = $db->escapeString($_POST['category_searched']);
    $price_range = $db->escapeString($_POST['price_range']);
    $established_year = $db->escapeString($_POST['established_year']);
    $location = $db->escapeString($_POST['location']);
    $Zipcode = $db->escapeString($_POST['Zipcode']);
    $opening_time = $db->escapeString($_POST['opening_time']);
    $is_hall_available = $db->escapeString($_POST['is_hall_available']);
    $hall_capacity = $db->escapeString($_POST['hall_capacity']);
    $hall_fee = $db->escapeString($_POST['hall_fee']);
    $discount = $db->escapeString($_POST['discount']);
    $no_of_seats_basic = $db->escapeString($_POST['no_of_seats_basic']);
    $cost_per_seat = $db->escapeString($_POST['cost_per_seat']);
    $description = $db->escapeString($_POST['description']);
    $Rating = $db->escapeString($_POST['Rating']);


    $val = getLnt($Zipcode);
    $Longitude = $val['lng'];
    $Latitude = $val['lat'];

    if ($number) {
        if (!is_numeric($number)) $form->setError("number", "Invalid Contact No");
        else if (strlen($number = trim($number)) < 10 || strlen($number = trim($number)) > 18) $form->setError("number", "Contact No should be in between 10 to 18 digits");
    } else $form->setError("number", "Contact No. not entered");
    if (!$barname || strlen($barname = trim($barname)) == 0) $form->setError("barname", "Barname can not be empty.");
    if (!$category_searched || strlen($category_searched = trim($category_searched)) == 0) $form->setError("category", "Category can not be empty.");
    if (!$location || strlen($location = trim($location)) == 0) $form->setError("location", "Location can not be empty.");
    if (!$Zipcode || strlen($Zipcode = trim($Zipcode)) == 0) $form->setError("Zipcode", "Postcode can not be empty.");
    else {
        if (strlen(trim($Zipcode)) > 10) {
            $form->setError("Zipcode", "Invalid Postcode.");
        }

    }
    if ($is_hall_available == 1) {
        //if hall is available
        if (!$hall_fee || strlen($hall_fee = trim($hall_fee)) == 0) $form->setError("hall_fee", "Hall fee can not be empty.");
        if (!$hall_capacity || strlen($hall_capacity = trim($hall_capacity)) == 0) $form->setError("hall_capacity", "hall capacity can not be empty.");

    }
    if (!$no_of_seats_basic || strlen($no_of_seats_basic = trim($no_of_seats_basic)) == 0) $form->setError("no_of_seats_basic", "Please enter total number of seat for Basic.");
    if (!$cost_per_seat || strlen($cost_per_seat = trim($cost_per_seat)) == 0) $form->setError("cost_per_seat", "Cost per seat can not be empty.");

    if ($Rating != "") {
        if (!is_numeric($Rating)) {

            $form->setError("Rating", "Invalid Ratings.");
        } elseif ($Rating > 5) {
            $form->setError("Rating", "Ratings should be out of five.");
        }


    }


    if ($form->num_errors > 1 || $form->num_errors == 1) {
        //$_SESSION['value_array'] = $_POST;
        //$_SESSION['error_array'] = $form->getErrorArray();
    } else {

        $db->select('bars_list', '*', NULL, 'Owner_id="' . $_SESSION['business_owner_id'] . '"', 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
        $barDetails1 = $db->getResult();
        if (!empty($barDetails1)) {
            if ($free_booking == 1) {
                //if free booking
                $entry_fee = $free_booking;
            }
            $array = array(

                'PhoneNo' => $number,
                'Business_Name' => $barname,
                'Category_Searched' => $category_searched,
                'is_hall_available' => $is_hall_available,
                'hall_capacity' => $hall_capacity,
                'hall_fee' => $hall_fee,
                'discount' => $discount,
                'cost_per_seat' => $cost_per_seat,
                'seat_for_basic' => $no_of_seats_basic,
                'description' => $description,
                'Category' => $category_searched,
                'Price_Range' => $price_range,
                'Longitude' => $Longitude,
                'Latitude' => $Latitude,
                'Established_Year' => $established_year,
                'Location_Searched' => $location,
                'Zipcode' => $Zipcode,
                'Hours' => $opening_time,
                'Rating' => $Rating

            );
            
            if($barDetails1[0]['Business_Name'] == ''){
                $array['is_requestedForClaim'] = 1;
                
                $to = 'info@mybarnite.com';

                $msg = "<html>";
                $msg .= "<head><title>Mybarnite</title></head>";
                $msg .= "<body>";
                $msg .= "Dear Admin,<br/><br/>";
                $msg .= "New business claim has been requested.<br/><br/>";
                $msg .= "Business id : " . $barDetails1[0]['id'] . "<br/>";
                $msg .= "Business Name : " . $barname . "<br/>";
                $msg .= "Owner Name : " . $_SESSION['business_owner_name'] . "<br/>";
                $msg .= "Owner Email : " . $_SESSION['business_owner_email'] . "<br/>";
                $msg .= "Owner Contact No : " . $number . "<br/>";
                $msg .= "<br/>Mybarnite Limited<br/>Email: <a href='mailto:info@mybarnite.com'>info@mybarnite.com</a><br/>URL: <a href='http://mybarnite.com'>mybarnite.com</a><br/><br/><img src='http://mybarnite.com/images/Picture1.png' width='110'>";
                $msg .= "</body></html>";
                $subj = 'Notification : Business Claim';
                $from = $_SESSION['business_owner_email'];
    
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= "From: " . $_SESSION['business_owner_email'] . "\r\n" . "";
                mail($to, $subj, $msg, $headers);
                
            }

            
            $db->update('bars_list', $array, 'Owner_id="' . $_SESSION['business_owner_id'] . '"'); // Table name, column names and values, WHERE conditions
            $res = $db->getResult();
            $barId = @$barDetails1[0]['id'];
        } else {
            $array = array(
                'Owner_id' => $_SESSION['business_owner_id'],
                'PhoneNo' => $number,
                'Business_Name' => $barname,
                'Category_Searched' => $category_searched,
                'is_hall_available' => $is_hall_available,
                'hall_capacity' => $hall_capacity,
                'hall_fee' => $hall_fee,
                'discount' => $discount,
                'cost_per_seat' => $cost_per_seat,
                'seat_for_basic' => $no_of_seats_basic,
                'description' => $description,
                'Category' => $category_searched,
                'Price_Range' => $price_range,
                'Longitude' => $Longitude,
                'Latitude' => $Latitude,
                'Established_Year' => $established_year,
                'Location_Searched' => $location,
                'Zipcode' => $Zipcode,
                'Hours' => $opening_time,
                'Rating' => $Rating,
                'free_booking' => $free_booking,
                'is_requestedForClaim' => 1

            );
            $db->insert('bars_list', $array);  // Table name, column names and respective values
            $res = $db->getResult();
            $barId = @$res[0];
        }

        /* echo "<pre>";
        print_r($res); */
        $_SESSION['bar_id'] = $barId;
        if (!empty($res)) {
            $_SESSION['msg'] = '<div class="alert alert-success">Profile has been updated successfully!!</div>';
            header("location:manage_bar_profile.php");
        } else {
            $_SESSION['msg'] = "";
            header("location:edit_bar_profile.php");
        }
    }


}
?>


    <!--==============================Map=================================-->


    </header>
    <div class="padcontent"></div>

    <!--==============================Content=================================-->
    <section id="content" class="main-content">
        <div class="container">
            <div class="row">

                <div class="span4"></div>
                <div class="span4">
                    <center>
                        <h2>MANAGE BAR PROFILE</h2>
                    </center>
                </div>
                <div class="span4"><a href="manage_bar_profile.php" class="btn btn-info submitEvent bg-pink pull-right">Back
                        to bar detail</a></div>

            </div>
            <div class="row" style="margin-left: 0;">
                <div id="fields" class="contact-form">

                    <form id="ajax-contact-form" class="form-horizontal edit_profile" method="post">
                        <?php if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        } ?>

                        <?php
                        /* if(isset($_POST['name']))
                            $barDetails[0]['name']=$_POST['name'];
                        else
                            $barDetails[0]['name']=@$barDetails[0]['name'];
                        
                        if(isset($_POST['email']))
                            $barDetails[0]['email']=$_POST['email'];
                        else
                            $barDetails[0]['email']=@$barDetails[0]['email'];
                         */
                        if (isset($_POST['number']))
                            $barDetails[0]['PhoneNo'] = $_POST['number'];
                        else
                            $barDetails[0]['PhoneNo'] = @$barDetails[0]['PhoneNo'];


                        if (isset($_POST['barname']))
                            $barDetails[0]['Business_Name'] = $_POST['barname'];
                        else
                            $barDetails[0]['Business_Name'] = $barDetails[0]['Business_Name'];

                        if (isset($_POST['description']))
                            $barDetails[0]['description'] = $_POST['description'];
                        else
                            $barDetails[0]['description'] = $barDetails[0]['description'];

                        if (isset($_POST['category_searched']))
                            $barDetails[0]['Category'] = $_POST['category_searched'];
                        else
                            $barDetails[0]['Category'] = $barDetails[0]['Category'];

                        if (isset($_POST['established_year']))
                            $barDetails[0]['established_year'] = $_POST['established_year'];
                        else
                            $barDetails[0]['established_year'] = @$barDetails[0]['established_year'];

                        if (isset($_POST['location']))
                            $barDetails[0]['Location_Searched'] = $_POST['location'];
                        else
                            $barDetails[0]['Location_Searched'] = $barDetails[0]['Location_Searched'];

                        if (isset($_POST['Zipcode']))
                            $barDetails[0]['Zipcode'] = $_POST['Zipcode'];
                        else
                            $barDetails[0]['Zipcode'] = $barDetails[0]['Zipcode'];

                        if (isset($_POST['price_range']))
                            $barDetails[0]['Price_Range'] = $_POST['price_range'];
                        else
                            $barDetails[0]['Price_Range'] = $barDetails[0]['Price_Range'];

                        if (isset($_POST['is_hall_available']))
                            $barDetails[0]['is_hall_available'] = $_POST['is_hall_available'];
                        else
                            $barDetails[0]['is_hall_available'] = $barDetails[0]['is_hall_available'];

                        if (isset($_POST['hall_fee']))
                            $barDetails[0]['hall_fee'] = $_POST['hall_fee'];
                        else
                            $barDetails[0]['hall_fee'] = $barDetails[0]['hall_fee'];

                        if (isset($_POST['hall_capacity']))
                            $barDetails[0]['hall_capacity'] = $_POST['hall_capacity'];
                        else
                            $barDetails[0]['hall_capacity'] = $barDetails[0]['hall_capacity'];

                        if (isset($_POST['no_of_seats_basic']))
                            $barDetails[0]['seat_for_basic'] = $_POST['no_of_seats_basic'];
                        else
                            $barDetails[0]['seat_for_basic'] = $barDetails[0]['seat_for_basic'];

                        if (isset($_POST['cost_per_seat']))
                            $barDetails[0]['cost_per_seat'] = $_POST['cost_per_seat'];
                        else
                            $barDetails[0]['cost_per_seat'] = $barDetails[0]['cost_per_seat'];

                        if (isset($_POST['discount']))
                            $barDetails[0]['discount'] = $_POST['discount'];
                        else
                            $barDetails[0]['discount'] = $barDetails[0]['discount'];


                        if (isset($_POST['opening_time']))
                            $barDetails[0]['Hours'] = $_POST['opening_time'];
                        else
                            $barDetails[0]['Hours'] = $barDetails[0]['Hours'];

                        if (isset($_POST['Rating']))
                            $barDetails[0]['Rating'] = $_POST['Rating'];
                        else
                            $barDetails[0]['Rating'] = $barDetails[0]['Rating'];
                        ?>
                        <div class="col-md-6 pull-left">


                            <div class="control-group">
                                <label class="control-label" for="inputName">Bar Name:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['Business_Name']; ?>" required
                                       name="barname" placeholder="Bar name...">

                            </div>
                            <span><?php echo $form->error("barname"); ?></span>
                            <br>

                            <div class="control-group">
                                <label class="control-label" for="inputName">Location:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['Location_Searched']; ?>" required
                                       name="location" placeholder="Location...">

                            </div>
                            <span><?php echo $form->error("location"); ?></span>
                            <br>

                            <div class="control-group">
                                <label class="control-label" for="inputName">Postcode:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['Zipcode']; ?>" required
                                       name="Zipcode" placeholder="Zipcode...">

                            </div>
                            <span><?php echo $form->error("Zipcode"); ?></span>
                            <br>

                            <div class="control-group">
                                <label class="control-label" for="inputName">Contact No:</label>
                                <input type="number" required value="<?php echo @$barDetails[0]['PhoneNo']; ?>"
                                       name="number" class="form-control" placeholder="Contact No...">

                            </div>
                            <span><?php echo $form->error("number"); ?></span>
                            <br>


                            <div class="control-group">
                                <label class="control-label" for="inputEmail">Category:</label>
                                <select name="category_searched" style="width: 73%;color: #333;">
                                    <option value="Pub" <?php if (@$barDetails[0]['Category'] == "Pub") { ?> selected="selected" <?php } ?> >
                                        Pub
                                    </option>
                                    <option value="Bars" <?php if (@$barDetails[0]['Category'] == "Bars") { ?> selected="selected" <?php } ?> >
                                        Bars
                                    </option>
                                    <option value="Wine Bars" <?php if (@$barDetails[0]['Category'] == "Wine Bars") { ?> selected="selected" <?php } ?> >
                                        Wine Bars
                                    </option>
                                    <option value="Lounges" <?php if (@$barDetails[0]['Category'] == "Lounges") { ?> selected="selected" <?php } ?> >
                                        Lounges
                                    </option>
                                </select>


                            </div>
                            <br>
                            <div class="control-group">
                                <label class="control-label" for="inputName">Established Year:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['Established_Year']; ?>"
                                       name="established_year" placeholder="Established year...">

                            </div>
                            <br>

                            <div class="control-group">
                                <label class="control-label" for="inputName">Description:</label>

                                <textarea required name="description" placeholder="Bar details..."
                                          style="background: white;height: 100px;padding: 12px;"><?php echo @$barDetails[0]['description']; ?></textarea>
                            </div>
                            <br>


                        </div>

                        <div class="col-md-6 pull-right">

                            <div class="control-group">
                                <label class="control-label" for="inputName">Price Range:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['Price_Range']; ?>"
                                       name="price_range" placeholder="Price range...">

                            </div>
                            <br>

                            <div class="control-group">
                                <label class="control-label" for="inputEmail">Hall:</label>
                                <select name="is_hall_available" id="is_hall_available" style="width: 73%;color: #333;">
                                    <option value="0" <?php if (@$barDetails[0]['is_hall_available'] == "0") { ?> selected="selected" <?php } ?> >
                                        Not available
                                    </option>
                                    <option value="1" <?php if (@$barDetails[0]['is_hall_available'] == "1") { ?> selected="selected" <?php } ?> >
                                        Available
                                    </option>

                                </select>
                            </div>
                            <br>

                            <div class="control-group" id="hallCapacity">
                                <label class="control-label" for="inputName">Capacity of hall (Ex.150 people):</label>
                                <input type="number" value="<?php echo @$barDetails[0]['hall_capacity']; ?>"
                                       name="hall_capacity" placeholder="Hall capacity...">

                            </div>
                            <span><?php echo $form->error("hall_capacity"); ?></span>
                            <br>

                            <div class="control-group" id="hallFee">
                                <label class="control-label" for="inputName">Hall Fee (&#163;):</label>
                                <input type="text" value="<?php echo @$barDetails[0]['hall_fee']; ?>" name="hall_fee"
                                       placeholder="Hall fee...">

                            </div>
                            <span><?php echo $form->error("hall_fee"); ?></span>
                            <br>


                            <div class="control-group">
                                <label class="control-label" for="inputName">Available seat:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['seat_for_basic']; ?>" required
                                       name="no_of_seats_basic" placeholder="Available seat...">

                            </div>
                            <span><?php echo $form->error("no_of_seats_basic"); ?></span>
                            <br>

                            <div class="control-group">
                                <label class="control-label" for="inputName">Price per seat (&#163;):</label>
                                <input type="text" value="<?php echo @$barDetails[0]['cost_per_seat']; ?>" required
                                       name="cost_per_seat" placeholder="Cost per seat...">

                            </div>
                            <span><?php echo $form->error("cost_per_seat"); ?></span>
                            <br>

                            <div class="control-group">
                                <label class="control-label" for="inputName">Discount:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['Discount']; ?>" name="discount"
                                       placeholder="Discount...">
                            </div>
                            <br>
                            
                            <div class="control-group">
                                <label class="control-label" for="inputName">Hours:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['Hours']; ?>" name="opening_time"
                                       placeholder="Hours...">
                            </div>
                            <br>

                            <div class="control-group">
                                <label class="control-label" for="inputName">Ratings:</label>
                                <input type="text" value="<?php echo @$barDetails[0]['Rating']; ?>" name="Rating"
                                       placeholder="Ratings out of 5...">

                            </div>
                            <span><?php echo $form->error("Rating"); ?></span>
                            <br>


                        </div>

                        <br>

                        <div class="span12">
                            <input name="editprofile" id="businesseditprofile" type="submit" value="SAVE CHANGES"
                                   class="btn submit btn-primary bg-pink white">

                        </div>

                    </form>

                </div>
                <div class="padcontent"></div>
            </div>
    </section>
    <script>
        $(document).ready(function () {
            //alert($("#is_hall_available").val());
            if ($("#is_hall_available").val() == 1) {
                // alert('unchecked');
                $("#hallFee").css("display", "block");
                $("#hallCapacity").css("display", "block");
                //$("#basic").css("display","block");
                //$("#free_booking").val("0");
            } else {
                //alert('checked');
                $("#hallFee").css("display", "none");
                $("#hallCapacity").css("display", "none");
                //$("#basic").css("display","none");
                //$("#free_booking").val("1");
            }
            $('#is_hall_available').on('change', function () {
                if ($(this).val() == 1) {
                    // alert('unchecked');
                    $("#hallFee").css("display", "block");
                    $("#hallCapacity").css("display", "block");
                    //$("#basic").css("display","block");
                    //$("#free_booking").val("0");
                } else {
                    //alert('checked');
                    $("#hallFee").css("display", "none");
                    $("#hallCapacity").css("display", "none");
                    //$("#basic").css("display","none");
                    //$("#free_booking").val("1");
                }
            });
        });
    </script>
<?php include 'template-parts/footer.php'; ?>