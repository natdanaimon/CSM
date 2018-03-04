<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
include './common/ConnectDB.php';
ACTIVEPAGES(7, 1);

if ($_GET[func] != NULL) {
    $tt_header = ($_GET[func] == "add" ? $_SESSION[add_info] : $_SESSION[edit_info]);
}
if ($_GET[id] == NULL && $_GET[func] != "add") {
    echo header("Location: exp_daily_createManage.php");
}


//$disableElement = 'disabled="disable"';
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
        <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <!--<link href="../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />-->
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
        <!-- BEGIS SELECT 2 SCRIPTS -->
        <link href="css/select2.min.css" rel="stylesheet" />

        <!-- END SELECT 2 SCRIPTS -->





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
                                    <span><?= $_SESSION[exp] ?></span>
                                    <i class="fa fa-circle" style="color:  #00FF00;"></i>
                                </li>
                                <li>
                                    <a href="exp_daily.php"><?= $_SESSION[exp_create_daily] ?></a>
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
                        <div class="row">
                            <form enctype="multipart/form-data" name="form-action" id="form-action" method="post">
                                <input type="hidden" id="func" name="func" value="<?= $_GET[func] ?>"/>
                                <input type="hidden" id="id" name="id" value="<?= $_GET[id] ?>"/>
                                 
                                <div class="col-md-8">


                                    <div class="row" id="div-refno" style="display:none">

                                        <div class="col-md-5">

                                        </div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-3">
                                            <div class="form-group form-md-line-input has-success" >
                                                <input type="text" class="form-control bold required" id="ref_no" name="ref_no" readonly="readonly" >
                                                <label for="form_control_1"><?= $_SESSION[lb_re_refNo] ?> <span class="required"></span></label>          
                                            </div>

                                        </div> 
                                    </div>



                                    <div class="portlet box green">
                                        <div class="portlet-title" onclick="closeStep(1)" style="cursor: pointer;">
                                            <div class="caption">
                                                <i class="fa fa-shopping-cart"></i> <?= $_SESSION[exp_create_daily] ?></div>
                                            <div class="tools">
                                                <!--<a href="javascript:closeStep(1);" class="fa fa-angle-down" style="color: white;text-decoration:none;"> </a>-->
                                                <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form" id="step1" style="display: block;">
                                            <!-- BEGIN FORM-->

                                            <div class="portlet light bordered">
                                                
                                                <div class="portlet-body form">

                                                    <div class="form-body">

                                                        <div class="row">
                                                            
                                                            <div class="col-md-6">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group form-md-line-input has-success">
                                                                    <input type="text" class="form-control bold" id="s_po_daily_ref"  name="s_po_daily_ref" <?= $disableElement ?>>
                                                                    <label  for="form_control_1"><?= $_SESSION[tb_po_refno] ?> <span class="required">*</span>
                                                                    </label>          
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <div class="row">
                                                            <div class="col-md-6">

                                                                <label for="d_daily_order" style="color: #36c6d3;"><?= $_SESSION[tb_po_orderdate] ?> <span class="required" style="color: red;">*</span></label> 
                                                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn default" type="button" <?= $disableView ?>>
                                                                            <i class="fa fa-calendar"></i>
                                                                        </button>
                                                                    </span>
                                                                    <input type="text" class="form-control" readonly name="d_daily_order" id="d_daily_order" value="<?= date("d-m-Y") ?>"  <?= $disableView ?>>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                            <div class="form-group form-md-line-input has-success">
                                                                    <select class="form-control edited bold" id="i_daily_shop" name="i_daily_shop"  <?= $disableElement ?>
                                                                            
                                                                            style="color:black;font-weight:bold;">
                                                                        <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                                                    </select>
                                                                    <label for="form_control_1"><?= $_SESSION[tb_po_shop] ?> <span class="required">*</span></label>          
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="d_daily_receive" style="color: #36c6d3;"><?= $_SESSION[tb_po_receivedate] ?> <span class="required" style="color: red;">*</span></label> 
                                                                <div class="input-group input-medium date date-picker" data-date-format="dd-mm-yyyy" data-date="<?= date("d-m-Y") ?>"  style="width: 100% !important;">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn default" type="button" <?= $disableView ?>>
                                                                            <i class="fa fa-calendar"></i>
                                                                        </button>
                                                                    </span>
                                                                    <input type="text" class="form-control" readonly name="d_daily_receive" id="d_daily_receive" value="<?= date("d-m-Y") ?>"  <?= $disableView ?>>

                                                                </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <div class="form-group form-md-line-input has-success">
                                                                    <select class="form-control edited bold" id="i_daily_receive" name="i_daily_receive"  <?= $disableElement ?>
                                                                            
                                                                            style="color:black;font-weight:bold;">
                                                                        <option value=""><?= $_SESSION[lb_please_select] ?></option>
                                                                    </select>
                                                                    <label for="form_control_1"><?= $_SESSION[tb_po_receiveby] ?> <span class="required">*</span></label>          
                                                                </div>
                                                        </div>
                                                            
                                                        </div>


                                                    </div>


                                                </div>
                                            </div>
                                            <!-- END FORM-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-gears font-green"></i>
                                                    <span class="caption-subject bold uppercase"> <?= $_SESSION[label_status] ?></span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">

                                                <div class="form-body">

                                                    <div class="form-group form-md-line-input has-success " style="margin-bottom: 0px !important;">
                                                        <select class="form-control edited bold" id="status" name="status" style="color:black;font-weight:bold;">
                                                            <option value="-1"></option>
                                                        </select>
                                                        <label for="form_control_1"><?= $_SESSION[label_status] ?></label>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <!-- END EXAMPLE TABLE PORTLET-->
                                </div>




                                <div class="col-md-12">

                                    <div class="portlet box green">
                                        <div class="portlet-title" onclick="closeStep(2)" style="cursor: pointer;">
                                            <div class="caption">
                                                <i class="fa fa-shopping-cart"></i> <?= $_SESSION[exp_create_daily] ?></div>
                                            <div class="tools">
                                                <!--<a href="javascript:closeStep(1);" class="fa fa-angle-down" style="color: white;text-decoration:none;"> </a>-->
                                                <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                                            </div>
                                        </div>
                                        <div class="portlet-body form" id="step2" style="display: block;">
                                            <!-- BEGIN FORM-->

                                            <div class="portlet light bordered">
                                                
                                                <div class="portlet-body form">

                                                    <div class="form-body">
