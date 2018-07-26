<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
include './common/ConnectDB.php';
include './common/Utility.php';
$util = new Utility();
ACTIVEPAGES(10, 1);

?>
<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?= $_SESSION[title] ?>  </title>
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
                                    <span><?= $_SESSION[menu_report] ?></span>
                                    <i class="fa fa-circle" style="color:  #00FF00;"></i>
                                </li>
                                <!--<li>
                                    <a href="exp_daily.php"><?= $_SESSION[queue_create] ?></a>
                                    <i class="fa fa-circle" style="color:  #00FF00;"></i>
                                </li>-->
                                <li>
                                    <?= $_SESSION[report_repair] ?>
                                </li>
                            </ul>
                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <br/>
                            <?php


                            ?>
                        </div>
                        <!------------ CONTENT ------------>
                        <div class="row">
                            <form enctype="multipart/form-data" name="form-action" id="form-action" method="post">
                                    <!-- Set Date-->
                                    <div class="col-md-12">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption font-green">
                                                    <i class="fa fa-gears font-green"></i>
                                                    <span class="caption-subject bold uppercase"> กำหนดระยะเวลาจัดซ่อม</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                <div class="form-body">
                                                    <div class="form-group form-md-line-input has-success "  >
                                                        <select class="form-control edited bold" id="i_dmg" name="i_dmg" style="color:black;font-weight:bold;" <?= $disableElement ?>>
                                                            <option value="-1"></option>
                                                        </select>
                                                        <label for="form_control_1">ระดับความเสียหาย
</label>
                                                    </div>
                                                     <label for="form_control_1" style="color: #36c6d3;">วันที่นัดส่ง <span class="required" style="color: red;"></span></label> 
                                                                <div class="input-group input-medium"  style="width: 100% !important;">
                                                                    <span class="input-group-btn">
                                                                        <button class="btn default" type="button" disabled="disabled">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </button>
                                                                    </span>
                                                                    <input type="text" class="form-control" name="d_sendcar" id="d_sendcar" readonly="readonly"   >
                                                                </div>
                                                <?php
                                                $db = new ConnectDB();
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_department b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
//        $strSql .= " and    s.s_status = 'A' ";

        $strSql .= " order by b.i_index  ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        foreach($_data as $data){

    if($i_date_dept[$data[i_dept]] > 0){
        $i_dept_ok = $i_date_dept[$data[i_dept]];
    }else{
        $i_dept_ok = 0;
    }


                                                ?>
                                                 <div class="form-group form-md-line-input has-success">
                                                                    <input type="number" class="form-control bold required i_dept_date" id="i_dept_date<?= $data[i_dept] ?>" name="i_dept_date<?= $data[i_dept] ?>"   value="<?=$i_dept_ok;?>" min="0" onkeyup="getDateTotal();">
                                                                    <label for="form_control_1"><?= $data[s_dept_th] ?> <span class="required"></span></label>          
                                                                </div>
                                                <?php } ?>
                                                <div class="form-group form-md-line-input has-success">
                                                                    <input type="number" class="form-control bold required" id="total_date" name="total_date" readonly="readonly" value="<?=$total_date;?>" min="0">
                                                                    <label for="form_control_1">รวม <span class="required"></span></label>          
                                                                </div>
                                                                <div class="form-group form-md-line-input has-success" style="display:none;">
                                                                    <select class="form-control bold " id="i_dept_start" name="i_dept_start">
                                                                    <option value="0">---- กรุณาเลือก ----</option>
                                                                    	<?php
        foreach($_data as $data){
                                                ?>
                                                <option value="<?=$data[i_dept];?>">
                                                <?=$data[s_dept_th];?>
                                                </option>
                                                <?php } ?>
                                                                    </select>
                                                                    <label for="form_control_1">แผนกที่เริ่ม <span class="required"></span></label>          
                                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet-body form">
                                            <div class="form-actions noborder">
                                                <a href="po_daily.php"> <button type="button" class="btn default"><?= $_SESSION[btn_cancel] ?></button></a>
                                                <button type="submit"  class="btn blue" id="btn_save" disabled="disabled" ><?= $_SESSION[btn_submit] ?></button>
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
            <?php include './commonModalRef.php'; ?>
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
        <script src="js/action/queue/queue_createManage.js" type="text/javascript"></script>
        <script src="js/action/search/queue.js?v=1" type="text/javascript"></script>
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
                //getDDLPartnercomp();
                //getDDLEmployee();
                getDDLStatus();
                save();
                $('.edit_show').hide();
                if (keyEdit == "") {
                    unloading();
                }else{
									//edit();
                                    //sum_total();
                                    
                                    //unloading();
                                    //searchRef();
                                    setTimeout(searchRef, 2000);
                                    

								}
            });
            
            $('#checkbox_date').click(function(){
            	
            	if($("#checkbox_date").prop('checked') == true){
							    //do something
							    $('#div_mt_date').show();
							    $('#i_fix_date').val('1');
							}else{
								$('#div_mt_date').hide();
								$('#i_fix_date').val('0');
							}
            });
            
            var i_fix_date = $('#i_fix_date').val();
            if(i_fix_date == 1){
							$('input:checkbox[id="checkbox_date"]').attr('checked', '1');
							$('#div_mt_date').show();
						}
            
        </script>
    </body>
</html>