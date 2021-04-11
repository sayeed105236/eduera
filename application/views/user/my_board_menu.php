<section class="page-header-area my-course-area responsive-myCourse">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?=$page_title?></h1>
                <ul>
                  <li <?php if ($page_name == 'my_courses') {echo 'class="active"';}?>><a href="<?php echo site_url('user/my_courses'); ?>">All courses</a></li>
                  <li class="res-two" <?php if ($page_name == 'wishlist') {echo 'class="active"';}?>><a href="<?php echo site_url('user/wishlist'); ?>">Wishlist</a></li>
                  <!-- <li <?php if ($page_name == 'notification') {echo 'class="active"';}?>><a href="<?php echo site_url('user/notification'); ?>">Notification</a></li> -->
                  <li <?php if ($page_name == 'payment_history') {echo 'class="active"';}?>><a href="<?php echo site_url('user/payment_history'); ?>">Payment history</a></li>
                  <li class="res-four" <?php if ($page_name == 'profile') {echo 'class="active"';}?>><a href="<?php echo site_url('user/profile'); ?>">User profile</a></li>

                  <li <?php if ($page_name == 'user_assessment') {echo 'class="active"';}?>><a href="<?php echo site_url('user/user_assessment'); ?>">User Assessment</a></li>

                  <li class="res-six" <?php if ($page_name == 'course_status') {echo 'class="active"';}?>><a class="new-feature" href="<?php echo site_url('user/course_status'); ?>">Course Status 
                    <!-- <span class="badge">New</span> -->
                  </a></li>
                  <li <?php if ($page_name == 'quiz_result') {echo 'class="active"';}?>><a class="new-feature" href="<?php echo site_url('user/quiz_result'); ?>">Quiz Result
                   <!-- <span class="badge">New</span> -->
                 </a></li>
                  <li class="res-eight" <?php if ($page_name == 'my_messages') {echo 'class="active"';}?>><a href="<?php echo site_url('user/my_messages'); ?>">My Messages</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>