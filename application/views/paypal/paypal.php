<h3 style="text-align: center;">You will redirect to PayPal shortly...</h3>

<body onload="document.getElementById('form_id').submit()">
	<form id='form_id' action="<?php echo PAYPAL_URL; ?>" method="post" onload>
	    <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
	    <input type="hidden" name="cmd" value="_xclick">
	    <input type="hidden" name="item_name" value="<?php echo $courses; ?>">
	    <input type="hidden" name="item_number" value="">
	    <input type='hidden' name='rm' value='2'>
	    <input type="hidden" name="amount" value="<?php echo $total_amount; ?>">
	    <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">
	    <input type="hidden" name="return" value="<?= base_url("paypal/paypal_success"); ?>">
	    <input type="hidden" name="cancel_return" value="<?php echo base_url('home/paypal_cancel/paypal'); ?>"> 
	    <!-- <input style='position: absolute; left: 50%; transform: translateX(-50%)' type="image" name="submit" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"> -->
	</form>
</body>