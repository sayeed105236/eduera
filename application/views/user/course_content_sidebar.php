<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<div class="col-lg-3  order-md-2 course_col" id = "lesson_list_area">
    <div class="card" >
        <div class="card-header course_card">
          <!--   <a type="button" data-toggle="modal" data-target="#shareModal" class="btn share-btn btn-block" onclick="shareSocial('<?=$course_details->slug?>')"><i class="fas fa-share"></i> Share</a> -->
            <?php
        if(!$course_details->mock_test){
if ($total_percentage > 90) {
	if ($course_details->certificate) {
		$image_path = $_SERVER['DOCUMENT_ROOT'] . '/eduera/assets/frontend/certificate/';

		?>
                <!--     <h5 class="mb-0">
                        <a target="_blank" href="<?=base_url('user/load_certificate/' . $course_details->id. '/'. $user_data->id)?>"  class="btn btn-link w-100 text-left section_button certificate_button" id="get_certificate"  >
                            Get Certificate
                        </a>
                    </h5> -->
                    <?php
}
}
}
?>
        </div>
    </div>
    <div class="text-center " id="" style="margin: 12px 10px; ">
        <h5 class="course-content-title" <?= $course_details->mock_test == 1 ? 'style="display: none"' : '' ?> > <?= $course_details->mock_test == 1 ? 'Practice Exam' : 'Course content'?></h5>
        
    </div>
    <div class="accordion" id="accordionExample" style="overflow-y: auto;height: 754px;">
        <?php if(!$course_details->mock_test){?>
        <?php foreach ($course_details->section_list as $section_index => $section) {
	?>
            <div class="card" style="margin:0px 0px;">
                <div class="card-header course_card" id="<?='heading-' . $section->id?>">
                    <h5 class="mb-0">
                        <button  class="btn btn-link w-100 text-left section_button course-sec-butt" type="button" data-toggle="collapse" data-target="#collapse-<?=$section->id?>" <?php if ($lesson_info->section_id == $section->id): ?> aria-expanded="true" <?php else: ?> aria-expanded="false" <?php endif;?> aria-expanded="false" aria-controls="<?='collapse-' . $section->id?>" onclick = "toggleAccordionIcon(this, <?=$section->id;?>)">
                            <h6 style="color: #959aa2; font-size: 13px;">
                                Section <?=($section_index + 1)?>
                                <span style="float: right; font-weight: 100;" class="accordion_icon" id="accordion_icon_<?=$section->id?>">
                                    <?php if ($lesson_info->section_id == $section->id) {?>
                                        <i class="fa fa-minus"></i>
                                    <?php } else {?>
                                        <i class="fa fa-plus"></i>
                                    <?php }?>
                                </span>
                            </h6>
                            <?=$section->title?>
                        </button>
                    </h5>
                </div>

                <div id="collapse-<?=$section->id?>" class="collapse <?php if ($lesson_info->section_id == $section->id) {
		echo 'show';
	}
	?>" aria-labelledby="<?php echo 'heading-' . $section->id; ?>" data-parent="#accordionExample">
                <?php foreach ($section->lesson_list as $lesson_index => $lesson) {
		?>
                    <div class="card-body"  style="padding:0px;">
                        <table style="width: 100%;">

                            <tr style="width: 100%; padding: 5px 0px;background-color: <?php if ($lesson_id == $lesson->id) {
			echo '#E6F2F5';
		} else {
			echo '#fff';
		}
		?>;">
                            <td style="text-align: left; padding:7px 10px;">

                                <a onclick="videoChange()"
                                <?php if (in_array($lesson->id, $user_course_access_info['lesson_id_list'])) {
			?>
                                    href="<?php
echo site_url('user/course/' . $course_details->id . '/' . $course_details->slug . '/lesson/' . $lesson->id);
			?>"
                                    <?php }?> style="color: #444549;font-size: 14px;font-weight: 400;"><?=($lesson_index + 1)?>. <?=$lesson->title?> (Duration: <?=second_to_time_conversion($lesson->duration_in_second)?>)</a>
                                    <div class="lesson_duration" style="padding-left: 10px;">
                                        <?php if ($lesson->lesson_file_list != null) {?>
                                            <?php foreach ($lesson->lesson_file_list as $lesson_file) {?>
                                                <i class="far fa-file"></i>
                                                <a href="<?='http://file.server.eduera.com.bd/lesson_files/' . $lesson_file?>" target="_blank"><?=$lesson_file?></a><br />
                                            <?php }?>
                                        <?php }?>
                                    </div>

                                    <?php if (isset($lesson->lesson_quiz)) {?>
                                        <?php foreach ($lesson->lesson_quiz as $lesson_quiz) {
                                            ?>
                                    <div class="card" style="margin:0px 0px;">
                                        <div class="card-header course_card">
                                            <h5 class="mb-0">
                                                <button  class="btn btn-link w-100 text-left section_button" type="button" style="background: #ec5252; color: #fff; border: none; white-space: normal; text-decoration: none;" 
                                                <?=$user_course_access_info['access_percentage'] == 100 || $lesson_quiz->free_access == 1  ? 'onclick = "take_course_assessment( null , ' . $lesson_quiz->id . ')"' : ''?>
                                                >
                                                    <?=$lesson_quiz->name?>
                                                </button>
                                            </h5>
                                        </div>
                                    </div>
                                    <?php }
                                }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                <?php }?>
            </div>
        </div>

    <?php }?>
        <?php }?>

        <div <?= $course_details->mock_test == 1 ? 'style="display:none"' : ''?>  id="mock-list-sidebar">
    <?php if ($course_quiz_list != null) {?>
        <?php foreach ($course_quiz_list as $course_quiz) {
           
            ?>
            <div class="card" style="margin:0px 0px; " >
                <div class="card-header course_card">
                    <h5 class="mb-0">
                        <button  class="btn btn-link w-100 text-left section_button" type="button" style="background: #ec5252; color: #fff; border: none; white-space: normal; text-decoration: none;" 
                        <?=$user_course_access_info['access_percentage'] == 100 || $course_quiz->free_access == 1  ? 'onclick = "take_course_assessment(' . $course_quiz->id . ')"' : ''?>
                        >
                            <?=$course_quiz->name?>
                        </button>
                    </h5>
                </div>
            </div>
        <?php }?>
    <?php }?>
