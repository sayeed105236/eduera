
<style type="text/css">
  
	.card-body span{
	    font-size: 12px;
	    color: #7E7E7E;
	}
    
    .card-body .manage{
        /*visibility:  hidden;*/
        color: #0f7c90;
        font-weight: bold;


    }
    .hover-link {
        position: absolute;
        z-index: 100;
        text-align: center;
        left: 50%;
        top: 50%;
        font-size: 2rem;
        color: #0f7c90;
        /*transition: .5s ease;*/
          opacity: 0;
          transform: translate(-50%, -50%);
           -ms-transform: translate(-50%, -50%);
    }
    .card-body:hover {
        opacity: 0.8;
        background: white;
    }

    .card-body:hover .hover-link{
        /*visibility: visible;*/
        text-align: center;
        opacity: 1

    }
</style>

<div class=" tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
    <div class="tab-content">                           
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        	<?php foreach($instructor_courses as $course){?>
            <div class="card">
           
            <div class="card-body">
                <div class="row hover-link">
                    <div class="col-md-12">
                        <a href="<?= base_url('instructor/course/'.$course->id)?>" id="manage" class="manage">Manage</a>
                    </div>
                </div>
                
                    
            	<div class="row course-info-section">

            		<div class="col-md-2">
            			<img width="120" height="80" src="<?=$this->course_model->get_course_thumbnail_url($course->id)?>">
            		</div>
                    
                		<div class="col-md-4">
                			<h5 class="resp-card"><?= $course->title?></h5>
                		</div>
                		<div class="col-md-2">
                            <?php if ($course->discount_flag == 1 && $course->discounted_price == 0): ?>
                                <h6 class="current-price">Free</h6>
                                <?php else: ?>
                                    <?php if ($course->discount_flag == 1): ?>
                                        <h6 class="current-price"><?=currency($course->discounted_price)?></h6>
                                        <span class="original-price"><del><?=currency($course->price)?></del></span>
                                        <?php else: ?>
                                            <h6 class="current-price"><?=currency($course->price)?></h6>
                                        <?php endif;?>
                                    <?php endif;?>
                                    <br>
                                    <span> Price</span> 

                		</div>
                		<div class="col-md-2">
                			<h6><?= $course->enrollment_count?></h6>
                            <span>Total Enrollment</span>
                		</div>
                		<div class="col-md-2">
                			<h6><?= $course->instructor_share?> %</h6>
                            <span>Your Profit</span>
                		</div>
                       
            	</div>
            </div>
        </div>
        <br>
    <?php } ?>
        </div>
    
     </div>
</div>

