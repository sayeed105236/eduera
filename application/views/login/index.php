<div class="top-content login-page-body">
<div class="inner-bg">
<div class="container">
                    
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 text">
            <h1>Eduera</h1>
            <div class="description">
                <!-- <p>Create a free account and get 30% content access in each of our online courses.</p> -->
                <p>Due to the COVID-19 crisis, we are giving a huge <b>discount</b> in the most of our courses, so that you can enroll in our courses and make your quarantine time valuable.</p>
                <p class="stay-home">Stay home, be safe.</p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-5">
            <?php include 'login_form.php'; ?>
        </div>
        
        <div class="col-sm-1 middle-border"></div>
        <div class="col-sm-1"></div>
            
        <div class="col-sm-5">
            <?php $this->load->view('login/registration_form'); ?>            
        </div>
    </div>
    
</div>
</div>
</div>
<script type="text/javascript">
    $("#signup_email").on('keyup', function() {
        var email = this.value;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('rest/api/is_duplicate_email'); ?>",
            data: {email: email},
            success: function(response){
                if (response == 1) {
                    $(".sign-up-email-error-message").show();
                    $("#signup_email").addClass("input-error");
                    document.getElementById('signup_email').setCustomValidity('Email already taken!');
                } else {
                    $(".sign-up-email-error-message").hide();
                    $("#signup_email").removeClass("input-error");
                    document.getElementById('signup_email').setCustomValidity('');
                }
            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
    });


    $("#signup_password").on('keyup', function() {
        var password = this.value;
        if (password.length < 6){
            $(".sign-up-password-error-message").show();
            $("#signup_password").addClass("input-error");
            document.getElementById('signup_password').setCustomValidity('Password has to be of 6 characters at least.');
        } else {
            $(".sign-up-password-error-message").hide();
            $("#signup_password").removeClass("input-error");
            document.getElementById('signup_password').setCustomValidity('');
        }
    });
</script>

