<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
ACTIVEPAGES(13, 3);

if ($_GET[func] != NULL) {
    $tt_header = ($_GET[func] == "add" ? $_SESSION[add_info] : $_SESSION[view_info]);
}
if ($_GET[id] == NULL && $_GET[func] != "add") {
    echo header("Location: ins_claim.php");
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
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
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
                                    <a href="ins_claim.php"><?= $_SESSION[ins_claim] ?></a>
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
                                <div class="col-md-12">
                                    <div class="row">

                                        <input type="hidden" id="func" name="func" value="<?= $_GET[func] ?>"/>
                                        <input type="hidden" id="id" name="id" value="<?= $_GET[id] ?>"/>
                                        <div class="col-md-12">
                                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-yellow">
                                                        <i class="fa fa-user font-yellow"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_detail_person2] ?></span>
                                                    </div>
                                                </div>

                                                <div class="portlet-body form">




                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_firstname" name="s_firstname" <?= $disableView ?> >
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_first] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_lastname" name="s_lastname" <?= $disableView ?> >
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_last] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_phone_1" name="s_phone_1" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_phone1] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_phone_2" name="s_phone_2" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_phone2] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_email" name="s_email" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_email] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning">
                                                                <input type="text" class="form-control bold" id="s_line" name="s_line" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_line] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                    </div>  

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning" >
                                                                <div class="md-radio-inline">
                                                                    <div class="md-radio">
                                                                        <input type="radio" id="s_owner1"   value="1" name="s_ownerSe" class="md-radiobtn" <?= $disableView ?>/>
                                                                        <label for="s_owner1">
                                                                            <span></span>
                                                                            <span class="check"></span>
                                                                            <span class="box"></span> <?= $_SESSION[lb_setClaim_ownerCar] ?> </label>
                                                                    </div>
                                                                    <div class="md-radio">
                                                                        <input type="radio" id="s_owner2"    value="2" name="s_ownerSe" class="md-radiobtn" <?= $disableView ?>/>
                                                                        <label for="s_owner2">
                                                                            <span></span>
                                                                            <span class="check"></span>
                                                                            <span class="box"></span> <?= $_SESSION[lb_setClaim_noOwnerCar] ?> </label>
                                                                    </div>



                                                                </div>
                                                                <input type="hidden" id="s_owner" name="s_owner" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-warning" id="div-ref" style="display: none">
                                                                <input type="text" class="form-control bold" id="s_related" name="s_related" <?= $disableView ?> >
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_ref] ?> <span class="required">*</span></label>          
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>


                                            <!-- END EXAMPLE TABLE PORTLET-->
                                        </div>








                                    </div>


                                    <div class="row">


                                        <div class="col-md-12">
                                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                            <div class="portlet light bordered">
                                                <div class="portlet-title">
                                                    <div class="caption font-green">
                                                        <i class="fa fa-do font-green"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_detail_claim] ?></span>
                                                    </div>
                                                </div>

                                                <div class="portlet-body form">

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group form-md-line-input has-success">
<!--                                                                <input type="text" class="form-control bold" id="s_claim_number" name="s_claim_number" >-->
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_docClaim] ?> <span class="required"></span></label>          
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail"  style="max-width: 205px; max-height: 160px;">
                                                                        <a id="s_copy_claim" title="no-image" class="example-image-link" href="images/no-image.png" data-lightbox="example-1">
                                                                            <img id="m_copy_claim" src="images/no-image.png" alt="" style="max-width: 195px; max-height: 145px;"/> 
                                                                        </a>
                                                                    </div>


                                                                </div>
                                                            </div> 
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group form-md-line-input has-success">
                                                                <input type="text" class="form-control bold" id="s_claim_number" name="s_claim_number" <?= $disableView ?>>
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_claimNo] ?> <span class="required"></span></label>          
                                                            </div> 
                                                        </div>






                                                    </div>










                                                </div>



                                                <div class="portlet-title">
                                                    <div class="caption font-green">
                                                        <i class="fa fa-do font-green"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_detail_claimSubReq] ?></span>
                                                    </div>
                                                </div>

                                                <div class="portlet-body form">

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group form-md-line-input has-success">
<!--                                                                <input type="text" class="form-control bold" id="s_claim_number" name="s_claim_number" >-->
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_docClaim1] ?> <span class="required"></span></label>          
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail"  style="max-width: 205px; max-height: 160px;">
                                                                        <a id="s_copy_driver" title="no-image" class="example-image-link" href="images/no-image.png" data-lightbox="example-3">
                                                                            <img id="m_copy_driver" src="images/no-image.png" alt="" style="max-width: 195px; max-height: 145px;"/> 
                                                                        </a>
                                                                    </div>


                                                                </div>
                                                            </div> 
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group form-md-line-input has-success">
<!--                                                                <input type="text" class="form-control bold" id="s_claim_number" name="s_claim_number" >-->
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_insurancePolicy] ?> <span class="required"></span></label>          
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail"  style="max-width: 205px; max-height: 160px;">
                                                                        <a id="s_copy_insurance" title="no-image" class="example-image-link" href="images/no-image.png" data-lightbox="example-4">
                                                                            <img id="m_copy_insurance" src="images/no-image.png" alt="" style="max-width: 195px; max-height: 145px;"/> 
                                                                        </a>
                                                                    </div>


                                                                </div>
                                                            </div> 
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group form-md-line-input has-success">
<!--                                                                <input type="text" class="form-control bold" id="s_claim_number" name="s_claim_number" >-->
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_carRegis] ?> <span class="required"></span></label>          
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail"  style="max-width: 205px; max-height: 160px;">
                                                                        <a id="s_copy_car" title="no-image" class="example-image-link" href="images/no-image.png" data-lightbox="example-5">
                                                                            <img id="m_copy_car" src="images/no-image.png" alt="" style="max-width: 195px; max-height: 145px;"/> 
                                                                        </a>
                                                                    </div>


                                                                </div>
                                                            </div> 
                                                        </div>

                                                    </div>


                                                    







                                                </div>






                                                <div class="portlet-title">
                                                    <div class="caption font-green">
                                                        <i class="fa fa-do font-green"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_detail_claimDmg] ?></span>
                                                    </div>
                                                </div>

                                                <div class="portlet-body form">

                                                    <div class="row">
                                                        <div id="image-damage"></div>
                                                    </div>










                                                </div>



                                                <div class="portlet-title">
                                                    <div class="caption font-green">
                                                        <i class="fa fa-do font-green"></i>
                                                        <span class="caption-subject bold uppercase"> <?= $_SESSION[tt_detail_claimPay] ?></span>
                                                    </div>
                                                </div>

                                                <div class="portlet-body form">

                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group form-md-line-input has-success">
