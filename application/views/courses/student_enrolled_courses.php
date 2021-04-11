<?php if($this->session->userdata('user_id')){?>
<?php if( isset($user_course_list) && count($user_course_list) > 0){?>
<div class="row course-container">
    <?php
        if(count($user_course_list ) <= 4){
            $marginTop = '40px';
        }else{
            $marginTop = '0';
        }
    ?>
    <div class="col uk-section" style="margin-bottom: <?= $marginTop?>">
         <div style="overflow: hidden;">
            <h2 style="float: left;" id="title">My Purchased Courses </h2> 

        <?php
                if(count($user_course_list) > 4){
            ?>
            <span class="view-all" style="float: right;"><a href="<?= base_url('/user/my_courses')?>">My Courses</a></span>
        <?php }?>

        </div>
        <div class="owl-carousel owl-theme">
            <?php foreach ($user_course_list as $course) {
       
            ?>
        <div class="item">
           
                <div class="flex-container resp-home-course">
                  

                    <div class="flex-item bg-violet card">
                        <div class="flex-item-inner" >
                            <a href="<?=site_url('user/course/' . $course->id . '/' . $course->slug . '/lesson/')?>">
                                <div class="tile-primary-content course-box" >
                                     <div class="course-image">
                                        <img src="<?=$this->course_model->get_course_thumbnail_url($course->id)?>" alt="" class="img-fluid">
                                    </div>
                                   
                                    <div class="course-details" style="padding: 10px;">
                                      <h5 class="title"><?=$course->title?></h5>
                                      <p class="instructors"><?=$course->short_description?></p>
                                      
                                    </div>
                                </div>
                                 </a>
                                <div class="tile-secondary-content tile-inline">
                                    <div class="popover-btns">
                                    <?php
                                    if ($this->session->userdata('user_id') != null) {
                                                $is_current_user_enrolled = is_an_user_already_enrolled_in_a_course($this->session->userdata('user_id'), $course->id);
                                            } else {
                                                $is_current_user_enrolled = false;
                                            }

                                            if ($is_current_user_enrolled): ?>
                                                
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="">
                                                    <a class=" btn share-btn btn-block btn-inline" href="<?=site_url('user/course/' . $course->id . '/' . $course->slug . '/lesson/')?>">Start Learing</a>

                                                    </div>
                                                </div>
                                              <!--   <div class="col-md-6">
                                                    <a type="button" data-toggle="modal" data-target="#shareModal" class="eduera-button btn share-btn btn-block" onclick="shareSocial('<?=$course->slug?>')"><i class="fas fa-share"></i> Share</a>
                                                </div> -->
                                            </div>


                                    <?php else: ?>


                                    <div class="cart-btn">
                                        <div class="row">
                                            <div class="col-md-6 cart">
                                                 <?php if (in_array($course->id, $this->session->userdata('cart_items'))) {?>
                                        <a class="btn btn-add-cart   addedToCart" href="<?=base_url('/home/shopping_cart')?>" >Go to cart</a>
                                        <?php } else {?>
                                        <button class="btn btn-add-cart btn-block  addToCart" type="button" course_id="<?=$course->id?>" onclick="handleCartItems(this)">Add to cart</button>
                                        <?php }?>
                                            </div>
                                            <div class="col-md-6">
                                               

                                                <?php if ($course->discount_flag == 1 && $course->discounted_price == 0) {?>
                                                    <a href = "<?=base_url('home/enroll_user_in_a_course/' . $course->id)?>" class="btn">Start now</a>
                                                <?php } else {?>
                                                 
                                                    <a href = "#" class="btn" onclick="buy_now_course('<?=$course->id?>')">Buy now</a>
                                                <?php }?>
                                            </div>


                                        </div>


                                    </div>



                                    <?php endif;?>

                                    </div>

                                    
                                    <?php if ($course->last_modified == ""): ?>
                                       <p class="last-updated"><?=$course->created_at?>

                                       </p>
                                   <?php else: ?>
                                       <div class="last-updated"><?=$course->created_at?>

                                       </div>
                                   <?php endif;?>
                                   <a href="<?php echo site_url('home/course/' . $course->slug); ?>" class="title"><?php echo $course->title; ?></a>
                                    <div class="course-popover-content">
                                        <?php $duration_in_second = 0;
                                        $lesson_count = $this->lesson_model->get_lesson_list("COUNT", array('id'), array("course_id" => $course->id));
                                        $lesson_list = $this->lesson_model->get_lesson_list("OBJECT", array("duration_in_second"), array("course_id" => $course->id));
                                        foreach ($lesson_list as $lesson) {
                                            $duration_in_second += $lesson->duration_in_second;
                                        }
                                        ?>

                                        <div class="course-meta">
                                            <span class=""><i class="fas fa-play-circle"></i>
                                            <?=$lesson_count?>
                                            </span>
                                            <span class=""><i class="far fa-clock"></i>
                                                <?=second_to_time_conversion($duration_in_second) . '&nbsp' . get_phrase('hours')?>
                                            </span>
                                            <span class=""><i class="fas fa-closed-captioning"></i><?php echo ucfirst($course->language); ?></span>
                                        </div>
                                        <div class="course-subtitle"><?=$course->short_description?></div>
                                        <?php if ($course->outcomes != null) {
                                            ?>
                                        <div class="what-will-learn">
                                            <ul>
                                                <?php

                                                $outcomes = json_decode($course->outcomes);
                                                foreach ($outcomes as $outcome): ?>
                                                <li><?php echo $outcome; ?></li>
                                            <?php endforeach;?>
                                            </ul>
                                        </div>
                                    <?php }?>
                                        


                                    </div>
                                   
                                </div>
                           
                        </div>
                    </div>
                   
                </div>
          
      </div>
               <?php 
           
       }?>

          <?php
              if(count($user_course_list) > 4){
          ?>
          <div class="item mx-auto item-inline">
                 <div class="uk-card uk-card-primary uk-card-hover uk-card-body uk-light">
                     <p><a href="<?= base_url('user/my_courses')?>">View All</a></p>
                 </div>
               
           </div>
       <?php }?>

    </div>
      </div>
</div>

<?php } 

    }?>