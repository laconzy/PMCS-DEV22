<!-- Navigation -->
<aside id="menu">
    <div id="navigation">
        <div class="profile-picture">
            <a href="#">
                <img src="<?php echo base_url(); ?>assets/img/users/<?php echo $this->session->userdata('image_name'); ?>" class="img-circle m-b" alt="logo" width="80" height="80">
            </a>

            <div class="stats-label text-color">
                <span class="font-extra-bold "><?php echo $this->session->userdata('dtx_name_initials'); ?></span>

                <div class="dropdown">




                    <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                        <small class="text-muted">Profile Options <b class="caret"></b></small>
                    </a>
                    <ul class="dropdown-menu animated flipInX m-t-xs">
                        <li><a href="<?php echo base_url(); ?>index.php/user/user_account">Profile</a></li>
                        <!--<li><a href="analytics.html">Settings</a></li>-->
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo base_url(); ?>index.php/login/user_logout"> Logout
                            </a>

                            <form id="logout-form" action="" method="POST" style="display: none;">

                            </form>
                        </li>
                    </ul>
                </div>


                <div id="sparkline1" class="small-chart m-t-sm"></div>
                <!--<div>
                    <h4 class="font-extra-bold m-b-xs">
                        $260 104,200
                    </h4>
                    <small class="text-muted">Your income from the last year in sales product X.</small>
                </div>-->
            </div>
        </div>

        <ul class="nav" id="side-menu">




             <?php
                foreach($menus as $menu){
                    if($menu['has_sub_menus'] == 'N'){
                        echo '<li>'
                        . '<a href="'.base_url().$menu['menu_url'].'"> '
                        . '<span >'.$menu['menu_name'].'</span>'
                        . '</a>'
                        . '</li>';
                    }
                    else{
                        if(sizeof($menu['sub_menus']) > 0){
                            $activeClass = (isset($menu_code) && $menu['menu_code'] == $menu_code) ? 'active' : '';
                            $str = '<li class="'.$activeClass.'">
                                    <a href="'.base_url().$menu['menu_url'].'">
                                    <span>'.$menu['menu_name'].'</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="nav nav-second-level">';
                            foreach ($menu['sub_menus'] as $sub_menu){
                                $str .= '<li>'
                                    . '<a href="'.base_url().$sub_menu['sub_menu_url'].'" style="font-size:12px">'
                                    . '<i class="'.$sub_menu['sub_menu_icon'].'"></i>'.$sub_menu['sub_menu_name'].'</a>'
                                    . '</li>';
                            }
                            $str .= '</ul>';
                            echo $str;
                        }
                    }
                }
            ?>

        </ul>
    </div>
</aside>
