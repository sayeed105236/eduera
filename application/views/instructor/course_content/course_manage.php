
<style>
	 /* Fixed sidenav, full height */
	.sidenav {
	  height: 100%;
	  width: 200px;
	  /*position: fixed;*/
	  z-index: 1;
	  /*top: 0;
	  left: 0;*/
	  /*background-color: #111;*/
	  overflow-x: hidden;
	  padding-top: 20px;
	}

	/* Style the sidenav links and the dropdown button */
	.sidenav a, .dropdown-btn {
	  padding: 6px 8px 6px 16px;
	  text-decoration: none;
	  font-size: 18px;
	  /*color: #818181;*/
	  display: block;
	  border: none;
	  background: none;
	  width:100%;
	  text-align: left;
	  cursor: pointer;
	  outline: none;
	}

	/* On mouse-over */
	/*.sidenav a:hover, .dropdown-btn:hover {
	  color: #0f7c90;
	}*/

	/* Main content */
	.main {
	  margin-left: 200px; /* Same as the width of the sidenav */
	  font-size: 20px; /* Increased text to enable scrolling */
	  padding: 0px 10px;
	}

	/* Add an active class to the active dropdown button */
	.active {
	  background-color: #000000;
	}
	.active a:hover {
		color: white;
	}

	/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
	.dropdown-container {
	  display: none;
	  background-color: #262626;
	  padding-left: 8px;
	}

	/* Optional: Style the caret down icon */
	.fa-caret-down {
	  float: right;
	  padding-right: 8px;
	} 
	.sidebar .active{
		color: #000000;
	}
	
	@media (min-width: 320px) and (max-width: 767px){
		.resp-side-nav{
			width: 100%;
		}
	}
	@media (min-width: 768px) and (max-width: 799px){
		.resp-ins-cont{
			padding-left: 90px;
		}
	}
	@media (min-width: 800px) and (max-width: 990px){
		.resp-ins-cont{
			padding-left: 100px;
		}
	}
	@media (min-width: 991px){
		.resp-ins-cont{
			padding-left: 40px;
		}
	}
</style>

<div class="row">
	<div class="col-md-8 mx-auto resp-ins-cont" style="margin-bottom: 10px;">
		<h3><?= $course_detail->title?></h3>
	</div>
</div>
<div class="row" style="margin-bottom: 20px;">
	<div class="col-md-2">
		 <div class="sidenav resp-side-nav">
		 	<ul>
		 		<h5>Course Content</h5>
		 		<!-- <li><a href="">Overview</a></li> -->
		 		<li <?php if($sub_page_view == 'q&a'){ echo 'class="active"'; }?>><a  href="<?= base_url('instructor/course/'.$course_id.'/question_and_answer')?>">Q&A</a></li>
		 		<!-- <li><a href="#about">Notes</a></li> -->
		 		<li <?php if($sub_page_view == 'announcement'){ echo 'class="active"'; }?>><a href="<?= base_url('instructor/course/'.$course_id.'/announcement')?>">Anouncements</a></li>

		 		<li <?php if($sub_page_view == 'enrollment_users' || isset($_GET['user_info'])){ echo 'class="active"'; }?>><a href="<?= base_url('instructor/course/'.$course_id.'/users')?>">Users</a></li>

		 		<li <?php if($sub_page_view == 'questions' ){ echo 'class="active"'; }?>><a href="<?= base_url('instructor/course/'.$course_id.'/questions')?>">Questions</a></li>

		 		<li <?php if($sub_page_view == 'quiz_set' || $sub_page_view == 'add_question' || $sub_page_view == 'show_question'){ echo 'class="active"'; }?>><a href="<?= base_url('instructor/course/'.$course_id.'/quiz_set?option=course')?>">Quiz</a></li>


		 		<?php 
		 		if($course_detail->mock_test){?>
		 		<li <?php if($sub_page_view == 'exam'){ echo 'class="active"'; }?>><a href="<?= base_url('instructor/course/'.$course_id.'/exam')?>">Exam</a></li>
		 	<?php }?>

		 	<li <?php if($sub_page_view == 'reviews' ){ echo 'class="active"'; }?>><a href="<?= base_url('instructor/course/'.$course_id.'/reviews')?>">Review</a></li>
		 	</ul>
		
		</div> 
	</div>
	<div class="col-md-10 resp-ins-cont">
		<?php include $sub_page_view . '.php';?>
	</div>
</div>