<div class="row">
                                    <div class="col-md-12" align="right">
                                        <div class="portlet-body form">
                                            
                                                <button onclick="add_row_order();" type="button"  class="btn blue" ><?= $_SESSION[btn_add] ?></button>
                                            
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                                      
                                                      <table width="100%" cellpadding="5" cellspacing="10">
                                                      	<tr style="height: 25px; background-color: #32c5d2; color: #ffffff; font-weight: bold;">
                                                      		<td width="5%" align="center">#</td>
                                                      		<td width="5%" align="center">No.</td>
                                                      		<td>Detail</td>
                                                      		<td width="10%" align="right">Price</td>
                                                      		<td width="10%" align="right">amount</td>
                                                      		<td width="10%" align="right">total</td>
                                                      		<td width="10"></td>
                                                      	</tr>
                                                      	<tbody id="tbody_order">
                                                      	<?php
                                                      	if($_GET[func]=='add'){
																													$no = 1;
																													for($i=0;$i<=4;$i++){
																														?>
																														<tr id="tr_order_<?=$i;?>">
                                                      			<td align="center">
                                                      				<a class="remove_tr" data-row="<?=$i;?>"><i class="fa fa-times"></i></a>
                                                      			</td>
                                                      			<td align="center">#</td>
                                                      			<td>
                                                      				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;">
                                                                    <input type="text" class="form-control bold" id="s_po_daily_order_<?=$i;?>" name="s_po_daily_order[]" >
                                                                         
                                                                </div>
                                                      			</td>
                                                      			<td>
                                                      				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">
                                                                    <input type="number" class="form-control bold cal_tr" data-row="<?=$i;?>" id="i_daily_price_<?=$i;?>" name="i_daily_price[]" >
                                                                         
                                                                </div>
                                                      			</td>
                                                      			<td>
                                                      				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">
                                                                    <input type="number" class="form-control bold cal_tr" data-row="<?=$i;?>" id="i_daily_amount_<?=$i;?>" name="i_daily_amount[]" >
                                                                         
                                                                </div>
                                                      			</td>
                                                      			<td align="right">
                                                      				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">
                                                                    <span id="total_<?=$i;?>">0</span><input type="hidden" id="total_txt_<?=$i;?>" class="quantity" value="0" />                
                                                                         
                                                                </div>
                                                      			</td>
                                                      			<td></td>
                                                      		</tr>
                                                      		<tr>
                                                      			<td colspan="6" style="border-bottom: 1px solid #cccccc;"></td>
                                                      		</tr>
																														<?php
																													$no++;
																													}
																												$total_summm = 0;
																												}else{
				$db = new ConnectDB();
        $strSql = " select * ";
        $strSql .= " FROM tb_po_daily_order  WHERE i_po_daily = '".$_GET[id]."' ";
        //$strSql .= " order by u.d_create desc , u.s_status desc ";
         $strSql;
         $_dataTable = $db->Search_Data_FormatJson($strSql);
 
 
				$no = 1;
				$i = 0;
																													foreach ($_dataTable as $key => $value) {
																														?>
																														<tr id="tr_order_<?=$i;?>">
                                                      			<td align="center">
                                                      				<a class="remove_tr" data-row="<?=$i;?>"><i class="fa fa-times"></i></a>
                                                      			</td>
                                                      			<td align="center"><?=$no;?></td>
                                                      			<td>
                                                      				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;">
                                                                    <input type="text" class="form-control bold" id="s_po_daily_order_<?=$i;?>" name="s_po_daily_order[]" value="<?=$_dataTable[$key]['s_po_daily_order'];?>" >
                                                                         
                                                                </div>
                                                      			</td>
                                                      			<td>
                                                      				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">
                                                                    <input type="number" class="form-control bold cal_tr" data-row="<?=$i;?>" id="i_daily_price_<?=$i;?>" name="i_daily_price[]" value="<?=$_dataTable[$key]['i_daily_price'];?>" >
                                                                         
                                                                </div>
                                                      			</td>
                                                      			<td>
                                                      				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">
                                                                    <input type="number" class="form-control bold cal_tr" data-row="<?=$i;?>" id="i_daily_amount_<?=$i;?>" name="i_daily_amount[]" value="<?=$_dataTable[$key]['i_daily_amount'];?>" >
                                                                         
                                                                </div>
                                                      			</td>
                                                      			<td align="right">
                                                      				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">
                                                                    <span id="total_<?=$i;?>"><?=$_dataTable[$key]['i_daily_amount']*$_dataTable[$key]['i_daily_price'];?></span><input type="hidden" id="total_txt_<?=$i;?>" class="quantity" value="<?=$_dataTable[$key]['i_daily_amount']*$_dataTable[$key]['i_daily_price'];?>" />                
                                                                         
                                                                </div>
                                                      			</td>
                                                      			<td></td>
                                                      		</tr>
                                                      		<tr>
                                                      			<td colspan="6" style="border-bottom: 1px solid #cccccc;"></td>
                                                      		</tr>
																														<?php
																													$no++;
																													$i++;
																													$total_summm += $_dataTable[$key]['i_daily_amount']*$_dataTable[$key]['i_daily_price'];
																													}
																												}
                                                      	?>
                                                      		
                                                      	</tbody>
                                                      	<tr>
                                                      		<td colspan="5" align="right">
                                                      			Sum
                                                      		</td>
                                                      		<td align="right">
                                                      			<span id="sum_total_order"><?=$total_summm;?></span>
                                                      		</td>
                                                      		<td></td>
                                                      	</tr>
                                                      </table>
                                                      <input type="hidden" name="last_no" id="last_no" value="<?=$i;?>"/>




                                                    </div>


                                                </div>
                                            </div>



                                            <!-- END FORM-->
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet-body form">
                                            <div class="form-actions noborder">
                                                <a href="po_daily.php"> <button type="button" class="btn default"><?= $_SESSION[btn_cancel] ?></button></a>
                                                <button type="submit"  class="btn blue" ><?= $_SESSION[btn_submit] ?></button>
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
                        </div>
                        <!------------ CONTENT ------------>


                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->

            </div>
            <!-- END CONTAINER -->






            <span class="badge bg-primary"></span>












            <?php include './commonModal.php'; ?>

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
        <script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>

        <script src="../assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="js/common/markPattern.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="../assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script src="js/common/select2.min.js"></script>
        <script src="js/common/notify.js" type="text/javascript"></script>
        <link href="css/notify.css" rel="stylesheet" type="text/css" />


        <link href="outbound/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" />
        <script src="outbound/lightbox/js/lightbox.js" type="text/javascript"></script>
        <!--<link href="css/custom_select2.css" rel="stylesheet" />-->
        <script src="js/action/exp/exp_daily_createManage.js" type="text/javascript"></script>
        <script src="js/action/search/popup.js" type="text/javascript"></script>
        <script src="js/common/closeStep.js" type="text/javascript"></script>



        
        <script>
        	function add_row_order(){
						var last_no = parseInt($('#last_no').val())+1;
						$('#last_no').val(last_no);
						var tr_txt = '<tr id="tr_order_'+last_no+'">                                                       			<td align="center">                                                       				<a onclick="func_remove_tr('+last_no+');"><i class="fa fa-times"></i>                                                       			</td>                                                       			<td align="center">#</td>                                                       			<td>                                                       				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;">                                                                     <input type="text" class="form-control bold" id="s_po_daily_order_'+last_no+'" name="s_po_daily_order[]" >                                                                                                                                          </div>                                                       			</td>                                                       			<td>                                                       				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">                                                                     <input type="number" class="form-control bold cal_tr" onkeyup="func_cal_tr('+last_no+')" onblur="func_cal_tr('+last_no+')"  data-row="'+last_no+'" id="i_daily_price_'+last_no+'" name="i_daily_price[]" >                                                                                                                                          </div>                                                       			</td>                                                       			<td>                                                       				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">                                                                     <input type="number" class="form-control bold cal_tr" onkeyup="func_cal_tr('+last_no+')"  onblur="func_cal_tr('+last_no+')" data-row="'+last_no+'" id="i_daily_amount_'+last_no+'" name="i_daily_amount[]" >                                                                                                                                          </div>                                                       			</td>                                                       			<td align="right">                                                       				<div class="form-group form-md-line-input has-success" style="padding-top: 0px;margin-left: 10px;">                                                                     <span id="total_'+last_no+'">0</span>   <input type="hidden" id="total_txt_'+last_no+'" class="quantity" value="0" />                                                                                                                                       </div>                                                       			</td>                                                       			<td></td>                                                       		</tr>                                                       		<tr>                                                       			<td colspan="6" style="border-bottom: 1px solid #cccccc;"></td>                                                       		</tr>';
						
						$('#tbody_order').append(tr_txt);
					}
					
					$('.remove_tr').click(function(){
						var row = $(this).attr('data-row');
						func_remove_tr(row);
					});
					
					function func_remove_tr(row){
						$('#tr_order_'+row).closest('tr').remove();
						sum_total();
					}
					
					$('.cal_tr').keyup(function(){
						var row = $(this).attr('data-row');
						func_cal_tr(row);
					});
					$('.cal_tr').blur(function(){
						var row = $(this).attr('data-row');
						func_cal_tr(row);
					});
					function func_cal_tr(row){
						var price = parseInt($('#i_daily_price_'+row).val());
						var amount = parseInt($('#i_daily_amount_'+row).val());
						var sum = price*amount;
						$('#total_'+row).html(sum);
						$('#total_txt_'+row).val(sum);
						sum_total();
					}
					function sum_total(){
						var last_no = $('#last_no').val(); 
						var total = 0;

				    $(".quantity").each(function() {
				        if (!isNaN(this.value) && this.value.length != 0) {
				            total += parseFloat(this.value);
				        }
				    });

						$('#sum_total_order').html(total);
					}
        </script>

<script>
                                                                                var keyEdit = "<?= $_GET[id] ?>";
        </script>
        <script>
            $(document).ready(function () {
                getDDLPartnercomp();
                getDDLEmployee();
                getDDLStatus();
                save();
                $('.edit_show').hide();
                if (keyEdit == "") {
                    unloading();
                }else{
									edit();
									sum_total();
								}

            });



        </script>
    </body>

</html>