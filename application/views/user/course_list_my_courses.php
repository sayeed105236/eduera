
<?php if (count($course_list) > 0) {
	?>
    <table class="eduera-simple-table resp-myCouTab">
        <tr>
            <th style="font-size: 18px;">Course</th>
            <th>Enrolled Price</th>
            <th>Paid amount</th>
            <th>Expiry Date</th>
        </tr>
        <?php foreach ($course_list as $course) {
		?>
            <tr>
                <td>
                    <div class="row">
                        <div class="col-md-3 resp-img-pos"><img src="<?php echo $this->course_model->get_course_thumbnail_url($course->id); ?>" alt="" class="img-fluid resp-img-size"></div>
                        <div class="col-md-9">
                            <h5 class="title resp-hSize"><?php echo $course->title; ?></h5>
                            <p class="description resp-pShow"><?=$course->short_description?></p>



                            <?php if($course->mock_test != 1){?>
                                <div class="course-meta resp-myCoumeta">

                                    <?php $duration_in_second = 0;
                                        $lesson_count = $this->lesson_model->get_lesson_list("COUNT", array('id'), array("course_id" => $course->id));
                                        $lesson_list = $this->lesson_model->get_lesson_list("OBJECT", array("duration_in_second"), array("course_id" => $course->id));
                                        foreach ($lesson_list as $lesson) {
                                            $duration_in_second += $lesson->duration_in_second;
                                        }
                                    ?>

                                    <span class=""><i class="fas fa-play-circle"></i>
                                        <?=$lesson_count?>
                                    </span>

                                    <span class=""><i class="far fa-clock"></i>
                                        <?=second_to_time_conversion($duration_in_second) . '&nbsp' . get_phrase('hours')?>
                                    </span>

                                    <span class=""><i class="fas fa-closed-captioning"></i> <?php echo ucfirst($course->language); ?></span>
                                </div>


                            <?php }?>



                            <div>
                                <?php

                                if($course->expiry_date == null){ ?>
                                    <a href="<?=site_url('user/course/' . $course->id . '/' . $course->slug . '/lesson/')?>" class="eduera-button btn resp-strt-btn"><?= $course->mock_test ? 'Start Practice Exam' : 'Start Lesson'?> </a>
                                <?php }else{
                                    // $expiry_date = date('Y-m-d', strtotime('-'.$course->expiry_month. ' month ago'));
                                  
                                    if($course->expiry_date == date('Y-m-d')){?>
                                        <a  class="expired-btn eduera-button">Date Expired</a>
                                   <?php }else{?>
                                        <a href="<?=site_url('user/course/' . $course->id . '/' . $course->slug . '/lesson/')?>" class="eduera-button btn resp-strt-btn"><?= $course->mock_test ? 'Start Practice Exam' : 'Start Lesson'?></a>
                                   <?php }
                                }

                                ?>
                                
                                <a type="button" data-toggle="modal" data-target="#shareModal" class="eduera-button btn share-btn resp-share-btn" onclick="shareSocial('<?=$course->slug?>')"><i class="fas fa-share"></i> Share</a>
                            </div>
                        </div>
                    </div>
                </td>
                <td><?=$course->enrolled_price?></td>
                <td><?=$course->paid_amount?></td>
                <td>
                    <?php 
                        if($course->expiry_date == 0 || $course->expiry_date == null){
                            echo 'Life Time';
                        }else{
                            echo $course->expiry_date;
                        }


                    ?>
                   
                        
                </td>
            </tr>
        <?php }?>
    </table>
<?php } else {?>
    <div>
        <p>No course found</p>
    </div>
<?php }?>


