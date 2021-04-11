<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link rel="stylesheet" href="<?= base_url('assets/frontend/default/css/main.css')?>" />

<?php 
$user_country = $this->user_model->getUserInfoByIpAddress();

?>

<section class="page-header-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=site_url('home');?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#"><?="Shopping cart"?></a></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo "Shopping cart" ?></h1>
            </div>
        </div>
    </div>
</section>


<section class="cart-list-area">
    <div class="container">
        <div class="row" id = "cart_items_details">
            <div class="col-lg-7">

                <div class="in-cart-box">
                    <div class="title"><?php echo sizeof($this->session->userdata('cart_items')) . ' courses in cart.'; ?></div>


                    <?php if ($this->session->flashdata('remove_cart_item_message_alart')) {?>

                    <div class="alert alert-danger alert-dismissible show" role="alert">
                        <strong></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?=$this->session->flashdata('remove_cart_item_message_alart')?>
                    </div>

                    <?php }?>

                    <?php if ($this->session->flashdata('remove_cart_item_message_success')) {?>


                    <div class="alert alert-success alert-dismissible show" role="alert">
                        <strong></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?=$this->session->flashdata('remove_cart_item_message_success')?>
                    </div>

                    <?php }?>


                    <?php if ($this->session->flashdata('portwallet_error')) {?>

                    <div class="alert alert-danger alert-dismissible show" role="alert">
                        <strong></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?=$this->session->flashdata('portwallet_error')?>
                    </div>

                    <?php }?>


                    <?php if ($this->session->flashdata('portwallet_success')) {?>

                    <div class="alert alert-success alert-dismissible show" role="alert">
                        <strong></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?=$this->session->flashdata('portwallet_success')?>
                    </div>

                    <?php }?>

                    <div class="">
                        <ul class="cart-course-list">
                            <?php foreach ($cart_item_list as $cart_item) {
	?>

                                <li>
                                    <div class="cart-course-wrapper <?=(isset($cart_item->already_enrolled) && $cart_item->already_enrolled) ? 'shopping-cart-already-enrolled-course-bar' : ''?>">
                                        <div class="image">
                                            <a href="<?=base_url('course/' . $cart_item->slug)?>">
                                                <img src="<?php echo $this->course_model->get_course_thumbnail_url($cart_item->id); ?>" alt="" class="img-fluid">
                                            </a>
                                        </div>
                                        <div class="details">
                                            <a href="<?=base_url('course/' . $cart_item->slug)?>">
                                                <div class="name"><?=$cart_item->title?></div>
                                            </a>
                                            <div class="shopping-cart-bottom-buttons-group">
                                                <?php if ($this->session->userdata('user_type') === "USER" || $this->session->userdata('user_type') === "ADMIN" || $this->session->userdata('user_type') === "SUPER_ADMIN") {?>

                                                    <?php if ($cart_item->in_wishlist) {?>

                                                        <a style="background-color: green !important; font-weight: bold;"  class="save-wishlist  wishlist-button button-wishlist add_to_wishlist_<?=$cart_item->id?>"  onclick="add_to_wishlist(<?=$cart_item->id?>)">Already in wishlist</a >
                                                    <?php } else {?>
                                                        <a class="wishlist-button button-wishlist add_to_wishlist_<?=$cart_item->id?>"  onclick="add_to_wishlist(<?=$cart_item->id?>)">Save in wishlist</a>
                                                    <?php }?>

                                                <?php }?>
                                                <?php if ($cart_item->amount_to_pay == 0) {?>
                                                    <button onclick="enroll_in_a_course('<?=$cart_item->id?>')">Enroll now</button>
                                                <?php } else {?>
                                                    <button style="display: none" id="add_for_checkout_<?=$cart_item->id?>" onclick="add_for_checkout('<?=$cart_item->id?>')">Add for checkout</button>
                                                <?php }?>
                                                <a href="<?=base_url('home/remove_cart_item/' . $cart_item->id)?>">Remove from cart</a>
                                            </div>
                                        </div>
                                        <div class="price">
                                            <div class="current-price current_amount" id="" ><?php
                                            if ($cart_item->discount_flag) {
                                            		if ($cart_item->discounted_price == 0) {
                                            			echo "Free";
                                            		} else {
                                            			// echo currency($cart_item->discounted_price);
                                                        if(get_user_country() == 'bd' || get_user_country() == 'BD'){
                                                            echo currency($cart_item->discounted_price);

                                                           }else{
                                                                echo  get_course_discounted_price($cart_item->id);
                                                         }
                                            		}
                                            	} else {

                                                    if(get_user_country() == 'bd' || get_user_country() == 'BD'){
                                                       
                                                        echo currency($cart_item->price);


                                                       }else{
                                                        echo  get_course_price($cart_item->id);
                                                        }
                                                  
                                            		// echo currency($cart_item->price);
                                            	}
                                            	?></div>
                                            <span class="coupon-tag">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                            <?php if ($cart_item->discount_flag) {?>
                                                <div class="total-original-price">
                                                    <span class="original-price">
                                                        <!-- <?=  currency($cart_item->price) ?> -->
                                                        
                                                        <?php
                                                            if(get_user_country() == 'bd' || get_user_country() == 'BD'){
                                                               
                                                                echo currency($cart_item->price);


                                                           }else{
                                                            echo  get_course_price($cart_item->id);
                                                            }
                                                        ?>
                                                    </span>
                                                </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>

            </div>
            <?php if (count($cart_item_list) > 0) {?>
                <div class="col-lg-5 checkout-box">
                    <div class="cart-sidebar">
                        <div class="total">Total: <span id="title-total-price" style="font-size: 17px; color: #EC5252;"></span></div>
                        <?php $total_amount_to_pay = 0;?>
                        <table class="eduera-simple-table" id="checkout-table" style="font-size: 13px">

                        </table>
                        <button type="button" class="btn btn-primary btn-block checkout-btn" onclick="redirectToCheckout()">Checkout</button>
                       
                         <a onclick="redirectToPaypal()" href="#" class="paypal-buy-now-button btn-block">
                            <span>Buy now with</span> 
                            <svg aria-label="PayPal" xmlns="http://www.w3.org/2000/svg" width="90" height="33" viewBox="34.417 0 90 33">
                               <path fill="#253B80" d="M46.211 6.749h-6.839a.95.95 0 0 0-.939.802l-2.766 17.537a.57.57 0 0 0 .564.658h3.265a.95.95 0 0 0 .939-.803l.746-4.73a.95.95 0 0 1 .938-.803h2.165c4.505 0 7.105-2.18 7.784-6.5.306-1.89.013-3.375-.872-4.415-.972-1.142-2.696-1.746-4.985-1.746zM47 13.154c-.374 2.454-2.249 2.454-4.062 2.454h-1.032l.724-4.583a.57.57 0 0 1 .563-.481h.473c1.235 0 2.4 0 3.002.704.359.42.469 1.044.332 1.906zM66.654 13.075h-3.275a.57.57 0 0 0-.563.481l-.146.916-.229-.332c-.709-1.029-2.29-1.373-3.868-1.373-3.619 0-6.71 2.741-7.312 6.586-.313 1.918.132 3.752 1.22 5.03.998 1.177 2.426 1.666 4.125 1.666 2.916 0 4.533-1.875 4.533-1.875l-.146.91a.57.57 0 0 0 .562.66h2.95a.95.95 0 0 0 .939-.804l1.77-11.208a.566.566 0 0 0-.56-.657zm-4.565 6.374c-.316 1.871-1.801 3.127-3.695 3.127-.951 0-1.711-.305-2.199-.883-.484-.574-.668-1.392-.514-2.301.295-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.499.589.697 1.411.554 2.317zM84.096 13.075h-3.291a.955.955 0 0 0-.787.417l-4.539 6.686-1.924-6.425a.953.953 0 0 0-.912-.678H69.41a.57.57 0 0 0-.541.754l3.625 10.638-3.408 4.811a.57.57 0 0 0 .465.9h3.287a.949.949 0 0 0 .781-.408l10.946-15.8a.57.57 0 0 0-.469-.895z"></path>
                               <path fill="#179BD7" d="M94.992 6.749h-6.84a.95.95 0 0 0-.938.802l-2.767 17.537a.57.57 0 0 0 .563.658h3.51a.665.665 0 0 0 .656-.563l.785-4.971a.95.95 0 0 1 .938-.803h2.164c4.506 0 7.105-2.18 7.785-6.5.307-1.89.012-3.375-.873-4.415-.971-1.141-2.694-1.745-4.983-1.745zm.789 6.405c-.373 2.454-2.248 2.454-4.063 2.454h-1.031l.726-4.583a.567.567 0 0 1 .562-.481h.474c1.233 0 2.399 0 3.002.704.358.42.467 1.044.33 1.906zM115.434 13.075h-3.272a.566.566 0 0 0-.562.481l-.146.916-.229-.332c-.709-1.029-2.289-1.373-3.867-1.373-3.619 0-6.709 2.741-7.312 6.586-.312 1.918.131 3.752 1.22 5.03 1 1.177 2.426 1.666 4.125 1.666 2.916 0 4.532-1.875 4.532-1.875l-.146.91a.57.57 0 0 0 .563.66h2.949a.95.95 0 0 0 .938-.804l1.771-11.208a.57.57 0 0 0-.564-.657zm-4.565 6.374c-.314 1.871-1.801 3.127-3.695 3.127-.949 0-1.711-.305-2.199-.883-.483-.574-.666-1.392-.514-2.301.297-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.501.589.699 1.411.554 2.317zM119.295 7.23l-2.807 17.858a.569.569 0 0 0 .562.658h2.822c.469 0 .866-.34.938-.803l2.769-17.536a.57.57 0 0 0-.562-.659h-3.16a.571.571 0 0 0-.562.482z"></path>
                            </svg>
                            <span id="usd_amount">()</span>
                         </a>
                        <!-- <button type="button"  onclick="redirectToPaypal()">Pay with Paypal</button> -->
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</section>

<script type="text/javascript">
 
    var courses = JSON.parse('<?=json_encode($cart_item_list)?>');
    var courses_to_pay = [];
    var total_amount_to_pay = 0;

    for(var i = 0; i < courses.length; i++){
        if (!courses[i].already_enrolled) {
            courses_to_pay.push(courses[i]);
        }
    }


    function enroll_in_a_course(course_id){
        window.location = '<?=base_url('home/enroll_user_in_a_free_course/')?>' + course_id;
    }

    function remove_from_toPay_list(course_id){
        for (var i = 0; i < courses_to_pay.length; i++){
            if (courses_to_pay[i].id == course_id){
                courses_to_pay.splice(i, 1);
                break;
            }
        }

        $("#add_for_checkout_" + course_id).show();

        generate_table();
    }



    function add_for_checkout(course_id){
        for (var i = 0; i < courses.length; i++){
            if (courses[i].id == course_id){
                courses_to_pay.push(courses[i]);
                break;
            }
        }
        $("#add_for_checkout_" + course_id).hide();
        generate_table();
    }


    function change_percentage(element, course_id){

        for(var i = 0; i < courses_to_pay.length; i++){
            if (courses_to_pay[i].id == course_id){
                courses_to_pay[i].percentage_to_pay = $(element).val();
                break;
            }
        }

        generate_table();
    }

    price = '<?=get_currency_price()?>';

    function generate_table(){
        country = '<?=get_user_country()?>';
        sign = '';
        if(country == 'BD' || country == 'bd'){
            sign = '';
        }else{
            sign = '$ ';
        }


        total_amount_to_pay = 0;
        var table_html =
        '<tr>' +
        '<th></th>' +
        '<th>Course</th>' +
        '<th>Percentage</th>' +
        '<th width="15%">Price</th>' +
        '</tr>';

        if (courses_to_pay.length > 0){
            for( var i = 0; i < courses_to_pay.length; i++){
                disabled = '';
                if(courses_to_pay[i].coupon_amount > 0){
                    disabled = 'disabled';
                }
                courses_to_pay[i].amount_to_pay_now = (courses_to_pay[i].percentage_to_pay * courses_to_pay[i].amount_to_pay) / 100;
                table_html +=
                '<tr>' +
                '<td><i class="fa fa-trash" onclick="remove_from_toPay_list(' + courses_to_pay[i].id + ')"></td>' +
                '<td>' + courses_to_pay[i].title + '</td>' +
                '<td>' +
                '<select class="shopping-cart-percent-select-field " onchange="change_percentage(this, ' + courses_to_pay[i].id + ')">' +
                '<option '+disabled+' value="25"';

                if (courses_to_pay[i].percentage_to_pay == 25){
                    table_html += ' selected '+disabled+'';
                }

                table_html += '>25%</option>' +
                '<option '+disabled+' value="50"';

                if (courses_to_pay[i].percentage_to_pay == 50){
                    table_html += ' selected '+disabled+'';
                }

                table_html += '>50%</option>' +
                '<option value="100"';

                if (courses_to_pay[i].percentage_to_pay == 100){
                    table_html += ' selected';
                }

                table_html += '>100%</option>' +
                '</select>' +
                '</td>' +
                '<td>' + sign + Math.round(courses_to_pay[i].amount_to_pay_now) + '</td>' +
                '</tr>';
                if(courses_to_pay[i].coupon_amount > 0){
                    total_amount_to_pay += courses_to_pay[i].amount_to_pay_now - Math.round(courses_to_pay[i].coupon_amount);
                }else{
                    total_amount_to_pay += Math.round(courses_to_pay[i].amount_to_pay_now);
                }

                if(courses_to_pay[i].coupon_amount > 0){



                    table_html +=
                    '<tr>'+
                    '<td colspan="2">Coupon for '+ courses_to_pay[i].title  + '</td>' +
                    '<td>'+  courses_to_pay[i].coupon_discount +' '+courses_to_pay[i].discount_type+'</td>'+
                    '<td>'+sign  +  Math.round(courses_to_pay[i].coupon_amount) +'</td>'+
                    '</tr>';

                    courses_to_pay[i].amount_to_pay = Math.round(courses_to_pay[i].amount_to_pay -
                    courses_to_pay[i].coupon_amount);
                    courses_to_pay[i].amount_to_pay_now = Math.round(courses_to_pay[i].amount_to_pay_now -
                    courses_to_pay[i].coupon_amount);
                }

            }
        } else {
            table_html += '<tr><td colspan="4" style="text-align: center;">No course to checkout.</td></tr>';
        }


        usdCurrency = '';
        table_html +=
        '<tr>' +
        '<td colspan="2">Total</td>' +
        '<td></td>' +
        '<td>' + sign + total_amount_to_pay + '</td>' +
        '</tr>';
        if(country == 'BD' || country == 'bd'){
            currency = ' BDT';
            usdCurrency = '('+(total_amount_to_pay.toFixed(2)/price).toFixed(0)+'  USD' + ')';
        }else{
            currency = ' USD';
           
        }

        
        
        $("#title-total-price").html(total_amount_to_pay.toFixed(0) + currency + usdCurrency);
        if(country == 'BD' || country == 'bd'){
            $("#usd_amount").text( ' ('+Math.round(total_amount_to_pay.toFixed(2)/price) + ' USD )');
        }else{
            $("#usd_amount").text( ' ('+(total_amount_to_pay.toFixed(0)) + ' USD )');
        }
        

        $(".checkout-box #checkout-table").html(table_html);
    }


    function redirectToCheckout(){

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('rest/api/set_checkout_details'); ?>",
            data: {"courses": courses_to_pay, "total_amount_to_pay": total_amount_to_pay},
            success: function(response){
                if (response == "1"){
                    window.location = "<?=base_url('portwallet/checkout/shopping_cart')?>";
                }else{
                    window.location = "<?=base_url('home/shopping_cart?payment_error=invalid')?>";
                }
            },
            error: function (request, status, error) {
            }
        })



    }

    function redirectToPaypal(){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('rest/api/set_checkout_details'); ?>",
            data: {"courses": courses_to_pay, "total_amount_to_pay": total_amount_to_pay},
            success: function(response){
                if (response == "1"){
                    window.location = "<?=base_url('home/paypal/shopping_cart_paypal')?>";
                }else{
                    window.location = "<?=base_url('home/shopping_cart?payment_error=invalid')?>";
                }
            },
            error: function (request, status, error) {
            }
        })
    }


  


    $(document).ready(function(){
        generate_table();
    });

    function add_to_wishlist(course_id){

        $.ajax({
            url : "<?php echo base_url('/user/add_to_wishlist'); ?>",
            type : "POST",
            data: { course_id : course_id },
            success : function(data) {
                var json = JSON.parse(data);
                if(json.action == 'Added'){
                    $(".add_to_wishlist_"+course_id).text('Already in wishlist');
                    $(".add_to_wishlist_"+course_id).css("background-color", "green");
                    $("#wishlist_count").text(json.count);
                }else{
                    $(".add_to_wishlist_"+course_id).text('Save in wishlist');
                    $(".add_to_wishlist_"+course_id).css("background-color", "#EC5252");
                    $("#wishlist_count").text(json.count);
                }


            },
            error : function(data) {
            // do something
            }
        });
    }
</script>

