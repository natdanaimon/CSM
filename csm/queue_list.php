<?php
@session_start();
include './common/Permission.php';
include './common/PermissionADM.php';
include './common/FunctionCheckActive.php';
include './common/ConnectDB.php';
ACTIVEPAGES(5, 1);
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
                                    <span><?= $_SESSION[queue_list] ?></span>
                                    <i class="fa fa-circle" style="color:  #00FF00;"></i>
                                </li>
                                <li>
                                    <a href="queue_list.php"><?= $_SESSION[queue_create] ?></a>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->
                        <div class="row">
                            <br/>
                        </div>

                        
                        <!------------ CONTENT R3-1  ------------>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-wrench font-dark"></i>
                                            <span class="caption-subject bold uppercase"><?= $_SESSION[queue_list] ?></span>
                                        </div>
                                        <div class="actions">

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar" >
                                            <div class="row">
                                                <!--                                                <div class="col-md-6">
                                                
                                                                                                </div>-->
                                                <div class="col-md-6" align="left"  <?= $hidden ?>>
                                                    <div class="btn-group" style="display:none;">
                                                        <a href="re_createManage.php?func=add">
                                                            <button id="sample_editable_1_new" class="btn sbold green"> <?= $_SESSION[btn_add] ?>
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group">
                                                        <button id="sample_editable_1_new" class="btn sbold red" onclick="deleteAll()"> <?= $_SESSION[btn_cancel_all] ?>

                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-striped table-bordered table-hover table-checkable order-column dt-responsive" id="datatable-1">
                                            <thead>
                                                <tr>
                                                    <th style="padding-left: 30px;width: 30px" class="no-sort">
                                                        <!--                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                                                                                    <input type="checkbox" class="group-checkable" data-set="#datatable .checkboxes" id="select_all" />
                                                                                                                    <span></span>
                                                                                                                </label>-->
                                                        <span class="md-checkbox has-success">
                                                            <input type="checkbox" id="checkbox14" name="checkbox14" class="md-check">
                                                            <label for="checkbox14">
                                                                <span class="inc"></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> </label>
                                                        </span>
                                                    </th>
                                                    <th  class="all"  style="width: 80px">  <?= $_SESSION[tb_co_refno] ?> </th>
                                                    <th  class="all">  <?= $_SESSION[tb_co_custname] ?> </th>
                                                    <th  class="all">  <?= $_SESSION[tb_co_license] ?> </th>

                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_caryear] ?></span> </th>
                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_carbrand] ?></span> </th>
                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_cargeneration] ?></span> </th>
                                                    <!--<th class="none"> <span style="color:red"><?= $_SESSION[tb_co_carsub] ?></span> </th>-->

                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_insurance_name] ?></span> </th>
                                                    <!--<th class="none"> <span style="color:red"><?= $_SESSION[tb_co_dmg] ?></span> </th>-->
                                                    <th class="none"> <span style="color:red"><?= $_SESSION[tb_co_dinbound_car] ?> - <?= $_SESSION[tb_co_doutbound_car] ?></span> </th>


                                                    <th  class="all">  <?= $_SESSION[tb_co_status] ?> </th>
                                                    <th style="width: 40px"> <?= $_SESSION[tb_co_edit] ?> </th>
                                                    <th style="width: 40px"> <?= $_SESSION[tb_co_cancel] ?></th>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- END EXAMPLE TABLE PORTLET-->
                            </div>
                        </div>
                        <!------------ CONTENT R3-1 ------------>                                               
                        
                        <!------------ CONTENT ------------>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption font-dark">
                                            <i class="fa fa-clock-o font-dark"></i>
                                            <span class="caption-subject bold uppercase"><?= $_SESSION[queue_list] ?></span>
                                        </div>
                                        <div class="actions">

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-toolbar" style="display:none;">
                                            <div class="row">
                                                <!--                                                <div class="col-md-6">
                                                
                                                                                                </div>-->
                                                <div class="col-md-6" align="left"  <?= $hidden ?>>
                                                    <div class="btn-group">
                                                        <a href="queue_createManage.php?func=add">
                                                        <!--<a data-toggle="modal" href="#searchRef"> -->
                                                            <button id="sample_editable_1_new" class="btn sbold green find_ref"  > <?= $_SESSION[btn_add] ?>
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group" style="display: none;">
                                                        <button id="sample_editable_1_new" class="btn sbold red" onclick="deleteAll()"> <?= $_SESSION[btn_cancel_all] ?>
