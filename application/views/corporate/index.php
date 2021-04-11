<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link name="favicon" type="image/x-icon" href="<?php echo base_url().'uploads/system/eduera-favicon.png' ?>" rel="shortcut icon" />

<title>Admin panel | <?= $system_name ?></title>

<!-- Bootstrap -->
<link href="<?= base_url('assets/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
<!-- Font Awesome -->
<link href="<?= base_url('assets/vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">

<!-- Custom Theme Style -->
<link href="<?= base_url('assets/build/css/custom.min.css') ?>" rel="stylesheet">
<!-- bootstrap-daterangepicker -->
<link href="<?= base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet">


<link href="<?= base_url('assets/build/css/main.css') ?>" rel="stylesheet">
<link href="<?= base_url('assets/vendors/iCheck/skins/flat/green.css') ?>" rel="stylesheet">

<!-- jQuery -->
<script src="<?= base_url('assets/vendors/jquery/dist/jquery.min.js') ?>"></script>
<!-- bootstrap-progressbar -->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '415184348686393'); 
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1" 
src="https://www.facebook.com/tr?id=415184348686393&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

</head>

<body class="nav-md">
<div class="container body">
<div class="main_container">
<div class="col-md-3 left_col">
<?php $this->load->view('component/admin_panel/sidebar.php'); ?>
</div>

<!-- top navigation -->
<div class="top_nav">
<?php $this->load->view('component/admin_panel/top_navbar.php'); ?>
</div>
<!-- /top navigation -->

<!-- page content -->
<div class="right_col" role="main">
<!-- top tiles -->
<?php // $this->load->view('component/admin_panel/top_tiles.php'); ?>
<!-- /top tiles -->

<?php $this->load->view($page_view); ?>
</div>
<!-- /page content -->

<!-- footer content -->
<footer>
<div class="pull-right">
<a href="<?= base_url('/home')?>">Eduera</a>
</div>
<div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>


<!-- Bootstrap -->
<script src="<?= base_url('assets/vendors/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- bootstrap-progressbar -->
<script src="<?= base_url('assets/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>"></script>



<!-- Custom Theme Scripts -->
<script src="<?= base_url('assets/build/js/custom.min.js') ?>"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?= base_url('assets/vendors/moment/min/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?= base_url('assets/vendors/iCheck/icheck.min.js') ?>"></script>




</body>
</html>