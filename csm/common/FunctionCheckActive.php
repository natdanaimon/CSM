<?php

function ACTIVEPAGES($page, $sub) {


    //csm
    $_SESSION["nav_main_workall"] = "";
    $_SESSION["nav_main_dashboard"] = "";
    $_SESSION["nav_main_setting"] = "";
    $_SESSION["nav_main_repair"] = "";
    $_SESSION["nav_main_emp"] = "";
    $_SESSION["nav_main_cus"] = "";
    $_SESSION["nav_main_insurance"] = "";
    $_SESSION["nav_main_ui"] = "";
    $_SESSION["nav_main_po"] = "";



    //csm setting
    $_SESSION["nav_sub_set_vat"] = "";
    $_SESSION["nav_sub_set_autoassessment"] = "";
    $_SESSION["nav_sub_set_dmg"] = "";
    $_SESSION["nav_sub_set_daily"] = "";
    $_SESSION["nav_sub_set_item"] = "";
    $_SESSION["nav_sub_set_comp_insurance"] = "";
    $_SESSION["nav_sub_set_comp_partner"] = "";
    $_SESSION["nav_sub_set_department"] = "";

    $_SESSION["nav_sub_set_year"] = "";
    $_SESSION["nav_sub_set_brand"] = "";
    $_SESSION["nav_sub_set_gen"] = "";
    $_SESSION["nav_sub_set_sub"] = "";
    $_SESSION["nav_sub_set_map"] = "";
    $_SESSION["nav_sub_set_cmail"] = "";
    $_SESSION["nav_sub_set_compu"] = "";


    //csm employee
    $_SESSION["nav_sub_emp_user"] = "";
    $_SESSION["nav_sub_emp_employee"] = "";



    //csm customer
    $_SESSION["nav_sub_cus_customer"] = "";

    //csm_po
    $_SESSION["nav_sub_po_search"] = "";
    $_SESSION["nav_sub_po_spare"] = "";
    $_SESSION["nav_sub_po_color"] = "";
    $_SESSION["nav_sub_po_other"] = "";


    //csm_exp
    $_SESSION["nav_main_exp"] = "";
    $_SESSION["nav_sub_exp_daily"] = "";
    
    //csm_que
    $_SESSION["nav_main_queue"] = "";
    $_SESSION["nav_sub_queue_list"] = "";
    $_SESSION["nav_sub_queue_listall"] = "";
    $_SESSION["nav_sub_queue_all"] = "";

    
    //csm_repair
    $_SESSION["nav_sub_re_create"] = "";
    $_SESSION["nav_sub_re_check"] = "";
    $_SESSION["nav_sub_re_process"] = "";
    $_SESSION["nav_sub_re_success"] = "";
    $_SESSION["nav_sub_re_cancel"] = "";


//csm insurance
    $_SESSION["nav_sub_ins_prd"] = "";
    $_SESSION["nav_sub_ins_tran"] = "";
    $_SESSION["nav_sub_ins_claim"] = "";


    //csm ui
    $_SESSION["nav_sub_ui_slide"] = "";
    $_SESSION["nav_sub_ui_news"] = "";
    $_SESSION["nav_sub_ui_knowledge"] = "";
    $_SESSION["nav_sub_ui_promotion"] = "";
    $_SESSION["nav_sub_ui_popup"] = "";
    $_SESSION["nav_sub_ui_portfolio"] = "";


    //csm Report
    $_SESSION["nav_main_report"] = "";
    $_SESSION["nav_sub_report_quotation"] = "";
    $_SESSION["nav_sub_report_invoice"] = "";
    $_SESSION["nav_sub_report_withholding"] = "";
    $_SESSION["nav_sub_report_receipt"] = "";
    $_SESSION["nav_sub_report_bill"] = "";



    if ($page == 0) {
        $_SESSION["nav_main_dashboard"] = " active open";
    } else if ($page == 999) {
       $_SESSION["nav_main_workall"] = " active open"; 
    } else if ($page == 1) {
        
    } else if ($page == 2) {

        $_SESSION["nav_main_cus"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_cus_customer"] = " active open";
        }
    } else if ($page == 3) {
        $_SESSION["nav_main_repair"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_re_create"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_re_check"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["nav_sub_re_process"] = " active open";
        } else if ($sub == 4) {
            $_SESSION["nav_sub_re_success"] = " active open";
        } else if ($sub == 5) {
            $_SESSION["nav_sub_re_cancel"] = " active open";
        }
    } 
    else if ($page == 4) {
        $_SESSION["nav_main_po"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_po_search"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_po_spare"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["nav_sub_po_color"] = " active open";
        } else if ($sub == 4) {
            $_SESSION["nav_sub_po_other"] = " active open";
        }
    }
    else if ($page == 5) {
        $_SESSION["nav_main_queue"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_queue_list"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_queue_listall"] = " active open";
        }else if ($sub == 3) {
            $_SESSION["nav_sub_queue_all"] = " active open";
        }
    }
    
    else if ($page == 7) {
        $_SESSION["nav_main_exp"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_exp_daily"] = " active open";
        } 
    } 
    
    else if ($page == 9) {
        $_SESSION["nav_main_emp"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_emp_user"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_emp_employee"] = " active open";
        }
    } 
    else if ($page == 10) {
        $_SESSION["nav_main_report"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_report_quotation"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_report_invoice"] = " active open";
        }
         else if ($sub == 3) {
            $_SESSION["nav_sub_report_withholding"] = " active open";
        }
         else if ($sub == 4) {
            $_SESSION["nav_sub_report_receipt"] = " active open";
        }
         else if ($sub == 5) {
            $_SESSION["nav_sub_report_bill"] = " active open";
        }
    } 
    
    else if ($page == 13) {
        $_SESSION["nav_main_insurance"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_ins_prd"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_ins_tran"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["nav_sub_ins_claim"] = " active open";
        }
    } else if ($page == 14) {
        $_SESSION["nav_main_ui"] = " active open";
        if ($sub == 1) {
            $_SESSION["nav_sub_ui_slide"] = " active open";
        } else if ($sub == 2) {
            $_SESSION["nav_sub_ui_news"] = " active open";
        } else if ($sub == 3) {
            $_SESSION["nav_sub_ui_knowledge"] = " active open";
        } else if ($sub == 4) {
            $_SESSION["nav_sub_ui_promotion"] = " active open";
        } else if ($sub == 6) {
            $_SESSION["nav_sub_ui_portfolio"] = " active open";
        } else if ($sub == 5) {
            $_SESSION["nav_sub_ui_popup"] = " active open";
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
        } else if ($sub == 9) {
            $_SESSION["nav_sub_set_year"] = " active open";
        } else if ($sub == 10) {
            $_SESSION["nav_sub_set_brand"] = " active open";
        } else if ($sub == 11) {
            $_SESSION["nav_sub_set_gen"] = " active open";
        } else if ($sub == 12) {
            $_SESSION["nav_sub_set_sub"] = " active open";
        } else if ($sub == 13) {
            $_SESSION["nav_sub_set_map"] = " active open";
        } else if ($sub == 14) {
            $_SESSION["nav_sub_set_cmail"] = " active open";
        } else if ($sub == 15) {
            $_SESSION["nav_sub_set_compu"] = " active open";
        }
    }
}
