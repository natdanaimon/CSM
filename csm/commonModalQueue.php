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
        <div class="modal fade" id="staffManage" role="dialog" style="top: 30px;">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">

                    <div class="modal-body">
                       <div style=" padding: 10px;border: 1px solid #ccc; border-radius: 10px !important;">
                       	เพิ่มช่าง
                       	<form id="formdate_staff" name="formdate_staff" method="post" enctype="multipart/form-data">
                       	<input type="hidden" id="func" name="func" value="addStaff"/>
                       	<input type="hidden" name="i_queue_dept_staff" id="i_queue_dept_staff"/>
                       	<table cellpadding="5" cellspacing="5" style="padding: 5px !important;" >
                       		<tr>
                       			<td>ช่าง</td>
                       			<td width="10"></td>
                       			<td>
                       				<select name="i_staff_id" id="i_staff_id">
                       					
                       				</select>
                       			</td>
                       			
                       		</tr>
                       		<tr>
                       			<td>วันที่เริ่มซ่อม</td>
                       			<td width="10"></td>
                       			<td>
                       			
                       			<input type="date" id="d_start_work" name="d_start_work"   />
                       			
                       			</td>
                       		</tr>
                       		<tr>
                       			<td></td>
                       			<td></td>
                       			<td>
                       				<button type="button" class="btn btn-success" id="btn_save_staff">Save Data</button>
                       			</td>
                       		</tr>
                       	</table>
                       	
                       	</form>
                       </div> 
                       
                       <br />
                        
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable_modal">
                            <thead>


                                    <!--<th align="left">  Ref. no </th>-->
                                    <th>  ชื่อช่าง </th>
                                    <th>  วันที่เริ่มซ่อม </th>
                                    <th>  วันที่ซ่อมเสร็จ </th>

                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
