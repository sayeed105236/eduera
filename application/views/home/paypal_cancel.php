<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<section class="cart-list-area">
    <div class="container">
        <div class="row" id = "cart_items_details">
            <div class="col-lg-7">

                <div class="in-cart-box">
                    <div class="title">
                       
                        </div>


                    <?php if ($this->session->flashdata('paypal_cancel')) {?>

                    <div class="alert alert-danger alert-dismissible show" role="alert">
                        <strong></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?=$this->session->flashdata('paypal_cancel')?>
                    </div>

                    <?php }?>

              

                </div>

            </div>
          
        </div>
    </div>
</section>