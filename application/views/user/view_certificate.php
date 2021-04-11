<style>

.cls_003{font-family:"Monotype Corsiva",serif;font-size:38px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
/*div.cls_003{font-family:"Monotype Corsiva",serif;font-size:46.1px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}*/
span.cls_002{font-family:"Monotype Corsiva",serif;font-size:24.7px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
div.cls_002{font-family:"Monotype Corsiva",serif;font-size:24.7px;color:rgb(81,94,101);font-weight:normal;font-style:italic;text-decoration: none}
span.cls_004{font-family:"Monotype Corsiva",serif;font-size:12.0px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
div.cls_004{font-family:"Monotype Corsiva",serif;font-size:10.0px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
span.cls_005{font-family:"Monotype Corsiva",serif;font-size:6.9px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}
div.cls_005{font-family:"Monotype Corsiva",serif;font-size:6.9px;color:rgb(43,42,41);font-weight:normal;font-style:italic;text-decoration: none}


.user-avatar--initials {
    background-color: #686f7a;
    border-radius: 50%;
    border: 1px solid #fff;
    color: #fff;
    font-size: 15px;
}

.user-avatar {
    display: inline-block;
    position: relative;
    max-width: 100%;
}

.ml5 {
    margin-left: 5px;
}

a {
    color: #007791;
    background-color: transparent;
    font-weight: 400;
    text-decoration: none;
}

.user-avatar{
    background-color: rgb(110, 26, 82);
    font-size: 15px;
    width: 48px;
}
.bg-white {
    background-color: #fff;
}
.recipient_name {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    border-radius: 5px;
    height: 50px;
    padding: 5px;
    margin-left: 5px;
    margin-right: 5px;
    color: #0f7c90;
    text-align: center;
    height: 55px;
    background: white;
}

.course-container-certificate {
    width: 100%;
    margin: 0 auto;
    margin-top: 40px;
}

#myCertificateURL {
    height: 50px;
}
.button-share-download {
    margin: 6px;
}
.download-certificate-btn{
    background-color: #0f7c90 !important;
    color: #fff !important;
    border-color: #0f7c90 !important;
}

.download-certificate-btn:hover{
    background-color: #fff !important;
    color: #0f7c90 !important;
    border-color: #0f7c90 !important;
}


.user-avatar--initials {
    background-color: #686f7a;
    border-radius: 50%;
    border: 1px solid #fff;
    color: #fff;
    font-size: 15px;
}
.user-avatar {
    display: inline-block;
    position: relative;
    max-width: 100%;
}
.user-avatar__inner {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.fx-c, .fxc {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
}
/*Review Section End*/
</style>

<script src="<?= base_url('assets/backend/js/html2canvas.js')?>"></script>

<section class="category-course-list-area"  style="margin-top: 40px">
    <div class="container" style="margin: 0;padding: 0; max-width: 100%;">

        <form method="post" action="<?=base_url('home/certificate')?>">
            <div class="row">

                    <!-- Certificate section start -->
                    <div  class="col-md-8 justify-content-center align-items-center" >

                    <div id="certificate2img" style="position:fixed;left: -999em; top:0px;width:841px;height:595px;">
                       <div style="position:absolute;left:0px;top:0px">
                        <img src="<?=base_url('assets/frontend/certificate/' . $certificate_info->course_id . '.jpg')?>" width=841 height=595>
                       </div>

                       <div class="row" style="position:relative;top:152.23px; text-align: center;">
                           <div class="col-md-12">
                               <div  class="cls_0033"><span class="cls_003">Certification of completion</span></div>
                           </div>
                       </div>

                       <div class="row" style=" text-align: center; position:absolute; left:130.62px;top:280.02px; padding-right: 30px;">
                           <div class="col-md-12">
                              <span class="cls_002 cls_003" style="font-weight:italic;"><?=$certificate_info->first_name?> <?=$certificate_info->last_name?>  has successfully completed <br><span style="color:#e33667;"><?=$certificate_info->course_name?></span> online training on <?=$get_date?> <?=$monthName?>, <?=$get_year?></span>
                          </div>
                       </div>

                       <div style="position:absolute;left:16.06px;top:567.77px;" class="cls_004"><span class="cls_004">Certificate no:  <?=$certificate_info->certificate_no?></span></div>
                       <div style="position:absolute;right:16.06px;top:567.77px;font-weight:bold" class="cls_004"><span class="cls_004">Verification URL:  www.eduera.com.bd/home/certificate</span></div>

                   </div>

                   <div id="loader_img" class="loader_img" style="display: none;">   

                    </div>

                    <div id="certificate_image">
                    </div>

                </div>
                <!-- Certificate section end -->
       
                <!-- <div class="col-md-2"></div> -->
                <div class="col-md-4 justify-content-center align-items-center resp-tab-certi">
                    <div class="row">
                        <div class="col-md- resp-tab-certi-name">
                            <h6>Certificate Recipient:</h6>
                            <div class="row recipient_name">
                                <div aria-label="Nazmul Huda" class="user-avatar user-avatar--initials" data-purpose="user-avatar" style="background-color: rgb(110, 26, 82); font-size: 15px; width: 48px;">
                                    <div class="user-avatar__inner fx-c">

                                      <?php if ($certificate_info->profile_photo_name === null || $certificate_info->profile_photo_name === "") {?>
                                          <span class="user-initials">
                                              <?=$certificate_info->first_name[0]?><?=$certificate_info->last_name[0]?>
                                          </span>
                                      <?php } else {?>
                                          <img src="<?php echo base_url() . 'uploads/user_image/' . $certificate_info->profile_photo_name; ?>" alt="" class="user-initials" style="width: 100%;height: 100%;border-radius: 50%;">
                                      <?php }?>
                                    </div>
                                </div>



                                <div class="ml5">
                                    <div>
                                    <a  data-purpose="certificate-recipient"><?=$certificate_info->first_name?> <?=$certificate_info->last_name?>

                                    </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course view start -->
                        <div class="row course-container-certificate" style="margin-top: 10px;">
                            
                            <div class="course-box-wrap responsive_div resp-tab-certi-name" style="margin-bottom: 5px;">
                                <h5 >About the course</h5>
                                <a href="<?=base_url('course/' . $course->slug)?>" class="course-block">
                                    <div class="course-box">
                                      
                                        <div class="course-image">
                                            <img src="<?=$this->course_model->get_course_thumbnail_url($course->id)?>" alt="" class="img-fluid">
                                        </div>
                                        <div class="course-details">
                                            <h5 class="title"><?=$course->title?></h5>
                                            <p class="instructors"><?=$course->short_description?></p>
                                            <?php if ($course->discount_flag == 1 && $course->discounted_price == 0): ?>
                                                <p class="price text-right"><?=get_phrase('free')?></p>
                                            <?php else: ?>
                                                <?php if ($course->discount_flag == 1): ?>
                                                    <p class="price text-right">
                                                        <small><?=$course->price?></small>
                                                        <?=$course->discounted_price?>
                                                    </p>
                                                <?php else: ?>
                                                    <p class="price text-right"><?=$course->price?></p>
                                                <?php endif;?>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                <!-- Course View End -->

                <div class="button-share-download">
                    <div class="row">
                        <div class="col" style="padding-bottom: 8px;">
                            <a href="<?=base_url('user/download_certificate/' . $certificate_info->certificate_key)?>" target="_blank"  class="btn download-certificate-btn btn-block" ><i class="fas fa-download"></i> Download</a>

                        </div>
                        <div class="col resp-share-cert" style="padding-bottom: 8px;">
                            <a type="button" data-toggle="modal" data-target="#shareCertificateModal" class="btn share-btn btn-block" onclick="shareCertificateSocial('<?=$certificate_info->certificate_key?>')"><i class="fas fa-share"></i> Share</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>

        </form>

    </div>

</section>


<?php $this->load->view('component/rating_modal'); ?>
<script type="text/javascript">
    let review = null;
    let user_id = null;
    course_review = '<?= json_encode($course_review)?>';
    review = JSON.parse(course_review);  
    if(review === undefined || review.length == 0){
           setTimeout(function() {
               $('#ReviewPreviewModal').modal();
           }, 3000);
    }

</script>


<script type="text/javascript">
     // Social share option js start
        function shareCertificateSocial(certificate_key){
            // var socialSlug = '<?=base_url('home/get_certificate/')?>'+certificate_key;
             var url = "<?=base_url('uploads/users_certificate/')?>"+'<?= $certificate_info->id?>_<?= $certificate_info->course_id?>_'+certificate_key+'.jpeg';
            $("#myCertificateURL").val(url);
            $("#shareCertificateButton").jsSocials({
                url: url,
                text: "My course completion certificate for : <?=isset($certificate_info->course_name) ? $certificate_info->course_name : null?> " ,
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

     // Social share option js end

     function copyCertificateLink() {
       /* Get the text field */
       var copyText = document.getElementById("myCertificateURL");

       /* Select the text field */
       copyText.select();
       copyText.setSelectionRange(0, 99999); /*For mobile devices*/

       /* Copy the text inside the text field */
       document.execCommand("copy");



     }
</script>

<script>
    var info = '<?= json_encode($certificate_info)?>';
    info = JSON.parse(info);

    function doCapture()
    {
        window.scrollTo(0,0);

        html2canvas(document.getElementById("certificate2img")).then(function(canvas){
            var img_data = canvas.toDataURL("image/jpeg", 0.9);


            var name = info.id + "_" + info.course_id + "_" + info.certificate_key;

            var ajax = new XMLHttpRequest();
            ajax.open("POST", "<?= base_url('rest/api/save_capture')?>", true);
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            var data=  JSON.stringify({'name': name, 'image': img_data});
            ajax.send("name="+data);


            ajax.onreadystatechange = function(){
                if(this.readyState==4 && this.status==200){
                }
            };

           
            
        });
    }


 var img_url =  '<?= base_url()?>'+'assets/users_certificate/' + info.id + "_" + info.course_id + "_" + info.certificate_key + ".jpeg";

    function checkImage (src, good, bad) {
       var img = new Image();
       img.onload = good; 
       img.onerror = bad;
       img. src = src;
    }

    checkImage(img_url, 
        function(){
            // var path = "<?=base_url()?>"+"assets/users_certificate/" + info.id + "_" + info.course_id + "_" + info.certificate_key+ ".jpeg";

            //     $('#certificate_image').append('<img  src="'+path+'" class=" cert_img"/>')

                document.getElementById("certificate2img").style.display = "none";
        },
        function(){
            document.getElementById("loader_img").style.display = "block";
            window.onload = doCapture;
            // console.log('not found');

           
        }
    );
    
     setTimeout(function(){
                var path = "<?=base_url()?>"+"assets/users_certificate/" + info.id + "_" + info.course_id + "_" + info.certificate_key + ".jpeg";

                document.getElementById("loader_img").style.display = "none";

                $('#certificate_image').append('<img src="'+path+'" class="cert_img"/>')

                // document.getElementById("certificate2img").style.display = "none";                    
            }, 5000);


</script>