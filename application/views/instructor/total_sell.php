<style type="text/css">
        .card-body span{
        font-size: 12px;
        color: #7E7E7E;
    }
    
    .card-body .manage{
        /*visibility:  hidden;*/
        color: #0f7c90;
        font-weight: bold;


    }
    .hover-link {
        position: absolute;
        z-index: 100;
        text-align: center;
        left: 50%;
        top: 50%;
        font-size: 2rem;
        color: #0f7c90;
        /*transition: .5s ease;*/
        opacity: 0;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
    }
    .card-body:hover  {
        opacity: 0.8;
        background: white;
    }

    .card-body:hover .hover-link{
        /*visibility: visible;*/
        text-align: center;
        opacity: 1

    }
</style>

<!-- <div class="tab-content py-3 px-3 px-sm-0" id="nav-rangeContent">
    <div class="form-inline pull-right">
        <label>Date range: </label>
       <div class="select">
         <select name="slct" id="slct">
           <option value="1">Last 7 days</option>
           <option value="2">Last 30 days</option>
           <option value="3">Last 12 months</option>
           <option value="3"> All time</option>
         </select>
       </div>
    </div>

</div> -->
<div class=" tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
    <div class="tab-content">                           
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <?php foreach($total_sell as $sell){?>
                <div class="card">
               
                <div class="card-body">
                    <div class="row hover-link">
                    <div class="col-md-12">
                        <a href="<?= base_url('instructor/course/'.$sell->id.'/users')?>" id="manage" class="manage">All user</a>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-md-2">
                            <img width="120" height="80" src="<?=$this->course_model->get_course_thumbnail_url($sell->id)?>">
                        </div>
                        <div class="col-md-4">
                            <h5 class="resp-card"><?= $sell->title?></h5>
                        </div>
                        <div class="col-md-2">
                            
                        </div>
                        <div class="col-md-2">
                            <h6><?= $sell->sell_count?></h6>
                            <span>Total Sell</span>
                        </div>
                        <div class="col-md-2">
                            <h6><?= currency($sell->total_profit)?> </h6>
                            <span>Your Total Profit</span>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        <?php } ?>
            </div>
       
     </div>
</div>