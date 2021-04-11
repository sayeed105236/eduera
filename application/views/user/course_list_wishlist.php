<div class="row course-container">
<?php foreach ($course_list as $course) {?>
<!-- <div class="col-sm-6">
    <div class="course-box-wrap already-purchased-course-card">
        <?php if ($course->already_enrolled) {?>
            <div class="already-purchased-course-card-icon-div" data-toggle="tooltip" data-placement="top" title="Already enrolled">
                <i class="fas fa-shopping-bag"></i>
            </div>
        <?php }?>
        <a href="<?=base_url('course/' . $course->slug)?>">
            <div class="course-box">
                <div class="course-image">
                    <img src="<?php echo $this->course_model->get_course_thumbnail_url($course->id); ?>" alt="" class="img-fluid">
                </div>
                <div class="course-details">
                    <h5 class="title"><?php echo $course->title; ?></h5>
                    <div>
                        <?php if ($course->already_enrolled) {?>
                            <button style="width: 100%; margin-bottom: 10px;" class="btn">Explore</button>
                        <?php } else {?>
                            <a href="<?=base_url('course/' . $course->slug)?>"><button style="width: 100%; margin-bottom: 10px;" class="btn">Detail</button></a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div> -->


        <div class="course-box-wrap col-md-3 responsive_div">
            <?php if ($course->already_enrolled) {?>
                <div class="already-purchased-course-card-icon-div" data-toggle="tooltip" data-placement="top" title="Already enrolled">
                    <i class="fas fa-shopping-bag"></i>
                </div>
            <?php }?>
            <a href="<?=base_url('course/' . $course->slug)?>">
                <div class="course-box">
                    <!-- <div class="course-badge position best-seller">Best seller</div> -->
                    <div class="course-image">
                        <img src="<?php echo $this->course_model->get_course_thumbnail_url($course->id); ?>" alt="" class="img-fluid">
                    </div>
                    <div class="course-details">
                        <h5 class="title"><?php echo $course->title; ?></h5>
                        <div>
                            <?php if ($course->already_enrolled) {?>
                                <button style="width: 100%; margin-bottom: 10px;" class="btn">Explore</button>
                            <?php } else {?>
                                <a href="<?=base_url('course/' . $course->slug)?>"><button style="width: 100%; margin-bottom: 10px;" class="btn">Detail</button></a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </a>

                  <!--   </div> -->
                    <!-- En popup -->
        </div>

<?php }?>



        
       
        
      
        
     
        </div>
          

