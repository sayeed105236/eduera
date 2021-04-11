<?php include 'my_board_menu.php'; ?>
<section class="my-courses-area">
    
    <div class="container">        
        <div class="row align-items-baseline" style="padding-bottom: 20px;">
            <div class="col-lg-6" style="width: 30%">
                <div class="my-course-filter-bar filter-box">
                    <span>Filter by</span>
                </div>
            </div>

            <div class="col-lg-6" style="width: 70%">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#make_payment_modal" style="float: right;">
                    Make payment
                </button>
            </div>
        </div>
        <?php if(count($payment_info_list) > 0){?>
        <div class="row no-gutters" id = "my_courses_area">
            <?php if ($this->session->flashdata('portwallet_error')) { ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('portwallet_error') ?>
            </div>

            <?php } ?>


            <?php if ($this->session->flashdata('portwallet_success')) { ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('portwallet_success') ?>
            </div>

            <?php } ?>

            <table class="eduera-simple-table">
                <tr>
                    <th>#</th>
                    <th>Invoice ID</th>
                    <th>Payment Date</th>
                    <th>Course title (paid for)</th>
                    <th>Paid amount</th>
                    <th>Status</th>
                </tr>
                <?php foreach ($payment_info_list as $key => $payment_info) { ?>
                    
                    <tr>
                        <td><?= ($key + 1) ?></td>
                        <td><?= $payment_info->invoice_id ?></td>
                        <td><?= $payment_info->created_at ?></td>
                        <td><?= $payment_info->title ?></td>
                        <td><?php 
                       
                        if(get_user_country() == 'bd' || get_user_country() == 'BD'){
                            echo $payment_info->paid_amount ;
                        }else{
                            echo get_usd_price($payment_info->paid_amount);
                        }
                        ?></td>
                        <td><?= $payment_info->status ?></td>
                    </tr>

                <?php } ?>
            </table>   
        </div>
        <div class="row no-gutters" id = "my_courses_area">            
            <nav>
                <?php //if (count($course_list) > $page_limit){
                    //echo $this->pagination->create_links();
                //}?>
            </nav>
        </div>
        <?php }else{
            echo 'Not found any payment history.';
        } ?>
    </div>
   
    <?php $this->load->view('user/make_payment_modal') ?>
</section>
