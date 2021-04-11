<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<div class="modal fade department_add_modal" id="department_add_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title department-title" >Add Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

           
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left  " action="<?= base_url('corporate/'.$company_id.'/department') ?>" method="post">
                    <div class="modal-body">
                  
                        <input type="hidden" name="id" id="department-id">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Department: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="title" name="name" required="required" class="form-control col-md-10 col-xs-12 col-lg-12 " >
                            </div>
                        </div>
                      
                    
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>


        </div>
    </div>
</div>

<script type="text/javascript">
    function Editdepartment(id){
        $(".department-title").text('Edit Department');

        $.ajax({
            type: "GET",
            url: "<?php echo site_url('corporate/get_single_department_info'); ?>",
            data: {id: id},
            success: function(response){

                var json = JSON.parse(response);
                console.log(json);
                $("#title").val(json[0]['name']);
                $("#department-id").val(json[0]['id']);
                

            },
            error: function (request, status, error) {
                console.log(request.responseText);
            }
        });
    }

    $(".add-department").click(function(){
        $(".department-title").text('Add Department').show();
        $("#title").val('');
        $("#department-id").val('');

       

    })
</script>