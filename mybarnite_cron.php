<?php
// Create connection
include('/home/mybarnite/public_html/business_owner/class/business_owner.php');
$db = new business_owner();

error_reporting(E_ALL);
// Check connection
if (!$db->connect()) {
    error_log("Connection failed: " . mysqli_connect_error());
    die("Connection failed: " . mysqli_connect_error());
} else {
    $db->select('bars_list', '*', null, 'Owner_id != 0');
    $bar_data = $db->getResult();

    if (!empty($bar_data)) {
        require_once('./config.php');
        foreach ($bar_data AS $bar_data_val) {
            $BarId = $bar_data_val['id'];
            $db->select('tbl_accounts', '*', null, "user_id=" . $bar_data_val['Owner_id'] . " AND stripe_account_id != ''", null, '1');
            $account_data_count = $db->numRows();
            if ($account_data_count > 0) {
                $account_data = $db->getResult();
                try {
                    $stripe_account = \Stripe\Account::retrieve($account_data[0]['stripe_account_id']);
                    if ($stripe_account != null) {
                        $db->select('bar_billing_transactions', '*', null, "bar_id=" . $BarId, 'bill_end_date DESC', '1');
                        $billing_data = $db->getResult();
                        if (empty($billing_data)) {
                            /*get start date of bar registration pending*/
                            $bill_start_date = '2019-09-01';
                            $bill_end_date = date('Y-m-d', strtotime($bill_start_date . '+28 days'));
                        } else {
                            $bill_start_date = date('Y-m-d', strtotime($billing_data[0]['bill_end_date'] . '+1 day'));
                            $bill_end_date = date('Y-m-d', strtotime($bill_start_date . '+28 days'));
                        }
                        /*find active subscription between start date & end date*/
                        $db->select('tbl_order_history', '*', null, "bar_id=" . $BarId . " AND ((DATE(bar_booking_start_date) >= '" . $bill_start_date . "' AND DATE(bar_booking_start_date) <= '" . $bill_end_date . "') OR (DATE(event_booking_end_date) >= '" . $bill_start_date . "' AND DATE(event_booking_end_date) <= '" . $bill_end_date . "')) AND payment_status = 'Done' AND bill_trans_id = 0");
                        // echo $db->getSql();
                        $order_data = $db->getResult();
                      
                        $TransferAmount = 0;
                        $total_amount = 0;
                        if (!empty($order_data)) {
                            foreach ($order_data AS $order_data_value) {
                                $total_amount += floatval($order_data_value['total_amount']);

                                $commission = 8;
                                if(floatval($order_data_value['order_commission']) > 0) {
                                    $commission = floatval($order_data_value['order_commission']);
                                }
                                $charge = floatval($order_data_value['total_amount']) * ($commission / 100);
                                $TransferAmount += floatval($order_data_value['payable_amount']) - floatval($charge);
                            }
                        }
                        $transerId = '';
                        if ($TransferAmount > 0) {
                            $transer = \Stripe\Transfer::create([
                                "amount" => $TransferAmount,
                                "currency" => "gbp",
                                "destination" => $account_data[0]['stripe_account_id']
                            ]);
                            if ($transer) {
                                $transerId = $transer->id;
                                error_log('Bar amount ' . $TransferAmount . ' transferred for Bar Id ' . $BarId);
                            }
                        }

                        $Array = array(
                            'bar_id' => $BarId,
                            'bill_start_date' => $bill_start_date,
                            'bill_end_date' => $bill_end_date,
                            'bill_amount' => $total_amount,
                            'paid_amount' => $TransferAmount,
                            'stripe_transaction_id' => $transerId
                        );

                        $db->insert('bar_billing_transactions', $Array);  // Table name, column names and respective values
                        $transaction = $db->getResult();
                        if (empty($transaction)) {
                            error_log('Bar amount ' . $TransferAmount . ' not transferred for Bar Id ' . $BarId);
                        } else {
                            $array = array(
                                'bill_trans_id' => $transaction[0],
                                'bill_trans_amount' => "CASE WHEN order_commission>0 THEN round(total_amount*(order_commission/ 100),2) ELSE round(total_amount,2)"
                            );

                            $db->update_calculation('tbl_order_history', $array, "bar_id=" . $BarId . " AND DATE(order_created_at) >= '" . $bill_start_date . "' AND DATE(order_created_at) <= '" . $bill_end_date . "' AND payment_status = 'Done' AND bill_trans_id = 0"); // Table name, column names and values, WHERE conditions
                        }
                    } else {
                        error_log("Stripe account not connected for Bar Id :" . $BarId);
                    }
                } catch (Exception $ex) {
                    error_log($ex->getMessage());
                }
            } else {
                error_log("Account not activated for Bar Id :" . $BarId);
            }
        }
    } else {
        error_log("No Record found for cron.");
    }

    $db->disconnect();
}
?>