<?php include 'my_board_menu.php'; ?>
<?php // debug($category_list); ?>

<style type="text/css">
    .btn{
        padding: 8px 12px;
    }
</style>
<section class="my-courses-area">
    <div class="container">
        <div class="row align-items-baseline">
            <div class="col-lg-6 resp-myCouFilt">

                <?php if($page_name == 'my_courses'){ ?>
                <div class="my-course-filter-bar filter-box">
                    <span>Filter by</span>
                    <div class="btn-group">
                        <a class="btn btn-outline-secondary dropdown-toggle all-btn resp-cat" href="#" data-toggle="dropdown">Category</a>

                        <div class="dropdown-menu" style="padding: 0px;">
                        	<?php foreach ($category_list as $category) { ?>
                        		<a class="dropdown-item resp-cat" href="<?= base_url('user/'.$page_name.'?category=' . $category->id) ?>"><?= $category->name ?></a>
                        	<?php } ?>                            
                        </div>
                    </div>
                    <?php if(isset($_GET['category'])) { ?>
                    <div class="btn-group">
                        <a class="btn btn-outline-secondary dropdown-toggle all-btn resp-cat" href="#" data-toggle="dropdown">Sub-category</a>
                        <div class="dropdown-menu" style="padding: 0px;">
                        	<?php 
                        		foreach ($category_list as $category) { 
                        			if ($category->id == $_GET['category']) {
                        				foreach ($category->sub_category_list as $sub_category) { ?>
                        					<a class="dropdown-item" href="<?= base_url('user/'.$page_name.'?category='.$category->id.'&sub_category=' . $sub_category->id) ?>"><?= $sub_category->name ?></a>
                        				<?php 
                        				}
                        			}
                        		} 
                        	?>                            
                        </div>
                    </div>
                	<?php } ?>


                    <div class="btn-group">
                        <a href="<?php echo site_url('user/'. $page_name); ?>" class="btn reset-btn" disabled>Reset</a>
                    </div>
                </div>
                <div class="my-courses-filter-tag-area">
                	<?php foreach ($filter_list as $key => $value) {
                		if ($value != null){
                			?>
                				<span class="my-courses-filter-tag badge badge-secondary">
			                		<?= $value['chip_text'] ?>
								    <i class="close fa fa-times" onclick="removeFilter(<?= $key ?>)"></i>
								</span>
                			<?php
                		}
                	} ?>
                	
                </div>
            <?php } ?>
                <?php if ($this->session->flashdata('enrollment_successful')) { ?>

                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong></strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('enrollment_successful') ?>
                </div>

                <?php } ?>
            </div>
            <?php if($page_name == 'my_courses'){ ?>
            <div class="col-lg-6 resp-myCouFilt">
                <div class="my-course-search-bar">
                    <form method="get" id="question-form" id="course-form">
                        <div class="input-group resp-search">
                            <input type="text" class="form-control" name="course"  id="my_board_my_courses_search_field" placeholder="Search my courses">
                            <div class="input-group-append">
                                <button class="btn search-btn-resize" type="submit" onclick="searchText()"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>    
                </div>
            </div>
        <?php }?>
        </div>
        <div class="row no-gutters " id = "my_courses_area" style="padding: 10px;">
            <?php include $sub_page_name. '.php'; ?>            
        </div>
        <nav>
            <?php //if (count($course_list) > $page_limit){
                echo $this->pagination->create_links();
            //}?>
        </nav>
    </div>
</section>

<script type="text/javascript">
	var filter_tag_list = JSON.parse('<?= json_encode($filter_list) ?>');

	function redirectWithNewFilterList(){
		var url = "<?php echo site_url('user/'. $page_name); ?>?" 
		for (var i = 0; i < filter_tag_list.length; i++){
			url += filter_tag_list[i].type + '=' + filter_tag_list[i].parameter;
		}
		window.location.replace(url);
	}

	function removeFilter(filter_index){
		filter_tag_list.splice(filter_index, 1);
		redirectWithNewFilterList();
	}

    function searchText(){
        $("#course-form").submit();
    }
	
</script>