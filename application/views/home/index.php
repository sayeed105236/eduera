<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="stylesheet" href="<?= base_url('assets/vendors/owl/css/owl.carousel.min.css')?>" /> <!-- owl carousel css -->
<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<section id="categories-tab" class="categories-tab-main-block">
    <div class="container">
        <div id="categories-tab-slider" class="categories-tab-block owl-carousel">
           
            <?php foreach($categories as $cat){?>
                <div class="item categories-tab-dtl">
                    <a href="<?php echo base_url('courses?category=' . $cat->id) ?>" title=""><i class="fa fa-ball"></i><?= $cat->name?></a>
             </div>
            <?php } ?>
        </div>
    </div>
</section>
<script src="<?= base_url('assets/vendors/owl/js/owl.carousel.min.js') ?>"></script> <!-- owl carousel js --> 


<section class="home-banner-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <div class="home-banner-wrap">
                    <div class="home-text">
                        <h2>Learn on your schedule</h2>
                        <p>Study any topic, anytime. Explore lots of courses for the lowest price ever!</p>
                    </div>
                    <form class="" action="<?php echo base_url('home/courses'); ?>" method="get">
                        <div class="input-group search-button">
                            <input type="text" class="form-control " name = "query" placeholder="What are you looking for?">
                            <div class="input-group-append">
                                <button class="btn search-button" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="home-fact-area">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-auto mr-auto">
                    <i class="fas fa-bullseye float-left"></i>
                    <div class="text-box">
                        <h4><span class="count"><?=count($course_list)?></span> online courses</h4>
                        <p>Explore a variety of topics</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-auto mr-auto">
                    <i class="fa fa-check float-left"></i>
                    <div class="text-box">
                        <h4>Expert instruction</h4>
                        <p>Find the right courses for you</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex">
                <div class="home-fact-box mr-md-auto ml-auto mr-auto">
                    <i class="fa fa-clock float-left"></i>
                    <div class="text-box">
                        <h4>Learn from industry experts</h4>
                        <p>Learn on your schedule</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
                    
    <?php 
        $this->load->view('courses/student_enrolled_courses.php');
        foreach($home_page_setting as $home){
             $this->load->view('courses/'.$home->slug.'_courses.php');
        }
    ?>
    
<!-- /flex-container -->
     
   
</section>


<script>

  $(".tile-secondary-content").on('click',  function(event) {
      event.preventDefault();

    window.location.href = event.currentTarget.previousElementSibling.href;

      /* Act on the event */
  });
  
   user_country =  '<?= $user_address?>';
   currencies =  JSON.parse('<?=json_encode($currency_data)?>');
   courses =  '<?= json_encode($courses_list)?>';
   course_list = JSON.parse(courses);

   for(var i = 0; i < course_list.length; i++){
    if(course_list[i].discount_flag == 1){
        if(user_country == 'bd' || user_country == 'BD' || user_country == ''){
            $(".discounted_price_"+course_list[i].id).append('<small>'+course_list[i].price+'</small>' + course_list[i].discounted_price);
        }else{
            $(".discounted_price_"+course_list[i].id).append('<small>'+get_usd_price(course_list[i].price)+'</small>' + get_usd_price(course_list[i].discounted_price));
        }
    }else if(course_list[i].discount_flag == 0 && course_list[i].price == 0 && course_list[i].discounted_price == 0){
       $(".price_"+course_list[i].id).append('Free');
    }else{
        if(user_country == 'bd' || user_country == 'BD' || user_country == ''){
            $(".price_"+course_list[i].id).append(course_list[i].price);
            // if(course_list[i].id == 70){
            //     $("#price_"+course_list[i].id).append('$363');
            // }else{
            //     $("#price_"+course_list[i].id).append(course_list[i].price);
            // }
        }else{
            $(".price_"+course_list[i].id).append(get_usd_price(course_list[i].price));

        }
    }
    
   }
    screenWidth = $(window).width();
    screenHeight = $(window).height();

    $(document).ready(function(){
        if (screenWidth <= 768){
            $(".course-block").removeClass("has-popover");
        } else {
            $(".course-block").addClass("has-popover");
        }
    })

    window.onresize = function(event) {
        screenWidth = $(window).width();
        screenHeight = $(window).height();
        if (screenWidth <= 768){
            $(".course-block").removeClass("has-popover");
        } else {
            $(".course-block").addClass("has-popover");
        }
    };

    function handleCartItems(elem) {
        url1 = '<?php echo site_url('rest/api/add_to_cart'); ?>';
        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : $(elem).attr('course_id')},
            success: function(response) {
                // console.log(JSON.parse(response));
                result = JSON.parse(response);
                //if (result.success){
                    $('#cart_items_number').html(result.cart_items_count);
                    $(elem).addClass('addedToCart');
                    // $(elem).text("This course is in cart");
                    $(".addToCart").hide();
                    $(".cart").append("<a class='btn btn-add-cart btn-block  addedToCart' href='<?=base_url('/home/shopping_cart')?>'>Go to cart</a>");

                //}
            }
        });
    }


    function buy_now_course(course_id){
        url1 = '<?php echo site_url('rest/api/add_to_cart'); ?>';
        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : course_id},
            success: function(response) {
                result = JSON.parse(response);
                window.location = '<?=base_url("home/shopping_cart")?>';
            }
        });
    }


function get_usd_price(price){

    return  currencies.sign+''+Math.round(price/currencies.value);
}




$("#categories-tab-slider").owlCarousel({
  loop: true,
  items: 6,
  dots: false,
  nav: true,      
  autoplayTimeout: 10000,
  smartSpeed: 2000,
  autoHeight: false,
  touchDrag: true,
  mouseDrag: true,
  margin: 20,
  autoplay: true,
  slideSpeed: 600,
  navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
  responsive: {
    0: {
        items: 2,
        nav: false,
        dots: false,
    },
    600: {
        items: 3,
        nav: false,
        dots: false,
    },
    768: {
        items: 3,
        nav: true,
        dots: false,
    },
    1100: {
        items: 4,
        nav: false,
        dots: false,
    }
  }
});

$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
</script>