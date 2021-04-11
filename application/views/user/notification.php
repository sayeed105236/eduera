<?php include 'my_board_menu.php'; ?>
<section class="my-courses-area">
    <div class="container">
        <div class="row align-items-baseline">
            <div class="col-lg-6">
                <div class="my-course-filter-bar filter-box">
                    <span>Notifications</span>
                </div>
            </div>
            
        </div>
        <div class="container no-gutters" id = "my_courses_area">            
            <nav>
                <div class="no-gutters" id = "my_courses_area">
                    <?php foreach ($company_add_request_list as $key => $company_add_request) { ?>
                        
                        <div class="row notification_bar">
                            <div>
                                <p><span class="notification_bar_company_name"><?= $company_add_request->company_name ?></span> has sent you the request to add you to their company as <?= $company_add_request->designation ?> under department '<?= $company_add_request->department ?>'</p>
                                <p style="padding-top: 10px;"><span style="padding-right: 10px;"><a onclick="return confirm('Are you sure?');" href="<?= base_url('user/update_company_request/'.$company_add_request->company_id . '/ACCEPTED')?>">Accept</a></span> <span><a onclick="return confirm('Are you sure?');" href="<?= base_url('user/update_company_request/'.$company_add_request->company_id . '/REJECTED')?>">Reject</a></span></p>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </nav>
        </div>
    </div>
</section>