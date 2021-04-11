<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<!-- display=none to hide this section (ASIB) -->
<div class="header-top-section"></div>

     <div class="header-contact-section">
        <h6>If you have any query please contact us info@eduera.com.bd , 01766343434, 01711958556, 01744187187</h6>
   
    </div>



<section class="menu-area">
    <div class="container-xl">

        <div class="row">
            <div class="col">

                <nav class="navbar navbar-expand-lg navbar-light bg-light">

                    <ul class="mobile-header-buttons">
                        <li><a class="mobile-nav-trigger" href="#mobile-primary-nav">Menu<span></span></a></li>
                        <li><a class="mobile-search-trigger" href="#mobile-search">Search<span></span></a></li>
                    </ul>

                    <a href="<?php echo site_url(''); ?>" class="navbar-brand" href="#">
                        <img src="<?php echo base_url() . 'uploads/system/eduera-logo-small.png'; ?>" alt="" height="40">
                    </a>
                        <div class="cart-box menu-icon-box responsive-cart" id="mobile-cart" >
                        <div class="icon">
                           <a href="<?php echo site_url('home/shopping_cart'); ?>"><i class="fas fa-shopping-cart"></i></a>
                            <?php if ($this->session->userdata('cart_items') !== null) {?>
                                <span class="number" id = "cart_items_number"><?php echo sizeof($this->session->userdata('cart_items')); ?></span>
                            <?php }?>

                        </div>
                    </div>


                    <?php include 'menu.php';?>


                    <!-- search field -->
                    <form id="header-search-area" class="inline-form" action="<?php echo site_url('home/courses'); ?>" method="get">
                        <div class="input-group search-box mobile-search">
                            <input id="header-search-field" type="text" name ='query' class="form-control" placeholder="<?php echo get_phrase('search_for_courses'); ?>" autocomplete="off">
                            <div class="input-group-append search-button">
                                <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="header-search-field-suggetion">
                            <ul>
                            </ul>
                        </div>
                    </form>
                    <!-- search field -->


                   

                    <!-- logged in items -->
                    <?php if ($this->session->userdata('user_type') !== null) {?>
                        <?php if(isset($user_data)){
                                if($user_data->instructor == 1){
                            ?>
                        <div class="instructor-box menu-icon-box resp-intrct-btn">
                            <div class="icon" style="margin-right: -25px !important;padding-right: 0px !important;">
                                <a href="<?= base_url('instructor')?>" >Instructor</a>
                            </div>

                        </div>
                    <?php }}
                    ?>
                        <div class="instructor-box menu-icon-box responsive-myCourses">
                            <div class="icon new-icon responsive-icon">
                                <a href="<?=base_url('user/my_courses')?>">My Courses</a>
                            </div>

                        </div>
                        <div class="instructor-box menu-icon-box responsive-logout" id="mobile-logout">
                            <div class="icon">
                                <a class="login-logout-icon" href="<?=base_url('login/logout')?>">Logout</a>
                            </div>
                        </div>

                        <!--<div class="instructor-box menu-icon-box">-->
                        <!--    <div class="icon">-->

                        <!--        <a href="<?=base_url('home/corporate')?>" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0; min-width: 100px;">Corporate</a>-->
                        <!--    </div>-->

                        <!--</div>-->


                        <div class="wishlist-box menu-icon-box" id="wishlist_items">
                            <div class="icon">
                                <a href="<?=base_url('user/wishlist')?>"><i class="far fa-heart"></i></a>
                                <span class="number" id="wishlist_count"><?=count($wishlist)?></span>
                            </div>
                        </div>

                       <!--  <div class="wishlist-box menu-icon-box" id = "wishlist_items">
                            <div class="icon">
                                <a href="<?=base_url('user/notification')?>"><i class="fas fa-bell"></i></a>
                                <span class="number" id="notification_count"><?=($notification_count)?></span>
                            </div>
                        </div> -->

                        <div class="wishlist-box menu-icon-box" id = "wishlist_items">
                            <div class="icon">
                                <a href="<?=base_url('home/user_message')?>"><i class="fas fa-bell"></i></a>
                                <?php
                                    if(isset($total_unseen_message)){
                                ?>
                                <span class="number" id="message_notification_count">
                                    <?php
                                            echo $total_unseen_message;
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>

                    <?php }?>



                    <!-- cart icon -->
                     <div class="cart-box menu-icon-box" id="web-cart">
                        <div class="icon">
                            <a href="<?php echo site_url('home/shopping_cart'); ?>"><i class="fas fa-shopping-cart"></i></a>
                            <?php if ($this->session->userdata('cart_items') !== null) {?>
                                <span class="number" id = "cart_items_number"><?php echo sizeof($this->session->userdata('cart_items')); ?></span>
                            <?php }?>
                        </div>
                    </div> 
                    <!-- end of cart icon -->


                    <!-- logged out items -->
                    <?php if ($this->session->userdata('user_type') !== null) {?>
                        <div class="user-box menu-icon-box">
                            <div class="icon">
                                <?php if(is_our_member_in_eduera($this->session->userdata('user_id')) != null){

                                    $member =  ucfirst(is_our_member_in_eduera($this->session->userdata('user_id'))[0]->membership_type);
                                    $color_code = '';
                                    if($member == 'Platinum'){
                                        $color_code = 'radial-gradient(circle, rgba(1,229,242,1) 9%, rgba(7,79,117,1) 63%)';
                                    }else if($member == 'Gold'){
                                        $color_code = 'radial-gradient(circle, rgba(243,222,118,1) 0%, rgba(241,218,113,1) 9%, rgba(208,162,50,1) 63%)';
                                    }else{
                                        $color_code = 'radial-gradient(circle, rgba(242,242,242,1) 0%, rgba(179,179,179,1) 63%)';
                                    }

                                    ?>
                                 
                                <?php if($member != ""){  ?>
                                <span class="membership"  style="background: <?= $color_code?>" title="You are a <?=$member?> member.">  
                                       <?= $member; ?>
                                </span>
                                <?php } ?>
                                  <?php   }?>
                                <a href="javascript::">
                                    <?php if ($user_data->profile_photo_name === null || $user_data->profile_photo_name === "") {?>
                                        <img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="img-fluid">
                                    <?php } else {?>
                                        <img src="<?php echo base_url() . 'uploads/user_image/' . $user_data->profile_photo_name; ?>" alt="" class="img-fluid">
                                    <?php }?>
                                </a>
                            </div>
                            <div class="dropdown user-dropdown corner-triangle top-right">
                                <ul class="user-dropdown-menu">

                                    <li class="dropdown-user-info">
                                        <a href="<?=base_url('user/profile')?>">
                                            <div class="clearfix">
                                                <div class="user-image float-left">
                                                    <img src="<?php echo base_url() . 'uploads/user_image/' . $user_data->profile_photo_name; ?>" alt="" class="img-fluid">
                                                </div>
                                                <div class="user-details">
                                                    <div class="user-name">
                                                        <span class="hi">Hi,</span>
                                                        <?=$this->session->userdata('name')?>
                                                    </div>
                                                    <div class="user-email">
                                                        <span class="email"><?=$this->session->userdata('email')?></span>
                                                        <span class="welcome">Welcome back</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="user-dropdown-menu-item"><a href="<?=base_url('user/my_courses')?>"><i class="far fa-gem"></i>My courses</a></li>
                                    <li class="user-dropdown-menu-item"><a href="<?=base_url('user/wishlist')?>"><i class="far fa-heart"></i>My Wishlist</a></li>
                                    <li class="user-dropdown-menu-item"><a href="<?php echo site_url('user/my_messages'); ?>"><i class="far fa-envelope"></i>My Messages</a></li>

                                    <li class="dropdown-user-logout user-dropdown-menu-item"><a href="<?=base_url('login/logout')?>">Log out</a></li>
                                </ul>
                            </div>
                        </div>

                    <?php } else {?>
                        <!-- width=100% responsive (ASIB) -->
                        <div class="sign-in-box btn-group">

                            <!-- width=48% responsive (ASIB) -->
                            <a target="_blank" class="btn btn-sign-in instructor-box menu-icon-box responsive-become-a-trainer" id="become-a-trainer" href="https://docs.google.com/forms/d/e/1FAIpQLSc5_LsdKgJjaa3D5rINLGT7cP1300hGUF7Mf6Qlgbv_58SDZg/viewform" >Become a trainer</a>

                            <!-- width=23% responsive (ASIB) -->
                            <a href="<?php echo site_url('login'); ?>" class="btn btn-sign-in responsive-login"><?php echo get_phrase('log_in'); ?></a>

                            <!-- width=23% responsive (ASIB) -->
                            <a href="<?php echo site_url('login'); ?>" class="btn btn-sign-up responsive-signin"><?php echo get_phrase('sign_up'); ?></a>


                          

                          <!-- <div class="instructor-box menu-icon-box " id="become-a-trainer">
                              <div class="icon">

                                  <a target="_blank" href="https://bit.ly/3gHdsFt" >Become a trainer</a>
                              </div>

                          </div> -->
                        </div>

                       
                    <?php }?>
                    <!-- end of logged out items -->


                </nav>
            </div>
        </div>
    </div>
</section>



<script type="text/javascript">

    // if (screen.width <= 699) {
    // document.location = "mobile.html";
    //     document.getElementById("become-a-trainer").style.display = "none"; 
    //     document.getElementById("become-trainer").style.display = "block"; 
    //     document.getElementById("mobile-cart").style.display = "block"; 
    //     document.getElementById("web-cart").style.display = "none"; 
    // }if(screen.width > 699){
    //      document.getElementById("become-a-trainer").style.display = "block"; 
    //      document.getElementById("become-trainer").style.display = "none"; 
    //      document.getElementById("mobile-cart").style.display = "none"; 
    //      document.getElementById("web-cart").style.display = "block"; 

    // }

    

    $(document).ready(function(){

        $(document).mouseup(function (e) {
            if ($(e.target).closest("#header-search-area").length == 0) {
                $(".header-search-field-suggetion").hide();
            }
        });

        $("#header-search-field").on("change paste keyup", function() {
           var query_text = $(this).val();

            $.ajax({
                type: "GET",
                url: "<?php echo site_url('rest/api/get_header_search_result/'); ?>" + query_text,
                success: function(response){
                    result = JSON.parse(response);

                    var html = '';
                    for( var j = 0; j < result.object_list.length; j++){
                        html += '<li><a href="<?=base_url("course/")?>' + result.object_list[j].slug + '">' + result.object_list[j].title + '<a/></li>';
                    }
                    $(".header-search-field-suggetion ul").html(html);
                    $(".header-search-field-suggetion").show();
                },
                error: function (request, status, error) {
                }
            });
        });
    });

     /* Countdown code*/
   /* const second = 1000,
          minute = second * 60,
          hour = minute * 60,
          day = hour * 24;

    let countDown = new Date('Aug 17, 2020 23:00:00').getTime(),
        x = setInterval(function() {    

          let now = new Date().getTime(),
              distance = countDown - now;

            
           
                 document.getElementById('days').innerText = Math.floor(distance / (day)),
            document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);
           
         

        //   do something later when date is reached
        //   if (distance < 0) {
        //     clearInterval(x);
        //     'IT'S MY BIRTHDAY!;
        //   }

        }, second);*/

</script>