<?php include 'my_board_menu.php';?>
<br />
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<section class="my-courses-area">
    <form method="post" action="<?=base_url('user/course_status')?>">


    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Search your course progress</h4>
                <br>
            </div>
        </div>
            <div class="row">

                <div class="form-group col-md-6">

                    <select class="form-control"  name="course_id" id="course_id">
                        <option value="">Choose your course</option>
                        <?php foreach ($course_list as $course) {?>
                            <option value="<?=$course->id?>" <?=isset($_POST['course_id']) && $_POST['course_id'] == $course->id ? 'selected' : ''?>><?=$course->title?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-info form-control" >Show</button>
                </div>

                <div class="form-group">

                </div>
            </div>

            <br>
            <?php if (isset($total_course_duration) > 0) {
	?>
           <h4 class="total_course_duration">
                <?='Total Course Duration: ' . second_to_time_conversion($total_course_duration);?>
            </h4>
            <h4 class="total_course_duration">
                <?='Your seen duration: ' . second_to_time_conversion($total_user_lesson_duration);?>
            </h4>

            <?php
}?>

<br>




        </div>
    </form>
        <div class="container-fluid">
            <div class="col">
                <?php if (isset($_POST['course_id'])) {?>

                    <div class="user-dashboard-content ">
                        <div class="content-title-box">
                            <div class="title">Progress</div>
                        </div>

                        <div>
                            <div class="col-md-12">
                                <h4 id="not_found" style="text-align: center;"></h4>
                                <canvas id="myChart" width="100%" height=100></canvas>

                            </div>
                        </div>
                    </div>
                <?php }
?>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>


    <script type="text/javascript">



        lesson_list = <?php echo isset($lesson_list) ? json_encode($lesson_list) : "[]"; ?>;

        
        var lesson_title = [];
        var lesson_status_percentage = [];

    // var backgroundColor = '';
    var color = [];
    var finished_percentage = 0;

    for(var i = 0; i < lesson_list.length; i++){
        if(lesson_list[i].duration_in_second != null){

            if (lesson_list[i].finished_time == null){
                finished_percentage = 0;
            } else {
                finished_percentage = Math.round((lesson_list[i].finished_time*100)/lesson_list[i].duration_in_second);
            }

            lesson_status_percentage.push(finished_percentage);
            lesson_title.push(lesson_list[i].title);

            if(finished_percentage <= 30){
                color.push("rgb(255, 26, 26)");
            }else if(finished_percentage > 30 && finished_percentage <= 70){
                color.push("rgb(255, 255, 0)");
            }else if(finished_percentage > 70 && finished_percentage <= 99){
                color.push("rgb(0, 255, 255)");
            }else{
                color.push("rgb(0, 255, 0)");
            }
        }

    }




    var ctx = document.getElementById('myChart').getContext('2d');
    var data = {
        labels: lesson_title,

        datasets: [
        {
            label: "Percentage",
            backgroundColor: color,
            borderColor: color,
            data: lesson_status_percentage,

        }
        ]
    };
    var option = {
        animation: {
            duration:2000
        },

        responsive: true,
        scales: {
            display: true,
            xAxes: [{
                ticks: {
                    beginAtZero: true,
                    max: 100
                }
            }],
            yAxes: [{
                categoryPercentage: 6,
                barPercentage: 0.1,
            }],
        }
    };

    var myBarChart = new Chart(ctx,{
        type: 'horizontalBar',
        data:data,
        options:option
    });

    </script>