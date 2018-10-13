<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <!-- Modal -->
        <div class="modal fade" id="statusManage" role="dialog" style="top: 30px;">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">

                    <div class="modal-body">
                      <form id="form_updatestatus" name="form_updatestatus" method="post" enctype="multipart/form-data"> 
                      <div style=" padding: 10px;border: 1px solid #ccc; border-radius: 10px !important;">
                       	
                       	
                       	<input type="hidden" id="func" name="func" value="addStatusForm"/>
                       	<input type="hidden" name="i_queue_dept_staff" id="i_queue_dept_staff"/>
                       	<input type="hidden" name="i_status" id="md_i_status"/>
                       	<input type="hidden" name="i_queue" id="md_i_queue"/>
                       	<input type="hidden" name="ref_no" id="md_ref_no"/>
                       	<input type="hidden" name="i_queue_dept" id="md_i_queue_dept"/>
                       	<table cellpadding="5" cellspacing="5" style="padding: 10px !important;" >

                       		<tr style="height: 35px;">
                       			<td>วันที่ซ่อมเสร็จ</td>
                       			<td width="10"></td>
                       			<td>
                       			
                                  <input type="date" id="d_start_work" name="d_start_work"  class="form-control"  value="<?=date('Y-m-d');?>"  />
                       			
                       			</td>
                                <td width="80" align="right">เวลา</td>
                                <td>
                                  <input type="time" id="t_start_work" name="t_start_work"  class="form-control"  value="<?=date('H:i');?>"  />
                                </td>
                       		</tr>
                       	</table>
                       	
                       	
                       </div> 
                       
                       <br />
                        
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable_modalstatus">
                            <thead>


                                    <!--<th align="left">  Ref. no </th>-->
                                    <th>  ชื่อช่าง </th>
                                    <th>  วันที่ / เวลา เริ่มซ่อม </th>
                                    <th>  วันที่ ซ่อมเสร็จ </th>
                                    <th>  เวลา ซ่อมเสร็จ </th>
                                    <th width="30">  Work </th>
                                    <th width="30">  OT </th>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="btn_save_status">Save Data</button>
                    </div>
                </div>

            </div>
        </div>
        <script src="../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>

        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                //initialRef("TRUE");

            });
        </script>
    </body>
</html>