<!--                                                                <input type="text" class="form-control bold" id="s_claim_number" name="s_claim_number" >-->
                                                                <label for="form_control_1"><?= $_SESSION[lb_setClaim_paySlip] ?> <span class="required"></span></label>          
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-new thumbnail"  style="max-width: 205px; max-height: 160px;">
                                                                        <a id="s_copy_pay" title="no-image" class="example-image-link" href="images/no-image.png" data-lightbox="example-6">
                                                                            <img id="m_copy_pay" src="images/no-image.png" alt="" style="max-width: 195px; max-height: 145px;"/> 
                                                                        </a>
                                                                    </div>


                                                                </div>
                                                            </div> 
                                                        </div>
                                                    </div>










                                                </div>





                                            </div>


                                            <!-- END EXAMPLE TABLE PORTLET-->
                                        </div>
                                    </div>



                                </div>










                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet-body form">
                                            <div class="form-actions noborder">
                                                <a href="ins_claim.php"> <button type="button" class="btn default"><?= $_SESSION[btn_cancel] ?></button></a>
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
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
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
        <script src="js/action/insurance/claimManage.js" type="text/javascript"></script>

        <!-- BEGIS SELECT 2 SCRIPTS -->
        <link href="css/select2.min.css" rel="stylesheet" />
        <script src="js/common/select2.min.js"></script>
        <!--<script src="js/common/pdfobject.js"></script>-->
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