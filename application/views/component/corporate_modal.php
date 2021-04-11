<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<div class="modal fade corporate_add_modal" id="corporate_add_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog " >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title corporate-title" >Add Corporate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

           
                <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left  " action="<?= base_url('home/corporate') ?>" method="post">
                    <div class="modal-body">
                  
                    
                        <div class="form-group">
                            <label class="control-label col-md-6 col-sm-6 col-xs-12 " for="title">Company name <span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" id="title" name="name" required="required" class="form-control col-md-10 col-xs-12 col-lg-12 " placholder="Enter your company name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="address">Company Address <span class="required"></span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <textarea rows="3" id="address" name="address" class="form-control col-md-12 col-xs-12" placholder="Enter your company address"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="title">Company Phone number<span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="text" id="title" name="phone" required="required" class="form-control col-md-12 col-xs-12" placholder="Enter your company phone number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-6 col-sm-6 col-xs-12" for="title">Company Email<span class="required">*</span>
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <input type="email" id="title" name="email" required="required" class="form-control col-md-12 col-xs-12" placholder="Enter your company email">
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