<!--                                                            <i class="fa fa-minus"></i>-->
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <?php

                                    ?>
                                        <!-- BEGIN STEP1-->
                                        <h3>ประจำวันที่ <?=date('d-m-Y');?></h3>
        <?php
        $db = new ConnectDB();
        $strSql = "select b.*,s.s_detail_th status_th, s.s_detail_en status_en ";
        $strSql .= " from   tb_department b , tb_status s  ";
        $strSql .= " where    b.s_status =  s.s_status ";
        $strSql .= " and    s.s_type   =  'ACTIVE' ";
        $strSql .= " order by b.i_index  ";
//        $strSql .= " and    s.s_status = 'A' ";
        $_data = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
        ?>
                                    
                                        <?php
                                        $i=0;
                                        foreach($_data as $data){

        $db = new ConnectDB();
        $strSql = "select d.*,q.ref_no , c.s_license, dmg.s_dmg_th, bc.s_brand_name, cg.s_gen_name ";
        $strSql .= " from   tb_queue_dept d  ";
        
        $strSql .= " LEFT JOIN  tb_queue q ON  d.i_queue = q.i_queue";
        $strSql .= " LEFT JOIN  tb_customer_car c ON  c.ref_no = q.ref_no";
        $strSql .= " LEFT JOIN  tb_damage dmg ON  c.i_dmg = dmg.i_dmg";
        $strSql .= " LEFT JOIN  tb_car_brand bc ON  c.s_brand_code = bc.s_brand_code";
        $strSql .= " LEFT JOIN  tb_car_generation cg ON  c.s_gen_code = cg.s_gen_code";
        $strSql .= " where  d.i_dept_date > 0";
        $strSql .= " and    d.i_dept = '".$data[i_dept]."' ";
        $strSql .= " and    d.i_active = '1' ";
        $strSql .= " ORDER BY d_start";
        $_datalv2 = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
                                      
                                        ?>
                                        <?php
                                        
                                        if($_datalv2){
 
                                        ?>
                                        <div class="portlet box green">
                                        <div class="portlet-title" onclick="closeStep(<?= $data[i_dept] ?>)" style="cursor: pointer;">
                                            <div class="caption">
                                                <i class="fa fa-clock-o"></i> <?= $data[s_dept_th] ?></div>
                                            <div class="tools">
                                                <span class="fa fa-angle-down" style="color: white;text-decoration:none;"> </span>
                                            </div>
                                        </div>
                                        <?php 
                                        	if($i == 0){
																						$none_aa = "a";
																					}else{
																						$none_aa = "a";
																					}
                                        ?>
                                        <div class="portlet-body form" id="step<?= $data[i_dept] ?>" style="display: none<?=$none_aa;?>;">
                                            <div class="portlet light bordered">
                                            
                                            <table class="table table-striped table-bordered table-hover table-checkable order-column dt-responsive" id="datatable">
                                            <thead>
                                                <tr>
                                                    
                                                    <th  class="all"  style="width: 100px">  REF.NO
</th>
                                                    <th  class="all">  เริ่ม </th>
                                                    <th  class="all">  กำหนดเสร็จ </th>
                                                    <th  class="all">  ยี่ห้อ </th>

                                                    <th class="all"> <span style="color:red">รุ่น
</span> </th>
                                                    <th class="all"> <span style="color:red">ทะเบียน
</span> </th>
                                                    <th class="all"> <span style="color:red">ระดับ
</span> </th>
                                                    <th class="all"> <span style="color:red">STAFF
</span> </th>


                                                    
                                            <th  class="all" style="width: 100px">  สถานะ </th>
                                            </tr>
                                            </thead>
                                            <tbody>
        

                                            <?php
                                        $i=0;
                                        foreach($_datalv2 as $datalv2){
                                        ?>
                                        <tr id = "<?=$datalv2['i_queue_dept'];?>">
                                        	<td>
                                        		<?=$datalv2['ref_no'];?>
                                        	</td>
                                        	<td><?=$datalv2['d_start'];?> (+<?=$datalv2['i_dept_date'];?>)</td>
                                        	<td><?=$datalv2['d_end'];?></td>
                                        	<td><?=$datalv2['s_brand_name'];?></td>
                                        	<td><?=$datalv2['s_gen_name'];?></td>
                                        	<td><?=$datalv2['s_license'];?></td>
                                        	<td><?=$datalv2['s_dmg_th'];?></td>
                                        	<td>
                                        	
                                        	<?php
        $db = new ConnectDB();
        $strSql = "select s.*,e.s_firstname , e.s_lastname";
        $strSql .= " from   tb_queue_dept_staff s  ";
        $strSql .= " LEFT JOIN  tb_employee e ON  e.i_emp = s.i_staff";
        $strSql .= " where  s.i_queue_dept = '".$datalv2[i_queue_dept]."'" ;
        $_datalv3 = $db->Search_Data_FormatJson($strSql);
        $db->close_conn();
                                        	?>
                                        	<?php
                                        	$sss = 1;
                                        	foreach($_datalv3 as $datalv3){
                                        	?>
                                        	<?=$datalv3[s_firstname];?> <?=$datalv3[s_lastname];?> <br />
                                        	<?php $sss++; } ?>
                                        	
                                        		<button data-toggle="modal" href="#staffManage" data-id="<?=$datalv2['i_queue_dept'];?>" data-i_dept="<?=$datalv2['i_dept'];?>" data-d_start_work="<?=$datalv2['d_start'];?>" class="btn btn-primary btn-xs getInfoStaff">เพิ่มช่าง</button>
                                        	</td>
                                        	<td>
                                        	<?php
                                        	if($datalv2['i_status'] == 1){
																						$txt_status = '<i class="fa fa-check"></i> สำเร็จ';
																						$btn_style = "btn-success  btn-block btnstatus approve";
																					}else{
																						$txt_status = '<i class="fa fa-times"></i> กำลังดำเนินการ ';
																						$btn_style = "btn-warning  btn-block btnstatus reject";
																					}
                                        	?>
                                        		<button class="btn <?=$btn_style;?> btn-xs" data-id="<?=$datalv2['i_queue_dept'];?>" data-i_queue = "<?=$datalv2['i_queue'];?>" data-ref="<?=$datalv2['ref_no'];?>" ><?=$txt_status;?></button>
                                        	</td>
                                        </tr>
                                        <?php } ?>
                                            </tbody>
                                        </table>
                                            
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    <?php } ?>
                                    <?php $i++; } ?>
                                    <!-- END STEP1-->
                                   
                                   
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








            <!-- BEGIN MODAL -->
            
            <!-- BEGIN MODAL -->
            
            <?php include './commonModalQueue.php'; ?>
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
         <link href="css/custom.css" rel="stylesheet" type="text/css" />
        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <link href="outbound/lightbox/css/lightbox.css" rel="stylesheet" type="text/css" />
        <script src="outbound/lightbox/js/lightbox.js" type="text/javascript"></script>
        <script src="js/common/closeStep.js" type="text/javascript"></script>
        <script src="js/action/queue/queue_list.js?v=1" type="text/javascript"></script>
        <script>
                                                            $(document).ready(function () {
                                                                initialDataTable_1("TRUE");
                                                                unloading();
                                                            });
        </script>
    </body>

</html>