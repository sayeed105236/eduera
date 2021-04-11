<?php include 'my_board_menu.php'; ?>

<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">
                    <div class="user-dashboard-sidebar resp-side-size">
                        <div class="user-box">
                            <?php if ($user_data->profile_photo_name === null || $user_data->profile_photo_name === "") { ?>
                                <img src="<?php echo base_url().'uploads/user_image/placeholder.png';?>" alt="" class="img-fluid">
                            <?php } else { ?>
                                <img src="<?php echo base_url().'uploads/user_image/'.$user_data->profile_photo_name;?>" alt="" class="img-fluid">
                            <?php } ?>
                            <div class="name">
                                <div class="name"><?= $user_data->first_name . ' ' . $user_data->last_name ?></div>
                            </div>
                        </div>
                        <div class="user-dashboard-menu">
                            <ul>
                                <li <?php if($sub_page_name == 'profile_info'){ echo 'class="active"'; } ?>><a href="<?php echo site_url('user/profile/'); ?>">Profile</a></li>
                                <li <?php if($sub_page_name == 'profile_credential'){ echo 'class="active"'; } ?>><a href="<?php echo site_url('user/profile/credential'); ?>">Credential</a></li>
                                <li <?php if($sub_page_name == 'profile_photo'){ echo 'class="active"'; } ?>><a href="<?php echo site_url('user/profile/photo'); ?>">Photo</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-dashboard-content">
                    	<div class="content-title-box">
						    <div class="title"><?= $sub_page_title; ?></div>
						    <!-- <div class="subtitle">Add information about yourself to share on your profile</div> -->
						</div>
                    	<?php include $sub_page_name.'.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>