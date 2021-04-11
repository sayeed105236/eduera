
<style type="text/css">
    .card {
        background: #0acf97;
        color: white;
    }
	.card-body span{
	    font-size: 12px;
	    color: #7E7E7E;
	}

</style>

<div class=" tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
    <div class="tab-content">                           
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <?php if(count($withdraw_amount_details) > 0){?>

            <div class="col-md-4" >
           
                    <h4 >Pending Balance: <?= ($pending_balance > 0 ) ? currency($pending_balance): 0 ?></h4>
              
            </div>    
            <br>
            	<div class="row">
            		<table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Withdraw amount</th>
                                <th>Withdraw date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($withdraw_amount_details as $key=> $amount){
                                $dt = new DateTime($amount->created_at);
                              
                            ?>
                            <tr>
                                <td><?= $key +1?></td>
                                <td><?=currency($amount->withdraw_amount)?></td>
                                <td><?= $dt->format('Y-m-d')?></td>
                            </tr>
                            <?php }?>     
                        </tbody>
                    </table>
            	</div>
            <!-- </div>
        </div> -->
    <?php }else{?>
        <h5 class="text-center">No transactions found.</h5>
    <?php }?>
        <br>
        </div>
    
     </div>
</div>

