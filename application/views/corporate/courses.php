<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      	<div class="dashboard_graph">

            <div class="row x_title">
              	<div class="col-md-12">
                	<h3>Course</h3>
              	</div>
            </div>
            <div class="filter-button-bar">
	            <a type="button" class="btn btn-info pull-right add-department" data-toggle="modal" data-target=".department_add_modal">Add new Course</a>
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
							<th>Price</th>
							<!-- <th>Action</th> -->
						</tr>
					</thead>


					<tbody>
						
						<tr>
							<td>1</td>
							<td>ITIL 4 international certification exam voucher with mock</td>
							<td>29068</td>
						</tr>	
						<!-- <tr>
							<td>2</td>
							<td>PRINCE2® Foundation Training</td>
							<td>1999</td>
						</tr> -->
									
						<tr>
							<td>2</td>
							<td>PRINCE2® Practitioner Certification Training</td>
							<td>9999</td>
						</tr>	
					</tbody>
					
				</table>
				<nav>
					
		        </nav>
            </div>

            <div class="clearfix"></div>
        </div>  
    </div>
</div>  