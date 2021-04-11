<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<section class="my-courses-area">
    <div class="container">
        <div class="row ">
            <div class="col-lg-12">
                <div class="my-course-filter-bar filter-box">
                  <a class="btn btn-danger create-corporate" data-toggle="modal" data-target=".corporate_add_modal">Create Corporate</a>
                  <br>
                  <br>
          			 <?php $this->load->view('component/corporate_modal'); ?> 
          			 <div class="form-group" style="margin-top: 20px;">
          			     <?php echo validation_errors(); ?>

          			     <?php if ($this->session->flashdata('corporate_save_success_message')) { ?>

          			     <div class="alert alert-success alert-dismissible fade show form-control" role="alert" style="height: auto">
          			         <strong></strong>
          			         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          			             <span aria-hidden="true">&times;</span>
          			         </button>
          			         <?= $this->session->flashdata('corporate_save_success_message') ?>
          			     </div>

          			     <?php } ?>


          			     <?php if ($this->session->flashdata('corporate_save_failed_message')) { ?>

          			     <div class="alert alert-danger alert-dismissible fade show form-control" role="alert" style="height: auto">
          			         <strong></strong> 
          			         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          			             <span aria-hidden="true">&times;</span>
          			         </button>
          			         <?= $this->session->flashdata('corporate_save_failed_message') ?>
          			     </div>

          			     <?php } ?>

          			 </div>
          			<?php if(count($corporate_list) > 0){?> 
	                <table class="eduera-simple-table">
	                	<thead>
		                    <tr>
		                      <th>Company name</th>
		                      <th>Details</th>
		                      <th width="10%">Action</th>
		                    </tr>
	                 	</thead>
	                 	<tbody>
	                 		<?php foreach($corporate_list as $corporate){?>
	                 		<tr>
	                 			<td><?= $corporate->name?></td>
	                 			<td><?= 'Address: '. $corporate->address?> <br> <?= 'Phone: '. $corporate->phone?> <br> <?= 'Email: '. $corporate->email?></td>
	                 			<td><a href="<?= base_url('corporate/'.$corporate->id  .'/dashboard/')?>" class="btn btn-warning">Admin Panel</a></td>
	                 		</tr>
	                 		<?php } ?>
	                 	</tbody>
	                </table>
	                <?php }else{ ?>
	                <h5>Not found any corporate account.</h5>	
                	<?php }?>       			
             
            </div>
            
        </div>
      
    </div>
</section>

