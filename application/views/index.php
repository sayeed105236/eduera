<!DOCTYPE html>
<html lang="en">
<head>

	<?php if ($page_name == 'course_detail'): ?>
		<title><?=$course->seo_title?></title>
		<?php else: ?>
			<title><?=get_settings('seo_title')?></title>
		<?php endif;?>


		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="author" content="<?php echo get_settings('author') ?>" />
		<meta name="robots" content="max-snippet:-1, max-image-preview:large, max-video-preview:-1">
		<meta name="google-site-verification" content="DOzzXZr2UE6Y3_ExIjrpC6yIcY48mTbVqBeCaThT_B8" />
		<?php
$seo_pages = array('home', 'course_detail');
if (in_array($page_name, $seo_pages)) {?>
			<?php if ($page_name == 'course_detail') {?>
				<meta name="keywords" content="<?=$course->meta_tags?>"/>
				<meta name="description" content="<?=$course->meta_description?>" />
			<?php } else if ($page_name == 'home') {?>
				<meta name="keywords" content="<?=get_settings('meta_tags')?>"/>
				<meta name="description" content="<?=get_settings('meta_description')?>" />
			<?php }?>
		<?php }?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/login/font-awesome/css/font-awesome.min.css">
		<link name="favicon" type="image/x-icon" href="<?php echo base_url() . 'uploads/system/eduera-favicon.png' ?>" rel="shortcut icon" />
		<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/select2.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/slick.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/slick-theme.css'; ?>">
		
		<!--user chat css-->
		<?php if($page_name=='user_message'){?>
		<link href="<?= base_url('assets/frontend/chat/user_chat.css')?>" rel="stylesheet"/>
		<?php } ?>
		<!-- share social media css start-->
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials-theme-flat.css">
		<!-- share social media css end-->

		<link href="<?= base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet">

		<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/fontawesome-all.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/bootstrap.min.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/main.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/responsive.css'; ?>">
		<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/jquery.webui-popover.min.css'; ?>">
		<script src="<?php echo base_url() . 'assets/frontend/default/js/tinymce.min.js'; ?>"></script> 

		<script src="<?php echo base_url('assets/backend/js/jquery-3.3.1.min.js'); ?>"></script>
		<?php if ($page_name === 'faq' || $page_name === 'quiz_result' || $page_name === 'lesson') {?>
			<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/main.css'; ?>">
			<?php
}
?>
<?php if($page_name == 'course_detail'){?>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/frontend/default/css/course_details_page.css')?>">
	<?php }?>
	
		<?php if ($page_name === 'login') {?>

			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/login/font-awesome/css/font-awesome.min.css">
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/login/css/style.css">

		<?php }?>
		<?php if ($page_name === 'view_certificate') {?>

			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/default/css/view_certificate.css">
		<?php }?>

		
		<?php if ($page_name === 'lesson') {?>
			<link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/default/css/user-lesson-view.css">
			<link rel="stylesheet" href="<?php echo base_url() . 'assets/frontend/default/css/overview.css'; ?>">
		<?php }?>
		<?php
include "socialShare.php";
?>
		<script src="<?php echo base_url('assets/frontend/default/js/popper.min.js'); ?>"></script>
		<script src="<?php echo base_url() . 'assets/frontend/default/js/bootstrap.min.js'; ?>"></script>

		<!-- Facebook Pixel Code -->
		<!-- <script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window,document,'script',
					'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '415184348686393');
				fbq('init', '217535706267638');
				fbq('track', 'PageView');
			</script>
			<noscript>
				<img height="1" width="1"
				src="https://www.facebook.com/tr?id=415184348686393&ev=PageView
				&noscript=1"/>
			</noscript> -->
			<!-- End Facebook Pixel Code -->
			
			<!-- Facebook Pixel Code -->
			<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window,document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
			 fbq('init', '575192549835910'); 
			fbq('track', 'PageView');
			</script>
			<noscript>
			 <img height="1" width="1" 
			src="https://www.facebook.com/tr?id=575192549835910&ev=PageView
			&noscript=1"/>
			</noscript>
			<!-- End Facebook Pixel Code -->
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=UA-159968734-1"></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());

			  gtag('config', 'UA-159968734-1');
			</script>

		</head>
		<body class="gray-bg">

			<script>
				fbq('track', 'CompleteRegistration', {
					value: 0.01,
					currency: 'BDT'
				});
			</script>
			<?php

if($instructor_page_name == 'instructor_panel'){
	include 'instructor/header.php';
	include 'instructor/sidebar.php';
}else{
	include 'component/header.php';

}

include $page_view . '.php';
include 'component/footer.php';
// include 'includes_bottom.php';
// include 'modal.php';
// include 'common_scripts.php';
?>

