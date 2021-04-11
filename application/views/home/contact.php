<meta name="viewport" content="width=device-width, initial-scale=1.0"> 

<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?php echo $page_title;; ?>
                            </a>
                        </li>
                    </ol>
                </nav>
                <h1 class="category-name">
                    <?php echo $page_title; ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container">
        <div class="row">
            <div class="col" style="padding: 35px;">
                <div class="contact-header">
                    <h3>Find and contact eduera</h3>
                    <hr>
                    <h6 style="font-style: ;">We would love to answer any questions and hear any comments you might have!</h6>
                </div>
                <div class="contact-form">

                    <div class="row ">
                       
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                            <div class="form-group" style="margin-top: 20px;">
                                <?php echo validation_errors(); ?>

                                <?php if ($this->session->flashdata('contact_success_message')) { ?>

                                <div class="alert alert-success alert-dismissible fade show form-control" role="alert" style="height: auto">
                                    <strong></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?= $this->session->flashdata('contact_success_message') ?>
                                </div>

                                <?php } ?>


                                <?php if ($this->session->flashdata('contact_failed_message')) { ?>

                                <div class="alert alert-danger alert-dismissible fade show form-control" role="alert" style="height: auto">
                                    <strong></strong> 
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <?= $this->session->flashdata('contact_failed_message') ?>
                                </div>

                                <?php } ?>

                            </div>
                            <form method="post" action="<?= base_url('home/contact') ?>"> 
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id="name" value="" placeholder="Full Name" required="">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" id="email" value="" placeholder="Email" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="Phone No." required="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <textarea  class="form-control fixed-height" cols="80" name="message" minlength="20" maxlength="500" id="message" placeholder="Type your message" required=""></textarea>
                                </div>
                                <p class="text-center"> <button type="submit" class="btn btn-block  " id="submit"> Submit your query </button></p>
                            </form>
                        </div>
                        
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                            <div class="gmap">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.2415453543035!2d90.41276111450264!3d23.774411493776583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c782948ffbf9:0xe43c376a71bfb570!2zR2xvYmFsIFNraWxscyBEZXZlbG9wbWVudCBBZ2VuY3kg4KaX4KeN4Kay4KeL4Kas4Ka-4KayIOCmuOCnjeCmleCmv-CmsuCmuCDgpqHgp4fgpq3gp4fgprLgpqrgpq7gp4fgpqjgp43gpp8g4KaP4Kac4KeH4Kao4KeN4Ka44Ka_!5e0!3m2!1sen!2sbd!4v1583831567893!5m2!1sen!2sbd&fbclid=IwAR1rWj8VUquBV4gYJh-eIdkWrCUhRwaVZAvrsc0d38YpUq7HTyrQFHkVTbo" allowfullscreen="" width="100%" frameborder="0"></iframe>
                            </div>

                          
                            <table class="table address-table">
                                <tbody><tr>
                                    <td class="fixed"> <i class="fa fa-map-marker"></i> </td>
                                    <td class="bold-address">
                                      <!--  Hayat Rose Park
                                       Level 5, House No 16
                                       Main Road, Bashundhara Residential Area
                                       Dhaka 1229. Dhaka, Bangladesh -->
                                       <?= $system_settings['address']?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fixed"> <i class="fa fa-envelope"></i> </td>
                                    <td class="bold-address"> <?= $system_settings['contact_email'] ?></td>
                                </tr>
                                <tr>
                                    <td class="fixed"> <i class="fa fa-phone-square"></i> </td>
                                    <td class="bold-address">
                                        <?= $system_settings['phone'] ?>
                                    </td>
                                </tr>
                            </tbody></table>
                            <div class="social-profile">
                                <ul class="nav list-unstyled list-inline contact-social-list">
                                    
                                    <li class="nav-item" > <a style="color: #3b5998" title="Connect with Facebook" href="https://www.facebook.com/eduera.com.bd/" class="" target="_blank"><i class="fab fa-facebook-square"></i></a> </li>

                                    <li class="nav-item" > <a style="color: #00acee" title="Connect with Twitter" href="https://twitter.com/eduera_bd" class=" " target="_blank"><i class="fab fa-twitter-square"></i> </a></li>

                                    <li class="nav-item" > <a style="color: #c4302b" title="Connect with Youtube" href="https://www.youtube.com/channel/UCqXuPKd1YWx-icu7UGsDxdQ?" class="" target="_blank"> <i class="fab fa-youtube-square"></i></a> </li>

                                    <li class="nav-item"> <a style="color: #0e76a8" title="Connect with Linkedin" href="https://www.linkedin.com/in/eduera/" class="" target="_blank"><i class="fab fa-linkedin"></i></a> </li>

                                    <li class="nav-item"> <a style="color: #c8232c" title="Connect with Pinterest" href="https://www.pinterest.com/eduerabd/" class="" target="_blank"> <i class="fab fa-pinterest-square"></i> </a></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>
