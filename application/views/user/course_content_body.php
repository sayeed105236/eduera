<div class="col-lg-9  order-md-1 course_col" id = "video_player_area">
    <!-- <div class="" style="background-color: #333;"> -->
        <div class="" style="text-align: center;">
            <!-- ----------- PLYR.IO ---------- -->

            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/global/plyr/plyr.css">

            <div  class="plyr__video-embed">
                <div class="" id="player"></div>
               <div class="full_div" style="display: none;">
                   <div class="bar" id="bar" >
                       <div class="loader" id="loader" ></div>
                   </div>
                   <span id="play_again" onclick="playAgain()">Play again</span>
                   <?php if($next_lesson_id != 0){?>
                   <span id="next" onclick="nextPlay()">Next</span>
               <?php } ?>
               </div>
                

            <?php 
            if(!$course_details->mock_test ){
                if($lesson_info->video_type == 'vimeo'){

                    ?>
                   
                    <div id="quiz_div" style="display: none;" class="quiz_div_on_player">
                        <div class="concent_div_on_player" id="concent_div_on_player">
                            <p>Total question is <span id="test_consent_course_number"></span>.</p>
                            <p style="font-size: 20px; color: #9D9D9D;">Are you ready to start a test?</p>
                            <div class="row" style="width: 200px; margin: 20px auto;">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <button class="btn quiz-btn" onclick="start_test()">Start</button>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <button class="btn quiz-btn" onclick="skip_test()">Skip</button>
                                </div>

                            </div>
                        </div>
                      
                        <div id="timer_div" style="display: none">
                            <p> <code id="do"></code> </p>

                            <div id="time">
                              
                            </div>
                       </div>

                       <div id="timesup" style="display: none;  font-size: 18px;font-weight: bold;color: #e83e8c;margin-bottom: 0%;"><p>Times up.</p></div>


                        <div class="question_div_on_player row" id="question_div_on_player">
                            
                        </div>
                    </div>
                    
                   
                 <?php
                  }else{ 
                    ?> 
                    <div class="" id="youtube_player">
                    </div>


                    <script src="<?php echo base_url();?>assets/global/plyr/plyr.js"></script>
                    <!-- <script>const player = new Plyr('#youtube_player');</script> -->

                 <?php 
             } 
         }else{?>
            <div style="margin-top: 60px;" id="mock-list-body">
                <h4>Choose any mock test</h4>
            <div class="main-body" style="position: relative;
overflow-y: auto;
overflow-x: auto;
height: 382px;">
            <?php if ($course_quiz_list != null) {?>
                <?php foreach ($course_quiz_list as $course_quiz) {
                   
                    ?>
                    <div class="card row" style="margin:0px 0px; ">
                        <div class="card-header course_card col-md-5 mx-auto">
                            <h5 class="mb-0">
                                <button  class="btn btn-link w-100 text-left section_button" type="button" style="background: #ec5252; color: #fff; border: none; white-space: normal; text-decoration: none;" 
                                <?=$user_course_access_info['access_percentage'] == 100 || $course_quiz->free_access == 1  ? 'onclick = "take_course_assessment(' . $course_quiz->id . ')"' : ''?>
                                >
                                    <?=$course_quiz->name?>
                                </button>
                            </h5>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
        </div>
        </div>
            <div id="quiz_div_mock" style="display: none;" class="quiz_div_on_player">
                <div class="" id="concent_div_on_player_mock">
                    <p>Total question is <span id="test_consent_course_number"></span>.</p>
                    <p style="font-size: 20px; color: #9D9D9D;">Are you ready to start a test?</p>
                    <div class="row" style="width: 200px; margin: 20px auto;">
                        <div class="col-md-6 col-lg-6 col-sm-6">
                            <button class="btn quiz-btn" style="margin-bottom: 10px;" onclick="start_test()">Start</button>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6">
                            <button class="btn quiz-btn" onclick="skip_test()">Skip</button>
                        </div>
                    </div>
                </div>
              
                <div id="timer_div" style="display: none">
                    <p> <code id="do"></code> </p>

                    <div id="time">
                      
                    </div>
               </div>

               <div id="timesup" style="display: none;  font-size: 18px;font-weight: bold;color: #e83e8c;margin-bottom: 0%;"><p>Times up.</p></div>


                <div class="question_div_on_player row" id="question_div_on_player_mock">
                    
                </div>
            </div>
         <?php 
     }
                 ?> 
          
        </div>


    </div>
        <?php 
        if(!$course_details->mock_test){
            ?>

        <div class="" style="margin: 20px 0;" id = "lesson-summary">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?=$lesson_info->title?></h5>
                    <p class="card-text"><?=$lesson_info->summary?></p>
                    <p></p>
                </div>
            </div>
        </div>
    <?php } ?>
</div>


<script src="https://unpkg.com/navigator.sendbeacon"></script>
<script src="https://player.vimeo.com/api/player.js"></script>
<script type="text/javascript">
 

 $(document).ready(function(){
     if(window.matchMedia("(max-width: 767px)").matches){
         // The viewport is less than 768 pixels wide
            document.getElementById("concent_div_on_player").style.padding = "0px"; 
              // document.getElementsByClassName("quiz-btn").style.marginBottom = "10px"; 
            $(".quiz-btn").css({marginBottom: "10px"});
            $(".question_div_on_player").css({padding: "0px"});
     } else if(window.matchMedia("(max-width: 1280px)").matches){
         // The viewport is at least 768 pixels wide
         //alert("This is a tablet.")
     }
 });




    $(document).ready(function(){

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {

        localStorage.setItem('activeTab', $(e.target).attr('href'));

    });
    var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $("#nav-home-tab").removeClass("active");
            $("#nav-home").removeClass("active");

            // $("#nav-profile-tab").addClass("active");
            // $("#nav-profile").addClass("active");
            // $("#nav-profile").addClass("show");

            $(activeTab+"-tab").addClass("active");
            $(activeTab).addClass("active");
            $(activeTab).addClass("show");

            

        }
});


