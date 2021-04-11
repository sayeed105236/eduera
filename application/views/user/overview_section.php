<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/overview.css')?>" />

<section id="tabs">
    <!-- <div class="container"> -->
 
        <div class="row resp-lesson-view-marg">
            <div class="col-lg-12 resp-lesson-view-pad">
                <nav>
                    <div class="nav nav-tabs nav-fill main-tab" id="nav-tab" role="tablist" >
                        <a class="nav-item nav-link active main-link resp-over-sec" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Overview</a>
                        <a class="nav-item nav-link main-link resp-over-sec" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Q&A</a>
                        <a class="nav-item nav-link main-link resp-over-sec" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Notes</a>
                        <a class="nav-item nav-link main-link resp-over-sec" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Announcements</a>
                    </div>
                </nav>
                <div class="container">
                    <div class="tab-content resp-start-lesson-content" id="nav-tabContent">
                        
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                           <div class="container">
                               <div class="about-this-course">
                                  <h4>About this course</h4>
                                  <div class="row">
                                      <div class="col-md-12">
                                          <span><?= $course_details->short_description?></span>
                                      </div>
                                  </div>
                               </div>
                           </div>

                           <div class="by-the-numbers">
                                  
                                  <div class="row">
                                      <div class="col-md-4">
                                          <span>By the numbers</span>
                                      </div>
                                      <div class="col-md-4">
                                          <span>Skill level: <?= ucfirst($course_details->level)?></span><br>
                                          <span>Students: <?= $course_details->enrollment?></span><br>
                                          <span>Language: <?= ucfirst($course_details->language)?></span>
                                      </div>
                                       <div class="col-md-4">
                                          <span>Lectures : <?= $course_details->lesson_count?></span><br>
                                          <span>Video : <?= second_to_time_conversion($course_details->duration_in_second)?> Hours</span>
                                      </div>
                                  </div>
                               </div>

                               <div class="certificate-section">
                                      
                                      <div class="row">
                                          <div class="col-md-4">
                                              <span>Certificates</span>
                                          </div>
                                          <div class="col-md-8">
                                              <span>Get Eduera certificate by completing entire course</span><br>
                                              <br>
                                              <div class="row">
                                                   <div class="col-md-6">
                                                       <?php       
                                                      if ($total_percentage > 90) {
                                                       
                                                       if ($course_details->certificate) {
                                                           $image_path = $_SERVER['DOCUMENT_ROOT'] . '/eduera/assets/frontend/certificate/';

                                                           ?>
                                                              <h5 class="mb-0">
                                                                  <a target="_blank" href="<?=base_url('user/load_certificate/' . $course_details->id. '/'. $user_data->id)?>"  class="btn  w-100 text-left section_button certificate_button" id="get_certificate"  >
                                                                      Get Certificate
                                                                  </a>
                                                              </h5>
                                                                          <?php
                                                      }
                                                      }
                                                      ?>
                                              </div>
                                           </div>
                                          </div>
                                           
                                      </div>
                                   </div>
                                   <!-- Certificate section end -->
                                   <div class="features-section">
                                          
                                        <div class="row">
                                            <div class="col-md-4">
                                                <span>Features</span>
                                            </div>
                                            <div class="col-md-8">
                                                <span>Available on <span class="device">Android </span></span><br>
                                              
                                            </div>
                                          
                                        </div>
                                   </div>
                                       <!-- Features section end -->

                                    <div class="features-section">
                                           
                                         <div class="row">
                                             <div class="col-md-4">
                                                 <span>Description</span>
                                             </div>
                                             <div class="col-md-8">
                                                 <div class="description-box-lesson view-more-parent">
                                                     <div class="view-more" onclick="viewMore(this,'show')">+ View More</div>

                                                     <div class="description-content-wrap">
                                                         <div class="description-content">
                                                             <?= $course_details->description; ?>
                                                         </div>

                                                         <?php if ($course_details->outcomes != null) {
                                                            ?>
                                                             <div class="what-you-get">
                                                                 <div class="what-you-get-title">What will you learn?</div>
                                                                 <ul class="what-you-get__items">
                                                         <?php

                                                            foreach ($course_details->outcomes as $outcome) {
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

                                                         <?php if ($course_details->requirements != null) {?>
                                                             <div class="requirements-box">
                                                                 <div class="requirements-title">Requirements</div>
                                                                 <div class="requirements-content">
                                                                     <ul class="requirements__list">
                                                                         <?php foreach ($course_details->requirements as $requirement) {?>
                                                                             <li><?php echo $requirement; ?></li>
                                                                         <?php }?>
                                                                     </ul>
                                                                 </div>
                                                             </div>
                                                         <?php }?>
                                                     </div>
                                                 </div>
                                               
                                             </div>
                                           
                                         </div>
                                    </div>
                                        <!-- Description section end -->   
                                    <?php if($course_details->instructor_id != 0){?>
                                    <div class="instructor-section">
                                           
                                           <div class="row">
                                               <div class="col-md-4">
                                                   <span>Instructor</span>
                                               </div>
                                               <div class="col-md-8">
                                                   <div class="row ">
                                                    <div aria-label="Nazmul Huda" class=" user-avatar user-avatar--initials resp-start-lesson-icon" data-purpose="user-avatar">
                                                        <div class="user-avatar__inner fx-c">
                                                            <?php if($instructor_details->profile_photo_name == ''){?>
                                                              <span class="user-initials">
                                                                  <?=$instructor_details->first_name[0]?><?=$instructor_details->last_name[0]?>
                                                              </span>
                                                          <?php }else{?>
                                                               <img src="<?php echo base_url() . 'uploads/user_image/'. $instructor_details->profile_photo_name ?>" alt="" class="user-initials">  
                                                          <?php }?>
                                                        </div>
                                                    </div>



                                                    <div class="ml5 col-md-6">
                                                        <div class="question-section">
                                                       
                                                        <p  data-purpose="certificate-recipient"><?= $instructor_details->first_name?> <?= $instructor_details->last_name?></p>
                                                        </div>
                                                         <br>
                                                       

                                                    </div>
                                                </div>
                                           <br>
                                          
                                       </div>
                                        
                                   </div>
                                </div>
                            <?php }?>

                        </div>
                    <!-- </div> -->
                 
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" style="width: 100%;">
                           <div class="col-md-10 nav nav-tabs nav-fill child-tab all-question-tab" id="nav-tab" role="tablist" style="padding-right: 0; width: 100%;">
                               <p class="col-md-6 nav-item nav-link active main-link" id="nav-all-question-tab" data-toggle="tab" href="#all-question-show-tab" role="tab" aria-controls="all-question-show-tab" aria-selected="true">All Questions</p>
                         
                                
                               <p class="col-md-6 nav-item nav-link main-link" id="nav-ask-question-tab" data-toggle="tab" href="#nav-ask-question" role="tab" aria-controls="nav-ask-question" aria-selected="false">Ask New Question</p>

                               <p style="display: none" class="col-md-3 nav-item nav-link  main-link back-to-all-question" id="nav-all-question-tab" data-toggle="tab" href="#all-question-show-tab" role="tab" aria-controls="all-question-show-tab" aria-selected="true">Back to all question</p>
                              
                               
                           </div>
                            <br>
                           <span id="insert-message" style="margin-left: 50%;"></span>
                           <br>
                           <div class="tab-content py-3 px-3 px-sm-0 col-md-10" id="nav-tabContent" style="width: 100%;margin: 0;padding: 0 !important;">
                               
                               <div class="tab-pane fade show active" id="all-question-show-tab" role="tabpanel" aria-labelledby="nav-all-question-tab">
                                 
                                <div class="question-title">
                                <?php if(count($question_and_ans_list) == 1){?>
                                    <p><?= count($question_and_ans_list)?> question in this course </p>
                                <?php }else{?>
                                   <p><?= count($question_and_ans_list)?> questions in this course </p>
                               <?php }?>
                                </div>   
                                   <br>
                                  
                                   
                                   <br>
                                  <?php foreach($question_and_ans_list as $q_and_a){
                                    ?>

                                   <div class="row recipient_name">

                                       <div aria-label="Nazmul Huda" class=" user-avatar user-avatar--initials" data-purpose="user-avatar">
                                           <div class="user-avatar__inner fx-c">

                                                <?php if($q_and_a->profile_photo_name == ''){?>
                                                 <span class="user-initials">
                                                    <?=$q_and_a->first_name[0]?><?=$q_and_a->last_name[0]?>
                                                 </span>
                                                <?php }else{?>
                                                  <img src="<?php echo base_url() . 'uploads/user_image/' . $q_and_a->profile_photo_name; ?>" alt="" class="user-initials"> 
                                                <?php }?>
                                           </div>
                                       </div>


                                       <div class="ml5 col-md-6">
                                           <div class="question-section">
                                           <p class="title"  data-purpose="certificate-recipient"><?= $q_and_a->title?>
                                           </p>
                                           <p  data-purpose="certificate-recipient"><?= $q_and_a->description?>
                                           </p>
                                           </div>
                                            <br>
                                          
                                           <div class="user">
                                            <span  id="replay-section-tab">
                                                <ul class="nav nav-tabs nav-fill child-tab all-replay-tab" id="nav-tab" role="tablist">
                                               <li>
                                                    <div><?= $q_and_a->first_name?> <?= $q_and_a->last_name?>  · </div>
                                                </li> 
                                                <li>
                                                    <div> <?= time_elapsed_string($q_and_a->created_at)?> · </div> 
                                                </li> ·
                                    
                                                <li style="cursor: pointer;" id="replay-section" data-toggle="tab"  href="#all-replay-show-tab" role="tab" aria-controls="all-replay-show-tab" aria-selected="true" onclick="replay('<?=$q_and_a->id?>')" >
                                                  <?php  if(count($q_and_a->replay) > 0){
                                                    echo  count($q_and_a->replay) .' replies';
                                                  }else{
                                                   echo  'Replay';
                                                  }
                                                  ?>
                                             </li>

                                                </ul>
                                                </span>
                                            
                                           </div>

                                       </div>


                                   </div>
                                  
                                   <br>
                                   
                               <?php } ?>
                               </div>
                            


                               
                               <div class="tab-pane fade show " id="nav-ask-question" role="tabpanel" aria-labelledby="nav-ask-question-tab">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="for">Title: </label>
                                            <input type="text" name="title" class="form-control" required="" placeholder="Enter the problem..">
                                        </div>
                                    </div>
                                    <div class="row">    
                                        <div class="form-group col-md-6">
                                            <label class="for">Description(optional): </label>
                                            <textarea name="description" id="description" class="form-control" required="" placeholder="Description"></textarea>
                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 " id="publish-tab">
                                            <div class=" nav nav-tabs nav-fill child-tab all-question-tab" id="nav-tab" role="tablist">

                                            <input class="btn btn-block " id="publish" data-toggle="tab" type="submit" href="#all-question-show-tab" role="tab" aria-controls="all-question-show-tab" aria-selected="true" value="Publish" />
                                        </div>
                                        </div>
                                       
                                    </div>

                                    
                               </div>
                               <div style="display: none;" class=" " id="all-replay-show-tab" role="tabpanel" aria-labelledby="replay-section">

                                    <div class="replay-question" >

                                    </div>
                                   <br>
                                   <!--  <div class="row">   
                                        <div class="col-md-1">
                                            <div aria-label="Nazmul Huda" class=" user-avatar user-avatar--initials" data-purpose="user-avatar" style="background-color: rgb(110, 26, 82); font-size: 15px; width: 40px; height: 40px;">
                                                <div class="user-avatar__inner fx-c">

                                                     <?php if($user_data->profile_photo_name == ''){?>
                                                      <span class="user-initials">
                                                         <?=$user_data->first_name[0]?><?=$user_data->last_name[0]?>
                                                      </span>
                                                     <?php }else{?>
                                                       <img src="<?php echo base_url() . 'uploads/user_image/' . $user_data->profile_photo_name; ?>" alt="" class="user-initials"> 
                                                     <?php }?>
                                                </div>
                                            </div>

                                        </div> 
                                        <div class="form-group col-md-6">
                                            <input name="replay" id="replay-message" class="form-control" required="" placeholder="Write your response"/>
                                        </div>

                                        <div class="col-md-3">
                                            <input style="padding: 8px;" class="btn btn-block" id="answer" name="answer" type="submit" value="Add an answer" />
                                        </div>


                                    </div>
                                  -->

                                    
                               </div>
                               <!-- replay tab end -->
                            </div>
                              
                        </div>
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="container">
                               
                          <div class="row">
                              <div class="col-md-8 mx auto">
                                <div class="create-bookmark--create-bookmark-container--2XoIK">
                                  <button data-purpose="create-bookmark-button" type="button" class="create-bookmark--create-bookmark-button--1o-Eb btn btn-quaternary">
                                    <div class="create-bookmark--create-bookmark-button-text--2yp8l overview-add-note">
                                      <div class="create-bookmark--create-button-left--1fPc9">
                                        <span style="padding: 0 !important;">Create a new note at 
                                          <span data-purpose="create-bookmark-current-time" class="current_time">00:00
                                          </span>
                                        </span>
                                      </div>
                                      <span class="create-bookmark--create-button-right--11jki fa fa-plus-circle" style="padding: 0 !important;">
                                      </span>
                                  </div>
                                  </button>
                                </div>

                                 
                                <div class="notes-section"style="display: none;">
                                   <div class="form-group  row" >
                                      <div class="col-md-1"><span class=" lecture-bookmark-duration--bookmark-timer--DMSFz"><span class="current_time">00:00</span></span></div>
                                      <div class="col"><textarea class="form-control author-biography-editor notes" id="notes"  name="notes"></textarea></div>


                                  </div>
                                  <div class="row">
                                      <div class="col " ><button class="btn btn-quaternary-save  pull-right save-notes" disabled="" type="button">Save</button> <button style="margin-right: 10px;"  data-purpose="create-bookmark-button" type="button" class=" btn btn-quaternary  pull-right cancel-notes">Cancel</button> </div>
                                  </div>
                                  
                                  <div class="row empty-notes-section form-group" style="display: none; margin-top: 10px">
                                      <div class="col-md-1"></div>
                                      <div class="col alert alert-warning">
                                          <span class="fa fa-exclamation-triangle" style="margin-right: 5px;"></span><span class="empty-notes"></span>
                                      </div>
                                  </div>
                                 </div>

                                 <!-- Notes -->
                              <?php foreach($course_notes as $notes){?>
                                 <span data-purpose="lecture-bookmark-container"><div data-purpose="bookmarks-container" class="bookmarks--bookmarks-container--1tc-p"><div class="lecture-bookmark-v2--bookmark-container--yCEMR"><div class="lecture-bookmark-v2--bookmark-header--2JV49"><div class="item-link item-link--common--RP3fp lecture-bookmark-v2--intro--132ek"  ><span class="lecture-bookmark-duration--bookmark-timer--DMSFz"><span><?= $notes->lesson_time?></span></span></div><div class="lecture-bookmark-v2--section-actions-container--39_Ok"><div class="fx lecture-bookmark-v2--section-description--2wldi"><div class="item-link item-link--common--RP3fp lecture-bookmark-v2--intro--132ek"><span class="lecture-bookmark-v2--section-icon--2qzRb udi udi-note"></span><?=$notes->section_rank?>. <?= $notes->section_title?></div><div class="lecture-bookmark-v2--sub-intro--2OzKK"><?=$notes->lesson_rank?>. <?= $notes->lesson_title?></div></div><div class="lecture-bookmark-v2--bookmark-actions--103d_">
                                
                                    <button type="button" aria-label="Delete bookmark" class="lecture-bookmark-v2--qrp-icon--3FfQg  btn-link" onclick="removenotes(<?= $notes->id?>)"><span class="fa fa-trash "></span></button>
                                </div></div></div><div class="lecture-bookmark-v2--content-container--2f_Tg"><div class="lecture-bookmark-v2--content--wi4tQ" data-purpose="bookmark-body"><div data-purpose="safely-set-inner-html:rich-text-viewer:html"><p><?= $notes->notes?></p></div></div></div></div></div></span>
                             <?php } ?>
                              </div>
                          </div>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                           <div class="container">
                                    
                                    <br>
                                   <?php 
                                    if($announcement_list != NULL){
                                        foreach($announcement_list as $q_and_a){
                                     ?>

                                    <div class="row recipient_name">

                                        <div aria-label="Nazmul Huda" class=" user-avatar user-avatar--initials" data-purpose="user-avatar">
                                            <div class="user-avatar__inner fx-c">

                                                 <?php if($q_and_a->profile_photo_name == ''){?>
                                                  <span class="user-initials">
                                                     <?=$q_and_a->first_name[0]?><?=$q_and_a->last_name[0]?>
                                                  </span>
                                                 <?php }else{?>
                                                   <img src="<?php echo base_url() . 'uploads/user_image/' . $q_and_a->profile_photo_name; ?>" alt="" class="user-initials"> 
                                                 <?php }?>
                                            </div>
                                        </div>


                                        <div class="ml5 col-md-6">
                                                   <div class="user">
                                                    <span  id="replay-section-tab">
                                                        <div class="instructor_name">
                                                            <?= $q_and_a->first_name?> <?= $q_and_a->last_name?>
                                                        </div>
                                                        <ul class="nav nav-tabs nav-fill child-tab all-replay-tab" id="nav-tab" role="tablist">
                                                           <li>
                                                                <div>posted an announcement  · </div>
                                                            </li> 
                                                            <li>
                                                                <div> <?= time_elapsed_string($q_and_a->created_at)?>  </div> 
                                                            </li> 
                                         

                                                        </ul>
                                                        </span>
                                                    
                                                   </div>
                                             <br>
                                           
                                           

                                            <div class="question-section">
                                            <p class="title"  data-purpose="certificate-recipient"><?= $q_and_a->title?>
                                            </p>
                                            <p  data-purpose="certificate-recipient"><?= $q_and_a->description?>
                                            </p>
                                            </div>

                                        </div>


                                    </div>
                                   
                                    <br>
                                    
                                <?php }
                            }else{
                                echo 'No Announcement';
                            }
                                 ?>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        <!-- </div> -->
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
    var notes = '';
    $(".create-bookmark--create-button-right--11jki").click(function(event) {
            $(".notes-section").show();
            $(".create-bookmark--create-bookmark-container--2XoIK").hide();
    });

    $(".cancel-notes").click(function(event) {
        /* Act on the event */
        $(".notes-section").hide();
        $(".create-bookmark--create-bookmark-container--2XoIK").show();
    });

    function get_course_notes(){


    }

    $(".save-notes").click(function(event) {
        /* Act on the event */

        if(total_sec == ''){
            total_sec = '00:00';
        }
        if(notes == '' || notes == null){
            $(".empty-notes-section").show();
            $(".empty-notes").text("You can't save empty notes.");
            
        }else{
            $.ajax({
                url: '<?= base_url('rest/api/save_course_notes')?>',
                type: 'POST',
                data: {course_id: courseid,  lesson_time: total_sec, notes: notes, lesson_id: lesson_info.id},
                success: function(res){
                    if(res == true){
                        $(".notes-section").hide();
                        $(".create-bookmark--create-bookmark-container--2XoIK").show();

                        window.location.reload();
                         
                    }else{
                        $(".empty-notes").text("Something went wrong.");
                    }
                }
            })
            .done(function() {
            })
            .fail(function() {
            })
            .always(function() {
            });
            
        }
    });

  


    tinymce.init({
        selector: '.author-biography-editor',
        menubar: false,
        statusbar: false,
        branding: false,
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | fontsizeselect",
        setup: function(ed) {
        ed.on('keyup', function(e) {
            // console.log(e);
                notes = ed.getContent();
                var len = ed.getContent().length;
                if (len >= 1) {
                    $(".save-notes").prop("disabled", false);
                }else{
                    $(".save-notes").prop("disabled", true);
                }

            });
        }

    });

    function removenotes(notes_id){
        // console.log('test');
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('rest/api/remove_course_notes')?>',
                    type: 'POST',
                    data: {notes_id: notes_id},
                    success: function(res){
                        if(res == true){
                            Swal.fire(
                              'Deleted!',
                              'Your file has been deleted.',
                              'success'
                            ).then(function() {
                                window.location.reload();
                            });
                        }else{
                            Swal.fire(
                              'Canceled!',
                              'Something went wrong. Please try again.',
                              'error'
                            ).then(function() {
                                window.location.reload();
                            });
                        }

                        // window.location.reload();
                    }
                });            
          
            }
        })
    }

    
</script>