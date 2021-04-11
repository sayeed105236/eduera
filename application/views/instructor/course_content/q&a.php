<style>
    .q_and_a_list{
        border-bottom: 1px solid;
        padding-bottom: 10px; 
        margin-bottom: 10px;
    }
</style>
<div class="card">
    <div class="card-header">
        <h4>Q&A</h4>
    </div>
    <div class="card-body">
        <?php if ($this->session->flashdata('replay_message_success')) { ?>

            <div class="alert alert-success alert-dismissible  show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('replay_message_success') ?>
            </div>

        <?php } ?>

        <?php if ($this->session->flashdata('replay_message_failed')) { ?>

            <div class="alert alert-danger alert-dismissible  show" role="alert">
                <strong></strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?= $this->session->flashdata('replay_message_failed') ?>
            </div>

        <?php } ?>
        <?php if(count($question_and_ans_list) > 0){?>
           <div class="row q_and_a_list">

                   <div class="col-md-2">
                       <h5>Title</h5>
                   </div>
                   <div class="col-md-4">
                       <span>Details</span> 

                   </div>
                   <div class="col-md-2">
                       <span>User Name</span>
                   </div>
                   <div class="col-md-2">
                       <span>Time</span>
                   </div>
                   <div class="col-md-2">
                       <span>Action</span>
                   </div>
                  
                  
           </div>
            <?php foreach($question_and_ans_list as $ans){
            ?>
               
            <div class="row q_and_a_list">

                    <div class="col-md-2">
                        <h5><?= $ans->title?></h5>
                    </div>
                    <div class="col-md-4">
                        <span><?= $ans->description?></span> 

                    </div>
                    <div class="col-md-2">
                        <span><?= $ans->first_name?> <?= $ans->last_name?></span>
                    </div>
                    <div class="col-md-2">
                        <span><?= time_elapsed_string($ans->created_at)?></span>
                    </div>
                    <div class="col-md-1">
                        <a type="button" onclick="replay('<?= $ans->id;?>')" class="btn btn-primary" data-toggle="modal" data-target="#replayModal" >Replay</a>
                    </div>
                   
            </div>
            <br>
        <?php 
            
                }
            }else{
                echo "Not found any Q&A.";
            }
         ?>
      
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="replayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Replay</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearData()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">

             <div class="col-md-4">

                 <h5>Title:</h5>
             </div>
             <div class="col-md-8">
                 <span id="title"></span> 

             </div>

        </div>
         <br>
         <div class="row q_and_a_list">

                 <div class="col-md-4">

                     <h5>Details:</h5>
                 </div>
                 <div class="col-md-8">
                     <span id="description"></span> 

                 </div>

         </div>

         <br>
         <div class="row">
              <div class="col-md-12">
                  <form action="<?= base_url('instructor/replay_message/')?>" method="post"> 
                      <div class="row">
                          <div class="col-md-4">
                              <h6 class="for">Replay: </h6>
                          </div>
                          <input type="hidden" name="question_ans_id" id="question_ans_id">
                          <input type="hidden" name="course_id" value="<?= $course_id?>">
                          <div class="col-md-8">
                              <textarea rows="6" name="replay_message" class="form-control" placeholder="Type your answer" required=""></textarea> 
                          </div>
                          
                      </div>
                      <br>
                      <div class="row">
                          <div class="col-md-4">
                              
                          </div>
                          <div class="col-md-8">
                              <button class="btn btn-info" type="submit">Send</button>
                          </div>
                          
                      </div>
                  </form>
                
              </div>
         </div>

         <br>
         <div class="row">
            <div class="col-md-4">
                <h5>Replay Messages: </h5>
            </div>
             <div class="replay_list">
                
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
    function replay(id){
        var html = '';
        $.ajax({
            url: '<?= base_url('rest/api/get_specific_question/')?>'+id,
            dataType: 'json',
            type: 'GET',
            success: function(response){
                $("#question_ans_id").val(response['question_and_ans'][0].id);
                $("#title").text(response['question_and_ans'][0].title);
                $("#description").text(response['question_and_ans'][0].description);

                $.ajax({
                    url: '<?= base_url('rest/api/get_replay_list/')?>'+response['question_and_ans'][0].id,
                    dataType: 'json',
                    type: 'GET',
                    success: function(data){
                        html += '<ul>';
                        j = 0;
                        for(var i = 0; i < data.length; i++){
                            j++;
                            html += '<li>'+j+'. '+ data[i].replay_message+'</li>';
                        }

                        html += '</ul>';

                        $(".replay_list").append(html);
                    }
                })

            }
        });
    }

    function clearData(){
        console.log('close');

        jQuery('.replay_list').html('');


    }
</script>