</script>
<script type="text/javascript">

var mock_test = parseInt('<?=($course_details->mock_test)?>');

courseId = '<?= $course_details->id?>';
var courseid = parseInt(courseId);

course_quiz_list = <?=json_encode($course_quiz_list)?>;

assessment_on = 'COURSE';
// question_counter = 0;
lesson_info = JSON.parse('<?=json_encode(isset($lesson_info_json) ? $lesson_info_json: '' )?>');
// console.log(lesson_info);
// if(!mock_test != 1){
    lesson_quiz = <?=json_encode($quiz)?>;



    $(document).ready(function() {
        $(':input[type="submit"]').prop('disabled', true);
        $('input[name="title"]').keyup(function() {
            if($(this).val() != '') {
                $(':input[type="submit"]').prop('disabled', false);
            }else{
                $(':input[type="submit"]').prop('disabled', true);

            }
        });
        /* replay button*/

        $('input[name="replay"]').keyup(function() {
            if($(this).val() != '') {
                $(':input[name="answer"]').prop('disabled', false);
            }else{
                $(':input[name="answer"]').prop('disabled', true);

            }
        });

        $("#publish").click(function(){
            title       = $(':input[name="title"]').val();
            description = $('textarea#description').val();

            $.ajax({
                type: 'POST',
                url: "<?= base_url('rest/api/insertUserQuestion')?>",
                data: {title:title, description:description, courseid:courseid},
                success: function(response) { 
                    result = JSON.parse(response);
                    if(result.success == true){
                        $(':input[name="title"]').val('');
                        $('textarea#description').val('');
                        document.getElementById("insert-message").setAttribute("class", "alert alert-success"); 
                        $("#insert-message").text('Your question appeared  in the question list.');

                        $("#insert-message").fadeOut(6000);
                    }

                }
            });
        });
    });


    $("#nav-ask-question-tab").on('click', function(){
        $("#nav-all-question-tab").text('Back');

        document.getElementById('all-question-show-tab').style.display = 'none';
    });

    $("#nav-all-question-tab").on('click', function(){
        $("#nav-all-question-tab").text('All Questions');

        document.getElementById('all-question-show-tab').style.display = 'block';
    });

    $('#publish').on('click', function () {
        $("#nav-all-question-tab").text('All Questions');
        document.getElementById('all-question-show-tab').style.display = 'block';
        location.reload(); 


    });

