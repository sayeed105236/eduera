<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<!-- chat application end -->

<footer class="footer-area d-print-none resp-foot">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-6">
                <p class="copyright-text">
                    <a href=""><img src="<?php echo base_url() . 'uploads/system/eduera-logo-300.png'; ?>" alt="" class="d-inline-block" width="110"></a>
                </p>
            </div>
            <div class="col-md-6">
                <ul class="nav justify-content-md-end footer-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/about_us'); ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/contact'); ?>">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/privacy_policy'); ?>">Privacy policy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('home/terms_and_condition'); ?>">Terms & condition</a>
                    </li>

                </ul>
            </div>
        </div>

    </div>

        <div class="stickyfooter resp-foot-size">
            <div class="sticky-clear">
                <div class="sticky-footer-gdpr active-sticky-footer">
                    <div class="container">
                        <div class="footer_sticky_bar ">


                            <ul class="live_chat_div row" >
                                <li class="col-sm-4 col-xs-12">
                                     <i class="fas fa-question-circle"></i><a class="sticky_request_call" href="<?=base_url('home/faq')?>" target="_blank" data-phone-code="AE">
                                        <span class="aap_icon call_back_footer"></span>Help and Support
                                    </a>
                                </li>
                                <li class="col-sm-4 col-xs-12">
                                    <i class="fa fa-certificate"></i><a class="sticky_request_call" href="<?=base_url('home/certificate')?>" target="_blank" data-phone-code="AE">
                                        Certificate Verify 
                                    </a>
                                </li>
                                <!-- <li class=" col-sm-3 col-xs-12">
                                   <i class="fas fa-phone"></i>  Call us on
                                    <a href="#" > +01766343434 </a>
                                </li> -->
                                <li class=" col-sm-4 col-xs-12">
                                  <!-- <a class="open-button" onclick="openForm()">Live Chat</a> -->
                                 <i class="fas fa-comment"></i> <a class="open-button" href="<?= base_url('home/user_message')?>">Live Chat</a>

                                    <!-- <i class="fas fa-comment"></i> -->
                                </li>



                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>

</footer>


<?php if (!$this->session->userdata('user_id')) {?>
  <div id="alert_popover" >
    <div class="wrapper-popup" >
      <div class="content">
        <div class="alert alert_default row">
          <div id="toast-header" class="image">
          </div>

          <div class="text-div">
            <a  href="#" class="close" data-dismiss="alert" area-label="close">&times;</a>
            <a id="course-link">
              <span style="font-size: 11px;"><strong id="name" > </strong> recently purchased</span>
              <p><strong id="course" style="font-size: 11px;"></strong></p>
              <p><small>Hope you also like it.</small><p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }?>

<!-- Start Preloader  -->
 

    <!--   <div class="modal fade show" id="preloader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document" style="position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%);">
              <a href="<?= base_url('membership')?>"> <div class="modal-content" id="web-modal-content" style="  position: absolute;left: 50%;top: 50%;transform: translate(-50%, -50%); background-image: url('<?= base_url('assets/web_membership_offer.jpg')?>'); background-size: cover;  height: 628px;background-repeat: no-repeat; width: 1200px;">

           
                <div class="modal-header" style="border-bottom: 0px;">
                  <button type="button" class="close membership-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;font-size: xxx-large;font-weight: bold;">×</span>
                  </button>
                </div>
                <div class="modal-body img-responsive"  >
               
                </div>
               
              </div></a>
            </div>


                <a href="<?= base_url('membership')?>"><div class="modal-content" id="mobile-modal-content" style=" display: none;  position: absolute;left: 50%;top: 40%;transform: translate(-50%, -50%); background-image: url('<?= base_url('assets/mobile_offer_membership.jpg')?>'); background-size: cover; width: 360px;height: 346px; background-repeat: no-repeat;">
                <div class="modal-header" >
                  <button type="button" class="close membership-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body img-responsive" >
                 <div class="modal-body img-responsive"  >
                 
                 </div>
                </div>
               
              </div></a>
            </div>
          </div> -->

<!-- End Preloader  -->
<script type="text/javascript">
     page_name = '<?= $page_name?>';
   window.onbeforeunload = function() {
    var key = 'preloader';
    // if(page_name != 'home'){
        // console.log(page_name);
        localStorage.removeItem(key);
    // }
    
     return ;
   };
    $(".membership-close").click(function() {
        /* Act on the event */
        localStorage.setItem('preloader' , 'active');
    });

        $(document).ready(function(){
          // $("#preloader").modal('show').delay(7000).fadeIn(500);
            setTimeout(
              function() 
              {

                var pre = localStorage.getItem('preloader');
                
                //do something special
                if(page_name == 'home' && pre == null){
                    $("#preloader").modal('show');
                }
                
              }, 5000);

             // if (screen.width <= 800) {
             //    document.getElementById("mobile-modal-content").style.display = "block";
             //     document.getElementById("web-modal-content").style.display = "none";
             // }else{
             //    document.getElementById("web-modal-content").style.display = "block";
             //    document.getElementById("mobile-modal-content").style.display = "none";
             // }
        });
   $(window).scroll(function() {
       /* Act on the event */
       var docScroll = $(document).scrollTop();
       if(docScroll <= 90){
        $(".stickyfooter").slideUp();
       }else{
        $(".stickyfooter").slideDown();
       }
   });
</script>
<script type="text/javascript">
    user_id = '<?=$this->session->userdata('user_id')?>';

    if(localStorage.getItem('limit')){
        limit = localStorage.getItem('limit');
    } else {
        limit = 0;
    }
    var interval = setInterval(function(){
        if(limit >=20){
            limit = 0;
        }
        limit++;
        localStorage.setItem("limit", limit);
        repeat();

    }, 25000);


    function repeat(){
        if(user_id == null || user_id == ''){
           $.ajax({
               url: '<?=base_url('/rest/api/getLatestPaidUserInfo')?>',
               type: 'GET',
               dataType: 'json',
               data: {limit:limit},
               success:function(response){
                   for (var i = 0; i < response.length; i++) {
                           $("#name").text(response[i]['first_name'] +' ' + response[i]['last_name']);
                           $("#course").text(response[i]['title']);
                           var image1 = 'http://localhost/eduera/uploads/thumbnails/course_thumbnails/course_thumbnail_default_'+response[i]['course_id']+'.jpg';
                           var html = [
                          '<img src=' + image1 + ' class="rounded mr-2" alt="..." width="70" height="90">',

                           ].join('\n');
                           if(html != ''){
                               document.getElementById("toast-header").innerHTML = html;

                           }
                           course_link = '<?=base_url('course/')?>'+response[i]['slug'];
                           document.getElementById("course-link").setAttribute("href", course_link);
                   }
                   $('#alert_popover').fadeIn('fast').delay(4000).fadeOut(3000);

               }

           })
           .done(function() {
           })
           .fail(function() {
           })
           .always(function() {
           });
        }


    }
    function openForm() {
      document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
      document.getElementById("myForm").style.display = "none";
    }

    $('.hide-chat-box').click(function(){
        $('.chat-content').slideToggle();
    });
</script>