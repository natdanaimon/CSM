<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
ACTIVEPAGES(13, 2);

if ($_GET[func] != NULL) {
    $tt_header = ($_GET[func] == "add" ? $_SESSION[add_info] : $_SESSION[view_info]);
}
if ($_GET[id] == NULL && $_GET[func] != "add") {
    echo header("Location: ins_transaction.php");
}

$disableView = 'disabled="disable"';
?>
<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?= $_SESSION[title] ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?= $_SESSION[title_content] ?>"    name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <?php include './templated/header.php'; ?>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <?php include './templated/menu.php'; ?>   
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
                        <?php include './templated/theme_panel.php'; ?>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                <li>
                                    <span><?= $_SESSION[ins_manage] ?></span>
                                    <i class="fa fa-circle" style="color:  #00FF00;"></i>
                                </li>
                                <li>
                                    <a href="ins_transaction.php"><?= $_SESSION[ins_transaction] ?></a>
                                    <i class="fa fa-circle" style="color:  #00FF00;"></i>
                                </li>
                                <li>
                                    <?= $tt_header ?>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <br/>
                        </div>

                        <!------------ CONTENT ------------>
                        <form id="form-action">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">

                                        <input type="hidden" id="func" name="func" value="<?= $_GET[func] ?>"/>
                                        <input type="hidden" id="id" name="id" value="<?= $_GET[id] ?>"/>
                                        <div class="col-md-12">
                                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-yellow">
                                                        <i class="fa fa-user font-yellow"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_detail_person] ?></span>
                                                    </div>
                                                </div>

                                                <div class="portlet-body form">




                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_firstname" name="s_firstname" <?= $disableView ?> >
                                                                <label for="form_control_1"><?= $_SESSION[lb_setTrans_first] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_lastname" name="s_lastname" <?= $disableView ?> >
                                                                <label for="form_control_1"><?= $_SESSION[lb_setTrans_last] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_phone" name="s_phone" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setTrans_phone] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_email" name="s_email" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setTrans_email] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                            <label for="form_control_1" style="color: #c49f47;"><?= $_SESSION[lb_setTrans_require_date] ?> <span class="required" style="color: red;">*</span></label> 
                                                            <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                                                <span class="input-group-btn">
                                                                    <button class="btn default" type="button" <?= $disableView ?>>
                                                                        <i class="fa fa-calendar"></i>
                                                                    </button>
                                                                </span>
                                                                <input type="text" class="form-control" readonly name="d_require" id="d_require" value="<?= date("d-m-Y") ?>"  <?= $disableView ?>>

                                                            </div>


                                                        </div>
                                                        <div class="col-md-6">

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input  form-md-floating-label has-warning">
                                                                <label for="form_control_1" style="color: #c49f47;"><?= $_SESSION[lb_setTrans_address] ?> <span class="required">*</span></label>          
                                                                <textarea class="form-control"  name="" rows="4" id="s_address" name="s_address" <?= $disableView ?> ></textarea>

                                                            </div>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input  form-md-floating-label has-warning">
                                                                <label for="form_control_1" style="color: #c49f47;"><?= $_SESSION[lb_setTrans_require] ?> <span class="required">*</span></label>          
                                                                <textarea class="form-control" name="" rows="4" id="s_require" name="s_require" <?= $disableView ?> ></textarea>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>


                                            <!-- END EXAMPLE TABLE PORTLET-->
                                        </div>








                                    </div>


                                    <div class="row">

                                        <input type="hidden" id="func" name="func" value="<?= $_GET[func] ?>"/>
                                        <input type="hidden" id="id" name="id" value="<?= $_GET[id] ?>"/>
                                        <div class="col-md-12">
                                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-green">
                                                        <i class="fa fa-automobile font-green"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_detail_insurance] ?></span>
                                                    </div>
                                                </div>

                                                <div class="portlet-body form">


                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="text" class="form-control bold" id="s_insurance_htext" name="s_insurance_htext" <?= $disableView ?>>
                                                        <label for="form_control_1"><?= $_SESSION[lb_setIns_htext] ?> <span class="required">*</span></label>          
                                                    </div> 
                                                    <div class="form-group form-md-line-input has-success" style="height: 80px">
                                                        <select class="form-control edited bold" id="i_ins_comp" name="i_ins_comp" <?= $disableView ?>>
                                                            <!--<option value="-1"></option>-->
                                                        </select>
                                                        <label for="form_control_1"><?= $_SESSION[lb_setIns_comp] ?></label>
                                                    </div>

                                                    <div class="form-group form-md-line-input has-success" >
                                                        <div class="md-radio-inline">
                                                            <div id="insurance_type"></div>

                                                        </div>
                                                        <input type="hidden" id="i_ins_type" name="i_ins_type" />
                                                    </div>


                                                    <div class="form-group form-md-line-input has-success" style="height: 60px" >
                                                        <select class="form-control edited bold" id="s_car_code" name="s_car_code" <?= $disableView ?>>
                                                        </select>
                                                        <label for="form_control_1"><?= $_SESSION[lb_setIns_code] ?></label>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-success" >
                                                                <select class="form-control edited bold" id="i_ins_promotion" name="i_ins_promotion" <?= $disableView ?>>
                                                                </select>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setIns_promotion] ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-success">
                                                                <input type="text" class="form-control bold" id="f_price" name="f_price" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setIns_price] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-success">
                                                                <input type="text" class="form-control bold" id="f_discount" name="f_discount" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setIns_discount] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-success">
                                                                <input type="text" class="form-control bold" id="f_point" name="f_point" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setIns_point] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>


                                            <!-- END EXAMPLE TABLE PORTLET-->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-green">
                                                        <i class="fa fa-file font-green"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_mg_protec_1] ?></span>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prcar_base" name="s_prcar_base" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_base] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prcar_fire" name="s_prcar_fire" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_fire] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prcar_water" name="s_prcar_water" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_water] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prcar_repair" name="s_prcar_repair" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_repair] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                        <div class="form-group form-md-line-input has-success">
                                                            <select class="form-control edited bold" id="i_prcar_repair_type" name="i_prcar_repair_type" <?= $disableView ?>>
                                                            </select>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_repair_type] ?><span class="required">*</span></label>      
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-green">
                                                        <i class="fa fa-file font-green"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_mg_protec_2] ?></span>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prperson_per" name="s_prperson_per" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_per] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prperson_pertimes" name="s_prperson_pertimes" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_pertimes] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prperson_outsider" name="s_prperson_outsider" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_outside] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-green">
                                                        <i class="fa fa-file font-green"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_mg_protec_3] ?></span>
                                                    </div>


                                                    <div class="col-md-12">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_personal" name="s_prother_personal" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_personal] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_insurance" name="s_prother_insurance" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_insurance] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_medical" name="s_prother_medical" <?= $disableView ?>>
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_medical] ?> <span class="required">*</span></label>          
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="portlet light bordered">
                                                <div class="row">
                                                    <div class="portlet-title">
                                                        <div class="caption font-green">
                                                            <i class="fa fa-file font-green"></i>
                                                            <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_mg_protec_3] ?></span>
                                                        </div>


                                                    </div>
                                                </div>
                                                <br/>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_1_txt" name="s_prother_1_txt" <?= $disableView ?> >
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_h_1] ?> <span class="required"></span></label>          
                                                        </div> 

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_1_val" name="s_prother_1_val" <?= $disableView ?> >
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_d_1] ?> <span class="required"></span></label>          
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_2_txt" name="s_prother_2_txt" <?= $disableView ?> >
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_h_2] ?> <span class="required"></span></label>          
                                                        </div> 

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_2_val" name="s_prother_2_val" <?= $disableView ?> >
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_d_2] ?> <span class="required"></span></label>          
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_3_txt" name="s_prother_3_txt" <?= $disableView ?> >
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_h_3] ?> <span class="required"></span></label>          
                                                        </div> 

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-md-line-input has-success">
                                                            <input type="text" class="form-control bold" id="s_prother_3_val" name="s_prother_3_val" <?= $disableView ?> >
                                                            <label for="form_control_1"><?= $_SESSION[lb_setIns_d_3] ?> <span class="required"></span></label>          
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                                <div class="col-md-3">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class="col-md-12" id="div-img1" >
                                        <div class="portlet light bordered" >
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-image font-green"></i>
                                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[image_h_copy_person] ?></span>
                                                </div>
                                            </div>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"  style="max-width: 205px; max-height: 160px;">
                                                    <a id="m1" title="no-image" class="example-image-link" href="images/no-image.png" data-lightbox="example-1">
                                                        <img id="img1" src="images/no-image.png" alt="" style="max-width: 195px; max-height: 145px;"/> 
                                                    </a>
                                                </div>

                                            </div>


                                        </div>

                                    </div>
                                    <div class="col-md-12" id="div-img2" >
                                        <div class="portlet light bordered" >
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-image font-green"></i>
                                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[image_h_copy_car] ?></span>
                                                </div>
                                            </div>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail"  style="max-width: 205px; max-height: 160px;">
                                                    <a id="m2" title="no-image" class="example-image-link" href="images/no-image.png" data-lightbox="example-2">
                                                        <img id="img2" src="images/no-image.png" alt="" style="max-width: 195px; max-height: 145px;"/> 
                                                    </a>
                                                </div>


                                            </div>

                                        </div>

                                        <!-- END EXAMPLE TABLE PORTLET-->
                                    </div>





                                </div>








                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet-body form">
                                            <div class="form-actions noborder">
                                                <a href="ins_transaction.php"> <button type="button" class="btn default"><?= $_SESSION[btn_cancel] ?></button></a>
                                                <!--<button type="button" class="btn blue" onclick="save()"><?= $_SESSION[btn_submit] ?></button>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="font-size: 12px; color: red;">
                                    <div class="col-md-12">
                                        <div class="portlet-body form">
                                            <div class="col-md-6" align="left">
                                                <span><?= $_SESSION[lb_create] ?> : <span id="lb_create"></span></span>
                                            </div>
                                            <div class="col-md-6" align="right">
                                                <span><?= $_SESSION[lb_edit] ?> : <span id="lb_edit"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                        <!------------ CONTENT ------------>



                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->

            </div>
            <!-- END CONTAINER -->


            <span class="badge bg-primary"></span>





            <!-- BEGIN FOOTER -->
            <?php include './templated/footer.php'; ?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
        <?php include './templated/quick_nav.php'; ?>
        <!-- END QUICK NAV -->



        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!--        <script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>-->
        <script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <!--<script src="../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js" type="text/javascript"></script>-->
        <script src="../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="../assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="js/common/markPattern.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
<!--        <script src="../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>-->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->

        <script src="js/common/notify.js" type="text/javascript"></script>
        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <!--<link href="css/custom.css" rel="stylesheet" type="text/css" />-->
        <script src="js/action/insurance/transactionManage.js" type="text/javascript"></script>

        <!-- BEGIS SELECT 2 SCRIPTS -->
        <link href="css/select2.min.css" rel="stylesheet" />
        <script src="js/common/select2.min.js"></script>
        <script src="js/common/pdfobject.js"></script>
        <!-- END SELECT 2 SCRIPTS -->
        <link href="outbound/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" />
        <script src="outbound/lightbox/js/lightbox.js" type="text/javascript"></script>

        <script>
            var keyEdit = "<?= $_GET[id] ?>";
        </script>
        <script>
            $(document).ready(function () {
                getDDLStatus();
                if (keyEdit == "") {
                    unloading();
                }
            });
        </script>


    </body>

</html>