// $("#replay-section").on('click', function(){
    function replay(question_id){
        var  html = ''; 

        tabcontent = document.getElementsByClassName("back-to-all-question");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "block";
        }

        document.getElementById("all-replay-show-tab").style.display = 'block';
        document.getElementById("nav-all-question-tab").style.display = 'none';
        document.getElementById("nav-ask-question-tab").style.display = 'none';
        document.getElementById("all-question-show-tab").style.display = 'none';

        /* question get*/
        if(question_id != ''){
            $.ajax({
                url: '<?= base_url('rest/api/get_specific_question/')?>'+question_id,
                dataType: 'JSON',
                type: 'GET',
                success: function(response){

                    for(var i = 0; i < response['question_and_ans'].length; i++){

                        html += '<div class="row">';

                        html += '<div aria-label="Nazmul Huda" class=" user-avatar user-avatar--initials" data-purpose="user-avatar" style="background-color: rgb(110, 26, 82); font-size: 15px; width: 40px; height: 40px;">';

                        html += '<div class="user-avatar__inner fx-c">';

                        if(response['question_and_ans'][i].profile_photo_name == ''){
                            html += '<span class="user-initials">'+response['question_and_ans'][i].first_name.substr(0, 1)+' '+response['question_and_ans'][i].last_name.substr(0, 1)+' ';
                            html += '</span>';
                        }else{
                            html += '<img src="<?php echo base_url() . 'uploads/user_image/'  ?>" alt="" class="user-initials">'
                        }

                        html += '</div></div>';

                        html += '<div class="ml5 col-md-6"><div class="question-section">';
                        html += '<p class="title"  data-purpose="certificate-recipient">'+response['question_and_ans'][i].title+'</p>';
                        html += '<span>'+response['question_and_ans'][i].first_name+' '+response['question_and_ans'][i].last_name+'</span> ·';
                        html += '<span>'+response['question_and_ans'][i].created_at+'</span> <br>'
                        html += '<br/><p  data-purpose="certificate-recipient"> '+response['question_and_ans'][i].description+'</p></div>';

                        html += '</div></div><br>';
                    }

                    html += '<div class="row "><div class="col-md-10 recipient_name"><span>';
                    if(response['replay_list'].length > 0){
                        html += ''+response['replay_list'].length+'';
                    }else{
                        html += 'No ';
                    }
                    html += ' replies</span></div></div>';

                    for(var j = 0; j < response['replay_list'].length; j++){

                        html += '<br><div class="row recipient_name" style="max-width:86%">';

                        html += '<div aria-label="Nazmul Huda" class=" user-avatar user-avatar--initials" data-purpose="user-avatar" style="background-color: rgb(110, 26, 82); font-size: 15px; width: 40px; height: 40px; margin-left: 20px;">';

                        html += '<div class="user-avatar__inner fx-c">';

                        if(response['replay_list'][j].profile_photo_name == ''){
                            html += '<span class="user-initials">'+response['replay_list'][j].first_name.substr(0, 1)+' '+response['replay_list'][j].last_name.substr(0, 1)+' ';
                            html += '</span>';
                        }else{
                            html += '<img src="<?php echo base_url() . 'uploads/user_image/' ?>" alt="" class="user-initials">'
                        }

                        html += '</div></div>';

                        html += '<div class="ml5 col-md-6"><div class="question-section">';
html += '<span>'+response['replay_list'][j].first_name+' '+response['replay_list'][j].last_name+' - ';
if(response['replay_list'][j].instructor == 1){
    html += '<span class="instructor-title">Instructor</span></span>';
}else{
    html += '<span class="instructor-title">Student</span></span>';
}

html += '<p>'+response['replay_list'][j].created_at+'</p> <br>'
html += '<p  data-purpose="certificate-recipient"> '+response['replay_list'][j].replay_message+'</p></div>';

html += '</div></div>';
}
$(".replay-question").append(html);

}
});
}





}
// });

$(".back-to-all-question").on('click', function(){
    tabcontent = document.getElementsByClassName("back-to-all-question");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    document.getElementById("nav-all-question-tab").style.display = 'block';
    document.getElementById("nav-ask-question-tab").style.display = 'block';
    document.getElementById("all-question-show-tab").style.display = 'block';
    document.getElementById("all-replay-show-tab").style.display = 'none';

    jQuery('.replay-question').html('');

})

var i = 0;
var id ;
next_lesson = '<?php isset($next_lesson_id) ? $next_lesson_id : 0?>';
function endloader(){

    if (i == 0) {
        i = 1;
        var elem = document.getElementById("loader");
        var width = 1;
        id = setInterval(frame, 10);


        function frame() {
            windowWidth = 0;
            if(window.screen.width < 768){
                windowWidth = 130;
            }else if(window.screen.width >= 768 && window.screen.width < 1024){
                windowWidth = 190;
            }else{
                windowWidth = 300;
            }
            if (width >= windowWidth) {
                clearInterval(id);
                i = 0;
                if(i == 0 ){
                    if(next_lesson != 0 || next_lesson != ''){
                       
                            window.location.href = '<?= base_url('user/course/'.$course_details->id.'/'.$course_details->slug.'/lesson/'.$next_lesson_id)?>' ;  
                    }

                }

            } else {
                width++;
                elem.style.width = width + "px";

            }
        }

    }
}


/* end loader*/

current_duration = 0;
current_volume = 0.5;
player;
options = {};
players = '';


