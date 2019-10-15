<?php require_once('./config.php'); ?>

<form action="charge.php" method="post" value="">
	<input type="hidden" name="proname" value="Custom t-shirt">
	<input type="hidden" name="proamt" value="100.0">
	<input type="hidden" name="proimg" value="https://toppng.com/public/uploads/thumbnail/thumbnail-effect-11553459356q2ka2pwpmu.png">
	<input type="hidden" name="prodes" value="Your custom designed t-shirt">
  	<script
	    src="https://checkout.stripe.com/checkout.js"
	    class="stripe-button"
	    data-label="Pay Now!"
	    data-key="<?php echo $stripe['publishable_key']; ?>"
	    data-name="Custom t-shirt"
	    data-description="Your custom designed t-shirt"
	    data-amount="1000"
	    data-currency="gbp"
	    data-image = "https://toppng.com/public/uploads/thumbnail/thumbnail-effect-11553459356q2ka2pwpmu.png"
	    data-allow-remember-me = "false">
	</script>      	
</form>