<form action="<?php echo base_url('user/upload_profile_photo'); ?>" enctype="multipart/form-data" method="post" accept="image/png, image/jpeg, image/jpg">
    <div class="content-box">
        <div style="padding: 10px 142px; margin-top: 20px;">
            <?php echo validation_errors(); ?>

            <?php if ($this->session->flashdata('profile_photo_upload_error')) { ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('profile_photo_upload_error') ?>
            </div>

            <?php } ?>

            <?php if ($this->session->flashdata('profile_photo_upload_successful')) { ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('profile_photo_upload_successful') ?>
            </div>

            <?php } ?>

        </div>
        <div class="email-group">
            <div class="form-group">
                <label for="user_profile_photo">Upload image:</label>
                <input type="file" class="form-control" name = "user_profile_photo" id="user_profile_photo">
            </div>
        </div>
    </div>
    <div class="content-update-box">
        <button type="submit" class="btn"><?php echo get_phrase('save'); ?></button>
    </div>
</form>