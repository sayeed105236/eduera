<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<div class="modal fade existing_user_add_modal" id="existing_user_add_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title user-title" >Add Existing User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left  " action="<?= base_url('corporate/'.$company_id.'/users') ?>" method="post">
                <div class="modal-body">

                    <input type="hidden" name="id" id="user-id">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Select User: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-10 col-xs-12 col-lg-12 existing_user" name="user_id">
                                <?php foreach($existing_user_list as $users){?>
                                    <option value="<?= $users->id?>">Name: <?=  $users->first_name?> <?= $users->last_name ?> <br/>
                                         Email:   <?=  $users->email?></option>
                                <?php } ?>    
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">User Role: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-10 col-xs-12 col-lg-12" name="corporate_role">

                                <option value="ADMIN">ADMIN</option>
                                <option value="USER">USER</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Select Department: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-10 col-xs-12 col-lg-12" name="department_id">
                                <?php foreach($department_list as $depart){?>
                                    <option value="<?= $depart->id?>"><?= $depart->name?></option>
                                <?php } ?>   
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Select Designation: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-10 col-xs-12 col-lg-12" name="designation_id">
                                <?php foreach($designation_list as $desig){?>
                                    <option value="<?= $desig->id?>"><?= $desig->name?></option>
                                <?php } ?>
                            </select>    
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
    $('select:not(.normal)').each(function () {
        $('.existing_user').select2({
            dropdownParent: $(this).parent()
        });
    });
</script>
<!-- New user modal -->

<div class="modal fade new_user_add_modal" id="existing_user_add_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title user-title" >Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left  " action="<?= base_url('corporate/'.$company_id.'/users') ?>" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">First Name: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="first_name" class="form-control col-md-7 col-xs-12"  data-validate-words="2" name="first_name" type="text" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Last Name: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="last_name" class="form-control col-md-7 col-xs-12"  data-validate-words="2" name="last_name" type="text" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Phone: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="phone" class="form-control col-md-7 col-xs-12"  data-validate-words="2" name="phone" type="text" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Email: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="email" class="form-control col-md-7 col-xs-12"  data-validate-words="2" name="email" type="email" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Biography: <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea class="resizable_textarea form-control" name="biography" placeholder="Write your biography.."></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">User Role: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-10 col-xs-12 col-lg-12" name="corporate_role">

                                <option value="ADMIN">ADMIN</option>
                                <option value="USER">USER</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Select Department: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-10 col-xs-12 col-lg-12" name="department_id">
                                <?php foreach($department_list as $depart){?>
                                    <option value="<?= $depart->id?>"><?= $depart->name?></option>
                                <?php } ?>   
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 " for="title">Select Designation: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control col-md-10 col-xs-12 col-lg-12" name="designation_id">
                                <?php foreach($designation_list as $desig){?>
                                    <option value="<?= $desig->id?>"><?= $desig->name?></option>
                                <?php } ?>
                            </select>    
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
    
