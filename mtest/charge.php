<?php
  require_once('./config.php');

  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];

  $customer = \Stripe\Customer::create([
      'email' => $email,
      'source'  => $token,
  ]);

  $charge = \Stripe\Charge::create([
      'customer' => $customer->id,
      'amount'   => 5000,
      'currency' => 'usd',
      "metadata" => $_POST
  ]);
  
  echo '<pre> POST';
    var_dump($_POST);
  echo '</pre>';    
  echo '<pre> Customer';
    var_dump($customer);
  echo '</pre>';
  echo '<pre> Charges';
    var_dump($charge);
  echo '</pre>';

  echo '<h1>Successfully charged $50.00!</h1>';
?>