if(lesson_info.video_type == 'vimeo'){

    options = {
        id:lesson_info.vimeo_id ,
        width: 640,
        loop: false,
        quality:'360p',
        autoplay:true,
        title: true,
        byline : true
    };

}else{
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// player = new Plyr('#youtube_player');
function onYouTubePlayerAPIReady() {
    players = new YT.Player('youtube_player', {
        height: '390',
        width: '640',
        videoId: lesson_info.video_id,
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        },
        playerVars: {

            start: user_lesson_status_left,


        }
    });


}
function onPlayerReady(event) {
    event.target.playVideo();
}

function onPlayerStateChange(event) {
    var state = event.target.getPlayerState();
    if (state === 2) {
        user_lesson_status_updated(event.target.playerInfo.currentTime);
    }
    else if (state === 0) {
        user_lesson_status_updated(event.target.playerInfo.currentTime);
        $(".full_div").show();
        endloader();
    }
}
}


function playAgain(){
    $(".full_div").hide();
    window.location.href = '<?= base_url('user/course/'.$course_details->id.'/'.$course_details->slug.'/lesson/')?>'+lesson_info.id ;

}

function nextPlay(){
    $(".full_div").hide();
    window.location.href = '<?= base_url('user/course/'.$course_details->id.'/'.$course_details->slug.'/lesson/'.$next_lesson_id)?>' ;
}

function videoChange(){
    if(lesson_info.video_type == 'vimeo'){
        player.pause();
        player.on('pause', function(data) {
            user_lesson_status_updated(data.seconds);
        });
    }else{
// console.log(players.stopVideo().playerInfo.currentTime);
user_lesson_status_updated(players.stopVideo().playerInfo.currentTime);

}
}

load_player();

// if(lesson_info != null){
    if(lesson_info.video_type == 'vimeo'){

        /* Ended Functionality*/

        player.on('ended', function(data){
            user_lesson_status_updated(data.seconds);
            if(next_lesson != 0){
                $(".full_div").show();

                if(lesson_quiz == null){
                    endloader();
                }

            }



            if (lesson_quiz == null) {
                load_player();
                user_lesson_status_updated(data.seconds);
            } else {
                question_counter = 0;
                current_duration = data.duration;
                assessment_on = 'LESSON';
                $("#test_consent_course_number").html(lesson_quiz.question_list.length);
                $("#quiz_div").show();
            }

    if(next_lesson != 0){
         user_lesson_status_updated(data.seconds);
        window.location.href = '<?= base_url('user/course/'.$course_details->id.'/'.$course_details->slug.'/lesson/'.$next_lesson_id)?>' ;
    }

    });

        /* Pause Functionality*/
        player.on('pause', function(data) {
            load_player();
            user_lesson_status_updated(data.seconds);
        });
    }else{

    }
// }