</div>
    
</div>
</div>

<script type="text/javascript">
    function toggleAccordionIcon(elem, section_id) {
        var accordion_section_ids = [];
        $(".accordion_icon").each(function(){ accordion_section_ids.push(this.id); });
        accordion_section_ids.forEach(function(item) {
            if (item === 'accordion_icon_'+section_id) {
                if ($('#'+item).html().trim() === '<i class="fa fa-plus"></i>') {
                    $('#'+item).html('<i class="fa fa-minus"></i>')
                }else {
                    $('#'+item).html('<i class="fa fa-plus"></i>')
                }
            }else{
                $('#'+item).html('<i class="fa fa-plus"></i>')
            }
        });

        $("#section_button").css({'text-decoration': 'none'});
    }

</script>
<script type="text/javascript">
    function shareSocial(slug){
        console.log(slug);
        var socialSlug = '<?=base_url('course/')?>'+slug;
        $("#myInput").val(socialSlug);
        var url = "<?=base_url('course/')?>"+slug;
        $("#shareButton").jsSocials({
            url: url,
            text: "Thought you might enjoy this course on @Eduera: <?=$course_details->title?> " ,
            showCount: false,
            showLabel: false,
            shareIn: "popup",
            shares: [
            "twitter",
            "facebook",
            "linkedin",
            { share: "pinterest", label: "Pin this" },
            { share: "email", logo: "fas fa-envelope"}
            ]
        });
    }

</script>