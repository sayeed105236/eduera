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
            </div>

            <div class="row">
                <div class="form-group col-md-6" id="lesson_list_field">
                <?php if (isset($_GET['enrollment_id'])) {
	?>
                    <select class="form-control" name="lesson_id">
                        <option value="-1">Select lesson</option>
                        <?php
foreach ($enrollment_list as $enrollment) {
		if ($enrollment->enrollment_id == $_GET['enrollment_id']) {
			foreach ($enrollment->lesson_list as $lesson) {
				?>
                                    <option value="<?=$lesson->id?>" <?php if (isset($_GET['lesson_id'])) {echo $lesson->id == $_GET['lesson_id'] ? 'selected' : '';}?>><?=$lesson->title?></option>
                                <?php
}
			break;
		}
	}?>
                    </select>
                    <?php }?>
                </div>
            </div>
            <div class="col-md-2">
                    <button class="btn btn-info form-control" onclick="show_assessment()">Show</button>
                </div>


            <div class="user-dashboard-content" style="width: 100% !important;">
                <div class="content-title-box">
                    <div class="title">Perfomance</div>
                </div>
                <div>
                    <div class="col-md-12">
                        <!-- <canvas id="test-wise-chart"></canvas> -->
                        <h4 id="not_found" style="text-align: center;"></h4>
                        <canvas id="myChart" width="100%"></canvas>
                        <canvas id="myLessonChart" width="100%"></canvas>

                    </div>
                    <div class="col-md-6">
                        <canvas id="performance-increase-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>


    <script type="text/javascript">

        enrollment_list = JSON.parse('<?=json_encode($enrollment_list)?>');

        function show_assessment(){
            var enrollment_id = $('select[name="enrollment_id"]').val();
            var lesson_id = $('select[name="lesson_id"]').val();
            var path_parameter = '';
            if (enrollment_id != '-1' && !isNaN(enrollment_id)){
                path_parameter += '?enrollment_id=' + enrollment_id;
                if (lesson_id != '-1' && !isNaN(lesson_id)){
                    path_parameter += '&lesson_id=' + lesson_id;
                }
            }

            window.location = '<?=base_url('user/user_assessment')?>' + path_parameter;
            // console.log(path_parameter);
        }


        function load_lesson(){
            var enrollment_id = $('select[name="enrollment_id"]').val();
            for(var i = 0; i < enrollment_list.length; i++){
                if (enrollment_list[i].enrollment_id == enrollment_id){
                    var html = '<select class="form-control" name="lesson_id">' +
                                '<option value="-1">Select lesson</option>';
                    for(var j = 0; j < enrollment_list[i].lesson_list.length; j++){
                        html += '<option value="' + enrollment_list[i].lesson_list[j].id + '">' + enrollment_list[i].lesson_list[j].title + '</option>';
                    }
                    html += '</select>';
                    $('#lesson_list_field').html(html);
                    break;
                }
            }

        }



        user_assessment = <?php echo isset($user_assessment) ? json_encode($user_assessment) : "[]"; ?>;

        if(user_assessment != '' && user_assessment != null){
            var assessment_title = [];
            var assessment_rate = [];

            var backgroundColor = '';
            var color = [];
            for(var i = 0; i < user_assessment.length; i++){
                var count = i+1;
                assessment_title.push("Assessment " + count);
                assessment_rate.push(user_assessment[i].assessment_data.success_rate);

                if(user_assessment[i].assessment_data.success_rate < 40.33){

                   backgroundColor = "rgba(255,99,132,0.2)";
                }else if(user_assessment[i].assessment_data.success_rate < 70.33){
                   backgroundColor = "rgba(50, 168, 102,0.2)";
                }else{
                   backgroundColor = "rgba(68, 209, 21)";
                }

                 color.push(backgroundColor);
            }

            var ctx = document.getElementById('myChart').getContext('2d');
            var data = {
                labels: assessment_title,
                datasets: [
                    {
                        label: "Success rate",
                        backgroundColor: color,
                        borderColor: color,
                        borderWidth: 2,
                        data: assessment_rate,
                    }
                ]
            };
            var option = {
                animation: {
                    duration:2000
                },

                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 100
                        }
                    }]
                }
            };

            var myBarChart = Chart.Bar(ctx,{
                data:data,
                options:option
            });
        }

</script>