<style>
    .q_and_a_list{
        border-bottom: 1px solid;
        padding-bottom: 10px; 
        margin-bottom: 10px;
    }
    .resp-rev-tab{
      overflow-x: auto;
      display: block;
    }
</style>
<div class="card">
    <div class="card-header">
        <div class="float-left">
        <h4>Course Reviews</h4>
        </div>
        
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('reviews_success')) { ?>

            <div class="alert alert-success alert-dismissible  show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('reviews_success') ?>
            </div>

        <?php } ?>

        <?php if ($this->session->flashdata('reviews_failed')) { ?>

            <div class="alert alert-danger alert-dismissible  show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('reviews_failed') ?>
            </div>

        <?php } ?>
            <?php if(count($course_review_list) > 0){?>
               <table id="datatable" class="table table-striped table-bordered resp-rev-tab">
                            
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>rating</th>
                        <th>Review</th>
                        <th>Status</th>
                   
                      </tr>
                    </thead>


                    <tbody>

                      <?php foreach ($course_review_list as $index => $review) { ?>
                        
                      <tr>
                        <td width="20%"><?= $review->first_name ?> <?= $review->last_name?></td>
                        <td width="20%"><?= $review->email ?></td>
                        <td width="10%">
                            <?php for($i = 1; $i < 6; $i++):?>
                                <?php if ($i <= $review->rating): ?>
                                   <i class="fa fa-star filled" style="color: #f5c85b;"></i>
                                <?php else: ?>
                                   <i class="fa fa-star" style="color: #abb0bb;"></i>
                                <?php endif; ?>
                          <?php endfor; ?>
            

                          </td>
                        <td width="40%"><?= $review->review ?></td>
                        <td width="10%">
                          <?php
                          if($review->status == 0){
                          ?>
                             <span onclick="active_review(<?=$review->id?>, 0, '<?= $review->course_id?>')" class="alert alert-danger">Inactive</span>
                            <?php

                          }else{
                            ?>
                             <span onclick="active_review(<?=$review->id?>, 1, '<?= $review->course_id?>')" class="alert alert-success">Active</span>
                          <?php }?>
                          
                          </td>
                        
                      </tr> 
                      <?php } ?>          
                    </tbody>
                    
                </table>
            <?php }else{
                echo "Not found any review yet.";
            }?>
    </div>
</div>






<script type="text/javascript">
    function edit_announcement(id){
        var html = '';
        $.ajax({
            url: '<?= base_url('rest/api/get_announcement_data/')?>'+id,
            dataType: 'json',
            type: 'GET',
            success: function(response){
              console.log(response[0].title);
                $("input[name='title']").val(response[0].title);
                $("textarea[name='description']").val(response[0].description);
                $("input[name='announcement_id']").val(response[0].id);
                // $("#question_ans_id").val(response['question_and_ans'][0].id);
                // $("#title").text(response['question_and_ans'][0].title);
                // $("#description").text(response['question_and_ans'][0].description);

               

            }
        });
    }

    function clearData(){
        console.log('close');

        jQuery('.replay_list').html('');


    }
</script>
