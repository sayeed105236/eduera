showQuiz = false;
videoQuizList = null;
allowSkip = false;
allowWrongAnswer = false;
player = null;
justStartedPlaying = false;
isIntialModeFullScreen = false;
breakPointIndex = 0;

function setAllowSkip(value){
  allowSkip = value;
}


function setAllowWrongAnswer(value){
  allowWrongAnswer = value;
}


function loadPlayerQuestions(inputQuizList){
  videoQuizList = inputQuizList;
}

function enableQuiz(){
  showQuiz = true;

  var player = videojs('gsda_player');
  markerList = {
    markers: []
  }
  for (var i = 0; i < videoQuizList.length; i++){
    markerList.markers.push({
      time: videoQuizList[i].time
      // text: quizList[i].question
    });
  }
  player.markers(markerList);
}

function disableQuiz(){
  showQuiz = false;
}

function insertQuizFrom(){
  
  var selectedQuizIndex = Math.floor(Math.random() * videoQuizList[breakPointIndex].quizList.length);
  var quiz = videoQuizList[breakPointIndex].quizList[selectedQuizIndex];
  
  var question = $("<p></p>");
  question.addClass('question');
  question.html(quiz.question);

  var optionList = '';
  for (var i = 0; i < quiz.optionList.length; i++){
    optionList += '<input class="button option_input" type="radio" name="quiz_option" value="' + quiz.optionList[i].id + '"> ' + quiz.optionList[i].value +'<br />'
  }

  var submitButton = '<input type="button" id="quiz_submit" class="action_button" value="Submit">';
  var continueButton = '<input type="button" class="action_button after_answer_action" id="continue_button" value="Continue" continue_point="' + 
                        videoQuizList[breakPointIndex].time + '.1">';
  var watchAgainButton = '<input type="button" class="action_button after_answer_action" id="watch_again_button" value="Watch Again" continue_point="' + 
                        (breakPointIndex == 0 ? '0' : videoQuizList[breakPointIndex - 1].time) + '.1">';
  var successMessage = '<p id="quiz_answer_success_message"></p>';

  formContainer = $("<div id='gsda_player_form_container'></div>");
  formContainer.addClass('overlay');

  

  mainForm = $("<div class='question_form' id='question_form'></div>").append(question, successMessage, optionList, submitButton);
  formContainer.append(mainForm);
  $("#gsda_player_container").append(formContainer);


  $("input#quiz_submit").click(function(){
      quiz.usersAnswer = parseInt($("input[name='quiz_option']:checked").val());
      $(".option_input").attr('disabled','disabled');
      $("#quiz_submit").remove();
      if (quiz.usersAnswer == quiz.answer) {
        videoQuizList[breakPointIndex].answered = true;
        if (breakPointIndex < videoQuizList.length - 1) {
          breakPointIndex++;
        }
        $("#quiz_answer_success_message").removeClass('wrong').addClass('right').html("Corrent");
        mainForm.append(continueButton);
      } else {        
        $("#quiz_answer_success_message").removeClass('right').addClass('wrong').html("Incorrent");
        mainForm.append(watchAgainButton);
      }

      $("input.after_answer_action").click(function(){
        justStartedPlaying = true;
        if (isIntialModeFullScreen) {
          player.requestFullscreen();
        }
        player.play();
        player.controls(true);
        player.currentTime(parseInt($(this).attr('continue_point')));
        formContainer.remove();
      });

      // console.log(givenAnswer);
  });






}

