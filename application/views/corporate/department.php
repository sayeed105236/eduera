<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      	<div class="dashboard_graph">

            <div class="row x_title">
              	<div class="col-md-12">
                	<h3>Department</h3>
              	</div>
            </div>
            <div class="filter-button-bar">
	            <a type="button" class="btn btn-info pull-right add-department" data-toggle="modal" data-target=".department_add_modal">Add new department</a>
	                    <?php $this->load->view('component/department_modal'); ?> 
            </div> 
            <br>
            <br>
            <div class="form-group" style="margin-top: 20px;">
                <?php echo validation_errors(); ?>

                <?php if ($this->session->flashdata('department_save_success_message')) { ?>

                <div class="alert alert-success alert-dismissible show form-control" role="alert" style="height: auto">
                    <strong></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('department_save_success_message') ?>
                </div>

                <?php } ?>


                <?php if ($this->session->flashdata('department_save_failed_message')) { ?>

                <div class="alert alert-danger alert-dismissible show form-control" role="alert" style="height: auto">
                    <strong></strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('department_save_failed_message') ?>
                </div>

                <?php } ?>

            </div>         	
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table id="datatable" class="table table-striped table-bordered">

					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>


					<tbody>
						 <?php foreach ($department_list as $index => $department) { ?>
						<tr>
							<td><?= $index+1; ?></td>
							<td><?= $department->name ?></td>
							
							<td>
							    <a class=""><i onclick="Editdepartment(<?= $department->id?>)" class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="modal" data-target=".department_add_modal"></i></a> 
                                <a onclick="return confirm('Are you agree remove this department?');"  href="<?php echo base_url('corporate/remove_department/'.$department->id.'?company_id='.$department->company_id) ?>">
                                    <i class="fa fa-trash"></i> 
                                </a>
							</td>
						</tr>	
						<?php } ?>					
					</tbody>
					
				</table>
				<nav>
					
		        </nav>
            </div>

            <div class="clearfix"></div>
        </div>  
    </div>
</div>  