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
</style>
<?php $aToZ = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']; ?>
<?php include 'quiz_set_add_modal.php';?>

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



<div class="card">
    <div class="card-header">
        <div class="float-left">
        <h4>Quiz Set</h4>
        </div>
        <div class="float-right">

            <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target=".quiz_set_add_modal" onclick="load_add_quiz_set_form()">Add Quiz Set</button> 
                   
        </div>
    </div>
    <div class="card-body">
        
        <div class="row">
            <div class="" style="padding: 40px 0px 0px 12px;">
                <div class="form-group" style="display: inline-block;">
                    <select class="form-control"  name="option_field" id="option_field">
                        <option value="-1">Choose your option</option>
                        <option value="course" <?= isset($_GET['option']) && $_GET['option'] == 'course' ? 'selected': ''?>>Course</option>
                        <option value="lesson" <?= isset($_GET['option']) && $_GET['option'] == 'lesson' ? 'selected': ''?>>Lesson</option>
                    </select>
                </div>
                <div class="form-group" style="display: inline-block;" id="lesson_list_div">
                    <select class="form-control" name="lesson_id" id="lesson_field">
                        <?php foreach ($course_info->lesson_list as $lesson) { ?>
                            <option value="<?= $lesson->id ?>" <?= isset($_GET['lesson_id']) && $_GET['lesson_id'] == $lesson->id ? 'selected': ''?>><?= $lesson->title ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="button" class="btn btn-info" onclick="filter_quiz_set('<?= $course_info->id ?>')">Filter</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
              
         
                <?php
             
                if (isset($quiz_set_list)) {
                    if (count($quiz_set_list) > 0) {
                        ?>
                    <table id="datatable" class="table table-striped table-bordered">

                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Quiz Name</th>
                                <th>Duration</th>
                                <th>Show Quiz Result</th>
                                <th>Free Access</th>
                                <th>Total Question</th>
                                
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php foreach ($quiz_set_list as $index => $quiz_set) {?>
                            <tr>
                                <td><?=$index + 1?></td>
                                <td><?=$quiz_set->name ?></td>
                                <td><?= $quiz_set->duration ?  $quiz_set->duration : 0?></td>
                                <td><?php echo ($quiz_set->quiz_result == 1) ? 'No' : 'Yes'; ?></td>
                                <td> <?php echo ($quiz_set->free_access == 1) ? 'Yes' : 'No'; ?></td>
                                <td><?= $quiz_set_list[0]->question_list[0] != NULL ? count($quiz_set->question_list) : 0 ?></td>
                           

                                <td>
                               

                                  <div class="dropdown" style="width: 95px;">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item" href="<?= base_url('instructor/course/'.$course_info->id.'/addQuestionInQuiz/'.$quiz_set->id)?>">Add Question</a>
                                      <a class="dropdown-item" href="<?= base_url('instructor/course/'.$course_info->id.'/show_questions/'.$quiz_set->id)?>">Show Questions</a>
                                      <a class="dropdown-item" href="#"  onclick="editQuizSet(<?= $quiz_set->id ?>)" data-toggle="modal" data-target=".quiz_set_add_modal">Edit</a>
                                      <a class="dropdown-item" href="#" onclick="delete_quiz_set('<?= $course_info->id ?>', '<?= $quiz_set->id ?>')">Delete</a>
                                    </div>
                                  </div>


                                </td>

                            </tr>
                            <?php }?>
                        </tbody>

                    </table>
                   <?php     }else{
                            echo '<span>Not found any quiz set.</span>';
                        }
                    }
                    ?>
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