<?php if($page_name === 'home'){?>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/default/css/home_page.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/js/uikit.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/js/uikit-icons.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.js"></script>
	<script type="text/javascript">
	    $('.owl-carousel').owlCarousel({
	        loop:false,
	      	stagePadding: 15,
	        margin:10,
	        nav:true,
	      	navText : ['<span class="uk-margin-small-right uk-icon" uk-icon="icon: chevron-left"></span>','<span class="uk-margin-small-left uk-icon" uk-icon="icon: chevron-right"></span>'],
	   
	        responsive:{
	            0:{
	                items:1
	            },
	            
	            640:{
	                items:2
	            },
	          	960:{
	                items:3
	            },
	            1200:{
	                items:3
	            },
	            1600: {
	            	items: 4
	            }
	        },
	        
	    });
	    
	</script>
<?php }?>
			<!-- Social share option js start -->
			<script type="text/javascript">

				function shareSocial(slug){
					var socialSlug = '<?=base_url('course/')?>'+slug;
					$("#myInput").val(socialSlug);
					var url = "<?=base_url('course/')?>"+slug;
					$("#shareButton").jsSocials({
						url: url,
						text: "Thought you might enjoy this course on @Eduera: <?=isset($course->title) ? $course->title : null?> " ,
						showCount: false,
						showLabel: false,
						shareIn: "popup",
						shares: [
						"twitter",
						"facebook",
						"linkedin",
						{ share: "pinterest", label: "Pin this" },
						{ share: "email", logo: "fas fa-envelope"}
						]
					});
				}

			</script>
			<!-- Social share option js end -->
			<!-- WhatsHelp.io widget -->
			<!-- <script type="text/javascript">
				(function () {
					var options = {
facebook: "1587216144886873", // Facebook page ID
call_to_action: "Live chat", // Call to action
position: "Right", // Position may be 'right' or 'left'
};
var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
})();
</script> -->

<!-- /WhatsHelp.io widget -->

<script src="<?php echo base_url() . 'assets/frontend/default/js/slick.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/frontend/default/js/select2.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/frontend/default/js/jquery.webui-popover.min.js'; ?>"></script>
<script src="<?php echo base_url() . 'assets/frontend/default/js/main.js'; ?>"></script>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.min.js"></script>

<script src="https://js.pusher.com/6.0/pusher.min.js"></script>

<script>

    login_user = '<?= ($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : ''?>';
    if(login_user != ''){
        Pusher.logToConsole = true;
    
        var pusher = new Pusher('46cd25c3a10b34a7f996', {
          cluster: 'mt1'
        });
    
    
        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
        
        
        var aSound = document.createElement('audio');
        aSound.setAttribute('src', 'https://www.file.server.eduera.com.bd/user_message.mp3');
        aSound.play();
        
        
        /*user unseen message count*/
            $.ajax({
              url: '<?=base_url('/rest/api/get_user_unseen_message/')?>'+data.sender_id,
              type: 'GET',
              success:function(response){
                  data = JSON.parse(response);
                  $('#message_notification_count').text(data[1]);
              }
          });
          
        
        })
    }
    </script>

<?php if($page_name == 'membership'){?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js>
    "></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.2/underscore-min.js"></script>

<?php }?>
<?php if($instructor_page_name == 'instructor_panel'){?>
 
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });

            $("#manage").on('click', function(){
            	// $('#sidebar').toggleClass('active');
            	// $(this).toggleClass('active');
            	$("#sidebar").hide();
            })
        });
    </script>
<?php } ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

<script type="text/javascript">
	/*Review section js*/

	var stars = '';
	$("label").click(function(){
	  // $(this).parent().find("label").css({"background-color": "#D8D8D8"});
	  // $(this).css({"background-color": "#7ED321"});
	  // $(this).nextAll().css({"background-color": "#7ED321"});
	  stars = $(this)[0].attributes[1].value;
	  if(stars == 'first-star'){
	    $("#rating-title").text('Terrible, not  expected at all');
	  }else if(stars == 'second-star'){
	    $("#rating-title").text('Ordinary, very disappointed');
	  }else if(stars == 'third-star'){
	    $("#rating-title").text('Average, could be better');
	  }else if(stars == 'fourth-star'){
	    $("#rating-title").text('Good, what I Expected');
	  }else if(stars == 'fifth-star'){
	    $("#rating-title").text('Stunning, beyond expectation');
	  }
	  $(".review-section").show();

	});

	$(".review-btn").click(function() {

		course_id = "<?=  (isset($course)) ? $course->id : null; ?>";
		courseId = "<?=  (isset($course_details)) ? $course_details->id : null; ?>";
		if(course_id == ""){
			review_course_id = courseId;
		}else{
			review_course_id = course_id;
		}
		
	   review= $("#review").val();
	   if(review == ''){
	        $.notify("Please write something in review section", "info");
	   }else{
	    $.ajax({
	        url: '<?= base_url('rest/api/save_review')?>',
	        type: 'POST',
	        data: {course_id: review_course_id, rating: stars, review: review},
	        success:function(response){
	        	
	        	res = JSON.parse(response);
	             if(res.success == 1){
	             	if(res.message == 'update'){
	             		$.notify("Successfully update your review", "success");
	             		$('#ReviewPreviewModal').modal('hide');
	             	}else{
	             		$.notify("Successfully save your review", "success");
	             		$('#ReviewPreviewModal').modal('hide');
	             	}
	                
	               
	             }else{
	                $.notify("Something went wrong! you have already given a review ", "error");
	                $('#ReviewPreviewModal').modal('hide');
	             }
	        }
	    })
	    .done(function() {
	        // console.log("success");
	    })
	    .fail(function() {
	        // console.log("error");
	    })
	    .always(function() {
	        // console.log("complete");
	    });
	   }
	  
	});

	/*Review section js end*/
</script>
</body>
</html>
