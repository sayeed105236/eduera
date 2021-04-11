<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> 

<style type="text/css">
    #accordion .panel {
      border-radius: 0;
      border: 0;
      margin-top: 0px;
    }
    #accordion a {
      display: block;
      padding: 10px 15px;
      border-bottom: 1px solid #b42b2b;
      text-decoration: none;
    }
    #accordion .panel-heading a.collapsed:hover,
    #accordion .panel-heading a.collapsed:focus {
      background-color: #b42b2b;
      color: white;
      transition: all 0.2s ease-in;
    }
    #accordion .panel-heading a.collapsed:hover::before,
    #accordion .panel-heading a.collapsed:focus::before {
      color: white;
    }
    #accordion .panel-heading {
      padding: 0;
      border-radius: 0px;
      text-align: center;
    }
    #accordion .panel-heading a:not(.collapsed) {
      color: #343a40;
      background-color: white;
      transition: all 0.2s ease-in;
    }

    /* Add Indicator fontawesome icon to the left */
    #accordion .panel-heading .accordion-toggle::before {
      font-family: 'FontAwesome';
      content: '\f00d';
      float: left;
      color: #343a40;
      font-weight: lighter;
      transform: rotate(0deg);
      transition: all 0.2s ease-in;
    }
    #accordion .panel-heading .accordion-toggle.collapsed::before {
      color: #444;
      transform: rotate(-135deg);
      transition: all 0.2s ease-in;
    }


   /* thead, tbody { display: block; width: 100% }

    tbody {
        height: 600px;       /* Just for the demo          */
        overflow-y: auto;    /* Trigger vertical scroll    */
        overflow-x: hidden;  /* Hide the horizontal scroll */
    }*/
</style>
<?php $aToZ = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']; ?>


<div class="row" style="padding: 7px;">
    <?php echo validation_errors(); ?>
</div>
<div class="row" style="padding: 7px;">
    <?php if ($this->session->flashdata('quiz_set_save_success')) {?>

        <div class="alert alert-success alert-dismissible show" role="alert">
            <strong></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?=$this->session->flashdata('quiz_set_save_success')?>
        </div>

    <?php }?>
</div>
<div class="row" style="padding: 7px;">
    <?php if ($this->session->flashdata('quiz_set_save_failed')) {?>

        <div class="alert alert-danger alert-dismissible show" role="alert">
            <strong></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?=$this->session->flashdata('quiz_set_save_failed')?>
        </div>

    <?php }?>
</div>
<?php 

    $lesson = "";
    if($this->session->userdata('lesson_id')){
        $lesson = "&lesson_id=".$this->session->userdata('lesson_id');
    }
?>


<div class="card">
    <div class="card-header">
        <div class="float-left">
        <h4>All Question Quiz Set</h4>
        </div>
        <div class="float-right">

            <a class="btn btn-info pull-right" href="<?= base_url('instructor/course/'.$course_info->id.'/quiz_set?option='.$this->session->userdata('option').$lesson)?>">Back</a>
                   


        </div>
    </div>
    <div class="card-body">
        
    



        <div class="row">
            <div class="col-md-12">
              <!-- <?= debug($quiz_set_list->question_list[0])?> -->
                <h5><?= $quiz_set_list->question_list[0] != NULL ? count($quiz_set_list->question_list) : 0 ?> total questions</h5>
                    <div class="row">
                      <?php if($quiz_set_list->question_list[0] != NULL){?> 
                          <form method="post" action="<?= base_url('instructor/remove_quiz_question_from_course/'.$course_info->id)?>"> 
                          <input type="hidden" name="quiz_set_id" value="<?= $quiz_set_id?>">        
                          <input type="hidden" name="lesson_id" value="<?= $this->session->userdata('lesson_id')?>">  
                          <!-- <button class="btn btn-info" type="submit" style="float: right;">Submit</button> -->
                          <br>    
                          <div style="height:600px;overflow:auto; margin-top: 20px;" > 
                         
                            <table class="table table-striped table-bordered" id="datatable" style="margin-top: 20px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Question</th>
                                        <th>Options</th>
                                        <th>Right Answer</th>
                                    </tr>
                                </thead>
                                </thead>
                                    <tbody>
                                      <?php 
                                      
                                      foreach($quiz_set_list->question_list as $question){
                                          if($question != null){
                                        ?>
                                        <tr>
                                            <td width="10%"><input type="checkbox" class="singlechkbox" name="question_id[]" value="<?= $question->id?>"/></td>
                                            <td width="30%"><?= $question->id?>. <?= $question->question?></td>
                                            <td width="40%">
                                                 <?php foreach(json_decode($question->option_list) as $index => $options){?> 
                                                <p>
                                                     <?= $aToZ[$index] ?> . <?= $options?> 

                                                </p>
                                                 <?php }?> 
                                            </td>
                                            <td><?= $aToZ[$question->right_option_value] ?></td>
                                        </tr>
                                     <?php } }?>
                                    </tbody>
                            </table>
                         
                           </div>

                           <button class="btn btn-info" type="submit" style="margin-top: 20px;" onclick="remove_question_from_course('<?=$course_info->id ?>')">Remove</button>
                          </form>  
                       <?php } ?>
                    </div>
               
               
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    <?php
        if (!isset($_GET['lesson_id'])){
            echo '$("#lesson_list_div").hide();';
        }
    ?>
    
    course_id =  '<?php echo $course_id; ?>';

    $("#option_field").on('change', function(){
        if($("#option_field").val() == 'lesson'){
            $("#lesson_list_div").show();
        }else{
            $("#lesson_list_div").hide();
        }
    });

    function remove_question_from_course(course_id){
        if (confirm('Are you sure to remove  question this quiz set?')){
            window.location = "<?= base_url('instructor/remove_quiz_question_from_course/') ?>" + course_id ;
        }
    }



    function filter_quiz_set(course_id){
        var option = $("#option_field").val();
        var lesson = $("#lesson_field").val();
        console.log(option);
        var url = "<?= base_url('instructor/course/'.$course_id.'/quiz_set') ?>";

        if (option == 'course'){
            url += '?option=course';
        } else if (option == 'lesson'){
            url += '?option=lesson&lesson_id=' + lesson;
        }

        window.location = url;
    }


    function delete_quiz_set(course_id, quiz_set_id){
        if (confirm('Are you sure to remove this quiz set?')){
            window.location = "<?= base_url('instructor/remove_quiz_set_from_course/') ?>" + course_id + "/" + quiz_set_id;
        }
    }

</script>
