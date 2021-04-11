<style>
    .q_and_a_list{
        border-bottom: 1px solid;
        padding-bottom: 10px; 
        margin-bottom: 10px;
    }
    td a {
        color: blue
    }
</style>
<link rel="stylesheet" type="text/css" href="  https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

<div class="card">
    <div class="card-header">
        <div class="float-left">
        <h4>Enrolled Users</h4>
        </div>
        <div class="float-right">
        <!-- <h4 class="btn btn-info" data-toggle="modal" data-target="#addModal" >Add</h4> -->
        </div>
    </div>
    <div class="card-body">
     
        <?php if(count($enrolled_user_list) > 0){?>
        <table id="example" class="table table-striped table-bordered resp-ins-tab">
        <thead>
            <tr>
                <th>Name</th>
                <th>Course Access</th>
                <th>Admin Access</th>
                <th>Payment Status</th>
                <th>Amount</th>
                <th>Enrolled date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($enrolled_user_list as $user){?>
            <tr>
                <td>
                    <?php if($user->id != null){?>
                    <a title="User Info" 
                    <?php if($course_detail->mock_test){ ?>
                    href="<?= base_url('instructor/course/'.$user->course_id.'/users?user_info='.$user->id.'&enrollment='.$user->enrollment_id)?>" <?php }?>
                    >
                        <?= $user->first_name?> <?= $user->last_name?>
                            
                        </a>
                    <?php }?>
                    </td>
                <td> 
                 <?php if($user->id != null){?>
                <?= access_in_a_course($user->id, $user->course_id)['access_percentage']?>%
                <?php }else{
                    echo '0%';
                }
                ?>
                </td>
                <td> <?= $user->access?>%</td>
                <td>
                    <?php 
                    if($user->status == 'Accepted' || $user->status == 'ACCEPTED' || $user->status == 'accepted'){
                        echo 'Paid';
                    }else{
                        echo 'Non Paid';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if($user->amount > 0){
                        echo $user->amount;
                    }else{
                        echo 0;
                    } 
                    ?>
                </td>
                <td><?= $user->created_at ?></td>
                
            </tr>
           <?php }?>
         
         
         
          
    
        </tbody>
      
    </table>
        
        <?php }else{
            echo 'No enrolled user.';
        }?>
      
    </div>
</div>





<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src=" https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js "></script>

<script type="text/javascript">
   

    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
