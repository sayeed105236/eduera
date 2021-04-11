<!-- Modal -->
<div class="modal fade" id="make_payment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Make payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger alert-dismissible hide" role="alert" id="checkout_form_error_message" style="display: none;">
                    <strong></strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <span class="message"></span>
                </div>
                <div class="form-group row" id="add_question_option_row_0">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="select_course" id="select_course_field">
                            <option value="-1">Select course</option>
                            <?php foreach ($course_list as $course) { ?>
                                <option value="<?= $course->id ?>" id="option_<?= $course->id ?>" <?php if ( $course->enrolled_price == 0 || ($course->paid_amount >= $course->enrolled_price) ) { echo 'disabled'; } ?>><?= $course->title ?></option>
                            <?php } ?>
                        </select>
                    </div> 
                    <div class="col-md-1 col-sm-1 col-xs-12">
                        <button type="button"  onclick="add_course_for_checkout()" class="btn btn-success btn-sm" name="button"> 
                        <i class="fa fa-plus"></i> 
                        </button> 
                    </div>
                </div>

                <table class="eduera-simple-table" id="checkout-table" style="font-size: 13px">                        
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="redirectToCheckout()">Checkout</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var courses = JSON.parse('<?= json_encode($course_list) ?>');
    var courses_to_pay = [];
    var total_amount_to_pay = 0;


    function add_course_for_checkout(){
        var selected_course_id = $("#select_course_field").val();
        for (var i = 0; i < courses_to_pay.length; i++){
            if (courses_to_pay[i].id == selected_course_id){
                $("#checkout_form_error_message span.message").html("Course already choosen");
                $("#checkout_form_error_message").show().delay(4000).fadeOut();
                return;
            }
        }

        for(var i = 0; i < courses.length; i++){
            if (courses[i].id == selected_course_id){
                courses_to_pay.push(courses[i]);
                break;
            }
        }
        generate_table();     
        
    }

    function remove_from_toPay_list(course_id){
        console.log(courses);
        
        for (var i = 0; i < courses.length; i++){
            if (courses[i].id == course_id){
                courses.splice(i, 1);
                break;
            }
        }

        generate_table();
    }


    function change_percentage(element, course_id){

        for(var i = 0; i < courses.length; i++){
            if (courses[i].id == course_id){
                courses[i].percentage_to_pay = $(element).val();
                break;
            }
        }

        generate_table();
    }


    function generate_table(){
        total_amount_to_pay = 0;
        var table_html = 
        '<tr>' +
            '<th></th>' +
            '<th>Course</th>' +
            '<th>Percentage</th>' +
            '<th>Price</th>' +
        '</tr>';

        if (courses_to_pay.length > 0){
            for( var i = 0; i < courses_to_pay.length; i++){

                if (courses_to_pay[i].percentage_to_pay == '-1'){
                    courses_to_pay[i].amount_to_pay_now = courses_to_pay[i].enrolled_price - courses_to_pay[i].paid_amount;
                } else {
                    courses_to_pay[i].amount_to_pay_now = (courses_to_pay[i].percentage_to_pay * courses_to_pay[i].enrolled_price) / 100;
                }
                
                table_html += 
                '<tr>' +
                    '<td><i class="fa fa-trash" onclick="remove_from_toPay_list(' + courses_to_pay[i].id + ')"></td>' +
                    '<td>' + courses_to_pay[i].title + '</td>' +
                    '<td>' +
                        '<select class="shopping-cart-percent-select-field" onchange="change_percentage(this, ' + courses_to_pay[i].id + ')">' +
                            '<option value="25"';

                            if (courses_to_pay[i].percentage_to_pay == 25){
                                table_html += ' selected';
                            }

                            table_html += '>25%</option>' +
                            '<option value="50"';

                            if (courses_to_pay[i].percentage_to_pay == 50){
                                table_html += ' selected';
                            }

                            table_html += '>50%</option>' +
                            '<option value="100"';

                            if (courses_to_pay[i].percentage_to_pay == 100){
                                table_html += ' selected';
                            }

                            table_html += '>100%</option>' +

                            '<option value="-1"';

                            if (courses_to_pay[i].percentage_to_pay == -1){
                                table_html += ' selected';
                            }

                            table_html += '>Remaining</option>' +
                        '</select>' +
                    '</td>' +
                    '<td>' + courses_to_pay[i].amount_to_pay_now + '</td>' +
                '</tr>';
                total_amount_to_pay += courses_to_pay[i].amount_to_pay_now;
            }
        } else {
            table_html += '<tr><td colspan="4" style="text-align: center;">No course to checkout.</td></tr>';
        }

        table_html += 
        '<tr>' +
            '<td colspan="2">Total</td>' +
            '<td></td>' +
            '<td>' + total_amount_to_pay + '</td>' +
        '</tr>';

        // $("#title-total-price").html(total_amount_to_pay.toFixed(2) + ' BDT');

        $("#checkout-table").html(table_html);
    }


    function redirectToCheckout(){

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('rest/api/set_checkout_details'); ?>",
            data: {courses: courses_to_pay, total_amount_to_pay: total_amount_to_pay},
            success: function(response){
                if (response == "1"){
                    window.location = "<?= base_url('portwallet/checkout/payment_history') ?>"
                }
            },
            error: function (request, status, error) {
            }
        })


        
    }


    $(document).ready(function(){
        generate_table();
    });
</script>