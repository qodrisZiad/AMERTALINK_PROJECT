<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="#" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $title;?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?php echo site_url()?>assets/user.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $greeting;?></h2>
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
                    $query_submenu = getSubmenu();
                    foreach (getMenu()->result() as $hasil_menu) { ?> 
                          <li>
                            <?php if($hasil_menu->fc_link == "#"){ ?>
                              <a>
                            <?php }else{
                              echo '<a href="'.base_url().$hasil_menu->fc_link.'">';
                              } ?>
                              <i class="fa <?php echo $hasil_menu->fv_class; ?>"></i><?php echo $hasil_menu->fv_menu; ?><span id="a_<?php echo $hasil_menu->fc_idmenu; ?>"></span></a>
                            <ul class="nav child_menu">
                              <?php foreach ($query_submenu->result() as $hasil_submenu) {
                                if ($hasil_submenu->parent == $hasil_menu->fc_idmenu) {
                                  echo '<li><a href="'.base_url().$hasil_submenu->fc_link.'">'.$hasil_submenu->fv_menu.'</a></li>
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
            <!-- /menu footer buttons -->
          </div>
        </div> 
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3><?php echo $bread;?><small><?php echo $sub_bread;?></small></h3>
          </div> 
          </div>
        </div>