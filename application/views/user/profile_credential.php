<form action="<?php echo base_url('user/profile/credential'); ?>" method="post">
    <div class="content-box">
        <div class="email-group">
            <div class="form-group">
                <label for="email">Email:</label>
                <span name="email" style="font-weight: bold; padding-left: 15px; color: gray"><?= $user_data->email ?></span>
            </div>
        </div>
        <div class="password-group">
            <div style="padding: 10px 142px; margin-top: 20px;">
                <?php echo validation_errors(); ?>

                <?php if ($this->session->flashdata('credential_change_successful')) { ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('credential_change_successful') ?>
                </div>

                <?php } ?>


                <?php if ($this->session->flashdata('credential_change_failed')) { ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong></strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('credential_change_failed') ?>
                </div>

                <?php } ?>

            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="current_password" name = "current_password" placeholder="Current password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name = "new_password" placeholder="New password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name = "confirm_password" placeholder="Confirm password">
            </div>
        </div>
    </div>
    <div class="content-update-box">
        <button type="submit" class="btn">Save</button>
    </div>
</form>