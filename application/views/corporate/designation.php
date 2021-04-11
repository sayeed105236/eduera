<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      	<div class="dashboard_graph">

            <div class="row x_title">
              	<div class="col-md-12">
                	<h3>Designation</h3>
              	</div>
            </div>
            <div class="filter-button-bar">
	            <a type="button" class="btn btn-info pull-right add-designation" data-toggle="modal" data-target=".designation_add_modal">Add new designation</a>
	                    <?php $this->load->view('component/designation_modal'); ?> 
            </div> 
            <br>
            <br>
            <div class="form-group" style="margin-top: 20px;">
                <?php echo validation_errors(); ?>

                <?php if ($this->session->flashdata('designation_save_success_message')) { ?>

                <div class="alert alert-success alert-dismissible show form-control" role="alert" style="height: auto">
                    <strong></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('designation_save_success_message') ?>
                </div>

                <?php } ?>


                <?php if ($this->session->flashdata('designation_save_failed_message')) { ?>

                <div class="alert alert-danger alert-dismissible show form-control" role="alert" style="height: auto">
                    <strong></strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $this->session->flashdata('designation_save_failed_message') ?>
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
						 <?php foreach ($designation_list as $index => $designation) { ?>
						<tr>
							<td><?= $index+1; ?></td>
							<td><?= $designation->name ?></td>
							
							<td>
						        <a class=""><i onclick="Editdesignation(<?= $designation->id?>)" class="fa fa-pencil-square-o" aria-hidden="true" data-toggle="modal" data-target=".designation_add_modal"></i></a> 
                                <a onclick="return confirm('Are you agree remove this designation?');"  href="<?php echo base_url('corporate/remove_designation/'.$designation->id.'?company_id='.$designation->company_id) ?>">
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


