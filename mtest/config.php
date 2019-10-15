<?php
require_once('vendor/autoload.php');

$stripe = [
  "secret_key"      => "sk_test_cNbu9LrIJIbVH54LwF3Sav2300VIsKzyCN",
  "publishable_key" => "pk_test_FzJETPlbFTmAQX4vIMUh49l800eu4N0z2P",
];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>