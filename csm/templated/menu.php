<?php @session_start(); ?>

<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
    <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
            <span></span>
        </div>
    </li>
    <li class="heading">

    </li>
    <!-- END SIDEBAR TOGGLER BUTTON -->
    <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
    <li class="nav-item start <?= $_SESSION["nav_main_dashboard"] ?>">
        <a href="dashboard.php" class="nav-link nav-toggle">
            <i class="fa fa-pie-chart"></i>
            <span class="title"><?= $_SESSION[home_overview] ?></span>

        </a>
    </li>
    <?php if ($_SESSION["perm"] == "A") { ?>
        <!--R2 บริหารจัดการข้อมูลลูกค้า-->
        <li class="nav-item <?= $_SESSION["nav_main_cus"] ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-user"></i>
                <span class="title">R2. <?= $_SESSION[cus_mcustomer] ?></span>
                <span class="selected"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  <?= $_SESSION["nav_sub_cus_customer"] ?>">
                    <a href="cus_customer.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[cus_customer] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
            </ul>
        </li>
        <!--R2 บริหารจัดการข้อมูลลูกค้า-->

        <!--R3 ระบบนำซ่อม-->
        <li class="nav-item <?= $_SESSION["nav_main_repair"] ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-wrench"></i>
                <span class="title">R3. <?= $_SESSION[repair] ?></span>
                <span class="selected"></span>
            </a>
            <ul class="sub-menu">
    <!--                <li class="nav-item  <?= $_SESSION["nav_sub_re_status"] ?>">
                    <a href="re_status.php" class="nav-link ">
                        <span class="title"><?= $_SESSION[re_status] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>-->
                <li class="nav-item  <?= $_SESSION["nav_sub_re_create"] ?>">
                    <a href="re_create.php" class="nav-link ">
                        <span class="title">1 <?= $_SESSION[re_create] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_re_check"] ?>">
                    <a href="re_check.php" class="nav-link ">
                        <span class="title">2 <?= $_SESSION[re_check] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
            </ul>
        </li>
        <!--R3 ระบบนำซ่อม-->






        <!--R8 ตั้งค่า-->
        <li class="nav-item <?= $_SESSION["nav_main_setting"] ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-cog"></i>
                <span class="title">R8. <?= $_SESSION[setting] ?></span>
                <span class="selected"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  <?= $_SESSION["nav_sub_set_vat"] ?>">
                    <a href="set_vat.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[vat] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_dmg"] ?>">
                    <a href="set_dmg.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[level_dmg] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_daily"] ?>">
                    <a href="set_daily.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[daily_record] ?></span>
                        <span class="selected"></span>
                    </a>
                </li> 
                <li class="nav-item  <?= $_SESSION["nav_sub_set_item"] ?>">
                    <a href="set_item.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[item] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_comp_insurance"] ?>">
                    <a href="set_compInsurance.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[comp_insurance] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_comp_partner"] ?>">
                    <a href="set_compPartner.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[comp_partner] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_department"] ?>">
                    <a href="set_department.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[department] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_autoassessment"] ?>">
                    <a href="set_auto.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[autoassessment] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_cmail"] ?>">
                    <a href="set_mail.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[set_cmail] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_compu"] ?>">
                    <a href="set_compulsory.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[set_compu] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>





                <li class="heading">
                    <h3 class="uppercase"></h3>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_year"] ?>">
                    <a href="set_caryear.php" class="nav-link ">
                        <span class="title"><?= $_SESSION[set_year] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_brand"] ?>">
                    <a href="set_carbrand.php" class="nav-link ">
                        <span class="title"><?= $_SESSION[set_brand] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_gen"] ?>">
                    <a href="set_cargeneration.php" class="nav-link ">
                        <span class="title"><?= $_SESSION[set_generation] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_sub"] ?>">
                    <a href="set_carsub.php" class="nav-link ">
                        <span class="title"><?= $_SESSION[set_sub] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_set_map"] ?>">
                    <a href="set_carmapping.php" class="nav-link ">
                        <span class="title"><?= $_SESSION[set_mapping] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>

            </ul>
        </li>
        <!--R8 ตั้งค่า-->

        <!--R9 บริหารจัดการข้อมูลพนักงาน-->
        <li class="nav-item <?= $_SESSION["nav_main_emp"] ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-users"></i>
                <span class="title">R9. <?= $_SESSION[emp_manage] ?></span>
                <span class="selected"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  <?= $_SESSION["nav_sub_emp_user"] ?>">
                    <a href="emp_user.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[emp_user] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_emp_employee"] ?>">
                    <a href="emp_employee.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[emp_employee] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>



            </ul>
        </li>
        <!--R9 บริหารจัดการข้อมูลพนักงาน-->















        <!--R13 บริหารจัดการข้อมูลพนักงาน-->
        <li class="nav-item <?= $_SESSION["nav_main_insurance"] ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-automobile"></i>
                <span class="title">R13. <?= $_SESSION[ins_manage] ?></span>
                <span class="selected"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  <?= $_SESSION["nav_sub_ins_prd"] ?>">
                    <a href="ins_product.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ins_product] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_ins_tran"] ?>">
                    <a href="ins_transaction.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ins_transaction] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_ins_claim"] ?>">
                    <a href="ins_claim.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ins_claim] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>


            </ul>
        </li>
        <!--R13 บริหารจัดการข้อมูลพนักงาน-->



        <!--R14 บริหารจัดการหน้าจอเว็บไซต์-->
        <li class="nav-item <?= $_SESSION["nav_main_ui"] ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-television"></i>
                <span class="title">R14. <?= $_SESSION[ui_management] ?></span>
                <span class="selected"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  <?= $_SESSION["nav_sub_ui_slide"] ?>">
                    <a href="ui_slide.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ui_slide] ?></span>
                        <span class="selected"></span>
                        <span class="badge badge-success" ></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_ui_news"] ?>">
                    <a href="ui_news.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ui_news] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_ui_knowledge"] ?>">
                    <a href="ui_knowledge.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ui_knowledge] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_ui_promotion"] ?>">
                    <a href="ui_promotion.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ui_promotion] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_ui_portfolio"] ?>">
                    <a href="ui_portfolio.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ui_portfolio] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  <?= $_SESSION["nav_sub_ui_popup"] ?>">
                    <a href="ui_popup.php" class="nav-link ">

                        <span class="title"><?= $_SESSION[ui_popup] ?></span>
                        <span class="selected"></span>
                    </a>
                </li>



            </ul>
        </li>
        <!--R14 บริหารจัดการหน้าจอเว็บไซต์-->



    <?php } ?>




