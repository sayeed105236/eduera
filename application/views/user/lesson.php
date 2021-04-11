<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/user-lesson-view.css')?>" />

<?php 
	if($course_review == null)
	{
		$col = 4;
		$main_col = 8;
	}else{
		$col = 4; 
		$main_col = 8;
	}
?>

<?php $this->load->view('component/rating_modal'); ?>
<div class="container-fluid course_container">
	<div class="row">
	    <div class="col-lg-<?=$main_col?> course_header_col">
	        <h5 class="resp-start-lesson-h5">
	            <img src="<?php echo base_url().'uploads/system/eduera-logo-small.png';?>" height="25"> |
	            <?php echo $course_details->title; ?>
	        </h5>
	    </div>
	    <?php 

	    // if(!$course_details->mock_test){
	    	?>
	    <div style="padding-left: 4px;padding-right: 4px;" class="col-lg-<?=$col?> course_header_col d-flex">

	        <?php if($course_review == null){ 
	        	$col = 4;

	        ?>
			
			<?php
	            }
	            if(isset($total_percentage)){
				if ($total_percentage > 90) {
					if ($course_details->certificate) {
						$image_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/certificate/';
			?>
			
				<a style="margin-left: auto !important;" target="_blank" href="<?=base_url('user/load_certificate/' . $course_details->id. '/'. $user_data->id)?>"   id="get_certificate" class="get_certificate_button ml-auto"  > <i style="margin-right: 4px;" class="fas fa-trophy"></i>
				Get Certificate
				</a>
            <?php
        			}
	        	}
	        }
	        ?>


	        <a data-toggle="modal" data-target="#ReviewPreviewModal" class="rating_btn <?= isset($total_percentage) && $total_percentage > 90 ? '' : 'ml-auto '?>"  > <i  class="fas fa-star"></i>
	            Leave your rating
	        </a>

	        <a style="margin-left: 15px !important;" href="" class="course_btn  ml-auto resp-share" data-toggle="modal" data-target="#shareModal" onclick="shareSocial('<?=$course_details->slug?>')"> <i class="fas fa-share"></i> Share </a>

	        <div style="margin-left: 10px !important;" class="course_btn dropdown  ml-auto" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" > 
	        	<i class="fa fa-ellipsis-v "  ></i> 

	        	<ul class="dropdown-menu drop" aria-labelledby="dropdownMenu1" >

        		<?php if($wishes){?>
	        	  <li><a class="fav" onclick="add_to_wishlist(<?=$course_details->id?>)" href="#">Unfavourite this course</a></li>
	        	<?php }else{?>
	        		<li><a class="fav" onclick="add_to_wishlist(<?=$course_details->id?>)" href="#">Favourite this course</a></li>
	        	
        		<?php }?>
	        	   <?php if($course_review != null){?>
	        	   <li id="editRating"><a   onclick="rating()">Edit yout rating</a></li>
	        	<?php }?>

	        	<li><a style="margin-left: 0 !important;padding-left: 0 !important;margin-right: 23px !important;" href="" class="course_btn  ml-auto resp-share-mobile"  onclick="shareSocial('<?=$course_details->slug?>')"> <i class="fas fa-share"></i> Share </a></li>

	        	</ul>

	        </div>

	    </div>
	<?php
	 // }
	?>
	</div>



    <div class="row" id = "lesson-container">
        <?php include 'course_content_body.php'; ?>
        <?php include 'course_content_sidebar.php'; ?>  
    </div>

    <?php
     if(!$course_details->mock_test){
    	?>
    <div class="row">
    	<!--Overveiew section   -->
        <?php 
        require 'overview_section.php'
        ?>
    </div>
<?php
	}
?>
</div>
<script type="text/javascript">
	$(".resp-share-mobile").on("click", function(){
		$("#shareModal").modal();
	})
	function rating(){
		
		$("#ReviewPreviewModal").modal("show");
		$(".review-section").show();
		 $.ajax({
	        url: '<?= base_url('rest/api/get_review/')?><?=$course_details->id?>',
	        type: 'GET',
	        dataType: 'json',
	        success:function(response){
	            
	            

	        	rating = response[0].rating;

	        	if(rating == 1){
	        		document.getElementsByClassName('star_icon_5')[0].style.fill = "#D12B66";
	        	}else if(rating == 2){
	        		document.getElementsByClassName('star_icon_5')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_4')[0].style.fill = "#D12B66";
	        	}else if(rating == 3){
	        		document.getElementsByClassName('star_icon_5')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_4')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_3')[0].style.fill = "#D12B66";
	        	}else if(rating == 4){
	        		document.getElementsByClassName('star_icon_5')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_4')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_3')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_2')[0].style.fill = "#D12B66";
	        	}else if(rating == 5){
	        		document.getElementsByClassName('star_icon_1')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_2')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_3')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_4')[0].style.fill = "#D12B66";
	        		document.getElementsByClassName('star_icon_5')[0].style.fill = "#D12B66";
	        	}
	             // $("#all_stars").append(html);

	             if(response[0].rating == 	1){
	               $("#rating-title").text('Terrible, not  expected at all');
	             }else if(response[0].rating == 2){
	               $("#rating-title").text('Ordinary, very disappointed');
	             }else if(response[0].rating == 3){
	               $("#rating-title").text('Average, could be better');
	             }else if(response[0].rating == 4){
	               $("#rating-title").text('Good, what I Expected');
	             }else if(response[0].rating == 5){
	               $("#rating-title").text('Stunning, beyond expectation');
	             }

	             $("#review").val(response[0].review);

	        }
	    })
	}
	function add_to_wishlist(course_id){

	    $.ajax({
	        url : "<?php echo base_url('/user/add_to_wishlist'); ?>",
	        type : "POST",
	        data: { course_id : course_id },
	        success : function(data) {
	            var json = JSON.parse(data);
	            if(json.action == 'Added'){
	                $(".fav").text('Unfavourite this course');
	                $("#wishlist_count").text(json.count);
	            }else{
	                $(".fav").text('Favourite this course');
	                $("#wishlist_count").text(json.count);
	            }
	        },
	        error : function(data) {
	        // do something
	        }
	    });
	}
</script>