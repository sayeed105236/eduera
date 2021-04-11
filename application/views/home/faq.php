<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">

                <h1 class="category-name">
                    <?php echo $page_title; ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="row">
        <div class="col-md-3 sidebar">
            <div class="scrollmenu">
                <ul>
                    <?php foreach ($faq_category as $faq_cat) {

	?>
                    <li><a href="<?=base_url('home/faq/' . $faq_cat->id)?>"><?=$faq_cat->name?></a></li>

                   <?php }?>
                </ul>


            </div>

        </div>
        <div class="col-md-9">

           <div id="maindiv">

                <div class="col-md-10 popular-list">

                    <?php
if (count($faq_list) > 0) {
	if (count($faq_list) == 1) {

		?>
                            <h3><a class="Article__kav" href="<?=base_url('home/faq/' . $faq_list[0]->faq_category_id . '/' . $faq_list[0]->id)?>" id="ka00I000000kgHTQAY" ><?=$faq_list[0]->question?></a></h3>
                            <p><?=$faq_list[0]->answer?></p>
                            <?php if ($faq_list[0]->video_id) {?>


                            <div class="col-md-6 video-responsive">
                              <br>
                              <h4>Video Example</h4>
                               <iframe controls controlsList="nodownload" src="https://player.vimeo.com/video/<?=$faq_list[0]->video_id?>"  height="640" width="420" frameborder="0" webkitallowfullscreen allowfullscreen allowtransparency allow="autoplay"></iframe>


                            </div>
                            <?php
}
		?>
                            <?php

	} else {
		foreach ($faq_list as $faq) {
			?>
                        <h3><a class="Article__kav" href="<?=base_url('home/faq/' . $faq->faq_category_id . '/' . $faq->id)?>" id="ka00I000000kgHTQAY" ><?=$faq->question?></a></h3>
                        <p><?=$faq->answer?></p>

                        <?php }

	}?>
            <div class="footer">
              <nav >
        <?php
echo $this->pagination->create_links();
	?>
              </nav>

            </div>
<?php
} else {
	echo "Not Found.";
}
?>
                </div>


            </div>
        </div>
    </div>

</section>
<script src="https://unpkg.com/navigator.sendbeacon"></script>
  <script src="https://player.vimeo.com/api/player.js"></script>
  <script>
    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);

    player.on('play', function() {
    });

    player.getVideoTitle().then(function(title) {
    });
  </script>
  