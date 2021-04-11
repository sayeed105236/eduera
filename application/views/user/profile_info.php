<form action="<?php echo base_url('user/profile/info'); ?>" method="post">
    <div class="row content-box">
            <div class="form-group">
            <?php echo validation_errors(); ?>

            <?php if ($this->session->flashdata('profile_info_update_successful')) {?>

            <div class="alert alert-success alert-dismissible fade show col" role="alert">
                <strong></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?=$this->session->flashdata('profile_info_update_successful')?>
            </div>

            <?php }?>


            <?php if ($this->session->flashdata('failed_to_update_profile_info')) {?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?=$this->session->flashdata('failed_to_update_profile_info')?>
            </div>

            <?php }?>

            <?php if (strlen($user_data->phone) <= 0 ) {?>
             <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Info!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                Please fillup your phone number field for further process.
            </div>

            <?php } else if (strlen($user_data->phone) < 11) {?>
                 <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Info!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Please fillup your valid phone number  for further process.
                </div>
            <?php }?>
        </div>
        <div class="basic-group" style="width: 100%">

            <div class="form-group">
                <label for="first_name">First name:</label>
                <input type="text" class="form-control" name="first_name" id="FristName" placeholder="First name" value="<?=$user_data->first_name?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last name:</label>
                <input type="text" class="form-control" name="last_name" placeholder="Last name" value="<?=$user_data->last_name?>">
            </div>
            <div class="form-group">
                <label for="last_name">Phone Number:</label>
                <input type="text" class="form-control" name="phone" placeholder="Phone Number" value="<?=$user_data->phone?>" required>
            </div>
            <div class="form-group">
                <label for="Biography">Biography:</label>
                <textarea class="form-control author-biography-editor" name="biography" id="Biography"><?=$user_data->biography?></textarea>
            </div>
            
        </div>

        <div class="link-group" style="width: 100%">
            <div class="form-group">
                <input type="text" class="form-control" maxlength="60"  name="twitter" placeholder="Twitter link" value="<?=$user_data->social_links->twitter?>">
                <small class="form-text text-muted">Add your twitter link.</small>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" maxlength="60" name = "facebook" placeholder="Facebook link" value="<?=$user_data->social_links->facebook?>">
                <small class="form-text text-muted">Add your facebook link.</small>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" maxlength="60" name = "linkedin" placeholder="Linkedin link" value="<?=$user_data->social_links->linkedin?>">
                <small class="form-text text-muted">Add your linkedin link.</small>
            </div>
        </div>

    </div>
    <div class="content-update-box">
        <button type="submit" class="btn">Save</button>
    </div>
</form>