// }else{
// }
   /*mock test check end*/

 
  
 
   
 


  
    function take_course_assessment(course_quiz_id, lesson_quiz_id){

       // 
        // console.log(course_quiz_id);
        document.getElementById("mock-list-sidebar").style.display = 'block'; 
        if(mock_test == 1 ){
            document.getElementById("mock-list-body").style.display = 'none'; 
            document.getElementsByClassName("course-content-title")[0].style.display = 'block';
        }
         // document.getElementsByClassName("course-content-title")[0].style.display = 'block'; 
        


        if(course_quiz_id != null){
            for (var i = 0; i < course_quiz_list.length; i++){
                if (course_quiz_list[i].id == course_quiz_id){
                    course_quiz = course_quiz_list[i];
                }
            }
        }else{
            for (var i = 0; i < lesson_quiz.length; i++){
                if (lesson_quiz[i].id == lesson_quiz_id){
                    lesson_quiz = lesson_quiz[i];
                }
            }
        }
        // for (var i = 0; i < course_quiz_list.length; i++){
        //     if (course_quiz_list[i].id == course_quiz_id){
        //         course_quiz = course_quiz_list[i];
        //     }
        // }
        document.getElementById("player").style.display = 'none'; 
      question_counter = 0;
      if(mock_test != 1){
       
        player.getCurrentTime().then(function(seconds) {

           
            current_duration = seconds;
            player.pause().then(function() {
                if(course_quiz_id != null){
                    assessment_on = 'COURSE';

                    $("#test_consent_course_number").html(course_quiz.question_list.length);
                }else{
                   
                    assessment_on = 'LESSON';

                    $("#test_consent_course_number").html(lesson_quiz.question_list.length);
           
                }
               
                setTimeout(time => {
                    document.getElementById("quiz_div").style.display = 'block'; 
                }, 10)
               // $("#quiz_div").show();
              
               
                 
                
                
            });
        });
      }else{
        if(course_quiz_id != null){
            assessment_on = 'COURSE';

            $("#test_consent_course_number").html(course_quiz.question_list.length);
        }


        $("#quiz_div_mock").show();
      }
           
    }


    function skip_test(){
        document.getElementById("player").style.display = 'block'; 

    
         if(mock_test == 1 ){
            document.getElementById("mock-list-sidebar").style.display = 'none'; 
            document.getElementById("mock-list-body").style.display = 'block'; 
            document.getElementById("quiz_div_mock").style.display = 'none';
            document.getElementsByClassName("course-content-title")[0].style.display = 'none';
         }
        

        if(mock_test != 1){
            load_player();
        }
        
    }

    function start_test() {
     
        // if(mobileCheck() == true){

        //     $(".plyr__video-embed").css({paddingBottom: "204%"});
        // }

      if(window.matchMedia("(max-width: 767px)").matches){
          // The viewport is less than 768 pixels wide
             $(".plyr__video-embed").css({paddingBottom: "204%"});
      } else if(window.matchMedia("(max-width: 1280px)").matches){
          // The viewport is at least 768 pixels wide
          $(".plyr__video-embed").css({paddingBottom: "75%"});
      }


      
        if(course_quiz_list[0].duration != null){
            if(course_quiz_list[0].duration != 0){
                
                $("#timer_div").show();
            }
            
           
        }

        if(mock_test != 1){
             if(Array.isArray(lesson_quiz) && lesson_quiz.length &&  lesson_quiz.duration != null){
                if(lesson_quiz.duration != 0){
                    
                    $("#timer_div").show();
                }
                
            }
        }
     
        
        user_assessment = {
            enrollment_id: '<?=$user_course_access_info["enrollment_id"]?>',
            question_and_answer_list: [],
            question_and_explanation: []
        };
        

        if(mock_test != 1){
            if (assessment_on == 'LESSON'){
                user_assessment.set_id = lesson_quiz.id

            } else {
                user_assessment.set_id = course_quiz.id
            }
            load_question(lesson_quiz);
           
        }else{
            user_assessment.set_id = course_quiz.id
            load_question();
        }
       
        if(mock_test != 1){
            $("#concent_div_on_player").hide();
            $("#question_div_on_player").show();
        }else{
            $("#concent_div_on_player_mock").hide();
            $("#question_div_on_player_mock").show();
        }
           
     
       
        

        /*timer start*/
        var c = -1;
        
      
            function myCounter() {
                if(course_quiz_list[0].duration != 0 || course_quiz_list[0].duration != null){
                    c= ++c;
                    document.getElementById("do").innerHTML = 'Time spent: '+ c  +' seconds';
                }
                if(mock_test != 1){
                     if(Array.isArray(lesson_quiz) && lesson_quiz.length &&  (lesson_quiz.duration != 0 || lesson_quiz.duration != null)) {
                        document.getElementById("do").innerHTML = 'Time spent: '+ c  +' seconds';
                    }
                
                }
            }

         if(course_quiz_list[0].duration != null || course_quiz_list[0].duration != 0 || lesson_quiz.duration != null || lesson_quiz.duration != 0){
            var quiztime = 0;
            if(course_quiz_list[0].duration != 0){
                quiztime = course_quiz_list[0].duration;
            }
           

            if(mock_test != 1){
                if(Array.isArray(lesson_quiz) && lesson_quiz.length &&  lesson_quiz.duration != 0){
                    quiztime = lesson_quiz.duration;
                }
            }
            myTimer = setInterval(myCounter, 1000);
            var fiveMinutes = 60 * quiztime;
            display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
            
                function startTimer(duration, display) {
                    var timer = duration, hours, minutes, seconds;
                   var tm =  setInterval(function () {
                        hours = Math.floor(timer / 3600);
                        minutes = parseInt(timer % 3600 / 60);
                        seconds = parseInt(timer % 3600 % 60);

                        hours = hours < 10 ? "0" + hours : hours;
                        minutes = minutes < 10 ? "0" + minutes : minutes;
                        seconds = seconds < 10 ? "0" + seconds : seconds;

                        display.textContent ='Time Left: ' +  hours + ':' + minutes + ":" + seconds;

                        if (--timer < 0 ) {
                            
                            
                            submit_assessment();
                          
                            
                            timer = duration;
                            // c = 0;


                        $("#timer_div").hide();

                        $("#timesup").show();
                        // $("#question_div_on_player").hide();

                        }

                        

                        
                    }, 1000);
                   if(duration == 0 ){
                       $("#timesup").hide();
                       clearInterval(tm);
                   
                   }
                    
                }
        }

            /* timer end*/
    }


    function load_player(){
        $("#quiz_div").hide();
        if(lesson_info.video_type == 'vimeo'){
            player = new Vimeo.Player('player', options);
            player.setVolume(current_volume);

        }else{
            // player = new Plyr('#youtube_player');
        }
        
    }
    var sec = 0;
    var min = 0;
    var total_sec = '';
    if(lesson_info != null){
        if(lesson_info.video_type == 'vimeo'){
            player.on('timeupdate', function (event) {
                
             // var date = new Date(0);
             // date.setSeconds(Math.floor(event.seconds)); // specify value for SECONDS here
             // var timeString = date.toISOString().substr(11, 8);
             var minutes = Math.floor(event.seconds / 60);
             var seconds = Math.floor(event.seconds) - minutes * 60;

             if(sec !=  seconds  || min !=  minutes){
                sec = seconds;
                min = minutes

                min = (min < 10) ? '0'+min : min;  
                sec = (sec < 10) ? '0'+sec : sec;  
               
                total_sec =  min+':'+sec;

                $(".current_time").text(total_sec);
             }
            
            })
            
        }
    }
    
   


    function load_question(){

           var letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];


           if (assessment_on == 'LESSON'){
               quiz_to_load = lesson_quiz;

           } else {

               quiz_to_load = course_quiz;

           }

           if (question_counter > (quiz_to_load.question_list.length - 1))

               return;
               var counter = 0;
            counter = question_counter +1;

           var html = '<p>Question '+ counter + ' of '+ quiz_to_load.question_list.length +'.</p>';
          

            html += '<p class="quiz_question" style="font-size: 20px;margin-bottom: 20px;">' + (question_counter + 1) + '. ' + quiz_to_load.question_list[question_counter].question + '</p>';
             if(quiz_to_load.question_list[question_counter].question_img != null){
            html += '<img class="quiz_question img-responsive" src="<?= base_url("uploads/question_images/")?>'+ quiz_to_load.question_list[question_counter].question_img+'" style="margin-bottom: 20px; width:250px; height:150px;" />';
        }
            if(!mock_test != 1){
                            


                 var option_list = JSON.parse(quiz_to_load.question_list[question_counter].option_list);
                for (var i = 0; i < option_list.length; i++){
                 // console.log(option_list[i]);
                 html += '<label class="label_container"  for="option_' + i + '"><span>' + letters[i] + '. ' + option_list[i] +'</span>';
                    html += '<input  id="option_' + i + '" type="radio" name="selected_answer" value="' + i + '">';
                    html += '<span class="checkmark"></span></label>';
                   
                }
            }else{

                   for (var i = 0; i < quiz_to_load.question_list[question_counter].option_list.length; i++){
                    // console.log(option_list[i]);
                    html += '<label class="label_container"  for="option_' + i + '"><span>' + letters[i] + '. ' + quiz_to_load.question_list[question_counter].option_list[i] +'</span>';
                       html += '<input  id="option_' + i + '" type="radio" name="selected_answer" value="' + i + '">';
                       html += '<span class="checkmark"></span></label>';
                      
                   }
            }
           

           // html += '<label>Explanation:</label><textarea id="explanation_'+question_counter+'" name="explanation" class="form-control"></textarea><br>';
           if(counter !=  1){
               html += '<button class="btn question_btn" onclick="previousQuestion()">Previous</button>';

           }

            html += '<button  class="btn question_btn" onclick="nextQuestion()" style="margin-left:10px;">Next</button>';
            html += '</br></br><p style="position: relative; display: list-item;list-style-type: disc;list-style-position: inside;">If you want to go to a specific question, select that number.</p> <div class="question_no" id="question_no" style="  overflow-x: scroll; -webkit-overflow-scrolling: touch;white-space: nowrap;bottom: 10px;position: relative; width:80%;  -webkit-overflow-scrolling: touch;"><div class="menu">';
                for(var i = 1; i <= quiz_to_load.question_list.length; i++){
                    color = "";
                    active = '';
                    color = "color:black";
                    if(counter == i){
                        color = "color:magenta";
                        active = 'active';
                    }
                        html += '<span class="'+active+'" style="padding-right:10px; display:inline-block; cursor:pointer; '+color+';  text-align: -webkit-match-parent;" onclick="specificQuestion('+i+')">'+i+'</span>';
                }
            html += '</div></div>';

            if(mock_test != 1){
                $("#question_div_on_player").html(html);
            }else{
                $("#question_div_on_player_mock").html(html);
            }
           
       }

    

       // function checkQuestion(){

       //  if (assessment_on == 'LESSON'){
       //      quiz_to_load = lesson_quiz;
       //  } else {
       //      quiz_to_load = course_quiz;
       //  }
       //   user_assessment.question_and_answer_list.push([quiz_to_load.question_list[question_counter].id, $('input[name="selected_answer"]:checked').val()]);

       // }

       function specificQuestion(question_no = null){
                  question_counter = question_no - 1;

                  // user_assessment.question_and_answer_list.push([quiz_to_load.question_list[question_counter].id, $('input[name="selected_answer"]:checked').val()]);

                  /* explanation*/
                  // user_assessment.question_and_explanation.push([quiz_to_load.question_list[question_counter].id, $('textarea[name="explanation"]').val()]);



                   if (question_counter == (quiz_to_load.question_list.length)) {
                    if(mock_test !=1){
                        $("#question_div_on_player").html(
                            '<div class="submit_confirmation_div">' +
                                '<p>You have answered all the questions.</p>' +
                                '<h3>Are you sure want to submit?</h3>'+
                                '<button class="btn" onclick="submit_assessment()">Submit</button>' +
                            '</div>'
                        );
                    }else{
                        $("#question_div_on_player_mock").html(
                            '<div class="submit_confirmation_div">' +
                                '<p>You have answered all the questions.</p>' +
                                '<h3>Are you sure want to submit?</h3>'+
                                '<button class="btn" onclick="submit_assessment()">Submit</button>' +
                            '</div>'
                        );
                    }
                     

                 } else {
                     load_question();

                     for(var i= 0; i < user_assessment.question_and_answer_list.length; i++){
                     
                          if(user_assessment.question_and_answer_list[i][0] == quiz_to_load.question_list[question_counter].id){
                         
                            if(user_assessment.question_and_answer_list[i][1] != 'undefined'){
                              
                              $('input[type="radio"][id="option_'+user_assessment.question_and_answer_list[i][1]+'"]').prop('checked', true);
                            }
                             
                          }
                      
                     }
                 }
             }


       function nextQuestion(){

           if (assessment_on == 'LESSON'){
               quiz_to_load = lesson_quiz;
           } else {
               quiz_to_load = course_quiz;
           }
            user_assessment.question_and_answer_list.push([quiz_to_load.question_list[question_counter].id, $('input[name="selected_answer"]:checked').val()]);
         
           question_counter++;

           if (question_counter == (quiz_to_load.question_list.length)) {
            if(mock_test != 1){
                $("#question_div_on_player").html(
                    '<div class="submit_confirmation_div">' +
                        '<p>You have answered all the questions.</p>' +
                        '<h3>Are you sure want to submit?</h3>'+
                        '<button class="btn" onclick="submit_assessment()">Submit</button>' +
                    '</div>'
                );
            }else{
                $("#question_div_on_player_mock").html(
                    '<div class="submit_confirmation_div">' +
                        '<p>You have answered all the questions.</p>' +
                        '<h3>Are you sure want to submit?</h3>'+
                        '<button class="btn" onclick="submit_assessment()">Submit</button>' +
                    '</div>'
                );
            }
               

           } else {
               load_question();

               for(var i= 0; i < user_assessment.question_and_answer_list.length; i++){
               
                if(user_assessment.question_and_answer_list[i][0] == quiz_to_load.question_list[question_counter].id){
                  
                    $('input[type="radio"][id="option_'+user_assessment.question_and_answer_list[i][1]+'"]').prop('checked', true);
                }
               }
           }


       }

        function previousQuestion(){

           if (assessment_on == 'LESSON'){
               quiz_to_load = lesson_quiz;
           } else {
               quiz_to_load = course_quiz;
           }
           question_counter--;
           load_question();
           for(var i= 0; i < user_assessment.question_and_answer_list.length; i++){
           
            if(user_assessment.question_and_answer_list[i][0] == quiz_to_load.question_list[question_counter].id){
              
                $('input[type="radio"][id="option_'+user_assessment.question_and_answer_list[i][1]+'"]').prop('checked', true);
            }
           }
           // console.log(user_assessment.question_and_answer_list);
           // console.log(quiz_to_load.question_list[question_counter].id);
            // user_assessment.question_and_answer_list.push([quiz_to_load.question_list[question_counter].id, $('input[name="selected_answer"]:checked').val()]);
           // if (question_counter == (quiz_to_load.question_list.length)) {

           //     $("#question_div_on_player").html(
           //         '<div class="submit_confirmation_div">' +
           //             '<p>You have answered all the questions.</p>' +
           //             '<h3>Are you sure want to submit?</h3>'+
           //             '<button class="btn" onclick="submit_assessment()">Submit</button>' +
           //         '</div>'
           //     );

           // } else {
               
           // }


       }


    function submit_assessment(){
        
        $.ajax({
            method: 'post',
            url: '<?=base_url("rest/api/save_assessment")?>',
            data: user_assessment,
            success: function(response){
                result = JSON.parse(response);
                if (result.success){
                    if(mock_test != 1){
                        $("#question_div_on_player").html(
                            '<div class="submit_confirmation_div">' +
                                '<p>Assessment result saved successfully.</p>' +
                                '<p>See you performance <a href="<?=base_url('user/quiz_result?enrollment_id=' . $user_course_access_info["enrollment_id"] . '&set_id=')?>'+user_assessment.set_id+'">here</a>' +
                            '</div>'
                        );
                    }else{
                        $("#question_div_on_player_mock").html(
                            '<div class="submit_confirmation_div">' +
                                '<p>Assessment result saved successfully.</p>' +
                                '<p>See you performance <a href="<?=base_url('user/quiz_result?enrollment_id=' . $user_course_access_info["enrollment_id"] . '&set_id=')?>'+user_assessment.set_id+'">here</a>' +
                            '</div>'
                        );
                    }
                    
                }
            }
        })
    }


    // Status monitoring code follows
    user_lesson_status_left = 0;
    user_lesson_status = '<?=isset($user_lesson_status[0]->finished_time) ? (int) $user_lesson_status[0]->finished_time : 0?>';
    user_lesson_id = '<?=isset($user_lesson_status[0]->id) ? (int) $user_lesson_status[0]->id : null?>';


  
   

    course_id = '<?=json_encode($course_details->id)?>';


    function user_lesson_status_updated(data){
        lesson_time =  Math.round(data);

        if(lesson_time > 0){

            if(user_lesson_status === '' || user_lesson_status === null){

                /*For lesson status inserted*/

                $.ajax({
                    url: '<?=base_url('rest/api/user_lesson_status_update')?>' + user_lesson_id,
                    type: 'POST',
                    data: {lesson_time: lesson_time, lesson_id: lesson_info.id},
                    success:function(response){
                        var res =  JSON.parse(response);

                        if(res.success == true){
                            user_lesson_status = lesson_time;
                            user_lesson_id = res.id;
                        }
                    }
                });

            }else{
                if(user_lesson_status < lesson_time){
                    $.ajax({
                        url: '<?=base_url('rest/api/user_lesson_status_update/')?>' + user_lesson_id,
                        type: 'POST',
                        data: {lesson_time: lesson_time, lesson_id: lesson_info.id},
                        success: function(response){
                            var res =  JSON.parse(response);
                            if(res.success == true){
                                user_lesson_status = lesson_time;

                            }
                        }
                    });
                }
            }

        }
    }

    /*To set previous time in lesson*/
    if(user_lesson_status == lesson_info.duration_in_second){
        user_lesson_status_left = 0;
    }else{
        user_lesson_status_left = user_lesson_status - 5;
    }

    if(lesson_info.video_type == 'vimeo'){
        player.setCurrentTime(user_lesson_status_left).then(function(seeking) {
        // seeking = whether the player is seeking or not
        }).catch(function(error) {
        // an error occurred
        });

        $(document).on('visibilitychange', function() {
            if(document.visibilityState == 'hidden') {
                player.pause();
            } else {
                // player.play();
            }
        });
    }
    
  


