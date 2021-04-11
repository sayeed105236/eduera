<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />
<?php

    $json = 'application/views/login/country.js';
    $data = file_get_contents($json);
    $country=  json_decode($data, true);

?>

<div class="form-box">
    <div class="form-top">
        <div class="form-top-left">
            <h3>Sign up now</h3>
            <p>Fill in the form below and click on the Sign up button:</p>
        </div>
        <div class="form-top-right">
            <i class="fa fa-pencil"></i>
        </div>
    </div>

    <div class="form-bottom">

        <?=form_error('signup_first_name')?>
        <?=form_error('signup_last_name')?>
        <?=form_error('signup_email')?>
        <?=form_error('signup_phone')?>
        <?=form_error('signup_password')?>

        <?php if ($this->session->flashdata('registration_error')) {?>

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?=$this->session->flashdata('registration_error')?>
        </div>

        <?php }?>
        <form id="registration_form" role="form" action="<?=base_url('login' . $url_params_for_register)?>" method="post" class="registration-form">
            <div class="form-group">
                <label class="sr-only" for="signup_first_name">First name</label>
                <input type="text" name="signup_first_name" placeholder="* First name" class="form-control" id="signup_first_name" required="required">
            </div>
            <div class="form-group">
                <label class="sr-only" for="signup_last_name">Last name</label>
                <input type="text" name="signup_last_name" placeholder="* Last name" class="form-control" id="signup_last_name" required="required">
            </div>
            <div class="form-group">
                <label class="sr-only" for="signup_email">Email</label>
                <input type="email" name="signup_email" placeholder="* Email" class="form-control" id="signup_email" required="required">
            </div>
            <div style="display: none;" class="alert alert-warning alert-dismissible fade show sign-up-email-error-message" role="alert">
                Email already taken!
            </div>
            <div class="form-group">
                <label class="sr-only" for="signup_phone">Phone</label>
                <div class="row">
                    <div class="col-md-3 contact">
                        <select name="country" id="" class="form-control country_phone" id="country_phone">
                            <option value="<?= $country['data'][18]['name']?>" Selected><?=$country['data'][18]['flag']?> (<?=$country['data'][18]['dial_code']?>)</option>
                            
                            <option value="<?= $country['data']['234']['name']?>"><?= $country['data']['234']['flag']?> (<?= $country['data']['234']['dial_code']?>)</option>

                            <optgroup label="Other countries">
                                <?php foreach($country['data'] as $country){?>
                                <option  value="<?=$country['name']?>"> <?=$country['flag']?> <?= $country['name']?> (<?= $country['code']?>) (<?=$country['dial_code']?>)</option>
                            <?php }?>
                            
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-9 contact-field">
                        <input type="text" name="signup_phone" placeholder="* Phone" class="form-control" id="signup_phone" required="required">
                    </div>
                </div>
               
                
            </div>
            <div class="form-group">
                <label class="sr-only" for="signup_password">Password</label>
                <input type="password" name="signup_password" placeholder="* Password" class="form-control" id="signup_password" required="required">
            </div>
            <div style="display: none;" class="alert alert-warning alert-dismissible fade show sign-up-password-error-message" role="alert">
                Password has to be of 6 characters at least.
            </div>
          
            <button type="submit" class="btn">Sign up!</button>
        </form>
    </div>
</div>