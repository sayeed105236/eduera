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

<section id="cover" class="min-vh-100">
    <div id="cover-caption">
        <div class="container">
            <div class="row text-white">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto text-center form p-4">
                    <h1 class="display-4 py-2 text-truncate"></h1>
                    <div class="px-2">
                        <div class="form-group" style="margin-top: 20px;">
                            <?php echo validation_errors(); ?>

                            <?php if ($this->session->flashdata('reset_password_success_message')) { ?>

                            <div class="alert alert-success alert-dismissible fade show form-control" role="alert" style="height: auto">
                                <strong></strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?= $this->session->flashdata('reset_password_success_message') ?>
                            </div>

                            <?php } ?>


                            <?php if ($this->session->flashdata('reset_password_failed_message')) { ?>

                            <div class="alert alert-danger alert-dismissible fade show form-control" role="alert" style="height: auto">
                                <strong></strong> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <?= $this->session->flashdata('reset_password_failed_message') ?>
                            </div>

                            <?php } ?>

                        </div>
                        <form action="<?= base_url('home/forgot_password')?>" method="post" class="justify-content-center">
                            <div class="form-group">
                                <label class="sr-only">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter your email">
                            </div>
                          
                            <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
