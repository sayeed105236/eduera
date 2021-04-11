<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<div class="form-box">
	<div class="form-top">
		<div class="form-top-left">
			<h3>Login to your account</h3>
			<p>Enter username and password to log on:</p>
		</div>
		<div class="form-top-right">
			<i class="fa fa-key"></i>
		</div>
	</div>
	<div class="form-bottom">

        <?=form_error('login_email')?>
        <?=form_error('login_password')?>

		<?php if ($this->session->flashdata('invalid_credential')) {?>

		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong></strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<?=$this->session->flashdata('invalid_credential')?>
		</div>

		<?php }?>

	<form id="login_form" role="form" action="<?=base_url('login' . $url_params_for_login)?>" method="post" class="registration-form height-forgot-pass">

	
		<div class="form-group">
			<label class="sr-only" for="login_email">Email</label>
			<input type="text" name="login_email" placeholder="Email..." class="form-control" value="" size="50" />
		</div>

		<div class="form-group">
			<label class="sr-only" for="login_password">Password</label>
			<input type="password" name="login_password" class="form-control" placeholder="Password..." value="" size="50" />
		</div>

		<div><button class="btn" type="submit">Login</button></div>
		<br>
		<a class="forgot-pass" href="<?=base_url('/home/forgot_password')?>">Forgot password</a>

	</form>



</div>

<div class="row">
	<div class="col">
        <a href="<?=$LoginUrlGamil;?>" class="google btn log-goo">
          <i class="fab fa-google"></i> Login with Google
        </a>

        <a href="<?=$facebook_login_url;?>" class="facebook btn log-face">
          <i class="fab fa-facebook"></i> Login with Facebook
        </a>

    </div>
  </div>

</div>