$(function(){
    // videojs('my-video', {
    //     controls: true,
    //     autoplay: true,
    //     preload: 'auto'
    // });

    // adding a button to the player
    player = videojs('gsda_player', {
        controls: true,
        autoplay: true,
        muted: false,
        preload: 'auto'
    });

    // player.on('play', ()=>{
    //   console.log(player.controlBar.progressControl.seekBar);
    //   player.controlBar.progressControl.seekBar.disable();
    // });

    // player.on('timeupdate', function() {
    //     if (Math.floor(player.currentTime()) > player.options.maxSecondsSeek) {
    //         player.pause();
    //         player.currentTime(timeBeforeChange);
    //         player.play();
    //     } else if (Math.floor(player.currentTime()) == player.options.maxSecondsSeek) {
    //         player.options.maxSecondsSeek += 1;
    //     }
    //     timeBeforeChange = player.currentTime();
    // });
    

    //  var buttonComponent = videojs.getComponent('Button');
    //  var stopButton = new buttonComponent(player, {
  	//   text: 'Stop Button',
  	//   buttonChildExample: {
  	//     buttonChildOption: true
  	//   }
  	// });


    // var formComponent = videojs.getComponent('Component');
    // console.log(formComponent);
    // var form = new formComponent(player);
    // form.addClass('quiz-form');

    // player.addChild(form);

    player.on('seeking', ()=>{
      console.log(videoQuizList);

      console.log("After seek - " + player.currentTime());
      var allowedToSeek = true;
      if (showQuiz) {
        if (!allowSkip) {
          for (var i = 0; i < videoQuizList.length; i++){
            console.log(videoQuizList[i].time + " - " + player.currentTime().toFixed());
            if (videoQuizList[i].time < player.currentTime().toFixed()) {
              if (!videoQuizList[i].answered) {
                allowedToSeek = false;
                break;
                // player.currentTime(0);
              } else {
                quizLoop:
                for (var j = 0; j < videoQuizList[i].quizList.length; j++){
                  if (videoQuizList[i].quizList[j].usersAnswer == videoQuizList[i].quizList[j].answer) {
                    allowedToSeek = true;
                    break quizLoop;
                  } else {
                    if (!allowWrongAnswer) {
                      allowedToSeek = true;
                      break quizLoop;
                    } else {
                      allowedToSeek = false;
                    }
                  }
                }
              }              
            }
          }

          // console.log(new Date() + " - " + allowedToSeek);
          if (!allowedToSeek) {
            justStartedPlaying = true;
            player.currentTime( i == 0 ? 0 : videoQuizList[i-1].time);
          }
        }
      }
     // if (player.currentTime() > 30){
     //   player.currentTime(0);
     // }
     // console.log(videojs.getPlayer('my-video').currentTime());
    });


    player.on('timeupdate', ()=>{

      // console.log(showQuiz);
      
      if (showQuiz) {
        console.log(breakPointIndex); 
        // console.log(player.currentTime().toFixed() + " = " + quizList[breakPointIndex].time);
    
        if ($("#gsda_player_form_container").length) {
          $("#gsda_player_form_container").remove();
        }
        // console.log(videojs.getPlayer('my-video').currentTime());
        if (player.currentTime().toFixed() == videoQuizList[breakPointIndex].time){
          if (!justStartedPlaying) {
            player.pause();
            player.controls(false);
            if (player.isFullscreen()) {
              isIntialModeFullScreen = true;
              player.exitFullscreen();
            }

            insertQuizFrom();

            var quizFormWidth = player.dimension('width');
            var quizFormHeight = player.dimension('height') - player.controlBar.dimension('height');
            $(".overlay").css("width", quizFormWidth + "px");
            $(".overlay").css("height", quizFormHeight + "px");            
            $(".overlay").show();

            if (breakPointIndex > videoQuizList.length) {
              return;
            }
          }          
        } else {
          justStartedPlaying = false;
        }
      }
    });


    

    // console.log(videojs.getPlayer('my-video').currentTime());
    // if (videojs.getPlayer('my-video').currentTime() > 30){
    // 	videojs.getPlayer('my-video').currentTime(1);
    // }

    // player.on('timeupdate', ()=>{
    // 	// console.log(videojs.getPlayer('my-video').currentTime());
    // 	if (player.currentTime() > 30){
    // 		console.log('Passed 30 seconds');
    //         player.pause();
    //         player.controls(false);
    //         $(".overlay").show();
    // 	}
    // });

    // player.on('seeking', ()=>{
    // 	if (videojs.getPlayer('my-video').currentTime() > 30){
    // 		videojs.getPlayer('my-video').currentTime(1);
    // 	}
    // 	// console.log(videojs.getPlayer('my-video').currentTime());
    // });

    // console.log(player.controlBar.progressControl.seekBar);
    // console.log(showQuiz);
})