</script>


<script type="text/javascript">
      // With jQuery
// $(document).on({
//     "contextmenu": function(e) {
//         console.log("ctx menu button:", e.which); 

//         // Stop the context menu
//         e.preventDefault();
//     },
//     "mousedown": function(e) { 
//         console.log("normal mouse down:", e.which); 
//     },
//     "mouseup": function(e) { 
//         console.log("normal mouse up:", e.which); 
//     }
// });


$(document).ready(function(){
    screenSize = window.screen.width;
    if(screenSize < 768){
        // The viewport is less than 768 pixels wide
        document.getElementById("bar").style.left  = '30%';
        document.getElementById("loader").style.width  = '130px';
        document.getElementById("bar").style.width = "130px"; 
        document.getElementById("play_again").style.fontSize  = "12px";
        document.getElementById("next").style.fontSize  = "12px";
        document.getElementById("play_again").style.left  = "31%";
        document.getElementById("next").style.left  = "51%";
    } else if(screenSize >= 768 && screenSize < 1024){
        document.getElementById("bar").style.left  = "40%";
        document.getElementById("loader").style.width  = "190px";
        document.getElementById("bar").style.width = "190px"; 
        document.getElementById("next").style.left  = "54%";
        document.getElementById("play_again").style.fontSize  = "12px";
        document.getElementById("next").style.fontSize  = "12px";
    }else{
        // The viewport is at least 768 pixels wide
        document.getElementById("bar").style.left  = "40%";
        document.getElementById("bar").style.width  = "300px";
        document.getElementById("loader").style.width  = "300px";
    }
});

</script>