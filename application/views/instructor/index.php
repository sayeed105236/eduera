<style>
     .tile_count .tile_stats_count span{
        color: #404040;
        font-weight: bold;
     }
    .tile_count .tile_stats_count .count {
        font-size: 15px;
        line-height: 30px;
        font-weight: 600;
        color: #797979;
        /*text-align: left;*/
    }
    @media (min-width: 768px) {
        .tile_count .tile_stats_count .count {
            font-size: 16px;
            line-height: 40px;
             /*text-align: left;*/
        }
    }
    @media (min-width: 992px) and (max-width: 1100px) {
        .tile_count .tile_stats_count .count {
            font-size: 20px;
            line-height: 40px;
             /*text-align: left;*/
        }
    }

    /* Tabs*/
    section {
        padding: 60px 0;
    }

    section .section-title {
        text-align: center;
        color: #007b5e;
        margin-bottom: 50px;
        text-transform: uppercase;
    }
    #tabs{
        background: #fff;
        color: #000;
    }
    #tabs h6.section-title{
        color: #eee;
    }

    #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #f3f3f3;
        background-color: transparent;
        border-color: transparent transparent #f3f3f3;
        /*border-bottom: 4px solid !important;*/
        border-bottom: 4px solid #007791 !important;
        font-size: 20px;
        font-weight: bold;
    }
    #tabs .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: .25rem;
        border-top-right-radius: .25rem;
        color: #eee;
        font-size: 20px;
    }
    .card {
      /* Add shadows to create the "card" effect */
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
      transition: 0.3s;
    }

    /* On mouse-over, add a deeper shadow */
    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    nav {
        padding: 0;
        border-bottom: 1px solid #fff;
    }

    .main-tab {
        min-height: 300px;
        border-bottom: 2px solid;
        background: #f7f8fa;
        padding-top:10px;
        width: 100% !important;
    }
    .tab-content{

    }
    #nav-rangeContent{
        margin-bottom: 40px;
    }

    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        appearance: none;
        outline: 0;
        box-shadow: none;
        border: 0 !important;
        background: #fff;
        background-image: none;
        font-size: 12px;
        font-weight: bold;
    }
    /* Remove IE arrow */
    select::-ms-expand {
      display: none;
    }
    /* Custom Select */
    .select {
        position: relative;
        display: flex;
        width: 11em;
        height: 2em;
        line-height: 2;
        background: #2c3e50;
        overflow: hidden;
        border-radius: .25em;
        border: 1px solid #007791;
        margin-left: 5px;
         font-size: 12px;
    }
    select {
        flex: 1;
        padding: 0 .5em;
        color: #007791;
        cursor: pointer;
    }
    /* Arrow */
    .select::after {
      content: '\25BC';
      position: absolute;
      top: 0;
      right: 0;
      padding: 0 1em;
      cursor: pointer;
      pointer-events: none;
      -webkit-transition: .25s all ease;
      -o-transition: .25s all ease;
      transition: .25s all ease;
      color: #007791;
    }
    /* Transition */
    .select:hover::after {
      color: #007791;
    }

    label{
        color: black;
        font-size: 14px;
    }
  
</style>
<div class="container">

    <!-- Card Start -->
<div class="card">
    <!-- Section Start -->
    <section id="tabs">
       
        <div class="container">

            <div class="row">
                <div class="col-md-12 ">
                    <nav>
                        <p style="font-weight: bold; color: red">* From now on the VAT & Tax will be deducted from the course</p>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a href="<?= base_url('instructor')?>" class="nav-item nav-link resp-instrctr <?php if($page_name =='instructor_courses'){echo 'active';} ?>" id="nav-home-tab"   role="tab" aria-controls="nav-home" aria-selected="true">
                                <div class="tile_count">
                                    <div class="tile_stats_count">
                                        <span class="count_top">Total Course</span>
                                        <div class="count green"><i class="fas fa-play-circle"></i> <?= ($instructor_courses_count)?></div>
                                            <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
                                    </div>
                                </div>
                            </a>

                            <a class="nav-item nav-link resp-instrctr <?php if($page_name =='total_sell'){echo 'active';} ?>" id="nav-profile-tab"  href="<?= base_url('instructor/total_sell')?>" role="tab" aria-controls="nav-profile" aria-selected="false">
                                <div class="tile_count">
                                    <div class="tile_stats_count">
                                        <span class="count_top">Total sell</span>
                                        <div class="count green"><?= currency($total_revenue)?> </div>
                                            <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
                                    </div>
                                </div>
                            </a>

                            <a class="nav-item nav-link resp-instrctr <?php if($page_name =='money_withdraw'){echo 'active';} ?>" id="nav-contact-tab"  href="<?= base_url('instructor/money_withdraw')?>" role="tab" aria-controls="nav-contact" aria-selected="false">
                                <div class="tile_count">
                                    <div class="tile_stats_count">
                                        <span class="count_top">Money Withdraw</span>
                                        <div class="count green"> <?=  (isset($total_withdraw_amount[0]->total_withdraw_amount) ) ? currency($total_withdraw_amount[0]->total_withdraw_amount) : 0 ?></div>
                                            <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span> -->
                                    </div>
                                </div>
                            </a>

                           
                        </div>
                    </nav>
                  
                    
                    <div class="container main-tab" >
                        <?php if($page_name != 'money_withdraw' || $page_name != 'instructor_courses'){?>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-rangeContent">
                            <form class="form-inline pull-right" id="date_range" action="" method="GET">
                                <label>Date range: </label>
                               <div class="select">
                                 <select name="search_range" id="slct" onchange="date_range()">
                                    <option value="all" <?php if($date_range == 'all' || isset($_GET['date_range'])){ echo 'selected'; }?>> All time</option>
                                   <option value="7 DAY"  <?php if($date_range == '7 DAY'){ echo 'selected'; }?>>Last 7 days</option>
                                   <option value="30 DAY" <?php if($date_range == '30 DAY'){ echo 'selected'; }?>>Last 30 days</option>
                                   <option value="12 MONTH" <?php if($date_range == '12 MONTH'){ echo 'selected'; }?>>Last 12 months</option>
                                   
                                 </select>
                               </div>
                            </form>

                        </div>
                    <?php }?>
                        <?php include $sub_page_view . '.php'; ?>
                     
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section end -->
</div>
<!-- Card End -->
</div>


        </div>
    </div>

    <script type="text/javascript">
        function date_range(el){
            $("#date_range").submit();
        }
    </script>