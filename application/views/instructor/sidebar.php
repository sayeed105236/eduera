<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
               <h4 class="resp-side"><a href="<?= base_url('/home')?>"> <img style="padding-right: 10px;" src="<?php echo base_url() . 'uploads/system/eduera-favicon.png' ?>" width="40px"/>Eduera</a></h4>
                <strong><img  src="<?php echo base_url() . 'uploads/system/eduera-favicon.png' ?>" width="40px"/></strong>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="<?= base_url('/instructor')?>"  aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-home"></i>
                        Dashboard
                    </a>
                </li>    
                  <!--   <ul class="collapse list-unstyled" id="homeSubmenu">
                        <li>
                            <a href="#">Home 1</a>
                        </li>
                        <li>
                            <a href="#">Home 2</a>
                        </li>
                        <li>
                            <a href="#">Home 3</a>
                        </li>
                    </ul> -->
                <!-- </li>
                <li>
                    <a href="#">
                        <i class="fas fa-briefcase"></i>
                        About
                    </a>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-copy"></i>
                        Pages
                    </a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#">Page 1</a>
                        </li>
                        <li>
                            <a href="#">Page 2</a>
                        </li>
                        <li>
                            <a href="#">Page 3</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-image"></i>
                        Portfolio
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-question"></i>
                        FAQ
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-paper-plane"></i>
                        Contact
                    </a>
                </li> -->
            </ul>

           
        </nav>



        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <!-- <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button> -->
                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class=" ml-auto">
                           <!--  <li class="nav-item active">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li> -->
                            <li class="nav-item">
                                <?php if ($this->session->userdata('user_type') !== null) {?>
                                   <div class="user-box menu-icon-box">
                                       <div class="icon">
                                           <a href="javascript::">
                                               <?php if ($user_data->profile_photo_name === null || $user_data->profile_photo_name === "") {?>
                                                   <img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="img-fluid">
                                               <?php } else {?>
                                                   <img src="<?php echo base_url() . 'uploads/user_image/' . $user_data->profile_photo_name; ?>" alt="" class="img-fluid">
                                               <?php }?>
                                           </a>
                                       </div>
                                       <div class="dropdown user-dropdown corner-triangle top-right">
                                           <ul class="user-dropdown-menu">

                                               <li class="dropdown-user-info">
                                                   <a href="<?=base_url('user/profile')?>">
                                                       <div class="clearfix">
                                                           <div class="user-image float-left">
                                                               <img src="<?php echo base_url() . 'uploads/user_image/placeholder.png'; ?>" alt="" class="img-fluid">
                                                           </div>
                                                           <div class="user-details">
                                                               <div class="user-name">
                                                                   <span class="hi">Hi,</span>
                                                                   <?=$this->session->userdata('name')?>
                                                               </div>
                                                               <div class="user-email">
                                                                   <span class="email"><?=$this->session->userdata('email')?></span>
                                                                   <span class="welcome">Welcome back</span>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </a>
                                               </li>

                                               <li class="user-dropdown-menu-item"><a href="<?=base_url('user/my_courses')?>"><i class="far fa-gem"></i> My courses</a></li>
                                               <li class="user-dropdown-menu-item"><a href="<?=base_url('user/wishlist')?>"><i class="far fa-heart"></i>My Wishlist</a></li>
                                               <li class="user-dropdown-menu-item"><a href="<?php echo site_url('user/my_messages'); ?>"><i class="far fa-envelope"></i>My Messages</a></li>
                                               <li class="user-dropdown-menu-item"><a href="<?php echo site_url('user/profile'); ?>"><i class="far fa-user-circle"></i>My Profile</a></li>

                                               <li class="dropdown-user-logout user-dropdown-menu-item"><a href="<?=base_url('login/logout')?>">Log out</a></li>
                                           </ul>
                                       </div>
                                   </div>

                               <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>