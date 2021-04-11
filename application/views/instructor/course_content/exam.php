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
        <h4>Exam</h4>
        </div>
        <div class="float-right">
        <!-- <h4 class="btn btn-info" data-toggle="modal" data-target="#addModal" >Add</h4> -->
        </div>
    </div>
    <div class="card-body">
        
       
        <div class="row">
            <div class="col-md-6 mx-auto col-md-offset-3">
                <div class="form-group">
                    <select name="quiz_name" class="form-control">
                        <option>Select test name</option>
                        <?php foreach($quiz_set_list as $quiz){?>
                            <option value="<?= $quiz->id ?>" <?php if (isset($_GET['quiz'])) {echo $quiz->id == $_GET['quiz'] ? 'selected' : '';}?>><?= $quiz->name?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 ">
                 <button class="btn btn-info form-control" onclick="show_assessment()">Show</button>
            </div>

        </div>

        
        <?php
        // $out = array();
        // $item = array();
        // foreach($user_assessment as $el){
        //    $key = serialize($el->enrollment_id);
        //    if (!isset($out[$key]))
        //        $out[$key]=1;
        //    else
        //        $out[$key]++;
        // }
        // // debug($out);
        // arsort($out);

        // foreach($out as $el=>$count){
        //    $items = unserialize($el);
          
        //    array_push($item, $items);
        // }
        // debug($item);
        ?>

      
       <br>
      <?php if (isset($user_assessment)) {

           $end_assesment = ($user_assessment);
           // debug($end_assesment)
           // if($end_assesment){
            ?>

       <div class="row">
        <div class="col-md-6 mx-auto">
            <div>
                
                <div class="form-group" style="display: inline-block; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc" id="reportrange">
                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                    <span>January 01, 2020 - January 31, 2020</span> <b class="caret"></b>
                </div>
            </div> 
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-info" onclick="filter()">Filter</button>
        </div>
           <div class="col-md-12">
               <table id="examtable" class="table table-striped table-bordered" style="width:100%">
                   <thead>
                       <tr>
                           <th>Date </th>
                           <th>Name</th>
                           <th>Number of total question</th>
                           <th>Number of attempted question</th>
                           <th>Number of right answer</th>
                           <th>Success rate</th>
                       <tr>
                   </thead>
                   <tbody>
                    <?php 
                  
                    foreach($end_assesment as $assessment){
                      
                        ?>
                       <tr>
                        <td><?= $assessment->created_at?></td>
                        <td><?= $assessment->first_name?> <?= $assessment->last_name?></td>
                           <td><?= $assessment->assessment_data['no_of_total_question']?></td>
                           <td><?= $assessment->assessment_data['attempted'] ?></td>
                           <td><?= $assessment->assessment_data['no_of_right_answer'] ?></td>
                           <td><?= $assessment->assessment_data['success_rate'] ?>%</td>
                         
                       </tr> 
                   <?php } ?>
                   </tbody>
               </table>
                        <div class="footer">
                            <nav style="float:right">
                                <?php
               echo $this->pagination->create_links();
               ?>
                            </nav>
                            <!-- Showing 1 to 10 of 57 entries -->
                            <div class="right" style="float:left">
                                <p>Showing <?php echo $offset + 1; ?> to <?php echo $offset + count($end_assesment); ?> of <?php echo $number_of_total_quiz_result_data ?> entries</p>
                            </div>
                        </div>
           </div>
       </div>
     
     <?php }
 // }
 ?>
      
    </div>
</div>



<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> -->


<script type="text/javascript">
   eduera_picker = null;
    url_string = window.location.href;
   function show_assessment(){
     //'abcde'

      //window.location.href
    var url = new URL(url_string);
    var quiz = url.searchParams.get("quiz");
    var per_page = url.searchParams.get("per_page");
    var start_date = url.searchParams.get("start_date");
    var end_date = url.searchParams.get("end_date");
    // var enrollment = url.searchParams.get("enrollment");
    var stickUrl = null;
   
   
    var set_id = $('select[name="quiz_name"]').val();
    var path_parameter = '';
    if (set_id != '-1' && !isNaN(set_id)){
       path_parameter += '?quiz=' + set_id;
    }

    if(quiz != null){
         stickUrl = removeParam("quiz", url_string);
        
    }

    if(per_page != null &&  quiz != null){
         stickUrl = removeParam("per_page", url_string);
        stickUrl = removeParam("quiz", url_string);
    }


    if(stickUrl != null){
       stickUrl =  stickUrl.split('?')[0];
    }
      
    if(quiz == '' || quiz == null){
       window.location = url_string + path_parameter;
    }else{
         window.location = stickUrl + path_parameter;
    }
           
    }

      $(function() {

     start = moment().subtract(29, 'days');
     end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
           'All Time': 'all-time',
        }
    }, cb);

    $("#reportrange").on('apply.daterangepicker', function(cv, picker){
      eduera_picker = picker;
    })

    cb(start, end);

});



function filter(){
    var url = new URL(url_string);
    var startDate = url.searchParams.get("start_date");
    var endDate = url.searchParams.get("end_date");
    var path_parameter = '';
    stickUrl = null;
    if(startDate != null){
         stickUrl = removeParam("start_date", url_string);
    }

    if(endDate != null){
         stickUrl = removeParam("end_date", url_string);
    }

    start_date = eduera_picker.startDate.format('YYYY-M-D');
    end_date = eduera_picker.endDate.format('YYYY-M-D');

    if(start_date != null){
        path_parameter +='&start_date=' + start_date;
    }

    if(end_date != null){
        if (url_string.length > 0){
            path_parameter += "&";
        }
        path_parameter +='end_date=' + end_date;
    }
    window.location.replace(url_string + path_parameter);
}

function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}


</script>

