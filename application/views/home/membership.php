<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<div class="container">

    <br>
        <div class="form-group">
        <?php echo validation_errors(); ?>
        
        <?php if ($this->session->flashdata('portwallet_error')) {?>

        <div class="alert alert-danger alert-dismissible show " role="alert">
            <strong></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?=$this->session->flashdata('portwallet_error')?>
        </div>

        <?php }?>


        <?php if ($this->session->flashdata('portwallet_success')) {?>

        <div class="alert alert-success alert-dismissible show congrats" role="alert">
            <strong></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?=$this->session->flashdata('portwallet_success')?>
        </div>

        <?php }?>

    </div>
   
    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">Become a member</h1>
      <p class="lead">You will get 2 out of 10 free live virtual international training  if you are a member.</p>
    </div>

      <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
          <div class="card-header card-header-inline">
            <h4 class="my-0 font-weight-bold" >Membership Plan</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title"><?= currency(2000)?> 
            </h1>
            <div class="row">
                <!-- <div class="col-md-6">
                
                    <h2 class="h4 mb-1">Choose any 2 training</h2><br>
                    <ul class="list-group">
                       <li class="list-group-item rounded-0">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck1" name="courses[]" type="checkbox" value="ITIL 4 Foundation">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck1">ITIL 4 Foundation</label>
                           </div>
                       </li>
                       <li class="list-group-item">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck2" name="courses[]" type="checkbox" value="PRINCE2 Foundation Training">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck2">PRINCE2 Foundation Training</label>
                           </div>
                       </li>
                       <li class="list-group-item">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck3" name="courses[]" type="checkbox" value="Internet of Things">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck3">Internet of Things</label>
                           </div>
                       </li>
                       <li class="list-group-item">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck4" name="courses[]" type="checkbox" value="Practical Project Management (PPM)">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck4">Practical Project Management (PPM)</label>
                           </div>
                       </li>
                       <li class="list-group-item rounded-0">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck5" name="courses[]" type="checkbox" value="CCC Big Data Foundation">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck5">CCC Big Data Foundation</label>
                           </div>
                       </li>
                       <li class="list-group-item rounded-0">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck6" name="courses[]" type="checkbox"  value="EXIN Agile Scrum Foundation">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck6">EXIN Agile Scrum Foundation</label>
                           </div>
                       </li>
                       <li class="list-group-item rounded-0">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck7" name="courses[]" type="checkbox" value="COBIT 5 Foundation">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck7">COBIT 5 Foundation</label>
                           </div>
                       </li>
                       <li class="list-group-item rounded-0">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck8" name="courses[]" type="checkbox" value="ISO 27001 Foundation">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck8">ISO 27001 Foundation</label>
                           </div>
                       </li>
                       <li class="list-group-item rounded-0">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck9" name="courses[]" type="checkbox" value="PRINCE2 Practitioner  Training">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck9">PRINCE2 Practitioner  Training</label>
                           </div>
                       </li>
                       <li class="list-group-item rounded-0">
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" id="customCheck10" name="courses[]" type="checkbox" value="Agile Scrum Master Training">
                               <label class="cursor-pointer font-italic d-block custom-control-label" for="customCheck10">Agile Scrum Master Training </label>
                           </div>
                       </li>
                   </ul>

                 
                </div> -->
                <div class="col-md-6 mx-auto">
               <h2 class="h4 mb-1">Key features</h2><br>
                     <ul class="list-group">
                        <li class="list-group-item rounded-0 features">
                            <div class="custom-control ">
                               
                                <label class="cursor-pointer font-italic d-block " > <span class="" >#</span> You will get discount from our live virtual training</label>
                            </div>
                        </li>
                        <li class="list-group-item features">
                            <div class="custom-control ">
                                <label class="cursor-pointer font-italic d-block " > <span class="" >#</span> Live virtual trainer lead interactive training</label>
                            </div>
                        </li>
                        <li class="list-group-item features">
                            <div class="custom-control ">
                                <label class="cursor-pointer font-italic d-block " > <span class="" >#</span> Digital certificate</label>
                            </div>
                        </li>
                        <li class="list-group-item features">
                            <div class="custom-control ">
                                <label class="cursor-pointer font-italic d-block " > <span class="" >#</span> Monthly live mentoring session</label>
                            </div>
                        </li>
                        
                       
                    </ul>
                </div>
            </div>
            <br>
            <br>
            <ul style="list-style: none" >
                <!-- <li>Share your details information with an employer</li> -->
                <li>Are you interested in a new job ?</li>

               <div class="form-group" style="display: inline-block;">
                   <input type="radio" name="terms" id="terms" value="yes" onchange="employerStatus(this)"><label class="status">Yes</label>
                   <input type="radio" name="terms" id="terms" value="no" onchange="employerStatus(this)"><label class="status">No</label>

               </div>
                 

            </ul>
                <div class="silver">

                <?php if($this->session->userdata('user_id') == null || $this->session->userdata('phone') == null || strlen($this->session->userdata('phone')) <= 9){?>
                   <!--  <button type="button" class="btn btn-lg  btn-outline-info  details-button " data-toggle="modal" data-target="#membershipInfo">Details</button> -->

                    <button type="button" class="btn btn-lg  btn-outline-primary  membership-button-silver " data-toggle="modal"  onclick="getMembershipInfo('silver')">Subscribe</button>
                    <?php }else{ ?>
                   <!--  <button type="button" class="btn btn-lg  btn-outline-info  details-button" data-toggle="modal" data-target="#membershipInfo">Details</button> -->

                    <button type="button" class="btn btn-lg  btn-outline-primary membership-button-silver " onclick="getMembershipInfoWithUrl('silver')">Subscribe</button>
                    <?php }?>
                </div>
          </div>
        </div>
      
      </div>
