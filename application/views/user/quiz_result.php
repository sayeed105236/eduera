<?php include 'my_board_menu.php';?>
<br />
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<section class="my-courses-area">
    <div class="container">
        <div class="row">
            <div class="form-group col-md-6">
                <select class="form-control" name="enrollment_id" onchange="load_lesson()">
                    <option value="-1">Select course</option>
                    <?php foreach ($enrollment_list as $enrollment) {?>
                        <option value="<?=$enrollment->enrollment_id?>" <?php if (isset($_GET['enrollment_id'])) {echo $_GET['enrollment_id'] == $enrollment->enrollment_id ? 'selected' : '';}?>><?=$enrollment->course_title?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6" id="lesson_list_field">
                <?php if (isset($_GET['enrollment_id'])) {
	?>
                   <select class="form-control" name="set_id">
                    <option value="-1">Select test name</option>
                    <?php
$alphabet = ["A", "B", "C", "D"];
	foreach ($user_assessment_all as $assessment) {
		?>
                      <option value="<?=$assessment->id?>" <?php if (isset($_GET['set_id'])) {echo $assessment->id == $_GET['set_id'] ? 'selected' : '';}?>>

                        <?=$assessment->name?>


                    </option>
                    <?php

	}?>
            </select>
        <?php }?>
    </div>
</div>
<div class="col-md-2">
                <button class="btn btn-info form-control show_quiz_result" onclick="show_assessment()">Show</button>
            </div>
<?php
if (isset($user_assessment)) {

    $end_assesment = end($user_assessment);
    if($end_assesment){

    if($end_assesment->quiz_result != 1){
	?>
    <div class="colorDefine">
        <span><span id="right"></span> Right Answer</span>
        <span><span id="wrong"></span>Wrong Answer</span>
        <span><span id="no_ans"></span>Not Found</span>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Number of total question</th>
                        <th>Number of attempted question</th>
                        <th>Number of right answer</th>
                        <th>Success rate</th>
                    <tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $end_assesment->assessment_data['no_of_total_question']?></td>
                        <td><?= $end_assesment->assessment_data['attempted'] ?></td>
                        <td><?= $end_assesment->assessment_data['no_of_right_answer'] ?></td>
                        <td><?= $end_assesment->assessment_data['success_rate'] ?>%</td>
                      
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <br>
    <?php
    
// foreach ($user_assessment as $assessment) {

		foreach ($end_assesment->quiz->question_list as $key => $questions) {

			?>
            
         <div class="row">
            <div class="col-md-12">

                <table class="eduera-simple-table">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Right Answer</th>
                            <th>Given Answer</th>
                            <th>Explanation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="50"><?=$key + 1 . '. ' . $questions->question?></td>

                            <?php
 if(isset($questions->option_list)){
for ($i = 0; $i < count($questions->option_list); $i++) {

				?>
                                <td width="25%"><?=$alphabet[$questions->right_option_value] . '. ' . $questions->option_list[$questions->right_option_value]?></td>
                                <?php if (isset($questions->given_answer) && $questions->given_answer != -1) {
					$color = "";
					if ($questions->given_answer == $questions->right_option_value) {
						$color = "#5aff01";
					} else {
						$color = "#ff0101";
					}
					?>
                                  <td width="25%" style="background-color: <?=$color?>"><?=$alphabet[$questions->given_answer] . '. ' . $questions->option_list[$questions->given_answer]?></td>
                                  <?php
} else {
					?>
                               <td width="25%" style="background-color: #ffc901">Not given any answer</td>
                           <?php }?>
                           <td width="25%">
                               <?php if(isset($questions->explanation) &&  $questions->explanation != NULL){?>
                                <?= $questions->explanation?>
                            <?php }else{
                                    echo 'No Explanation';
                                }
                                ?>
                           </td>
                           <?php break;}
                       }
                           ?>
                       </tr>
                   </tbody>
               </table>
           </div>
       </div>
       <?php
   
}
		
	}else{
        ?>
        <br>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Number of total question</th>
                            <th>Number of attempted question</th>
                            <th>Number of right answer</th>
                            <th>Success rate</th>
                        <tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $end_assesment->assessment_data['no_of_total_question']?></td>
                            <td><?= $end_assesment->assessment_data['attempted'] ?></td>
                            <td><?= $end_assesment->assessment_data['no_of_right_answer'] ?></td>
                            <td><?= $end_assesment->assessment_data['success_rate'] ?>%</td>
                          
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
      
<?php

        }
    }
}?>

</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">

    enrollment_list = JSON.parse('<?=json_encode($enrollment_list)?>');
    user_assessment_list = JSON.parse('<?=json_encode($user_assessment_all)?>');

    function show_assessment(){
        var enrollment_id = $('select[name="enrollment_id"]').val();
        var set_id = $('select[name="set_id"]').val();
        var path_parameter = '';
        if (enrollment_id != '-1' && !isNaN(enrollment_id)){
            path_parameter += '?enrollment_id=' + enrollment_id;
            if (set_id != '-1' && !isNaN(set_id)){
                path_parameter += '&set_id=' + set_id;
            }
        }

        window.location = '<?=base_url('user/quiz_result')?>' + path_parameter;
    }

    function load_lesson(){
        var enrollment_id = $('select[name="enrollment_id"]').val();
        $.ajax({
            url: '<?=base_url('rest/api/getCourseWiseAssessment/')?>'+enrollment_id,
            type: 'GET',
            dataType: 'json',
            success:function(response){
                var html = '<select class="form-control" name="set_id">' +
                '<option value="-1">Select test name</option>';
                for(var i = 0; i < response.length; i++){
                    console.log(response[i].name);
                    html += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                }
                html += '</select>';
                $('#lesson_list_field').html(html);
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

    }
</script>