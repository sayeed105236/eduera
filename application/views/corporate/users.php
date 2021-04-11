<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="dashboard_graph">

			<div class="row x_title">
				<div class="col-md-12">
					<h3>User List</h3>
				</div>
			</div>
			<div class="filter-button-bar">
				<a type="button" class="btn btn-info pull-right add-user" data-toggle="modal" data-target=".existing_user_add_modal">Add existing user</a>
				<a type="button" class="btn btn-info pull-right add-user" data-toggle="modal" data-target=".new_user_add_modal">Add new user</a>
				<?php $this->load->view('component/user_modal'); ?> 

			</div>           
			<br>
			<br>
			<div class="form-group" style="margin-top: 20px;">
				<?php echo validation_errors(); ?>

				<?php if ($this->session->flashdata('user_save_success_message')) { ?>

					<div class="alert alert-success alert-dismissible show form-control" role="alert" style="height: auto">
						<strong></strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?= $this->session->flashdata('user_save_success_message') ?>
					</div>

				<?php } ?>


				<?php if ($this->session->flashdata('user_save_failed_message')) { ?>

					<div class="alert alert-danger alert-dismissible show form-control" role="alert" style="height: auto">
						<strong></strong> 
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<?= $this->session->flashdata('user_save_failed_message') ?>
					</div>

				<?php } ?>

			</div>         	
			<div class="col-md-12 col-sm-12 col-xs-12">
				<table id="datatable" class="table table-striped table-bordered">

					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Role</th>
							<th>Department</th>
							<th>Designation</th>
							<th>Request Status</th>
							<th>Action</th>
						</tr>
					</thead>


					<tbody>
						<?php foreach ($user_list as $index => $user) { ?> 
							<tr>
								<td><?= $index+1 ?></td>
								<td><?= $user->first_name ?>  <?= $user->last_name?></td>
								<td><?= $user->email ?></td>
								<td><?= $user->phone ?></td>
								<td><?= $user->corporate_role ?></td>
								<td><?= $user->department ?></td>
								<td><?= $user->designation ?></td>
								<td><?= $user->request_status ?></td>


							 <td>

								<a onclick="return confirm('Are you agree remove this user?');"  href="<?php echo base_url('corporate/remove_user/'.$user->company_user_id.'?company_id='.$user->company_id) ?>">
									<i class="fa fa-trash"></i> 
								</a>
							</td>  
						</tr>	
					<?php } ?> 					
					<!-- <tr>
						<td>1</td>
						<td>Sanjit Dutta </td>
						<td>sanjit.dutta@ebl-bd.com</td>

						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>2</td>
						<td>Khairul Islam </td>
						<td>khairul.islam@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>3</td>
						<td>Shohidul Islam </td>
						<td>shohidul.islam@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>4</td>
						<td>Imtiaz Ahmed </td>
						<td>imtiaz.ahmed@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>5</td>
						<td>Nirapada Biswas </td>
						<td>nirapada.biswas@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>6</td>
						<td>Rezaul Haq </td>
						<td>rezaul.haq@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>7</td>
						<td>Tanvir Jubair </td>
						<td>tanvir.jubair@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>8</td>
						<td>Aktarul Hasan </td>
						<td>aktarul.hassan@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>9</td>
						<td>Bishu Das </td>
						<td>bishu.das@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>10</td>

						<td>Tasnuba Tania </td>
						<td>tasnuba.tania@ebl-bd.com</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>11</td>
						<td>Ashfaqul Alam </td>
						<td>ashfaqul.alam@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>12</td>
						<td>Syful Islam </td>
						<td>syful.islam@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>13</td>
						<td>Khaled Hossain </td>
						<td>khaled.hossain@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>14</td>
						<td>Ridwan Al Galib </td>
						<td>ridwan.al.galib@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>15</td>
						<td>Jubayer Khan </td>
						<td>jubayer.khan@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>16</td>
						<td>Hasinul Islam </td>
						<td>hasinul.islam@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>17</td>
						<td>Shamser Alam </td>
						<td>shamser.alam@ebl-bd.com</td>
						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr> -->
					

				</tbody>

			</table>
			<nav>

			</nav>
		</div>

		<div class="clearfix"></div>
	</div>  
</div>
</div>  