</div>  

<div class="modal fade" id="getStarted" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Your information </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form method="post" action="<?= base_url('home/membership')?>" id="membership_form">      
          <div class="modal-body">
            <div class="container">
                <div class="form-group row">
                    <input type="hidden" name="membership" >
                    <input type="hidden" name="employerStatus" >
                    <input type="hidden" name="courses" >
                    <label class="control-label col-md-4 mx-auto label" for="name">Full name </label>
                    <input type="text" name="name" id="member_name" class="form-control col-md-8" required="">
                </div>

                 <div class="form-group row">
                    <label class="control-label col-md-4 mx-auto label" for="phone">Phone number </label>
                    <input type="text" name="phone" id="member_phone" class="form-control col-md-8" required="">
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-4 mx-auto label" for="email">Email </label>
                    <input type="email" name="email" id="member_email" class="form-control col-md-8" required="">
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>  
    </div>
  </div>
</div>


<div class="modal fade" id="membershipInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">International Training </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <h4>You can select any 2 training</h4>
            <ul>
              <li>ITIL 4 Foundation</li>
              <li>PRINCE2 Foundation Training</li>
              <li>Internet of Things</li>
              <li>Practical Project Management (PPM)</li>
              <li>CCC Big Data Foundation</li>
              <li>EXIN Agile Scrum Foundation</li>
              <li>COBIT 5 Foundation</li>
              <li>ISO 27001 Foundation</li>
              <li>PRINCE2 Practitioner  Training</li>
              <li>Agile Scrum Master Training </li>

            </ul>
            
        </div>
      </div>
     
    </div>
  </div>
</div>