<!--    <li class="nav-item <?= $_SESSION["cs_nav_main_dashboard"] ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-game-controller"></i>
            <span class="title"><?= $_SESSION[app_nagieos_bet] ?></span>
            <span class="selected"></span>
            <span class="badge badge-danger" id="noti-nagieos-bet"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_register"] ?>">
                <a href="cs_register.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[register] ?></span>
                    <span class="selected"></span>
                    <span class="badge badge-success" id="noti-register"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_deposit"] ?>">
                <a href="cs_deposit.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[deposit] ?></span>
                    <span class="selected"></span>
                    <span class="badge badge-info" id="noti-deposit"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_withdraw"] ?>">
                <a href="cs_withdraw.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[withdraw] ?></span>
                    <span class="selected"></span>
                    <span class="badge badge-warning" id="noti-withdraw"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_report_dpwd"] ?>">
                <a href="cs_report.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[report] ?></span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="nav-item  <?= $_SESSION["cs_nav_sub_report_dpwd_u"] ?>">
                <a href="cs_report_user.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[report_user] ?></span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="nav-item  <?= $_SESSION["cs_nav_sub_report_log"] ?>">
                <a href="cs_report_log.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[report_log] ?></span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_report_today"] ?>">
                <a href="cs_report_today.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[report_today] ?></span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="heading">
                &nbsp;
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_vip"] ?>">
                <a href="cs_vip.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[vip] ?></span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_vip_pass"] ?>">
                <a href="cs_vip_pass.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[vip_pass] ?></span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["cs_nav_sub_vip_today"] ?>">
                <a href="cs_vip_today.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[vip_today] ?></span>
                    <span class="selected"></span>
                </a>
            </li>




        </ul>
    </li>





    <li class="nav-item <?= $_SESSION["ui_nav_main_dashboard"] ?>">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-tv"></i>
            <span class="title"><?= $_SESSION[app_nagieos_ui] ?></span>
            <span class="selected"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item  <?= $_SESSION["ui_nav_sub_slide"] ?>">
                <a href="ui_slide.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[slide] ?></span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["ui_nav_sub_gallery"] ?>">
                <a href="ui_gallery.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[gallery] ?></span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["post_nav_sub_popup"] ?>">
                <a href="po_promotion_popup.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[popup_promotion] ?></span>
                    <span class="selected"></span>
                </a>
            </li>   
            <li class="nav-item  <?= $_SESSION["post_nav_sub_youtube"] ?>">
                <a href="po_live_youtube.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[live_youtube] ?></span>
                    <span class="selected"></span>
                </a>
            </li>  

            <li class="nav-item  <?= $_SESSION["post_nav_sub_news"] ?>">
                <a href="po_news.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[news] ?></span>
                    <span class="selected"></span>
                </a>
            </li>
            <li class="nav-item  <?= $_SESSION["post_nav_sub_picture"] ?>">
                <a href="po_picture.php" class="nav-link ">

                    <span class="title"><?= $_SESSION[picture] ?></span>
                    <span class="selected"></span>
                </a>
            </li>







        </ul>
    </li>-->


















    <!--
        <li class="heading">
    
        </li>
        <li class="heading">
    
        </li>
        <li class="nav-item start ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item start ">
                    <a href="index.html" class="nav-link ">
                        <i class="icon-bar-chart"></i>
                        <span class="title">Dashboard 1</span>
                    </a>
                </li>
                <li class="nav-item start ">
                    <a href="dashboard_2.html" class="nav-link ">
                        <i class="icon-bulb"></i>
                        <span class="title">Dashboard 2</span>
                        <span class="badge badge-success">1</span>
                    </a>
                </li>
                <li class="nav-item start ">
                    <a href="dashboard_3.html" class="nav-link ">
                        <i class="icon-graph"></i>
                        <span class="title">Dashboard 3</span>
                        <span class="badge badge-danger">5</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="heading">
            <h3 class="uppercase">Features</h3>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-diamond"></i>
                <span class="title">UI Features</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="ui_colors.html" class="nav-link ">
                        <span class="title">Color Library</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_general.html" class="nav-link ">
                        <span class="title">General Components</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_buttons.html" class="nav-link ">
                        <span class="title">Buttons</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_buttons_spinner.html" class="nav-link ">
                        <span class="title">Spinner Buttons</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_confirmations.html" class="nav-link ">
                        <span class="title">Popover Confirmations</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_sweetalert.html" class="nav-link ">
                        <span class="title">Bootstrap Sweet Alerts</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_icons.html" class="nav-link ">
                        <span class="title">Font Icons</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_socicons.html" class="nav-link ">
                        <span class="title">Social Icons</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_typography.html" class="nav-link ">
                        <span class="title">Typography</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_tabs_accordions_navs.html" class="nav-link ">
                        <span class="title">Tabs, Accordions & Navs</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_timeline.html" class="nav-link ">
                        <span class="title">Timeline 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_timeline_2.html" class="nav-link ">
                        <span class="title">Timeline 2</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_timeline_horizontal.html" class="nav-link ">
                        <span class="title">Horizontal Timeline</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_tree.html" class="nav-link ">
                        <span class="title">Tree View</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <span class="title">Page Progress Bar</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item ">
                            <a href="ui_page_progress_style_1.html" class="nav-link "> Flash </a>
                        </li>
                        <li class="nav-item ">
                            <a href="ui_page_progress_style_2.html" class="nav-link "> Big Counter </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  ">
                    <a href="ui_blockui.html" class="nav-link ">
                        <span class="title">Block UI</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_bootstrap_growl.html" class="nav-link ">
                        <span class="title">Bootstrap Growl Notifications</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_notific8.html" class="nav-link ">
                        <span class="title">Notific8 Notifications</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_toastr.html" class="nav-link ">
                        <span class="title">Toastr Notifications</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_bootbox.html" class="nav-link ">
                        <span class="title">Bootbox Dialogs</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_alerts_api.html" class="nav-link ">
                        <span class="title">Metronic Alerts API</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_session_timeout.html" class="nav-link ">
                        <span class="title">Session Timeout</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_idle_timeout.html" class="nav-link ">
                        <span class="title">User Idle Timeout</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_modals.html" class="nav-link ">
                        <span class="title">Modals</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_extended_modals.html" class="nav-link ">
                        <span class="title">Extended Modals</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_tiles.html" class="nav-link ">
                        <span class="title">Tiles</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_datepaginator.html" class="nav-link ">
                        <span class="title">Date Paginator</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ui_nestable.html" class="nav-link ">
                        <span class="title">Nestable List</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-puzzle"></i>
                <span class="title">Components</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="components_date_time_pickers.html" class="nav-link ">
                        <span class="title">Date & Time Pickers</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_color_pickers.html" class="nav-link ">
                        <span class="title">Color Pickers</span>
                        <span class="badge badge-danger">2</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_select2.html" class="nav-link ">
                        <span class="title">Select2 Dropdowns</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_bootstrap_multiselect_dropdown.html" class="nav-link ">
                        <span class="title">Bootstrap Multiselect Dropdowns</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_bootstrap_select.html" class="nav-link ">
                        <span class="title">Bootstrap Select</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_multi_select.html" class="nav-link ">
                        <span class="title">Bootstrap Multiple Select</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_bootstrap_select_splitter.html" class="nav-link ">
                        <span class="title">Select Splitter</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_clipboard.html" class="nav-link ">
                        <span class="title">Clipboard</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_typeahead.html" class="nav-link ">
                        <span class="title">Typeahead Autocomplete</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_bootstrap_tagsinput.html" class="nav-link ">
                        <span class="title">Bootstrap Tagsinput</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_bootstrap_switch.html" class="nav-link ">
                        <span class="title">Bootstrap Switch</span>
                        <span class="badge badge-success">6</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_bootstrap_maxlength.html" class="nav-link ">
                        <span class="title">Bootstrap Maxlength</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_bootstrap_fileinput.html" class="nav-link ">
                        <span class="title">Bootstrap File Input</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_bootstrap_touchspin.html" class="nav-link ">
                        <span class="title">Bootstrap Touchspin</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_form_tools.html" class="nav-link ">
                        <span class="title">Form Widgets & Tools</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_context_menu.html" class="nav-link ">
                        <span class="title">Context Menu</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_editors.html" class="nav-link ">
                        <span class="title">Markdown & WYSIWYG Editors</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_code_editors.html" class="nav-link ">
                        <span class="title">Code Editors</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_ion_sliders.html" class="nav-link ">
                        <span class="title">Ion Range Sliders</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_noui_sliders.html" class="nav-link ">
                        <span class="title">NoUI Range Sliders</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="components_knob_dials.html" class="nav-link ">
                        <span class="title">Knob Circle Dials</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">Form Stuff</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="form_controls.html" class="nav-link ">
                        <span class="title">Bootstrap Form
                            <br>Controls</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_controls_md.html" class="nav-link ">
                        <span class="title">Material Design
                            <br>Form Controls</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_validation.html" class="nav-link ">
                        <span class="title">Form Validation</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_validation_states_md.html" class="nav-link ">
                        <span class="title">Material Design
                            <br>Form Validation States</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_validation_md.html" class="nav-link ">
                        <span class="title">Material Design
                            <br>Form Validation</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_layouts.html" class="nav-link ">
                        <span class="title">Form Layouts</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_repeater.html" class="nav-link ">
                        <span class="title">Form Repeater</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_input_mask.html" class="nav-link ">
                        <span class="title">Form Input Mask</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_editable.html" class="nav-link ">
                        <span class="title">Form X-editable</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_wizard.html" class="nav-link ">
                        <span class="title">Form Wizard</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_icheck.html" class="nav-link ">
                        <span class="title">iCheck Controls</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_image_crop.html" class="nav-link ">
                        <span class="title">Image Cropping</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_fileupload.html" class="nav-link ">
                        <span class="title">Multiple File Upload</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="form_dropzone.html" class="nav-link ">
                        <span class="title">Dropzone File Upload</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-bulb"></i>
                <span class="title">Elements</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="elements_steps.html" class="nav-link ">
                        <span class="title">Steps</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="elements_lists.html" class="nav-link ">
                        <span class="title">Lists</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="elements_ribbons.html" class="nav-link ">
                        <span class="title">Ribbons</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="elements_overlay.html" class="nav-link ">
                        <span class="title">Overlays</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="elements_cards.html" class="nav-link ">
                        <span class="title">User Cards</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-briefcase"></i>
                <span class="title">Tables</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="table_static_basic.html" class="nav-link ">
                        <span class="title">Basic Tables</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="table_static_responsive.html" class="nav-link ">
                        <span class="title">Responsive Tables</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="table_bootstrap.html" class="nav-link ">
                        <span class="title">Bootstrap Tables</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <span class="title">Datatables</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item ">
                            <a href="table_datatables_managed.html" class="nav-link "> Managed Datatables </a>
                        </li>
                        <li class="nav-item ">
                            <a href="table_datatables_buttons.html" class="nav-link "> Buttons Extension </a>
                        </li>
                        <li class="nav-item ">
                            <a href="table_datatables_colreorder.html" class="nav-link "> Colreorder Extension </a>
                        </li>
                        <li class="nav-item ">
                            <a href="table_datatables_rowreorder.html" class="nav-link "> Rowreorder Extension </a>
                        </li>
                        <li class="nav-item ">
                            <a href="table_datatables_scroller.html" class="nav-link "> Scroller Extension </a>
                        </li>
                        <li class="nav-item ">
                            <a href="table_datatables_fixedheader.html" class="nav-link "> FixedHeader Extension </a>
                        </li>
                        <li class="nav-item ">
                            <a href="table_datatables_responsive.html" class="nav-link "> Responsive Extension </a>
                        </li>
                        <li class="nav-item ">
                            <a href="table_datatables_editable.html" class="nav-link "> Editable Datatables </a>
                        </li>
                        <li class="nav-item ">
                            <a href="table_datatables_ajax.html" class="nav-link "> Ajax Datatables </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="?p=" class="nav-link nav-toggle">
                <i class="icon-wallet"></i>
                <span class="title">Portlets</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="portlet_boxed.html" class="nav-link ">
                        <span class="title">Boxed Portlets</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="portlet_light.html" class="nav-link ">
                        <span class="title">Light Portlets</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="portlet_solid.html" class="nav-link ">
                        <span class="title">Solid Portlets</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="portlet_ajax.html" class="nav-link ">
                        <span class="title">Ajax Portlets</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="portlet_draggable.html" class="nav-link ">
                        <span class="title">Draggable Portlets</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-bar-chart"></i>
                <span class="title">Charts</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="charts_amcharts.html" class="nav-link ">
                        <span class="title">amChart</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="charts_flotcharts.html" class="nav-link ">
                        <span class="title">Flot Charts</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="charts_flowchart.html" class="nav-link ">
                        <span class="title">Flow Charts</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="charts_google.html" class="nav-link ">
                        <span class="title">Google Charts</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="charts_echarts.html" class="nav-link ">
                        <span class="title">eCharts</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="charts_morris.html" class="nav-link ">
                        <span class="title">Morris Charts</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <span class="title">HighCharts</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item ">
                            <a href="charts_highcharts.html" class="nav-link "> HighCharts </a>
                        </li>
                        <li class="nav-item ">
                            <a href="charts_highstock.html" class="nav-link "> HighStock </a>
                        </li>
                        <li class="nav-item ">
                            <a href="charts_highmaps.html" class="nav-link "> HighMaps </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-pointer"></i>
                <span class="title">Maps</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="maps_google.html" class="nav-link ">
                        <span class="title">Google Maps</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="maps_vector.html" class="nav-link ">
                        <span class="title">Vector Maps</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="heading">
            <h3 class="uppercase">Layouts</h3>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-layers"></i>
                <span class="title">Page Layouts</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item ">
                    <a href="layout_blank_page.html" class="nav-link ">
                        <span class="title">Blank Page</span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_ajax_page.html" class="nav-link ">
                        <span class="title">Ajax Content Layout</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_offcanvas_mobile_menu.html" class="nav-link ">
                        <span class="title">Off-canvas Mobile Menu</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_classic_page_head.html" class="nav-link ">
                        <span class="title">Classic Page Head</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_light_page_head.html" class="nav-link ">
                        <span class="title">Light Page Head</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_content_grey.html" class="nav-link ">
                        <span class="title">Grey Bg Content</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_search_on_header_1.html" class="nav-link ">
                        <span class="title">Search Box On Header 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_search_on_header_2.html" class="nav-link ">
                        <span class="title">Search Box On Header 2</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_language_bar.html" class="nav-link ">
                        <span class="title">Header Language Bar</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_footer_fixed.html" class="nav-link ">
                        <span class="title">Fixed Footer</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_boxed_page.html" class="nav-link ">
                        <span class="title">Boxed Page</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-feed"></i>
                <span class="title">Sidebar Layouts</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="layout_sidebar_menu_light.html" class="nav-link ">
                        <span class="title">Light Sidebar Menu</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_sidebar_menu_hover.html" class="nav-link ">
                        <span class="title">Hover Sidebar Menu</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_sidebar_search_1.html" class="nav-link ">
                        <span class="title">Sidebar Search Option 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_sidebar_search_2.html" class="nav-link ">
                        <span class="title">Sidebar Search Option 2</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_toggler_on_sidebar.html" class="nav-link ">
                        <span class="title">Sidebar Toggler On Sidebar</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_sidebar_reversed.html" class="nav-link ">
                        <span class="title">Reversed Sidebar Page</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_sidebar_fixed.html" class="nav-link ">
                        <span class="title">Fixed Sidebar Layout</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_sidebar_closed.html" class="nav-link ">
                        <span class="title">Closed Sidebar Layout</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-paper-plane"></i>
                <span class="title">Horizontal Menu</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="layout_mega_menu_light.html" class="nav-link ">
                        <span class="title">Light Mega Menu</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_mega_menu_dark.html" class="nav-link ">
                        <span class="title">Dark Mega Menu</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_full_width.html" class="nav-link ">
                        <span class="title">Full Width Layout</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class=" icon-wrench"></i>
                <span class="title">Custom Layouts</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="layout_disabled_menu.html" class="nav-link ">
                        <span class="title">Disabled Menu Links</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_full_height_portlet.html" class="nav-link ">
                        <span class="title">Full Height Portlet</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="layout_full_height_content.html" class="nav-link ">
                        <span class="title">Full Height Content</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="heading">
            <h3 class="uppercase">Pages</h3>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-basket"></i>
                <span class="title">eCommerce</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="ecommerce_index.html" class="nav-link ">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ecommerce_orders.html" class="nav-link ">
                        <i class="icon-basket"></i>
                        <span class="title">Orders</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ecommerce_orders_view.html" class="nav-link ">
                        <i class="icon-tag"></i>
                        <span class="title">Order View</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ecommerce_products.html" class="nav-link ">
                        <i class="icon-graph"></i>
                        <span class="title">Products</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="ecommerce_products_edit.html" class="nav-link ">
                        <i class="icon-graph"></i>
                        <span class="title">Product Edit</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-docs"></i>
                <span class="title">Apps</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="app_todo.html" class="nav-link ">
                        <i class="icon-clock"></i>
                        <span class="title">Todo 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="app_todo_2.html" class="nav-link ">
                        <i class="icon-check"></i>
                        <span class="title">Todo 2</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="app_inbox.html" class="nav-link ">
                        <i class="icon-envelope"></i>
                        <span class="title">Inbox</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="app_calendar.html" class="nav-link ">
                        <i class="icon-calendar"></i>
                        <span class="title">Calendar</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="app_ticket.html" class="nav-link ">
                        <i class="icon-notebook"></i>
                        <span class="title">Support</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-user"></i>
                <span class="title">User</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="page_user_profile_1.html" class="nav-link ">
                        <i class="icon-user"></i>
                        <span class="title">Profile 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_user_profile_1_account.html" class="nav-link ">
                        <i class="icon-user-female"></i>
                        <span class="title">Profile 1 Account</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_user_profile_1_help.html" class="nav-link ">
                        <i class="icon-user-following"></i>
                        <span class="title">Profile 1 Help</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_user_profile_2.html" class="nav-link ">
                        <i class="icon-users"></i>
                        <span class="title">Profile 2</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-notebook"></i>
                        <span class="title">Login</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item ">
                            <a href="page_user_login_1.html" class="nav-link " target="_blank"> Login Page 1 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_user_login_2.html" class="nav-link " target="_blank"> Login Page 2 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_user_login_3.html" class="nav-link " target="_blank"> Login Page 3 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_user_login_4.html" class="nav-link " target="_blank"> Login Page 4 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_user_login_5.html" class="nav-link " target="_blank"> Login Page 5 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_user_login_6.html" class="nav-link " target="_blank"> Login Page 6 </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  ">
                    <a href="page_user_lock_1.html" class="nav-link " target="_blank">
                        <i class="icon-lock"></i>
                        <span class="title">Lock Screen 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_user_lock_2.html" class="nav-link " target="_blank">
                        <i class="icon-lock-open"></i>
                        <span class="title">Lock Screen 2</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-social-dribbble"></i>
                <span class="title">General</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="page_general_about.html" class="nav-link ">
                        <i class="icon-info"></i>
                        <span class="title">About</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_general_contact.html" class="nav-link ">
                        <i class="icon-call-end"></i>
                        <span class="title">Contact</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-notebook"></i>
                        <span class="title">Portfolio</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item ">
                            <a href="page_general_portfolio_1.html" class="nav-link "> Portfolio 1 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_general_portfolio_2.html" class="nav-link "> Portfolio 2 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_general_portfolio_3.html" class="nav-link "> Portfolio 3 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_general_portfolio_4.html" class="nav-link "> Portfolio 4 </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-magnifier"></i>
                        <span class="title">Search</span>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item ">
                            <a href="page_general_search.html" class="nav-link "> Search 1 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_general_search_2.html" class="nav-link "> Search 2 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_general_search_3.html" class="nav-link "> Search 3 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_general_search_4.html" class="nav-link "> Search 4 </a>
                        </li>
                        <li class="nav-item ">
                            <a href="page_general_search_5.html" class="nav-link "> Search 5 </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item  ">
                    <a href="page_general_pricing.html" class="nav-link ">
                        <i class="icon-tag"></i>
                        <span class="title">Pricing</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_general_faq.html" class="nav-link ">
                        <i class="icon-wrench"></i>
                        <span class="title">FAQ</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_general_blog.html" class="nav-link ">
                        <i class="icon-pencil"></i>
                        <span class="title">Blog</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_general_blog_post.html" class="nav-link ">
                        <i class="icon-note"></i>
                        <span class="title">Blog Post</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_general_invoice.html" class="nav-link ">
                        <i class="icon-envelope"></i>
                        <span class="title">Invoice</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_general_invoice_2.html" class="nav-link ">
                        <i class="icon-envelope"></i>
                        <span class="title">Invoice 2</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item  ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">System</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="page_cookie_consent_1.html" class="nav-link ">
                        <span class="title">Cookie Consent 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_cookie_consent_2.html" class="nav-link ">
                        <span class="title">Cookie Consent 2</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_system_coming_soon.html" class="nav-link " target="_blank">
                        <span class="title">Coming Soon</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_system_404_1.html" class="nav-link ">
                        <span class="title">404 Page 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_system_404_2.html" class="nav-link " target="_blank">
                        <span class="title">404 Page 2</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_system_404_3.html" class="nav-link " target="_blank">
                        <span class="title">404 Page 3</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_system_500_1.html" class="nav-link ">
                        <span class="title">500 Page 1</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="page_system_500_2.html" class="nav-link " target="_blank">
                        <span class="title">500 Page 2</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-folder"></i>
                <span class="title">Multi Level Menu</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i> Item 1
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="javascript:;" target="_blank" class="nav-link">
                                <i class="icon-user"></i> Arrow Toggle
                                <span class="arrow nav-toggle"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="icon-power"></i> Sample Link 1</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="icon-paper-plane"></i> Sample Link 1</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="icon-star"></i> Sample Link 1</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-camera"></i> Sample Link 1</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-link"></i> Sample Link 2</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-pointer"></i> Sample Link 3</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="javascript:;" target="_blank" class="nav-link">
                        <i class="icon-globe"></i> Arrow Toggle
                        <span class="arrow nav-toggle"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-tag"></i> Sample Link 1</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-pencil"></i> Sample Link 1</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="icon-graph"></i> Sample Link 1</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="icon-bar-chart"></i> Item 3 </a>
                </li>-->
</ul>
</li>
</ul>