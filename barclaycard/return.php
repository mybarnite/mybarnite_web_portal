<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_POST['transStatus'] == 'Y') {
    $orderid = explode("-", $_POST['MC_orderID']);
    $roleid = $_POST['MC_roleid'];
    $userid = $_POST['MC_userid'];

    $eventid = $_POST['MC_eventid'];
    $barid = $_POST['MC_barid'];
    $usercount = $_POST['MC_usercount'];
    $discount = $_POST['MC_discount'];

    if ($_POST['MC_roleid'] == '2') {

        $email = $_POST['MC_emailid'];
        $transactionid = $_POST['transId'];
        $cartId = $_POST['cartId'];
        $title = $_POST['MC_name'];
        $noofpersons = (isset($_POST['MC_persons'])) ? $_POST['MC_persons'] : 0;
        $amount = $_POST['MC_totalpayable'];
        $dt = date('d-m-Y');
        $username = $_POST['MC_CN'];
        $pendingamount = $_POST['MC_pendingamount'];
        $payableamount = $_POST['MC_totalpayable'];

        $subscription_barid = $barid;
        if (intval($barid) == 0 && intval($eventid) > 0) {
            //Get bar id from events
            $db->select('tbl_events', 'bar_id', null, 'id=' . intval($eventid));
            $event_data = $db->getResult();
            $subscription_barid = $event_data[0]['bar_id'];
        }

        //Get subscription data for commission
        $query = "SELECT * from tbl_businessowner_subscription WHERE is_active='Active' AND payment_status='Done' AND bar_id=" . intval($subscription_barid);
        $exe = $db->myconn->query($query);
        $num_subscription = $exe->num_rows;

        $commission = 8.00;
        if ($num_subscription > 0) {
            $commission = 0;
        } else {
            //Get registration data for commission
            $query = "SELECT * from bars_list WHERE id=" . intval($subscription_barid);
            $exe = $db->myconn->query($query);
            $num_registration = $exe->num_rows;
            if ($num_registration > 0) {
                 $registration_data = $exe->fetch_assoc();
                 $reg_date = $registration_data['registration_date'];
            
                 if($reg_date != '' && $reg_date != null){
                     $valid_date = date('Y-m-d',strtotime('+1 month',strtotime($reg_date)));
                     if(strtotime($valid_date) > strtotime(date('Y-m-d'))){
                         $commission = 0;
                     }
                 }
            }
        }

        if ($barid != "" && $barid != 0) {
            $ispayonline = $_POST['MC_payonline'];
            $hall = ($_POST['MC_hall'] == 1) ? "Yes" : "No";

            if (isset($orderid[0]) || isset($_POST['MC_orderID'])) {

                if (!isset($orderid[0])) {
                    $orderid[0] = $_POST['MC_orderID'];
                }

                $array = array(

                    'payment_status' => 'Done',
                    'transaction_id' => $transactionid,
                    'cartId' => $cartId,
                    'percentage_discount' => $discount,
                    'payable_amount' => $payableamount,
                    'pending_amount' => $pendingamount,
                    'is_pay_online' => $ispayonline,
                    'is_authorised' => 1,
                    'order_commission' => $commission
                );

                $db->update('tbl_order_history', $array, 'id=' . $orderid[0]); // Table name, column names and values, WHERE conditions
                $res2 = $db->getResult();
                $lastInsertedId = $res2[0];

                $db->select('tbl_order_history', 'tbl_order_history.*,bars_list.Business_Name,bars_list.id as barId,bars_list.Owner_id', 'bars_list on tbl_order_history.bar_id=bars_list.id', 'tbl_order_history.id=' . $orderid[0], 'id DESC');

                $getBarOrderDetial = $db->getResult();

                $startdate = $getBarOrderDetial[0]['bar_booking_start_date'];
                $starttime = $getBarOrderDetial[0]['bar_booking_starts'];
                $endtime = $getBarOrderDetial[0]['bar_booking_ends'];
                $noofpersons = $getBarOrderDetial[0]['no_of_persons'];

                if ($_POST['MC_hall'] == 1) {
                    $sql = 'SELECT count(*) as hall_booked FROM tbl_order_history WHERE id!= ' . $orderid[0] . ' and payment_status = "Done" and bar_id=' . $barid . ' and bar_booking_start_date = "' . Date("Y-m-d", strtotime($startdate)) . '" AND ((bar_booking_starts <=  "' . $starttime . '" AND bar_booking_ends >  "' . $starttime . '")OR (bar_booking_starts <  "' . $endtime . '" AND bar_booking_ends >=  "' . $endtime . '")OR (bar_booking_starts >=  "' . $starttime . '" AND bar_booking_starts <  "' . $endtime . '")OR (bar_booking_ends >  "' . $starttime . '" AND bar_booking_ends <=  "' . $endtime . '")) and is_hall_booked = "1" ORDER BY id DESC';
                    $res = $db->myconn->query($sql);
                    $isbookedfohall = $res->fetch_array();
                    $isexistforhall = intval($isbookedfohall[0]['hall_booked']);
                    $isexistforseat = 0;

                } else {
                    $isexistforhall = 0;
                    $isexistforseat = 1;
                }

                if ($noofpersons != "" && $noofpersons > 0) {
                    //Get total seats from bars_list
                    $db->select('bars_list', 'seat_for_basic as seats', null, 'id=' . $barid, 'id DESC');
                    $total_seats = $db->getResult();
                    $total_seats = $total_seats[0]['seats'];

                    $db->select('tbl_order_history', 'SUM(no_of_persons) as seats', null, 'id!= ' . $orderid[0] . ' and payment_status = "Done" and bar_id=' . $barid . ' and no_of_persons >0 and bar_booking_start_date <= "' . Date("Y-m-d", strtotime($startdate)) . '" AND ((bar_booking_starts <=  "' . $starttime . '" AND bar_booking_ends >  "' . $starttime . '")OR (bar_booking_starts <  "' . $endtime . '" AND bar_booking_ends >=  "' . $endtime . '")OR (bar_booking_starts >=  "' . $starttime . '" AND bar_booking_starts <  "' . $endtime . '")OR (bar_booking_ends >  "' . $starttime . '" AND bar_booking_ends <=  "' . $endtime . '"))', 'id DESC');

                    $reserved_seats = $db->getResult();
                    $total_booked_seats = $reserved_seats[0]['seats'];
                    $available_seats = $total_seats - $total_booked_seats;

                    if ($noofpersons <= $available_seats) {
                        //Available
                        $isexistforseat = 0;
                    } elseif ($noofpersons > $total_seats) {
                        //Not available
                        $isexistforseat = 1;
                    } elseif ($noofpersons >= $available_seats) {
                        //Not available
                        $isexistforseat = 1;
                    } else {
                        //Available
                        $isexistforseat = 0;
                    }
                }

                //echo $isexistforhall."-".$_POST['MC_hall'].":".$isexistforseat."-".$noofpersons."-";
                if ($isexistforhall == 1 && $isexistforseat == 1 && $_POST['MC_hall'] != "" && $noofpersons > 0) {
                    //echo "Not available1";
                    $flag = 1;
                } elseif ($isexistforhall == 0 && $isexistforseat == 0 && $_POST['MC_hall'] != "" && $noofpersons > 0) {
                    //echo "Available2";
                    $flag = 4;
                } elseif ($isexistforhall == 1 && $isexistforseat == 0 && $_POST['MC_hall'] != "" && $noofpersons > 0) {
                    //echo "hall not Available3";
                    $flag = 3;
                } elseif ($isexistforhall == 0 && $isexistforseat == 1 && $_POST['MC_hall'] != "" && $noofpersons > 0) {
                    //echo "Seat not Available4";
                    $flag = 2;
                } elseif ($isexistforhall == 1 && $_POST['MC_hall'] == 1 && $noofpersons == 0) {
                    //echo "Not available5";
                    $flag = 1;
                } elseif ($isexistforhall == 0 && $_POST['MC_hall'] == 1 && $noofpersons == 0) {
                    //echo "Available6";
                    $flag = 4;
                } elseif ($isexistforseat == 1 && $_POST['MC_hall'] == 0 && $noofpersons > 0) {
                    //echo "Not available7";
                    $flag = 1;
                } elseif ($isexistforseat == 0 && $_POST['MC_hall'] == 0 && $noofpersons > 0) {
                    //echo "Available8";
                    $flag = 4;
                }
            }

        } elseif ($eventid != "" && $eventid != 0) {

            $array = array(

                'payment_status' => 'Done',
                'transaction_id' => $transactionid,
                'cartId' => $cartId,
                'payable_amount' => $payableamount,
                'pending_amount' => $pendingamount,
                'is_pay_online' => 1,
                'is_authorised' => 1,
                'order_commission' => $commission
            );

            $db->update('tbl_order_history', $array, 'id=' . $orderid[0]); // Table name, column names and values, WHERE conditions
            $res2 = $db->getResult();
            $lastInsertedId = $res2[0];
        }

        /* $db->update('tbl_order_history',$array,'id='.$orderid[0]); // Table name, column names and values, WHERE conditions
        $res2 = $db->getResult();
        $lastInsertedId = $res2[0]; */
        if ($lastInsertedId > 0) {
            $array1 = array(
                'userCount' => ($usercount + 1)
            );
            if ($barid != "" && $barid != 0) {
                $db->update('tbl_promotions', $array1, 'barId=' . $barid); // Table name, column names and values, WHERE conditions
            } elseif ($eventid != "" && $eventid != 0) {
                $db->update('tbl_promotions', $array1, 'eventId=' . $eventid); // Table name, column names and values, WHERE conditions
            }

            if ($lastInsertedId > 0) {

                function qr($transactionid, $width = 200, $height = 200, $charset = 'utf-8', $error = 'H')
                {
                    // Google chart api url
                    $uri = 'https://chart.googleapis.com/chart?';

                    // url queries
                    $query = array(
                        'cht' => 'qr',
                        'chs' => $width . 'x' . $height,
                        'choe' => $charset,
                        'chld' => $error,
                        'chl' => $transactionid
                    );

                    // full url
                    $uri = $uri .= http_build_query($query);

                    return $uri;
                }


                $to = $email;
                //$to = "radicalinweb@gmail.com";
                $subject = 'Mybarnite';
                $from = 'info@mybarnite.com';

                // To send HTML mail, the Content-type header must be set
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                // Create email headers
                $headers .= 'From: ' . $from . "\r\n" .
                    'Reply-To: ' . $from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                // Compose a simple HTML email message


                if ($eventid != "" && $eventid != 0) {
                    $message = "<html>";
                    $message .= "<head><title>Mybarnite</title></head>";
                    $message .= "<body>";
                    $message .= "<table border='1' cellspacing='0' style='width:100%;'>";
                    $message .= "<tr class='border_bottom'><td  colspan='2' align='center'><img src='https://mybarnite.com/images/barlogo.png' width='329' height='192'/></td><td>Name : $username<br/>To : " . $to . "<br/>Transaction id : " . $transactionid . "</td></tr>";
                    $message .= "<tr>
									  <th>Title</th><th>No Of Persons</th><th>Amount</th>
									</tr>
									<tr>
									  <td>$title</td><td>$noofpersons</td><td>" . $amount . "</td>
									</tr>
									<tr>
										<td></td>
										<td>Sub total</td>
										<td align='right'>" . $amount . "</td>
									</tr>
									<tr>

										<td colspan='2'><img src=" . qr($transactionid, 400, 200) . "></td>
										<td><img alt='" . $transactionid . "' src='https://mybarnite.com/barcode.php?codetype=Code39&size=40&text=" . $transactionid . "' /></td>
									</tr>";
                    $message .= "</table>";

                    $message .= "<br/>";
                    $message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
                    $message .= "</body></html>";
                } elseif ($barid != "" && $barid != 0) {
                    //echo $flag;exit;
                    if ($flag == 1) {
                        $message = "<html>";
                        $message .= "<head><title>Mybarnite</title></head>";
                        $message .= "<body>";
                        $message .= "<p>Dear $username,</p>";
                        $message .= "<p>  Please note that Hall and seats for booking are not available. Your refund will be initiated shortly for order id " . $orderid[0] . ".For more information please contact to administrator (info@mybarnite.com).</p><br/><br/>";
                        $message .= "<br/>";
                        $message .= "<p>Please accept appology for inconviniency.</p><br/><br/>";
                        $message .= "<br/><br/>";
                        $message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
                        $message .= "</body></html>";


                        /******************************** Sending Refund request to Admin  ********************************/
                        $to1 = "info@mybarnite.com";
                        $subject1 = 'Mybarnite';
                        $from1 = 'info@mybarnite.com';

                        // To send HTML mail, the Content-type header must be set
                        $headers1 = 'MIME-Version: 1.0' . "\r\n";
                        $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                        // Create email headers
                        $headers1 .= 'From: ' . $from . "\r\n" .
                            'Reply-To: ' . $from . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();
                        $message1 = "<html>";
                        $message1 .= "<head><title>Mybarnite</title></head>";
                        $message1 .= "<body>";
                        $message1 .= "<p>Dear Admin,</p>";
                        $message1 .= "<p>  Please note that Hall and seats for booking are not available for order " . $orderid[0] . ",Kindly issue refund from merchant login for transaction id " . $transactionid . "</p><br/><br/>";
                        $message1 .= "<br/><br/>";
                        $message1 .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
                        $message1 .= "</body></html>";
                        mail($to1, $subject1, $message1, $headers1);

                    } elseif ($flag == 4) {
                        $message = "<html>";
                        $message .= "<head><title>Mybarnite</title></head>";
                        $message .= "<body>";
                        $message .= "<table border='1' cellspacing='0' style='width:100%;'>";
                        $message .= "<tr class='border_bottom'><td  colspan='2' align='center'><img src='https://mybarnite.com/images/barlogo.png' width='329' height='192'/></td><td>Name : $username<br/>To : " . $to . "<br/>Transaction id : " . $transactionid . "</td></tr>";
                        $message .= "<tr>
											  <th>Title</th><th>No Of Persons</th><th>Hall</th><th>Total Amount</th>
											</tr>
											<tr>
											  <td>$title</td><td>$noofpersons</td><td>$hall</td><td>" . $payableamount . "</td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td>Total paid</td>
												<td align='right'>" . $amount . "</td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td>Pending amount</td>
												<td align='right'>" . $pendingamount . "</td>
											</tr>
											<tr>

												<td colspan='2'><img src=" . qr($transactionid, 400, 200) . "></td>
												<td><img alt='" . $transactionid . "' src='https://mybarnite.com/barcode.php?codetype=Code39&size=40&text=" . $transactionid . "' /></td>
											</tr>";

                        $message .= "</table>";
                        $message .= "<br/>";
                        $message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";

                        $message .= "</body></html>";
                    } elseif ($_POST['MC_hall'] != 1 && $noofpersons > 0 && $flag == 2) {
                        $message = "<html>";
                        $message .= "<head><title>Mybarnite</title></head>";
                        $message .= "<body>";
                        $message .= "<p>Dear $username,</p>";
                        $message .= "<p>New payment has been proceeded successfully for order id " . $orderid[0] . ". But requested booking for seats are not ready. Kindly contact to administrator (info@mybarnite.com) to issue refund.</p><br/><br/>";
                        $message .= "<br/>";
                        $message .= "<p>Please accept appology for inconviniency.</p><br/><br/>";
                        $message .= "<br/><br/>";
                        $message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
                        $message .= "</body></html>";
                    } elseif ($_POST['MC_hall'] == 1 && $noofpersons > 0 && $flag == 2) {
                        $message = "<html>";
                        $message .= "<head><title>Mybarnite</title></head>";
                        $message .= "<body>";

                        $message .= "<table border='1' cellspacing='0' style='width:100%;'>";
                        $message .= "<tr class='border_bottom'><td  colspan='2' align='center'><img src='https://mybarnite.com/images/barlogo.png' width='329' height='192'/></td><td>Name : $username<br/>To : " . $to . "<br/>Transaction id : " . $transactionid . "</td></tr>";
                        $message .= "<tr>
											  <th>Title</th><th>No Of Persons</th><th>Hall</th><th>Total Amount</th>
											</tr>
											<tr>
											  <td>$title</td><td>$noofpersons</td><td>$hall</td><td>" . $payableamount . "</td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td>Total paid</td>
												<td align='right'>" . $amount . "</td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td>Pending amount</td>
												<td align='right'>" . $pendingamount . "</td>
											</tr>
											<tr>

												<td colspan='2'><img src=" . qr($transactionid, 400, 200) . "></td>
												<td><img alt='" . $transactionid . "' src='https://mybarnite.com/barcode.php?codetype=Code39&size=40&text=" . $transactionid . "' /></td>
											</tr>

											";
                        $message .= "</table>";
                        $message .= "<br/>";
                        $message .= "<p>Note:	New payment has been proceeded successfully for order id " . $orderid[0] . ". But requested booking for seats are not ready. if you want to cancel the booking then please contact to administrator (info@mybarnite.com) to issue refund.</p><br/><br/>";
                        $message .= "<br/><br/>";
                        $message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";

                        $message .= "</body></html>";
                    } else if ($_POST['MC_hall'] == 1 && $noofpersons == 0 && $flag == 3) {
                        $message = "<html>";
                        $message .= "<head><title>Mybarnite</title></head>";
                        $message .= "<body>";
                        $message .= "<p>Dear $username,</p>";
                        $message .= "<p>New payment has been proceeded successfully for order id " . $orderid[0] . ". But requested booking for hall is not ready. Kindly contact to administrator (info@mybarnite.com) to issue refund.</p><br/><br/>";
                        $message .= "<br/>";
                        $message .= "<p>Please accept appology for inconviniency.</p><br/><br/>";
                        $message .= "<br/><br/>";
                        $message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";
                        $message .= "</body></html>";
                    } else if ($_POST['MC_hall'] == 1 && $noofpersons > 0 && $flag == 3) {
                        $message = "<html>";
                        $message .= "<head><title>Mybarnite</title></head>";
                        $message .= "<body>";

                        $message .= "<table border='1' cellspacing='0' style='width:100%;'>";
                        $message .= "<tr class='border_bottom'><td  colspan='2' align='center'><img src='https://mybarnite.com/images/barlogo.png' width='329' height='192'/></td><td>Name : $username<br/>To : " . $to . "<br/>Transaction id : " . $transactionid . "</td></tr>";
                        $message .= "<tr>
											  <th>Title</th><th>No Of Persons</th><th>Hall</th><th>Total Amount</th>
											</tr>
											<tr>
											  <td>$title</td><td>$noofpersons</td><td>$hall</td><td>" . $payableamount . "</td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td>Total paid</td>
												<td align='right'>" . $amount . "</td>
											</tr>
											<tr>
												<td></td>
												<td></td>
												<td>Pending amount</td>
												<td align='right'>" . $pendingamount . "</td>
											</tr>
											<tr>

												<td colspan='2'><img src=" . qr($transactionid, 400, 200) . "></td>
												<td><img alt='" . $transactionid . "' src='https://mybarnite.com/barcode.php?codetype=Code39&size=40&text=" . $transactionid . "' /></td>
											</tr>

											";
                        $message .= "</table>";
                        $message .= "<br/>";
                        $message .= "<p>Note:	New payment has been proceeded successfully for order id " . $orderid[0] . ". But requested booking for hall is not ready. if you want to cancel the booking then please contact to administrator (info@mybarnite.com) to issue refund.</p><br/><br/>";
                        $message .= "<br/><br/>";
                        $message .= "<p>Thank you for using our website</p><p>Mybarnite Limited</p><p>Email: info@mybarnite.com</p><p>URL: mybarnite.com</p><p><img src='https://mybarnite.com/images/Picture1.png' width='110'></p>";

                        $message .= "</body></html>";
                    }
                }
                // Sending email
                if (mail($to, $subject, $message, $headers)) {
                    $_SESSION['msg'] = 'Payment confirmation email has been sent successfully.';

                } else {
                    $_SESSION['msg'] = 'Unable to send email. Please try again.';
                }
                $_SESSION['discount'] = 0;
                $_SESSION['payableamount'] = 0;
                unset($_SESSION['payableamount']);
                unset($_SESSION['discount']);

            }
        }
    }
    if ($_POST['MC_roleid'] == '1') {
        $email = $_POST['MC_emailid'];
        $months = "+" . $_POST['MC_duration'];
        $duration = "$months months";
        $refdate = $_POST['MC_refdate'];
        $refdateformat = date('Y-m-d', $_POST['MC_refdate']);

        //$refdate = strtotime(@$_POST['refdate']);
        $currentdt = ($refdate) ? $refdateformat : date('Y-m-d', time());
        $MonthsLater = ($refdate) ? strtotime($duration, $refdate) : strtotime($duration, time());
        $enddt = date('Y-m-d', $MonthsLater);
        $refdatenew = $enddt;

        //$transactionid = 'MBS'.$_REQUEST['PAYID'];
        $transactionid = $_POST['transId'];
        $username = $_POST['MC_CN'];
        $amount = $_POST['amount'];
        $cartId = $_POST['cartId'];

        $array = array(
            'dueamount' => 0,
            'start_date' => $currentdt,
            'end_date' => $enddt,
            'ref_date' => $refdatenew,
            'payment_status' => 'Done',
            'transaction_id' => $transactionid,
            'cartId' => $cartId,
            'is_active' => 'Active',
            'is_authorised' => 0

        );
        //echo $orderid[0];
        $db->update('tbl_businessowner_subscription', $array, 'id=' . $orderid[0]);
        $res = $db->getResult();
        $lastInsertedId = $res[0];
        if ($lastInsertedId > 0) {


            $to = $email;
            $subject = 'Mybarnite - Subscription';
            $from = 'info@mybarnite.com';

            // To send HTML mail, the Content-type header must be set
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            // Create email headers
            $headers .= 'From: ' . $from . "\r\n" .
                'Reply-To: ' . $from . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $message = "<html>";
            $message .= "<head><title>Mybarnite</title></head>";
            $message .= "<body>";
            $message .= "Dear $name,
						<br/><br/>
						Thank you for your recent purchase from Mybarnite.com.<br/>
						Please find enclosed the proof of purchase and the receipt attached. Should you have any further query, please contact our customer support team<br/><br/>";
            $message .= "<table cellspacing='0' style='width:100%;'>";
            $message .= "<tr><th>Name :</th><td>" . $username . "</td></tr>";
            $message .= "<tr><th>Email :</th><td>" . $to . "</td></tr>";
            $message .= "<tr><th>Duration :</th><td>From : " . $currentdt . " to " . $enddt . "</td></tr>";
            $message .= "<tr><th>Amount :</th><td>" . $amount . "</td></tr>";
            $message .= "<tr><th>Payment :</th><td>Done</td></tr>";
            $message .= "<tr><th>Transaction id :</th><td>" . $transactionid . "</td></tr>";
            $message .= "</table>";
            $message .= "<br/><br/>
						Thanks you again for using our website
						<br/><br/>
						Mybarnite Limited<br/>
						EMail: info@mybarnite.com<br/>
						URL: mybarnite.com<br/><br/>
						<img src='https://mybarnite.com/images/Picture1.png' width='50%'>
						<br/>";
            $message .= "</body></html>";
            if (mail($to, $subject, $message, $headers)) {
                $_SESSION['msg'] = 'Payment confirmation email has been sent successfully.';
            } else {
                $_SESSION['msg'] = 'Unable to send email. Please try again.';
            }
        }
    }
}

?>