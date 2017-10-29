<?php

function ACTIVEPAGES($page, $sub) {


    //csm
    $_SESSION["nav_main_dashboard"] = "";
    $_SESSION["nav_main_setting"] = "";
    $_SESSION["nav_main_emp"] = "";
    $_SESSION["nav_main_cus"] = "";


    //csm setting
    $_SESSION["nav_sub_set_vat"] = "";
    $_SESSION["nav_sub_set_autoassessment"] = "";
    $_SESSION["nav_sub_set_dmg"] = "";
    $_SESSION["nav_sub_set_daily"] = "";
    $_SESSION["nav_sub_set_item"] = "";
    $_SESSION["nav_sub_set_comp_insurance"] = "";
    $_SESSION["nav_sub_set_comp_partner"] = "";
    $_SESSION["nav_sub_set_department"] = "";

    //csm employee
    $_SESSION["nav_sub_emp_user"] = "";
    $_SESSION["nav_sub_emp_employee"] = "";

    //csm customer
    $_SESSION["nav_sub_cus_customer"] = "";













    if ($page == 0) {
        $_SESSION["nav_main_dashboard"] = " active open";
    } else if ($page == 1) {
        
    } else if ($page == 2) {

        $_SESSION["nav_main_cus"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_cus_customer"] = " active open";
        }
    } else if ($page == 3) {
        
    } else if ($page == 9) {
        $_SESSION["nav_main_emp"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_emp_user"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_emp_employee"] = " active open";
        }
    } else if ($page == 99) {
        $_SESSION["nav_main_setting"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_set_vat"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_set_autoassessment"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["nav_sub_set_dmg"] = " active open";
        } else if ($sub == 4) {
            $_SESSION["nav_sub_set_daily"] = " active open";
        } else if ($sub == 5) {
            $_SESSION["nav_sub_set_item"] = " active open";
        } else if ($sub == 6) {
            $_SESSION["nav_sub_set_comp_insurance"] = " active open";
        } else if ($sub == 7) {
            $_SESSION["nav_sub_set_comp_partner"] = " active open";
        } else if ($sub == 8) {
            $_SESSION["nav_sub_set_department"] = " active open";
        }
    }
}

function ACTIVEPAGES_DEMO($page, $sub) {

    // main

    $_SESSION["cs_nav_main_dashboard"] = "";



    // sub nagieos bet
    $_SESSION["cs_nav_sub_deposit"] = "";
    $_SESSION["cs_nav_sub_withdraw"] = "";
    $_SESSION["cs_nav_sub_register"] = "";






    if ($page == 0) {
        $_SESSION["nav_main_dashboard"] = " active open";
    } else if ($page == 1) {
        $_SESSION["cs_nav_main_dashboard"] = " active open";
        if ($sub == 1) {
            $_SESSION["cs_nav_sub_dashboard"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["cs_nav_sub_deposit"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["cs_nav_sub_withdraw"] = " active open";
        } else if ($sub == 4) {
            $_SESSION["cs_nav_sub_bank"] = " active open";
        } else if ($sub == 5) {
            $_SESSION["cs_nav_sub_report"] = " active open";
        } else if ($sub == 6) {
            $_SESSION["cs_nav_sub_register"] = " active open";
        } else if ($sub == 7) {
            $_SESSION["cs_nav_sub_promotion"] = " active open";
        } else if ($sub == 8) {
            $_SESSION["cs_nav_sub_vip"] = " active open";
        }
    }
}

function ACTIVEPAGES_SUB($main, $sub) {
    if ($main == 2) {
        if ($sub == 1) {
            $_SESSION["active_slide"] = "current-page";
        }
    } else if ($main == 3) {
        if ($sub == 1) {
            $_SESSION["active_partner_group"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_partner_company"] = "current-page";
        }
    } else if ($main == 4) {
        if ($sub == 1) {
            $_SESSION["active_newsletter"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_news_post"] = "current-page";
        }
    } else if ($main == 5) {
        if ($sub == 1) {
            $_SESSION["active_price_football"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_price_snooker"] = "current-page";
        } else if ($sub == 3) {
            $_SESSION["active_promotion"] = "current-page";
        }
    } else if ($main == 7) {
        if ($sub == 1) {
            $_SESSION["active_game"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_team"] = "current-page";
        }
    } else if ($main == 9) {
        if ($sub == 1) {
            $_SESSION["active_league"] = "current-page";
        } else if ($sub == 2) {
            $_SESSION["active_fa"] = "current-page";
        } else if ($sub == 3) {
            $_SESSION["active_champion"] = "current-page";
        }
    }
}

?>