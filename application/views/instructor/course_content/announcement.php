<style>
    .q_and_a_list{
        border-bottom: 1px solid;
        padding-bottom: 10px; 
        margin-bottom: 10px;
    }
</style>
<div class="card">
    <div class="card-header">
        <div class="float-left">
        <h4>Announcement</h4>
        </div>
        <div class="float-right">
        <h4 class="btn btn-info" data-toggle="modal" data-target="#addModal" >Add</h4>
        </div>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('announcement_success')) { ?>

            <div class="alert alert-success alert-dismissible  show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('announcement_success') ?>
            </div>

        <?php } ?>

        <?php if ($this->session->flashdata('announcement_failed')) { ?>

            <div class="alert alert-danger alert-dismissible  show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('announcement_failed') ?>
            </div>

        <?php } ?>
        <?php if(count($announcement_list) > 0){?>
           <div class="row q_and_a_list">

                   <div class="col-md-4">
                       <h5>Title</h5>
                   </div>
                   <div class="col-md-4">
                       <span>Details</span> 

                   </div>
                 
                   <div class="col-md-2">
                       <span>Time</span>
                   </div>
                   <div class="col-md-2">
                       <span>Action</span>
                   </div>
                  
                  
           </div>
            <?php foreach($announcement_list as $announcement){
            ?>
               
            <div class="row q_and_a_list">

                    <div class="col-md-4">
                        <h5><?= $announcement->title?></h5>
                    </div>
                    <div class="col-md-4">
                        <span><?= $announcement->description?></span> 

                    </div>
                   
                    <div class="col-md-2">
                        <span><?= time_elapsed_string($announcement->created_at)?></span>
                    </div>
                    <div class="col-md-2">
                        <a type="button" onclick="edit_announcement('<?= $announcement->id;?>')" class="" data-toggle="modal" data-target="#editModal" ><i class="fa fa-edit"></i>  </a> ||
                        <a type="button" href="<?= base_url('instructor/remove_announcement/'.$announcement->id) ?>" onclick="return confirm('Are you agree remove this?');" ><i class="fas fa-trash"></i>  </a> 
                    </div>
                   
            </div>
            <br>
        <?php 
            
                }
            }else{
                echo "Not found any announcement.";
            }
         ?>
      
    </div>
</div>


<!-- add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Announcement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearData()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       

         <br>
         <div class="row">
              <div class="col-md-12">
                  <form action="<?= base_url('instructor/insert_announcement/')?>" method="post"> 
                      <input type="hidden" name="question_ans_id" id="question_ans_id">
                        <input type="hidden" name="course_id" value="<?= $course_id?>">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="for">Title: </h6>
                        </div>
                     
                        <div class="col-md-8">
                            <input rows="6" name="title" class="form-control" placeholder="Write your title" required=""/>
                        </div>
                        
                    </div>
                     <br>
                      <div class="row">
                          <div class="col-md-4">
                              <h6 class="for">Description: </h6>
                          </div>
                          
                          <div class="col-md-8">
                              <textarea rows="6" name="description" class="form-control" placeholder="Description ...." required=""></textarea> 
                          </div>
                          
                      </div>
                      <br>
                      <div class="row">
                          <div class="col-md-4">
                              
                          </div>
                          <div class="col-md-8">
                              <button class="btn btn-info" type="submit">Save</button>
                          </div>
                          
                      </div>
                  </form>
                
              </div>
         </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="clearData()" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Announcement</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearData()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       

         <br>
         <div class="row">
              <div class="col-md-12">
                  <form action="<?= base_url('instructor/update_announcement/')?>" method="post"> 

                        <input type="hidden" name="course_id" value="<?= $course_id?>">
                        <input type="hidden" name="announcement_id" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="for">Title: </h6>
                        </div>
                     
                        <div class="col-md-8">
                            <input rows="6" name="title" class="form-control" placeholder="Write your title" required=""/>
                        </div>
                        
                    </div>
                     <br>
                      <div class="row">
                          <div class="col-md-4">
                              <h6 class="for">Description: </h6>
                          </div>
                          
                          <div class="col-md-8">
                              <textarea rows="6" name="description" class="form-control" placeholder="Description ...." required=""></textarea> 
                          </div>
                          
                      </div>
                      <br>
                      <div class="row">
                          <div class="col-md-4">
                              
                          </div>
                          <div class="col-md-8">
                              <button class="btn btn-info" type="submit">Update</button>
                          </div>
                          
                      </div>
                  </form>
                
              </div>
         </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="clearData()" data-dismiss="modal">Close</button>
      </div>
    </div>
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
