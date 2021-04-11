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
        <h4>Quiz Result</h4>
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
                        <?php foreach($user_assessment_all as $assessment){?>
                            <option value="<?= $assessment->id ?>" <?php if (isset($_GET['quiz'])) {echo $assessment->id == $_GET['quiz'] ? 'selected' : '';}?>><?= $assessment->name?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="col-md-2 ">
                 <button class="btn btn-info form-control" onclick="show_assessment()">Show</button>
            </div>

        </div>
        
        <br>
       <?php if (isset($user_assessment)) {

            $end_assesment = end($user_assessment);
            if($end_assesment){ ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Number of total question</th>
                            <th>Number of attempted question</th>
                            <th>Number of right answer</th>
                            <th>Success rate</th>
                        <tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $end_assesment->assessment_data['no_of_total_question']?></td>
                            <td><?= $end_assesment->assessment_data['attempted'] ?></td>
                            <td><?= $end_assesment->assessment_data['no_of_right_answer'] ?></td>
                            <td><?= $end_assesment->assessment_data['success_rate'] ?>%</td>
                          
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
      <?php }}?>
    </div>
</div>






<script type="text/javascript">
  
   function show_assessment(){
   
    var url_string = window.location.href; //window.location.href
    var url = new URL(url_string);
    var quiz = url.searchParams.get("quiz");
    var stickUrl = null;
    if(quiz != null){
        stickUrl = removeParam("quiz", url_string);
    }
   
    var set_id = $('select[name="quiz_name"]').val();
    var path_parameter = '';
    if (set_id != '-1' && !isNaN(set_id)){
       path_parameter += '&quiz=' + set_id;
    }
               
    if(quiz == '' || quiz == null){
        window.location = url_string + path_parameter;
    }else{
        window.location = stickUrl + path_parameter;
    }
           
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
