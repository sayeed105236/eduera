<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<section class="course-header-area" id="course-header-area">
    <div class="container">
        <div class="row align-items-end">
            <!-- Mobile View Start -->
            <div class="col-lg-4 course_overview_mobile_view">
                <div class="course-sidebar natural " id="course-sidebar">
                    <?php if ($course->preview_video_id != null || $course->preview_video_id != ""): ?>
                        <div class="preview-video-box">
                            <a data-toggle="modal" data-target="#CoursePreviewModal" onclick="loadVimeoVideo(<?=$course->preview_video_id?>, '<?=$course->title?>')">
                                <img src="<?php echo $this->course_model->get_course_thumbnail_url($course->id); ?>" alt="" class="img-fluid">
                                <span class="play-btn"></span>
                            </a>
                        </div>
                    <?php endif;?>
                    <div class="course-sidebar-text-box">
                        <?php if ($course->is_current_user_enrolled) {?>

                            <!-- If the logged in user is alrady enrolled in this course. -->
                            <div class="already_purchased" style="margin: 10px 0;">
                                <a href="<?php echo site_url('user/my_courses'); ?>">Already enrolled</a>

                            </div>
                            <!-- End of Already enrolled section -->

                        <?php } else {
        ?>

                            <div class="buy-btns">

                                <!-- Enroll now / Buy now button group -->
                                <?php if ($course->discount_flag == 1 && $course->discounted_price == 0) {?>
                                    <a href = "<?=base_url('home/enroll_user_in_a_course/' . $course->id)?>" class="btn">Start now</a>
                                <?php } else {?>
                                    <!-- <a href = "<?=base_url('home/enroll_user_in_a_course/' . $course->id)?>" class="btn">Start for free</a> -->
                                    <a href = "#" class="btn" onclick="buy_now_course('<?=$course->id?>')">Buy now</a>
                                <?php }?>

                                <!-- End of Enroll/Buy button group -->


                                <!-- Cart button-->
                                <div class="cart-btn">
                                    <?php if (in_array($course->id, $this->session->userdata('cart_items'))) {?>
                                        <a class="btn btn-add-wishlist addedToCart" href="<?=base_url('/home/shopping_cart')?>" >Go to cart</a>
                                    <?php } else {?>
                                        <button class="btn btn-add-cart addToCart" type="button" course_id="<?=$course->id?>" onclick="handleCartItems(this)">Add to cart</button>
                                    <?php }?>
                                </div>

                                <!-- End of cart button-->
                                <?php
        if ($this->session->userdata('user_type') !== null) {
        if ($wishlist) {
            if (in_array($course->id, $wishlist)) {
                ?>
                                            <a  class="btn btn-add-wishlist add_to_wishlist_<?=$course->id?>"  onclick="add_to_wishlist(<?=$course->id?>)">Already in wishlist</a >
                                        <?php } else {
                ?>

                                            <a onclick="add_to_wishlist(<?=$course->id?>)" class="btn btn-add-cart  add_to_wishlist_<?=$course->id?>">Add to wishlist</a>
                                            <?php
        }
        } else {?>
                                        <a onclick="add_to_wishlist(<?=$course->id?>)" class="btn btn-add-cart  add_to_wishlist_<?=$course->id?>">Add to wishlist</a>
                                    <?php }
        }?>

                            </div>

                        <?php }?>

                        <a type="button" data-toggle="modal" data-target="#shareModal" class="btn share-btn btn-block" onclick="shareSocial('<?=$course->slug?>')"><i class="fas fa-share"></i> Share</a>
                        <!-- Price / free button group-->
                        <div class="price">
                            <?php if ($course->discount_flag == 1 && $course->discounted_price == 0): ?>
                                <span class = "current-price"><span class="current-price">Free</span></span>
                                <?php else: ?>
                                    <?php if ($course->discount_flag == 1): ?>
                                       <span class = "current-price"><span class="current-price">
                                           <?=currency($course->discounted_price)?>
                                            
                                           </span></span>

                                        <span class="original-price"><?=currency($course->price)?></span>
                                        <?php else: ?>
                                            <span class = "current-price"><span class="current-price"><?=currency($course->price)?></span></span>
                                        <?php endif;?>
                                    <?php endif;?>
                        </div>
                                <br />
                                <!-- End of price/free button group -->


                                <div class="includes">
                                    <div class="title"><b>Includes:</b></div>
                                    <ul>
                                        <li><i class="far fa-file-video"></i><?php echo second_to_time_conversion($course->duration_in_second); ?> on demand videos</li>
                                        <li><i class="far fa-file"></i><?php echo $course->lesson_count; ?> lessons</li>
                                        <li><i class="fas fa-mobile-alt"></i>Access on mobile</li>
                                    </ul>
                                </div>
                                <?php
        if (!$course->is_current_user_enrolled) {
        if ($coupon > 0) {
            // if(count($coupon_details) <= 0){
        ?>
                                <div id="coupon">
                                    <form class="row">
                                        <input type="text" class="col-md-8 col-sm-6 col-xs-12 coupon-code" placeholder="Enter Coupon" required=""  name="coupon_code" value="<?= isset($_GET['CouponCode']) ? $_GET['CouponCode'] : ''?>"> <button  onclick="applyCoupon('<?=$course->id?>', '<?=$course->price?>', '<?=$course->discounted_price?>')" type="button" class="btn-coupon-code  col-md-3 col-sm-6 col-xs-12">Apply</button>
                                        <label id="coupon_message" class="coupon_message"></label>
                                    </form>
                                </div>
                            <?php
                        // }else{
                        //     $startdate = $coupon_details[0]->start_date;
                        //     $expire = strtotime($startdate. ' + 2 days');
                        //     echo $today = strtotime("today midnight");
                        // }
        }
        }?>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile View ENd -->

            <div class="col-lg-8">
                <div class="course-header-wrap">
                    <h1 class="title"><?php echo $course->title; ?></h1>
                    <p class="subtitle"><?php echo $course->short_description; ?></p>
                    <div class="rating-row">
                        <span class="course-badge best-seller"><?php echo $course->level; ?></span>
                        <!-- <span class="d-inline-block average-rating">4</span><span>(1 rating)</span> -->
                        <span class="enrolled-num"><?php echo $course->enrollment; ?> students enrolled</span>
                    </div>
                    <div class="created-row">
                        <!-- <span class="created-by">Created by <a href="">Global Skill</a></span> -->
                        <?php if ($course->last_modified == null) {?>
                            <span class="last-updated-date">Last updated <?=$course->created_at?></span>
                        <?php } else {?>
                            <span class="last-updated-date">Last updated <?=$course->last_modified?></span>
                        <?php }?>
                        <span class="comment">
                            <i class="fas fa-comment"></i><?php echo $course->language; ?>
                        </span>
                    </div>
                </div>
                <!-- <div class="col-lg-4">

                </div> -->
            </div>
        </div>
    </div>
