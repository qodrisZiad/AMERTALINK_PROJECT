<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="#" class="site_title"><i class="fa fa-paw"></i> <span><?= SITE_TITLE;?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo site_url()?>assets/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?= $greeting;?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu --> 
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <?php  
                    $menu = $this->session->userdata('menu');
                    $submenu = $this->session->userdata('submenu');
                    foreach ($menu as $hasil_menu) { ?> 
                          <li>
                            <?php if($hasil_menu->fc_link == "#"){ ?>
                              <a>
                            <?php }else{
                              echo '<a href="'.base_url().$hasil_menu->fc_link.'">';
                              } ?>
                              <i class="fa <?php echo $hasil_menu->fv_class; ?>"></i><?php echo $hasil_menu->fv_menu; ?><span id="a_<?php echo $hasil_menu->fc_idmenu; ?>"></span></a>
                            <ul class="nav child_menu">
                              <?php foreach ($submenu as $hasil_submenu) {
                                if ($hasil_submenu->parent == $hasil_menu->fc_idmenu) {
                                  echo '<li><a href="'.base_url(). ucfirst($hasil_submenu->fc_link) .'">'.$hasil_submenu->fv_menu.'</a></li>
                                        <script type="text/javascript">
                                            $("#a_'.$hasil_submenu->parent.'").addClass("fa fa-chevron-down");
                                        </script>
                                  ';
                                }
                              } ?>
                            </ul>
                          </li>
                        <?php 
                    }
                    ?>
                    <li><a href="<?php echo base_url()?>/Login/logout"><i class="fa fa-lock"></i>Logout</a></li>
                </ul>
              </div> 
            </div>
            <!-- /sidebar menu --> 

          </div>
        </div>
        <!-- top navigation -->
          <div class="top_nav">
            <div class="nav_menu">
              <nav class="" role="navigation">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>

                <ul class="nav navbar-nav navbar-right">
                  <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <img src="<?= site_url().'assets/images/logo2.png'; ?>" alt="">John Doe
                      <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                      <li><a href="javascript:;">  Profile</a>
                      </li>
                      <li>
                        <a href="javascript:;">
                          <span class="badge bg-red pull-right">50%</span>
                          <span>Settings</span>
                        </a>
                      </li>
                      <li>
                        <a href="javascript:;">Help</a>
                      </li>
                      <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                      </li>
                    </ul>
                  </li>

                  <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope-o"></i>
                      <span class="badge bg-green">6</span>
                    </a>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                      <li>
                        <a>
                          <span class="image">
                                            <img src="images/img.jpg" alt="Profile Image" />
                                        </span>
                          <span>
                                            <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                        </span>
                        </a>
                      </li>
                      <li>
                        <a>
                          <span class="image">
                                            <img src="images/img.jpg" alt="Profile Image" />
                                        </span>
                          <span>
                                            <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                        </span>
                        </a>
                      </li>
                      <li>
                        <a>
                          <span class="image">
                                            <img src="images/img.jpg" alt="Profile Image" />
                                        </span>
                          <span>
                                            <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                        </span>
                        </a>
                      </li>
                      <li>
                        <a>
                          <span class="image">
                                            <img src="images/img.jpg" alt="Profile Image" />
                                        </span>
                          <span>
                                            <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                        </span>
                        </a>
                      </li>
                      <li>
                        <div class="text-center">
                          <a href="inbox.html">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                          </a>
                        </div>
                      </li>
                    </ul>
                  </li>

                </ul>
              </nav>
            </div>
          </div>
        <!-- /top navigation -->

    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3><?php echo $bread;?><small><?php echo $sub_bread;?></small></h3>
          </div> 
          </div>
        </div>