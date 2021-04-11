<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="<?= base_url('/home')?>" class="site_title"><img src="<?php echo base_url().'uploads/system/eduera-favicon.png'; ?>" alt="" height="40" style="padding-left: 10px;"> <span><?= $system_name ?></span></a>
    </div>

    <div class="clearfix"></div>
    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <h3><?= $company->name?></h3>

            <ul class="nav side-menu">
                <li><a href="<?= base_url('corporate/'.$company_id.'/dashboard') ?>"><i class="fa fa-home"></i> Dashboard <span class="label label-success pull-right"></span></a></li>
                <li><a href="<?= base_url('corporate/'.$company_id.'/users') ?>"><i class="fa fa-users"></i> Users <span class="label label-success pull-right"></span></a></li>
                <li><a href="<?= base_url('corporate/'.$company_id.'/courses') ?>"><i class="fa fa-book"></i> Courses <span class="label label-success pull-right"></span></a></li>
                <li><a href="<?= base_url('corporate/'.$company_id.'/designation') ?>"><i class="fa fa-user" aria-hidden="true"></i> Designation <span class="label label-success pull-right"></span></a></li>
                <li><a href="<?= base_url('corporate/'.$company_id.'/department') ?>"><i class="fa fa-cubes" aria-hidden="true"></i> Department <span class="label label-success pull-right"></span></a></li>
               
               
            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="Settings">
            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Lock">
            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= base_url('login/logout/') ?>">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>