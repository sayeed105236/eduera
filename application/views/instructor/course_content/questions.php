
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> 
<style>
    .q_and_a_list{
        border-bottom: 1px solid;
        padding-bottom: 10px; 
        margin-bottom: 10px;
    }

    .container {
      /*width: 1180px;*/
      margin-top: 3em;
    }
    #accordion .panel {
      border-radius: 0;
      border: 0;
      margin-top: 0px;
    }
    #accordion a {
      display: block;
      padding: 10px 15px;
      border-bottom: 1px solid #b42b2b;
      text-decoration: none;
    }
    #accordion .panel-heading a.collapsed:hover,
    #accordion .panel-heading a.collapsed:focus {
      background-color: #b42b2b;
      color: white;
      transition: all 0.2s ease-in;
    }
    #accordion .panel-heading a.collapsed:hover::before,
    #accordion .panel-heading a.collapsed:focus::before {
      color: white;
    }
    #accordion .panel-heading {
      padding: 0;
      border-radius: 0px;
      text-align: center;
    }
    #accordion .panel-heading a:not(.collapsed) {
      color: #343a40;
      background-color: white;
      transition: all 0.2s ease-in;
    }

    /* Add Indicator fontawesome icon to the left */
    #accordion .panel-heading .accordion-toggle::before {
      font-family: 'FontAwesome';
      content: '\f00d';
      float: left;
      color: #343a40;
      font-weight: lighter;
      transform: rotate(0deg);
      transition: all 0.2s ease-in;
    }
    #accordion .panel-heading .accordion-toggle.collapsed::before {
      color: #444;
      transform: rotate(-135deg);
      transition: all 0.2s ease-in;
    }

</style>

<?php $aToZ = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']; ?>
<div class="card">
    <div class="card-header">
        <div class="float-left">
        <h4>Questions</h4>
        </div>
        <div class="float-right">
        <!-- <h4 class="btn btn-info" data-toggle="modal" data-target="#addModal" >Add</h4> -->

        </div>
    </div>
    <div class="card-body">
        <?php if(count($question_list) > 0){?>
         <h5>Total <?= count($question_list) ?> questions</h5>
        
        <div class="row">
            <div class="col-md-1">
               <form method="GET" id="pagination_form">
                   <div class="form-group">
                       <select class="form-control" name="pagination" id="pagination" style="padding: 0 !important; padding-right: 50px !important;">
                           <option value="10" <?= isset($_GET['pagination']) && $_GET['pagination'] == 10 ?   'selected' : '' ?>>10</option>
                           <option value="25" <?= isset($_GET['pagination']) && $_GET['pagination'] == 25 ?   'selected' : '' ?>>25</option>
                           <option value="50" <?= isset($_GET['pagination']) && $_GET['pagination'] == 50 ?   'selected' : '' ?>>50</option>
                           <option value="100" <?= isset($_GET['pagination']) && $_GET['pagination'] == 100 ?  'selected' : '' ?>>100</option>
                       </select> 
                   </div>
                </form>  
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
               

                <?php
                    foreach ($question_list as $index => $question) {
                ?>

                   <div class="container">
                     <div id="accordion" class="panel-group">
                       <div class="panel">
                         <div class="panel-heading">
                         <h4 class="panel-title">
                           <a href="#panelBody<?=$question->id?>" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><?= $index + 1 ?>. <?= $question->question?></a>
                           </h4>
                         </div>
                         <div id="panelBody<?=$question->id?>" class="panel-collapse collapse in">
                         <div class="panel-body">
                             <?php if ($question->option_list !== null && count($question->option_list) > 0) { ?>
                                 <table class="table table-bordered">
                                     <thead>
                                         <tr>
                                             <th>#</th>
                                             <th>Option</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php foreach ($question->option_list as $option_index => $option) { ?>
                                             <tr <?= $question->right_option_value == $option_index ? 'style="background-color: #cbeccb"' : ''?>>
                                                 <th scope="row"><?= $aToZ[$option_index] ?></th>
                                                 <td><?= $option ?></td>
                                             </tr>
                                         <?php }?>
                                     </tbody>
                                 </table>
                             <?php } else {?>
                                 <div style="text-align: center;">
                                     <p>No Option</p>
                                 </div>
                             <?php }?>

                             <p>Explanation: 
                             <?php if($question->explanation != ''){?>
                                 <?= $question->explanation?></p>
                             <?php }else{?>    
                                 No Explanation
                              <?php } ?> 
                           </div>
                         </div>
                       </div>
                       
                       
                     </div>
                   </div>

                <?php }?>
                <div class="footer">
                    <nav>
                        <?php
    echo $this->pagination->create_links();
    ?>
                    </nav>
                    <!-- Showing 1 to 10 of 57 entries -->
                    <div class="right" style="float:left">
                        <p>Showing <?php echo $offset + 1; ?> to <?php echo $offset + count($question_list); ?> of <?php echo $number_of_total_question ?> entries</p>
                    </div>
                </div>
            </div>
          </div>
      <?php }else{
            echo "Not found any questions.";
      }?>
     </div>
   </div>  
<script type="text/javascript">
    
    $("#pagination").on('change',function(event) {
        event.preventDefault();

        $("#pagination_form").submit();
        /* Act on the event */
    });
</script>
