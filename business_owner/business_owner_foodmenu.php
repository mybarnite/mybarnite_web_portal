<?php
error_reporting();
include('template-parts/header.php');
?>
<script type="text/javascript" src="js/uploader.js"></script>
<link type="text/css" href="css/uploader.css" rel="stylesheet"/>
<?php
if (isset($_POST['AddItem'])) {

    /* $itemName = $_POST['boxes'];
    $itemPrice = $_POST['price'];
    $itemCategoryId = $_POST['cat'];
    $itemCategoryName = ($itemCategoryId=="1")?"Food":"Drink"; 
    
$db->insert('tbl_menu_items',array('bar_id'=>$_SESSION['bar_id'],'cat_id'=>$itemCategoryId,'cat_name'=>$itemCategoryName,'menu_item_name'=>$itemName,'price'=>$itemPrice));  // Table name, column names and respective values
    $res = $db->getResult();  
    $lastInsertedId = $res[0];
    if($lastInsertedId!="")
    {
        $_SESSION['msg']="Data inserted successfully";
    }
    else
    {
        $_SESSION['msg']="";
    }		 */


    global $flag;
    $valid_formats = array("jpg", "png", "gif", "pdf", "JPG", "PNG", "GIF", "PDF");
    $path = "foodmenu_uploads/"; // Upload directory
    $count = 0;

    // Loop $_FILES to exeicute all files
    $total = count($_FILES['files']['name']);
    if ($total < 1) {
        $flag = 0;
        $_SESSION['msg'] = "<div class='alert alert-success'>Please select any file.</div>";
    } else {
        // Loop through each file
        for ($i = 0; $i < $total; $i++) {
            $new_filename = $_SESSION['bar_id'] . "-" . time() . "-" . $_FILES['files']['name'][$i];
            if ($_FILES['files']['error'][$i] == 0) {
                $file_type = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);
                if (!in_array(pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION), $valid_formats)) {
                    $_SESSION['msg'] = "<div class='alert alert-danger'>File format is invalid.</div>";
                    $flag = 1;
                    // Skip invalid file formats
                } else { // No error found! Move uploaded files 
                    if ($flag != 1) {
                        $new_filename = $_SESSION['bar_id'] . "-" . time() . "-" . $_FILES['files']['name'][$i];
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $path . $new_filename))
                            $count++; // Number of successfully uploaded file

                        $values = array('bar_id' => $_SESSION['bar_id'], 'file_name' => $new_filename, 'file_path' => $path . $new_filename, 'file_type' => $file_type);
                        $db->insert('tbl_barfoodmenu_uploads', $values);  // Table name, column names and respective values
                        $res1 = $db->getResult();
                        if ($res1 != "") {
                            $flag = 0;
                            $_SESSION['msg'] = "<div class='alert alert-success'>File Uploaded successfully.</div>";
                        }
                    }


                }
            }
        }
    }


}

$db->select('tbl_menu_items', '*', NULL, 'bar_id=' . @$_SESSION['bar_id'], 'id DESC');
$items = $db->getResult();

?>
<!--==============================Content=================================-->
<section id="content">
    <div class="container">
        <?php
        if (isset($_SESSION['business_owner_id'])) {

            if (isset($_SESSION['bar_id'])) {
                ?>

                <br/>
                <div class="row text-center">
                    <div class="span12">
                        <center>
                            <h2>Foods</h2>
                        </center>
                    </div>
                </div>
                <div class="row">
                    <div class="span4"></div>
                    <div class="span4">
                        <center>
                            <div class="my-form">
                                <div class="control-group" id="msg">
                                    <?php

                                    if (isset($_SESSION['msg'])) {
                                        echo $_SESSION['msg'];
                                        unset($_SESSION['msg']);
                                    }

                                    ?>
                                </div>
                                <form role="form" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="event_name" class="pull-left">Upload image : </label>
                                        <input type="file" id="file" name="files[]" multiple="multiple"
                                               accept="image/*"/>
                                    </div>
                                    <br/>
                                    <div>
                                        <label for="event_name" class="pull-left">Formats Supported - pdf, png, gif and
                                            jpg</label>
                                    </div>
                                    <br/>
                                    <p>
                                        <input type="submit" value="Upload" name="AddItem" id="AddItem"
                                               class="btn submit btn-info bg-pink"/>
                                        <button type="button" id="reset" name="reset" value="reset"
                                                class="btn btn-info submitEvent bg-pink">Reset
                                        </button>
                                    </p>
                                </form>
                            </div>
                        </center>
                    </div>
                    <div class="span4"></div>
                </div>
                <div class="row text-center">
                    <div class="span12">
                        <div class="container" id="gallery">

                            <?php
                            $db->select('tbl_barfoodmenu_uploads', '*', NULL, 'bar_id=' . $_SESSION['bar_id'], 'id DESC'); // Table name, Column Names, JOIN, WHERE conditions, ORDER BY conditions
                            $images = $db->getResult();
                            /* echo "<pre>";
                            print_r($images); */
                            if (!empty($images)) {
                                foreach ($images as $image) {
                                    $formats = array("jpg", "png", "gif", "pdf", "JPG", "PNG", "GIF", "PDF");;
                                    $file_path = "business_owner/" . $image['file_path'];
                                    $ext = pathinfo($image['file_name'], PATHINFO_EXTENSION);
                                    if (!in_array($ext, $formats)) {
                                        $file_path = "business_owner/foodmenu_uploads/PDF-icon.png";
                                    } else {
                                        $file_path = "business_owner/" . $image['file_path'];
                                    }
                                    if (file_exists($image['file_path'])) {
                                        ?>
                                        <figure class="threecol first gallery-item">
                                            <img src="<?php echo SITE_PATH . $file_path; ?>" height="300" width="300">
                                            <h3><?php echo $image['file_type']; ?></h3>
                                            <figcaption class="img-title">
                                                <h5>
                                                    <a href="javascript:void(0);"
                                                       onclick="delete_image(<?php echo $image['id']; ?>);">DELETE</a> |
                                                    <a href="<?php echo $image['file_path']; ?>"
                                                       target="_blank">VIEW</a>

                                                </h5>
                                            </figcaption>
                                        </figure>


                                        <?php
                                    }
                                }
                            } else {
                                ?>
                                <div class='alert alert-danger'>Records not found.</div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <?php
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.gallery-item').hover(function () {
            $(this).find('.img-title').fadeIn(300);
        }, function () {
            $(this).find('.img-title').fadeOut(100);
        });
        $('#AddItem').click(function () {
            var fileName = $("#file").val();
            if (!fileName) {
                $("#msg").html("<div class='alert alert-danger'>Please select any file.</div>");
                return false;
            } else {
                return true;
            }
        });
        $("#reset").click(function () {
            $.ajax({
                url: "removeSession.php",
                type: "POST",
                success: function (result) {
                    window.location = "business_owner_foodmenu.php";
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });

        });
    });

    function delete_image(id) {
        $.ajax({
            url: "manageMenuItems.php",
            type: "POST",
            data: {img_id: id},

            success: function (result) {
                window.location = "business_owner_foodmenu.php";
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#gallery").html("<div class='alert alert-danger'>System error occured.</div>");
            }
        });
    }
</script>
