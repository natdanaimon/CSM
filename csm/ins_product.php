<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
ACTIVEPAGES(13, 1);
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
                                    <a href="ins_product.php"><?= $_SESSION[ins_product] ?></a>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <br/>
                        </div>

                        <!------------ CONTENT ------------>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-automobile font-dark"></i>
                                            <span class="caption-subject bold uppercase"><?= $_SESSION[tt_mg_insprd] ?></span>
                                        </div>
                                        <div class="actions">

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar">
                                            <div class="row">
                                                <!--                                                <div class="col-md-6">
                                                
                                                                                                </div>-->
                                                <div class="col-md-6" align="left"  <?= $hidden ?>>
                                                    <div class="btn-group">
                                                        <a href="ins_productManage.php?func=add">
                                                            <button id="sample_editable_1_new" class="btn sbold green"> <?= $_SESSION[btn_add] ?>
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button id="sample_editable_1_new" class="btn sbold red" onclick="deleteAll()"> <?= $_SESSION[btn_delete_all] ?>
<!--                                                            <i class="fa fa-minus"></i>-->
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" align="right"  <?= $hidden ?>>
                                                    <div class="btn-group">
                                                        <a href="javascript:clickFile()" >
                                                            <button id="sample_editable_1_new" class="btn sbold blue" >
                                                                <i class="fa fa-cloud-upload"></i>
                                                                <?= $_SESSION[btn_import] ?>
                                                            </button>
                                                        </a>
                                                        <form method="post"  id="upfile" enctype="multipart/form-data">
                                                            <input type="file" style="display:none;" id="file" name="file"/>
                                                            <input type="submit" style="display:none;" id="submitfile" name="submit"/>
                                                        </form>

                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="controller/insurance/productController.php?func=export" target="_blank">
                                                            <button id="sample_editable_1_new" class="btn sbold yellow" style="background: #ffcc00">
                                                                <i class="fa fa-file-excel-o"></i>
                                                                <?= $_SESSION[btn_export_excel_ng] ?>
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="excel/templated insurance.xlsx" >
                                                            <button id="sample_editable_1_new" class="btn sbold green">
                                                                <i class="fa fa-file-excel-o"></i>
                                                                <?= $_SESSION[btn_export_excel_temp] ?>
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="javascript:openLogs()" target="_blank">
                                                            <button id="sample_editable_1_new" class="btn sbold red">
                                                                <i class="fa fa-warning"></i>
                                                                <?= $_SESSION[btn_logs_error] ?>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column dt-responsive" id="datatable">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left: 30px;width: 30px" class="no-sort">

                                                        <span class="md-checkbox has-success">
                                                            <input type="checkbox" id="checkbox14" name="checkbox14" class="md-check">
                                                            <label for="checkbox14">
                                                                <span class="inc"></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> </label>
                                                        </span>
                                                    </th>
                                                    <th class="all">  <?= $_SESSION[tb_co_htext] ?> </th>
                                                    <th class="all">  <?= $_SESSION[tb_co_insurance_name] ?> </th>
                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_insurance_type] ?></span> </th>
                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_price] ?> </span></th>

                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_dPromotion] ?> </span></th>
                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_dDiscount] ?> </span></th>
                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_dBase] ?> </span></th>
                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_dRepair] ?> </span></th>
                                                    <th class="all">  <?= $_SESSION[tb_co_cartype] ?></th> 
                                                    <th class="all">  <?= $_SESSION[tb_co_status] ?></th>
                                                    <th class="all" style="width: 40px"> <?= $_SESSION[tb_co_edit] ?> </th>
                                                    <th class="all" style="width: 40px"> <?= $_SESSION[tb_co_delete] ?></th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                        <!------------ CONTENT ------------>
                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->

            </div>
            <!-- END CONTAINER -->








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
        <script src="js/common/utility.js" type="text/javascript"></script>
        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <link href="css/custom.css" rel="stylesheet" type="text/css" />
        <link href="outbound/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" />
        <script src="outbound/lightbox/js/lightbox.js" type="text/javascript"></script>
        <script src="js/action/insurance/product.js" type="text/javascript"></script>
        <script>
                                                            $(document).ready(function () {
                                                                initialDataTable("TRUE");
                                                                unloading();
                                                            });
        </script>
    </body>

</html>