</section>

<section class="course-content-area">
    <div class="container">
        <div class="row">


            <div class="col-lg-8">
                <?php if ($course->outcomes != null) {
    ?>
                    <div class="what-you-get-box">
                        <div class="what-you-get-title">What will you learn?</div>
                        <ul class="what-you-get__items">
                            <?php

    foreach ($course->outcomes as $outcome) {
        if ($outcome != "") {
            ?>
                                    <li><?php echo $outcome; ?></li>
                                    <?php

        }
    }

    ?>
                        </ul>
                    </div>
                <?php }?>
                <br>


                <div class="course-curriculum-box">
                    <div class="course-curriculum-title clearfix">
                        <div class="title float-left">Curriculam for this course</div>
                        <div class="float-right">
                            <span class="total-lectures"><?php echo $course->lesson_count; ?> lessons</span>
                            <span class="total-time"><?php echo second_to_time_conversion($course->duration_in_second); ?> Hours</span>
                        </div>
                    </div>

                    <div class="course-curriculum-accordion">
                        <?php $lesson_counter = 0;?>
                        <?php foreach ($course->section_list as $section_key => $section) {?>

                            <div class="lecture-group-wrapper">
                                <div class="lecture-group-title clearfix" data-toggle="collapse" data-target="#collapse-<?php echo $section->id; ?>" aria-expanded="false">
                                    <div class="title float-left"><?php echo $section->title; ?></div>
                                    <div class="float-right">
                                        <span class="total-lectures"><?php echo count($section->lesson_list); ?> lessons</span>
                                        <span class="total-time"><?php echo second_to_time_conversion($section->duration_in_second); ?> Hours</span>
                                    </div>
                                </div>

                                <div id="collapse-<?php echo $section->id; ?>" class="lecture-list collapse">
                                    <ul>
                                        <?php foreach ($section->lesson_list as $key => $lesson) {?>
                                            <?php $lesson_counter++;?>
                                            <?php 
                                            $video_count = 0;
                                                                                               
                                               if($course->id == 60){
                                                   $video_count = 18;
                                               }else if($course->id == 64){
                                                   $video_count = 0;
                                               }else{
                                                    $video_count = 3;
                                               }
                                           ?>
                                            <!--  <li class="lecture has-preview">
                                                <span class="lecture-title"><?php echo $lesson->title; ?></span>
                                                <?php if (($lesson->vimeo_id != null && $lesson->vimeo_id != "") && (is_an_user_instructor_in_this_course($this->session->userdata('user_id'), $course->id) || $this->session->userdata('user_type') == 'SUPER_ADMIN' || $this->session->userdata('user_type') == "ADMIN" || ($section_key == 0 && $key == 0) || $lesson_counter <= $video_count)) {?>
                                                    <span data-toggle="modal" data-target="#CoursePreviewModal" class="lecture-preview center lespre" onclick="loadVimeoVideo(<?=$lesson->vimeo_id?>, '<?=$lesson->title?>')"> Preview</span>

                                                <?php }?>
                                                <span class="lecture-time float-right"><?php echo second_to_time_conversion($lesson->duration_in_second); ?></span>
                                            </li>  -->
                                             <li class="lecture has-preview">
                                                <span class="lecture-title"><?php echo $lesson->title; ?></span>
                                                <?php 

                                                    if (($lesson->vimeo_id != null && $lesson->vimeo_id != "" || $lesson->video_id != null && $lesson->video_id != '') && (is_an_user_instructor_in_this_course($this->session->userdata('user_id'), $course->id) || $this->session->userdata('user_type') == 'SUPER_ADMIN' || $this->session->userdata('user_type') == "ADMIN" || ($section_key == 0 && $key == 0) || $lesson->preview == 1)) {?>

                                                        <span data-toggle="modal" data-target="#CoursePreviewModal" class="lecture-preview center lespre" 
                                                        onclick="loadVimeoVideo('<?=$lesson->vimeo_id?>', '<?=$lesson->title?>', '<?= ($lesson->video_id) ? $lesson->video_id: null?>', '<?= $lesson->id?>')"
                                                        > Preview</span>

                                                <?php }?>
                                                <span class="lecture-time float-right"><?php echo second_to_time_conversion($lesson->duration_in_second); ?></span>
                                            </li> 
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        <?php }?>
                        <br>
                       <?php if($course->id == 60 || $course->id == 67){?>
                         <div class="presentation row">
                             <div class="col-lg-6">
                                 <?php
                                     if($course->id == 67){
                                 ?>
                                <h3 class="badge badge-info ">Preview the PRINCE2 Presentation slide</h3>
                                 <?php }else{?>
                                  <h3 class="badge badge-info ">Preview the ITIL4 Presentation slide</h3>
                                 
                                 <?php } ?>
                             </div>
                             <div class="col-lg-3">
                                   <?php if($course->id == 60){?>
                                   <a target="_blank" href="<?= base_url('home/presentation/'.$course->id)?>">Preview</a>
                                   <?php }elseif($course->id == 67){?>
                                     <a target="_blank" href="http://demo.eduera.com.bd/PRINCE2.pdf">Preview</a>
                                   <?php }?>
                             </div>
                         </div>
                     <?php }?>  
                    </div>

                   
                </div>

              
                <?php if ($course->description != null) {?>
                    <div class="description-box view-more-parent">
                        <div class="view-more" onclick="viewMore(this,'show')">+ View More</div>
                        <div class="description-title">Description</div>
                        <div class="description-content-wrap">
                            <div class="description-content">
                                <?php echo $course->description; ?>
                            </div>
                        </div>
                    </div>
                <?php }?>
              
                <!--  Course Review Section Start-->
                <?php 
                  
                if( count($course_review) > 0){
                    
                    ?>
                <div class="student-feedback-box">
                    <div class="student-feedback-title">
                        <?php echo get_phrase('student_feedback'); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="average-rating">
                                <div class="num">
                                        <!-- Average rating call here -->
                                        <?php
                                        $total_rating =  $this->crud_model->get_ratings($course->id, true)->row()->rating;

                                        $number_of_ratings = $this->crud_model->get_ratings($course->id)->num_rows();
                                        if ($number_of_ratings > 0) {
                                          $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                                        }else {
                                          $average_ceil_rating = 0;
                                        }
                                        echo $average_ceil_rating;
                                        ?>
                                </div>
                                <div class="rating">
                                     <?php for($i = 1; $i < 6; $i++):?>
                                       <?php if ($i <= $average_ceil_rating): ?>
                                         <i class="fas fa-star filled" style="color: #f5c85b;"></i>
                                       <?php else: ?>
                                         <i class="fas fa-star" style="color: #abb0bb;"></i>
                                       <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                <div class="title"><?php echo get_phrase('average_rating'); ?></div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="individual-rating">
                                <ul>
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                    <li>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?php echo $this->crud_model->get_percentage_of_specific_rating($i, $course->id); ?>%"></div>
                                        </div>
                                        <div>
                                            <span class="rating">
                                              <?php for($j = 1; $j <= (5-$i); $j++): ?>
                                                <i class="fas fa-star"></i>
                                              <?php endfor; ?>
                                              <?php for($j = 1; $j <= $i; $j++): ?>
                                                <i class="fas fa-star filled"></i>
                                              <?php endfor; ?>

                                            </span>
                                            <span><?php echo $this->crud_model->get_percentage_of_specific_rating($i, $course->id); ?>%</span>
                                        </div>
                                    </li>
                                <?php endfor;?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--  Review section -->

                      <div class="reviews">
                        <div class="reviews-title"><?php echo get_phrase('reviews'); ?></div>
                        <ul>
                          <?php
                          $ratings = $this->crud_model->get_ratings($course->id)->result_array();

                          foreach($ratings as $rating):
                            ?>
                            <li>
                              <div class="row">
                                <div class="col-lg-4">
                                  <div class="reviewer-details clearfix">
                                    <div class="reviewer-img float-left">

                                      <img src="<?php echo $this->user_model->get_user_image_url($rating['user_id']); ?>" alt="">
                                    </div>
                                    <div class="review-time">
                                      <div class="time">
                                        <?php echo date('D, d-M-Y', strtotime($rating['created_at'])); ?> 
                                      </div>
                                      <div class="reviewer-name">
                                        <?php
                                        $user_details = $this->user_model->get_user($rating['user_id'])->row_array();
                                        echo $user_details['first_name'].' '.$user_details['last_name'];
                                        ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-8">
                                  <div class="review-details">
                                    <div class="rating">
                                      <?php
                                      for($i = 1; $i < 6; $i++):?>
                                      <?php if ($i <= $rating['rating']): ?>
                                        <i class="fas fa-star filled" style="color: #f5c85b;"></i>
                                      <?php else: ?>
                                        <i class="fas fa-star" style="color: #abb0bb;"></i>
                                      <?php endif; ?>
                                    <?php endfor; ?>
                                  </div>
                                  <div class="review-text">
                                    <?php echo $rating['review']; ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>

                    <!--  Review section end -->
                </div>
            <?php }?>
                <!--  Course Review Section End-->
            </div>



            <!-- Right side preview part -->
            <div class="col-lg-4">
                <div class="course-sidebar natural course_overview_web_view  sidebar-webview" id="course-sidebar">
                    <?php if ($course->preview_video_id != null || $course->preview_video_id != ""): ?>
                        <div class="preview-video-box">
                            <a data-toggle="modal" data-target="#CoursePreviewModal" onclick="loadVimeoVideo(<?=$course->preview_video_id?>, '<?=$course->title?>')">
                                <img src="<?php echo $this->course_model->get_course_thumbnail_url($course->id); ?>" alt="" class="img-fluid">
                                <span class="play-btn"></span>
                            </a>
                        </div>
                    <?php endif;?>
                    <div class="course-sidebar-text-box">
                        <?php if ($course->is_current_user_enrolled) {?>

                            <!-- If the logged in user is alrady enrolled in this course. -->
                            <div class="already_purchased" style="margin: 10px 0;">
                                <a href="<?php echo site_url('user/my_courses'); ?>">Already enrolled</a>

                            </div>
                            <!-- End of Already enrolled section -->

                        <?php } else {?>

                            <div class="buy-btns">

                                <!-- Enroll now / Buy now button group -->
                                <?php if ($course->discount_flag == 1 && $course->discounted_price == 0) {?>
                                    <a href = "<?=base_url('home/enroll_user_in_a_course/' . $course->id)?>" class="btn">Start now</a>
                                <?php } else {?>
                                    <!-- <a href = "<?=base_url('home/enroll_user_in_a_course/' . $course->id)?>" class="btn">Start for free</a> -->
                                    <a href = "#" class="btn" onclick="buy_now_course('<?=$course->id?>')">Buy now</a>
                                <?php }?>

                                <!-- End of Enroll/Buy button group -->


                                <!-- Cart button-->
                                <div class="cart-btn">
                                    <?php if (in_array($course->id, $this->session->userdata('cart_items'))) {?>
                                        <a class="btn btn-add-wishlist addedToCart" href="<?=base_url('/home/shopping_cart')?>" >Go to cart</a>
                                    <?php } else {?>
                                        <button class="btn btn-add-cart addToCart" type="button" course_id="<?=$course->id?>" onclick="handleCartItems(this)">Add to cart</button>
                                    <?php }?>
                                </div>

                                <!-- End of cart button-->
                                <?php
                                    if ($this->session->userdata('user_type') !== null) {
                                            if ($wishlist) {
                                                if (in_array($course->id, $wishlist)) {
                                                    ?>
                                            <a  class="btn btn-add-wishlist add_to_wishlist_<?=$course->id?>"  onclick="add_to_wishlist(<?=$course->id?>)">Already in wishlist</a >
                                        <?php } else {
                                        ?>

                                            <a onclick="add_to_wishlist(<?=$course->id?>)" class="btn btn-add-cart  add_to_wishlist_<?=$course->id?>">Add to wishlist</a>
                                            <?php
                                            }
                                         } else {?>
                                        <a onclick="add_to_wishlist(<?=$course->id?>)" class="btn btn-add-cart  add_to_wishlist_<?=$course->id?>">Add to wishlist</a>
                                    <?php }
                                }?>

                            </div>

                        <?php }?>

                        <a type="button" data-toggle="modal" data-target="#shareModal" class="btn share-btn btn-block" onclick="shareSocial('<?=$course->slug?>')"><i class="fas fa-share"></i> Share</a>
                        <!-- Price / free button group-->
                        <div class="price">
                            <?php if ($course->discount_flag == 1 && $course->discounted_price == 0): ?>
                                <span class = "current-price"><span class="current-price">Free</span></span>
                                <?php else: ?>
                                    <?php if ($course->discount_flag == 1): ?>
                                       <span class = "current-price"><span class="current-price">
                                           <!-- <?=currency($course->discounted_price)?> -->
                                            <?php if(get_user_country() == 'bd' || get_user_country() == 'BD'){
                                               
                                                echo currency($course->discounted_price);

                                               }else{
                                                    
                                                    echo  get_course_discounted_price($course->id);

                                             }?>
                                           </span></span>
                                        <span class="original-price">

                                            <!-- <?=currency($course->price)?> -->
                                                
                                                <?php if(get_user_country() == 'bd' || get_user_country() == 'BD'){
                                                   
                                                   echo currency($course->price);

                                                   }else{
                                                     echo  get_course_price($course->id);
                                                        

                                                 }?>
                                            </span>
                                        <?php else: ?>
                                            <span class = "current-price"><span class="current-price">

                                                <!-- <?=currency($course->price)?> -->
                                                    
                                                    <?php if(get_user_country() == 'bd' || get_user_country() == 'BD'){
                                                        // if($course->id == 70){
                                                        //    echo '$363';
                                                        // }else{
                                                        //     echo currency($course->price);
                                                        // }
                                                        echo currency($course->price);
                                                       }else{
                                                        echo  get_course_price($course->id);

                                                     }?>
                                                </span></span>
                                        <?php endif;?>
                                    <?php endif;?>
                        </div>
                                <br />
                                <!-- End of price/free button group -->


                                <div class="includes">
                                    <div class="title"><b>Includes:</b></div>
                                    <ul>
                                        <li><i class="far fa-file-video"></i><?php echo second_to_time_conversion($course->duration_in_second); ?> on demand videos</li>
                                        <li><i class="far fa-file"></i><?php echo $course->lesson_count; ?> lessons</li>
                                        <li><i class="fas fa-mobile-alt"></i>Access on mobile</li>
                                    </ul>
                                </div>
                                <?php
                                if(!($course->discount_flag == 1 && $course->discounted_price == 0)){
if (!$course->is_current_user_enrolled) {
    if ($coupon > 0) {
        // if( count($coupon_details) <= 0){
        ?>
                                <div id="coupon_code">
                                    <form class="row">
                                        <input type="text" class="col-md-8 col-sm-6 col-xs-12 coupon-code" placeholder="Enter Coupon" required=""  name="coupon_code" value="<?= isset($_GET['CouponCode']) ? $_GET['CouponCode'] : ''?>"> <button  onclick="applyCoupon('<?=$course->id?>', '<?=$course->price?>', '<?=$course->discounted_price?>')" type="button" class="btn-coupon-code  col-md-3 col-sm-6 col-xs-12" >Apply</button>
                                        <label id="coupon_message" class="coupon_message"></label>
                                    </form>
                                </div>
                            <?php

                    // }else{
                    //    $startdate = $coupon_details[0]->end_date;
                    //    $expire = strtotime($startdate. ' + 1 days');
                    //    $today = strtotime("today midnight");

                    //    if($today >= $expire){
                    //        echo "<h5 style='color:red'>Coupon Expired.</h5>";
                    //    } else {
                    //        echo "<h5 style='color:green'>Coupon Applied.</h5>";
                    //    }

                    //    if($coupon_details[0]->coupon_limit != NULL && $coupon_details[0]->coupon_limit != 0){
                            
                    //         if($coupon_details[0]->coupon_limit == $coupon_details[0]->already_applied){
                    //             echo "<h5 style='color:red'>Coupon Limit Exceeded.</h5>";
                    //         }

                    //    }else{

                            

                    //    }


                    // }
}
}
}?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

      



        <!-- Start Showing preview video -->
        <div class="modal left fade video-dialog" id="CoursePreviewModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog " role="document">
                <div class="modal-content course-preview-modal">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span id="vimeo_player_title"></span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" id="vm" onclick="pausePreview('vimeo')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <button style="display: none;" type="button" class="close" data-dismiss="modal" id="yt" onclick="pausePreview('youtube')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="course-preview-video-wrap" id="videowrapper">
                            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/global/plyr/plyr.css">
                            <div id="preloader" style="display:none">
                              <div id="status"></div>
                            </div>
                            <div class="plyr__video-embed" id="player">
                               
                            </div>
                            <div style="display: none;"  id="ytplayer">
                             
                            </div>
                            <?php if(count($lesson_preview) > 0){?>
                            <div class="free-sample-videos" style="margin: 20px;"> 
                                    <h5>Free Sample Videos:</h5>
                                    <div class="lesso-list">
                                    <?php 
                                      
                                    foreach($lesson_preview as $key=>$preview){
                                           
                                        ?>
                                        <div id="lesson-preview_<?=$preview->vimeo_id?>" class="lesson-preview row lesson-inline" onclick="loadVimeoVideo('<?=$preview->vimeo_id?>', '<?=$preview->title?>', '<?= ($preview->video_id) ? $preview->video_id: null?>', '<?= $preview->id?>')">
                                            <!-- <div class="col-md-2"></div> -->
                                            <div class="col-md-9">
                                                <p><?= $preview->title?></p>
                                            </div>
                                            <div class="col-md-3">
                                                <span><?= second_to_time_conversion($preview->duration_in_second)?></span>
                                            </div>
                                        </div>
                                        
                                    <?php }
                                 
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
                            <script src="<?php echo base_url();?>assets/global/plyr/plyr.js"></script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

   
<script src="https://unpkg.com/navigator.sendbeacon"></script>

<script src="https://player.vimeo.com/api/player.js"></script>


<script type="text/javascript">
     coupon_code = '';

    window.onload = function(){

      coupon_code_for_web = $("#coupon_code input[name='coupon_code']").val();
      coupon_code_for_mobile = $("#coupon input[name='coupon_code']").val();
    

      if(coupon_code_for_web != null && coupon_code_for_mobile != null && coupon_code_for_mobile != '' && coupon_code_for_web != ''){
        coupon_code = coupon_code_for_web;
        // // console.log(coupon_code)
        // console.log(coupon_code_for_web);
        // console.log(coupon_code_for_mobile);
            setInterval(function(){ 
               $(".btn-coupon-code").click();
            },2000);
      }


        
  }

   $(function() {
     $('#CoursePreviewModal').on('shown.bs.modal', function (e) {
       var src = $('#videowrapper').attr('data-iframe-src');
       $('#videowrapper').attr('src', src);
     });

     $('#CoursePreviewModal').on('hidden.bs.modal', function (e) {
       $('#videowrapper').attr('src', '');
     });
   });

   
  course_id = '<?= $course->id?>';
   var videoDialogPlayer;

    /*auto video open*/
    $(document).ready(function(){

        // setTimeout(function() {
        //     $('#CourseFirstPreviewModal').modal();
        // }, 3000);



    preview_video_id =    '<?=$course->preview_video_id?>';
    course_title =  '<?=$course->title?>';

        
        // if(preview_video_id != ''){ 
        //     // $("#CoursePreviewModal").modal('show');
        //     $("#vimeo_player_title").html(course_title);
        //     $("#player").html("");
        // }  

        // if(preview_video_id != ''){ 
        //     var options = {
        //         id:preview_video_id ,
        //         width: 640,
        //         loop: false,
        //         quality:'240p',
        //         autoplay:true,
        //         title: true,
        //         byline : true,
        //     };
        //     player1 = new Vimeo.Player('player', options);
        //     player1.setVolume(0.5);

        //     player1.getDuration().then(function(duration) {
        //     });
        // }

    });
    

    function applyCoupon(course_id, price, discounted_price){
        clearInterval();
        coupon_code_for_web = $("#coupon_code input[name='coupon_code']").val();
        coupon_code_for_mobile = $("#coupon input[name='coupon_code']").val();
       
       // console.log(coupon_code_for_web);
       // console.log(coupon_code_for_mobile);
        if(coupon_code_for_mobile == '' || coupon_code_for_mobile == undefined){
            coupon_code = coupon_code_for_web;
        }else{

            coupon_code = coupon_code_for_mobile;

        }

        user_id = '<?=$this->session->userdata('user_id') ? $this->session->userdata('user_id') : ''?>';
        if(coupon_code == '' || coupon_code == null){
            $(".coupon_message").text("Please enter the coupon code.");
        // }else if(user_id == ''){
        //     document.getElementById("coupon_message").style.fontSize = "medium";
        //     $(".coupon_message").text("Please login first.");
        }else{
            // console.log(coupon_code);
            $.ajax({
                url: '<?php echo base_url('rest/api/get_coupon_info/'); ?>'+ coupon_code,
                type: 'POST',
                dataType: 'json',
                success: function(response){
                    /*current date pick*/

                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = today.getFullYear();

                    today = yyyy + '-' + mm + '-' + dd;

                    /*current date pick end*/


                    if(response === undefined || response.length == 0){
                        $(".coupon_message").text("The coupon code entered is not exists. Perhaps you used the wrong coupon code?.")
                    }else{
                        if(response){

                            var startDate = Date.parse(response[0].start_date) / 1000;
                            var endDate = Date.parse(response[0].end_date) / 1000;
                            var currentDate = Date.parse(today) / 1000;
                           
                            // exit();
                            
                            if(response[0].course_id != course_id){
                                $(".coupon_message").text("The coupon code entered is not valid for this course. Perhaps you used the wrong coupon code?.");
                            }else  if(!(currentDate >= startDate && currentDate <= endDate) || response[0].status == 0){
                          
                                $(".coupon_message").text("Coupon Expired!");

                            }else if(parseInt(response[0].coupon_limit) <= parseInt(response[0].already_applied)){

                                $(".coupon_message").text("Coupon Limit Exceeded.");
                                
                            }else{

                                // console.log(response[0].coupon_limit);
                                // console.log(response[0].already_applied);

                                // exit();
                                document.getElementById("coupon_message").style.color = "green";
                                document.getElementById("coupon_message").style.fontSize = "medium";
                                course_price = 0;
                                if(discounted_price > 0){
                                    course_price = discounted_price;
                                }else{
                                    course_price = price;
                                }

                                if(response[0].discount_type == 'percentage' && response[0].discount == 100 || response[0].discount_type == 'taka' && response[0].discount == course_price){
                                    /*insert enrolled*/
                                    url1 = '<?php echo site_url('rest/api/save_enrollment'); ?>';
                                    $.ajax({
                                        url: url1,
                                        type : 'POST',
                                        data : {course_id : course_id, price: price, discounted_price: discounted_price, coupon_id: response[0].id},
                                        success: function(response) {

                                            result = JSON.parse(response);
                                            if(result.success == true){
                                                $(".coupon_message").text("Coupon Applied!");
                                                window.location = '<?=base_url("user/my_courses/")?>'
                                            }else{
                                                document.getElementById("coupon_message").style.color = "red";
                                                $(".coupon_message").text("Coupon not Applied!");
                                            }

                                        }
                                    });

                                }else{
                                    $(".coupon_message").text("Coupon Applied!");
                                    url1 = '<?php echo site_url('rest/api/add_to_cart'); ?>';
                                    $.ajax({
                                        url: url1,
                                        type : 'POST',
                                        data : {course_id : course_id},
                                        success: function(response) {
                                            result = JSON.parse(response);
                                            window.location = '<?=base_url("home/shopping_cart/")?>' + coupon_code;
                                        }
                                    });
                                }


                            }
                        }

                    }
                }
            })
            .done(function() {
                // console.log("success");
            })
            .fail(function() {
                // console.log("error");
            })
            .always(function() {
                // console.log("complete");
            });

        }
    }

    previous_id = '';
    current_id = '';
    next_vimeo_id = '';
    function vplayer(vimeo_id='', title, video_id= '', lesson_id = ''){
        if(vimeo_id != ''){


            

            $("#ytplayer").hide();
             $("#player").show();

             $("#yt").hide();
             $("#vm").show();
            
            if(current_id == ''){
                current_id = vimeo_id;
                // document.getElementById('lesson-preview_'+current_id).style.backgroundColor = "#3c3b37";
            }else{
                // document.getElementById('lesson-preview_'+current_id).style.backgroundColor = "";
                previous_id = current_id;
                current_id = vimeo_id;

                // document.getElementById('lesson-preview_'+current_id).style.backgroundColor = "#3c3b37";
            }


            var options = {
                id:vimeo_id ,
                width: 640,
                loop: false,
                quality:'240p',
                autoplay:true,
                title: true,
                byline : true
            };
           


            if(previous_id){
                player1.destroy();

                player1 = new Vimeo.Player('player', options);
                player1.setVolume(0.5);

                player1.on('ended', function(data){
                    
                 document.getElementById('preloader').style.display = "block";
                 jQuery("#preloader").fadeOut(2000);

                    $.ajax({
                      url: '<?= base_url('/rest/api/get_next_preview_video')?>',
                      type: 'POST',
                      dataType: 'json',
                      data: { course_id: course_id, lesson_id : lesson_id},
                      success: function (res){
                          if (res === undefined || res.length == 0) {
                          }else{
                              loadVimeoVideo(res[0].vimeo_id, res[0].title, res[0].video_id, res[0].id);
                          }
                          
                      }
                  })
                  .done(function() {
                      console.log("success");
                  })
                  .fail(function() {
                      console.log("error");
                  })
                  .always(function() {
                      console.log("complete");
                  });
                });
            }else{
                player1 = new Vimeo.Player('player', options);
                player1.setVolume(0.5);

            
            
               player1.on('ended', function(data){

                document.getElementById('preloader').style.display = "block";
                 jQuery("#preloader").fadeOut(2000);

                         $.ajax({
                             url: '<?= base_url('/rest/api/get_next_preview_video')?>',
                             type: 'POST',
                             dataType: 'json',
                             data: { course_id: course_id, lesson_id : lesson_id},
                             success: function (res){

                                if (res === undefined || res.length == 0) {

                                 }else{
                                     loadVimeoVideo(res[0].vimeo_id, res[0].title, res[0].video_id, res[0].id);
                                 }
                                 
                             }
                         })
                         .done(function() {
                         })
                         .fail(function() {
                             console.log("error");
                         })
                         .always(function() {
                             console.log("complete");
                         });
               });
                
            }
            

         
      
            
        }else{
            $("#player").hide();
            $("#ytplayer").show();
            $("#yt").show();
            $("#vm").hide();

            var el = document.createElement('script');
            el.src = "//www.youtube.com/iframe_api";
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(el, s);
               
           window.onYouTubeIframeAPIReady = function () {
             videoDialogPlayer = new YT.Player('ytplayer', {
               height: '355',
               width: '498',
               videoId: video_id,
               events: {
               'onReady': onPlayerReady
             },
             });
           }
               function onPlayerReady(event) {
                  event.target.playVideo();
                }
                    
        }
    }
  
  

    function loadVimeoVideo(vimeo_id='', title, video_id= '', lesson_id= ''){
        $("#vimeo_player_title").html(title);
        $("#player").html("");

        
        this.vplayer(vimeo_id, title, video_id, lesson_id);

    }



    function pausePreview(value){
        if(value == 'vimeo'){
            player1.destroy();
        }else{
            // videoDialogPlayer = null;
            videoDialogPlayer.stopVideo();
            // videoDialogPlayer.stopVideo();
               // videoDialogPlayer.destroy();
                 // Clear out the reference to the destroyed player
        }
       
       
    }
</script>
<script type="text/javascript">

    /*$(document).ready(function(){
        var height = $("#course-header-area").height() + 60;
        $("#course-sidebar").css("margin-top", "-" + height + "px");
    });*/

    function viewMore(element,visibility){
        if(visibility=='hide'){
            $(element).parent('.view-more-parent').addClass('expanded');
            $(element).remove();
        }
        else if($(element).hasClass('view-more')){
            $(element).parent('.view-more-parent').addClass('expanded has-hide');
            $(element).removeClass('view-more').addClass('view-less').html('- View Less');
        }
        else if($(element).hasClass('view-less')){
            $(element).parent('.view-more-parent').removeClass('expanded has-hide');
            $(element).removeClass('view-less').addClass('view-more').html('+ View More');
        }
    }





    function buy_now_course(course_id){
        url1 = '<?php echo site_url('rest/api/add_to_cart'); ?>';
        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : course_id},
            success: function(response) {
                result = JSON.parse(response);
                window.location = '<?=base_url("home/shopping_cart")?>';
            }
        });
    }


    function handleCartItems(elem) {
        url1 = '<?php echo site_url('rest/api/add_to_cart'); ?>';
        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : $(elem).attr('course_id')},
            success: function(response) {
result = JSON.parse(response);
//if (result.success){
    $('#cart_items_number').html(result.cart_items_count);
    $(elem).addClass('addedToCart');
// $(elem).text("This course is in cart");
$(".addToCart").hide();
$(".cart-btn").append("<a class='btn btn-add-wishlist addedToCart' href='<?=base_url('/home/shopping_cart')?>'>Go to cart</a>");

//}
}
});
    }

    function add_to_wishlist(course_id){

        $.ajax({
            url : "<?php echo base_url('/user/add_to_wishlist'); ?>",
            type : "POST",
            data: { course_id : course_id },
            success : function(data) {
                var json = JSON.parse(data);
                if(json.action == 'Added'){
                    $(".add_to_wishlist_"+course_id).text('Already in wishlist');
// $(".add_to_wishlist_"+course_id).css("background-color", "green");
$("#wishlist_count").text(json.count);
}else{
    $(".add_to_wishlist_"+course_id).text('Save in wishlist');
// $(".add_to_wishlist_"+course_id).css("background-color", "#EC5252");
$("#wishlist_count").text(json.count);
}
},
error : function(data) {
// do something
}
});
    }


</script>