<script type="text/javascript">
    var statusValue = {}; 
    var  employeer = '';
    function employerStatus(status){
        statusValue = {
            value: status.value,
        }
        return status.value;
    }
     courses = [];
     $(".custom-checkbox input[type='checkbox']").change(function(){
        var course = $(this).val();
        if($(this).prop('checked')){
          if(courses.indexOf(course) === -1) {
              courses.push(course);
          }
        }else{
          courses.pop();
        }
        
        if(courses.length > 2){
          courses.pop();
            alert("Please choose only 2 course");
            $(this).prop("checked", false);
            
        }
      $("#membership_form input[name='courses']").val(courses);
    });
      
    // console.log(test);
    function getMembershipInfo(data){
         employeer = statusValue.value;
        console.log(data);
      // if(courses.length < 2){
      //   alert('Please select atleast 2 course');
      //   $('#getStarted').modal('hide');
      // }
      // else 
      // if(employeer == '' || employeer == undefined){
      // //    alert('Please select employeer status');
      // //   $('#getStarted').modal('hide');
      // // }
      // else{
        $(".membership-button-silver").attr("data-target", "#getStarted");
      // }
  
         $("#membership_form input[name='membership']").val(data);
         $("#membership_form input[name='employerStatus']").val(employeer);
    }

     function getMembershipInfoWithUrl(data){
         employeer = statusValue.value;

        if(data == ''){
            alert('Membership information missing.')
            
        }else{
        // else  if(courses.length < 2){
        //   alert('Please select atleast 2 course');
        //   // $('#getStarted').modal('hide');
        
        // }
        // else if(employeer == '' || employeer == undefined){
        //  alert('Please select employeer status');
        // }else {
  

            window.location = "<?=base_url('portwallet/membership/')?>"+data+'?emp='+employeer;
            // 
        }
       
         
    }

/* Congratulations effect*/
    $(function() {
      var numberOfStars = 100;
      
      for (var i = 0; i < numberOfStars; i++) {
        // $('.congrats').append('<div class="blob fa fa-heart ' + i + '"></div>');
        $('.congrats').append('<div class="blob fa fa-heart ' + i + '"></div><div class="smile fa fa-smile ' + i + '"</div>');
      } 

      animateText();
      
      animateBlobs();
    });

    $('.congrats').click(function() {
      reset();
      
      animateText();
      
      animateBlobs();
    });

    function reset() {
      $.each($('.blob'), function(i) {
        TweenMax.set($(this), { x: 0, y: 0, opacity: 1 });
      });

       $.each($('.smile'), function(i) {
        TweenMax.set($(this), { x: 0, y: 0, opacity: 1 });
      });
      
      // TweenMax.set($('h1'), { scale: 1, opacity: 1, rotation: 0 });
    }

    function animateText() {
      //   TweenMax.from($('h1'), 0.8, {
      //   scale: 0.4,
      //   opacity: 0,
      //   rotation: 15,
      //   ease: Back.easeOut.config(4),
      // });
    }
      
    function animateBlobs() {
      
      var xSeed = _.random(350, 380);
      var ySeed = _.random(120, 170);
      
      $.each($('.blob'), function(i) {
        var $blob = $(this);
        var speed = _.random(1, 5);
        var rotation = _.random(5, 100);
        var scale = _.random(0.8, 1.5);
        var x = _.random(-xSeed, xSeed);
        var y = _.random(-ySeed, ySeed);

        TweenMax.to($blob, speed, {
          x: x,
          y: y,
          ease: Power1.easeOut,
          opacity: 0,
          rotation: rotation,
          scale: scale,
          onStartParams: [$blob],
          onStart: function($element) {
            $element.css('display', 'block');
          },
          onCompleteParams: [$blob],
          onComplete: function($element) {
            $element.css('display', 'none');
          }
        });
      });

      $.each($('.smile'), function(i) {
        var $blob = $(this);
        var speed = _.random(1, 5);
        var rotation = _.random(5, 100);
        var scale = _.random(0.8, 1.5);
        var x = _.random(-xSeed, xSeed);
        var y = _.random(-ySeed, ySeed);

        TweenMax.to($blob, speed, {
          x: x,
          y: y,
          ease: Power1.easeOut,
          opacity: 0,
          rotation: rotation,
          scale: scale,
          onStartParams: [$blob],
          onStart: function($element) {
            $element.css('display', 'block');
          },
          onCompleteParams: [$blob],
          onComplete: function($element) {
            $element.css('display', 'none');
          }
        });
      });
    }

</script>