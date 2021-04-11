<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<style>
<!--
span.cls_003{font-family:"Monotype Corsiva",serif;font-size:46.1px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
div.cls_003{font-family:"Monotype Corsiva",serif;font-size:46.1px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
span.cls_002{font-family:"Monotype Corsiva",serif;font-size:24.7px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
div.cls_002{font-family:"Monotype Corsiva",serif;font-size:24.7px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
span.cls_004{font-family:"Monotype Corsiva",serif;font-size:10.0px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
div.cls_004{font-family:"Monotype Corsiva",serif;font-size:10.0px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
span.cls_005{font-family:"Monotype Corsiva",serif;font-size:6.9px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
div.cls_005{font-family:"Monotype Corsiva",serif;font-size:6.9px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
-->
</style>
<script type="text/javascript" src="5fddaf08-7982-11ea-8b25-0cc47a792c0a_id_5fddaf08-7982-11ea-8b25-0cc47a792c0a_files/wz_jsgraphics.js"></script>
<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?php echo $page_title; ?>
                            </a>
                        </li>
                    </ol>
                </nav>

            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container">
        <?php echo validation_errors(); ?>
        <h3>Verify your certificate</h3>
        <form method="post" action="<?=base_url('home/certificate')?>">
            <div class="row">



                <div class="col-md-4" >

                    <div class="form-group">
                        <input placeholder="Enter your certificate no" type="number" name="certificate_no" class="form-control" required="">
                    </div>
                    <br>

                    <div class="form-group">
                        <input type="submit" value="Check" class="btn btn-info">
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-6" >
                    <?php
if ($certificate_info != null) {

	if ($certificate_info->certificate_no == intval($_POST['certificate_no'])) {

		?>
                            <div style="position:relative;left:50%;margin-left:-420px;top:0px;width:841px;height:595px;border-style:outset;overflow:hidden">
                                <div style="position:absolute;left:0px;top:0px">

                                    <img src="<?=base_url('assets/frontend/certificate/' . $certificate_info->course_id . '.jpg')?>" width=841 height=595>
                                </div>
                             
                                <div class="row" style="position:absolute;left:220.59px;top:152.23px; text-align: center;">
                                    <div class="col-md-12">
                                        <div  class="cls_003"><span class="cls_003">Certification of completion</span></div>
                                    </div>
                                </div>

                                <div class="row" style=" text-align: center; position:absolute; left:130.62px;top:280.02px; padding-right: 30px;">
                                    <div class="col-md-12">
                                        <span class="cls_002 cls_003" style="font-weight:italic;"> <?=$certificate_info->first_name ?> <?= $certificate_info->last_name ?>  has successfully completed <br><span style="color:#e33667;"><?= $certificate_info->course_name ?></span> online training on <?= $get_date ?> <?=$monthName ?>, <?= $get_year ?> </span>
                                    </div>
                                </div>

                                <div style="position:absolute;left:16.06px;top:567.77px;" class="cls_004"><span class="cls_004">Certificate no:  <?=$certificate_info->certificate_no?></span></div>
                                <div style="position:absolute;right:16.06px;top:567.77px;font-weight:bold" class="cls_004"><span class="cls_004">Verification URL:  www.eduera.com.bd/home/certificate</span></div>
                            </div>
                        <?php } else {
		echo $error;
	}
} else {
	if ($error != null) {
		echo $error;
	} else {
		?>
                            <div style="position:relative;left:50%;margin-left:-420px;top:0px;width:841px;height:595px;border-style:outset;overflow:hidden">
                                <div style="position:absolute;left:0px;top:0px">

                                    <img src="<?=base_url('assets/frontend/certificate/1.jpg')?>" width=841 height=595>
                                </div>
                               

                                <div class="row" style="position:absolute;left:130.59px;top:152.23px; text-align: center;">
                                    <div class="col-md-12">
                                        <div  class="cls_003"><span class="cls_003">Certification of completion</span></div>
                                    </div>
                                </div>

                                <div class="row" style=" text-align: center; position:absolute; left:120.62px;top:280.02px; padding-right: 30px;">
                                    <div class="col-md-12">
                                        <span class="cls_002 cls_003" style="font-weight:italic;"> ``Your name will be here``  has successfully completed <br><span style="color:#e33667;">``Course name`` </span> online training on 21 april, 2020 </span>
                                    </div>
                                </div>

                                <div style="position:absolute;left:16.06px;top:567.77px;" class="cls_004"><span class="cls_004">Certificate no:  20200421004000001</span></div>
                                <div style="position:absolute;right:16.06px;top:567.77px;font-weight:bold" class="cls_004"><span class="cls_004">Verification URL:  www.eduera.com.bd/home/certificate</span></div>
                            </div>
                            <?php
}
}
?>
                </div>
            </div>

        </form>

    </div>
</section>
