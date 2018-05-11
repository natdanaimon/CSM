var $datatable1 = $('#datatable-1');

function initialDataTable_1(first) {
    $.ajax({
        type: 'GET',
        url: 'controller/queue/createController.php?func=dataTableR10',
        beforeSend: function() {
            $('#se-pre-con').fadeIn(100);
        },
        success: function(data) {
            if (data == '') {
                var datatable = $datatable1.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            var res = JSON.parse(data);
            var JsonData = [];
            $.each(res, function(i, item) {

                var col_checkbox = "";
                var col_refno = item.ref_no + ' [ '+item.s_password+' ] ';
                var col_name = item.s_fullname;
                var col_license = item.s_license;


                var col_caryear = item.i_year;
                var col_carbrand = item.i_brand;
                var col_cargen = item.i_gen;
//                var col_carsub = item.i_sub; $_dataTable[$key]['i_brand'] = $service - > getBrand($_dataTable[$key]['s_brand_code']);

                var col_insurance = item.i_ins_comp;
//                var col_dmg = item.i_dmg;
                var col_inout = item.d_inbound + " - " + item.d_outbound_confirm;


                var col_status = "";
                var col_edit = "";
                var col_delete = "";

                col_checkbox = '<span class="md-checkbox has-success" style="padding-right: 0px;">';
                col_checkbox += '  <input type="checkbox" id="checkbox_' + i + '" name="checkboxItem" class="md-check"';
                col_checkbox += '  value="' + item.i_cust_car + '" onclick=remove_select_all("checkbox_' + i + '")>';
                col_checkbox += '  <label for="checkbox_' + i + '">';
                col_checkbox += '    <span class="inc"></span>';
                col_checkbox += '    <span class="check"></span>';
                col_checkbox += '    <span class="box"></span> </label>';
                col_checkbox += '</span>';




                col_status = '';
                col_status += '     <span class="badge badge-' + colorStatus(item.s_status) + '">' + sortHidden(item.s_status) + (language == "th" ? item.status_th : item.status_en) + '</span>';
                col_status += '';


                col_edit += '<a href="queue_createManage.php?func=add&id=' + item.ref_no + '" class="btn btn-circle btn-icon-only blue" style="width:32px;height:32px">';
                col_edit += ' <i class="fa fa-edit"></i>';
                col_edit += '</a>';

                col_delete += '<a href="' + (disable != "" ? '#' : 'javascript:Confirm(\'' + item.i_cust_car + '\',\'delete\');') + '" style="width:33px;height:33px" class="btn btn-circle btn-icon-only red" ' + disable + '>';
                col_delete += ' <i class="fa fa-archive" ></i>';
                col_delete += '</a>';


                var addRow = [
                    col_checkbox,
                    col_refno,
                    col_name,
                    col_license,
                    col_caryear,
                    col_carbrand,
                    col_cargen,
//                    col_carsub,
                    col_insurance,
//                    col_dmg,
                    col_inout,
                    col_status,
                    col_edit,
                    col_delete
                ]

                JsonData.push(addRow);

            });
            if (first == "TRUE") {
                $datatable1.dataTable({
                    data: JsonData,
                    order: [
                        [1, 'desc'],
                        [11, 'asc']
                    ],
                    columnDefs: [
                        { "orderable": false, "targets": 0 }
                    ]
                });
            } else {

                var datatable = $datatable1.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.rows.add(JsonData);
                datatable.draw();
            }
            notification();
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function(data) {

        }

    });
}



var $datatable = $('#datatable');
var $datatable_modal = $('#datatable_modal');


$('.find_ref').click(function(){
	//alert(1111);
});

$('.getInfoStaff').click(function(){
	
	
	
	var i_queue_dept = $(this).attr('data-id');
	var i_dept = $(this).attr('data-i_dept');
	var d_start_work = $(this).attr('data-d_start_work');
	
	getDDLEmployee(i_dept);
	$('#i_queue_dept_staff').val(i_queue_dept);
	$('#d_start_work').val(d_start_work);
	//alert(i_queue_dept)
	initialDataTableStaff(i_queue_dept);
	
	
});


function initialDataTableStaff(i_queue_dept){
	$.ajax({
        type: 'GET',
        url: 'controller/queue/createController.php?func=dataTableStaff&id=+'+i_queue_dept,
        beforeSend: function () {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {

           
            
            
            if (data == '') {
                var datatable = $datatable_modal.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                
                datatable.draw();
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            
            var res = JSON.parse(data);
            var JsonData = [];
            $.each(res, function (i, item) {

                var col_name = item.s_firstname + " " + item.s_lastname;
                var col_start = item.d_start_work;
                var col_end = item.d_end_work;



                var addRow = [
                    col_name,
                    col_start,
                    col_end
                ]

                JsonData.push(addRow);

            });
 
            if (i_queue_dept > 0) {
                $datatable_modal.dataTable({
                    data: JsonData,
                    destroy: true,
                    order: [
                        [0, 'asc'],
                        [1, 'asc'],
                        [2, 'asc']
                    ],
                    columnDefs: [
                        {"orderable": false, "targets": 0}
                    ]
                });
            } else {

                var datatable = $datatable_modal.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.rows.add(JsonData);
                datatable.draw();
            }
            $('#se-pre-con').delay(100).fadeOut();
            

        },
        error: function (data) {

        }

    });
}
/**
Save Staff
*/
$('#btn_save_staff').click(function(){
 
        var i_staff_id =  $('#i_staff_id').val();
        //alert(i_staff_id)
        if(i_staff_id == null){
        	$('#i_staff_id').notify("กรุณาเลือกช่าง", "error");
					return false;
				}
				//return false;
        var formData = new FormData($('#formdate_staff')[0]);
        //alert($('#d_start_work').val())
        $.ajax({
            type: 'POST',
            url: 'controller/queue/createController.php',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                //$('#se-pre-con').fadeIn(100);
            },
            success: function(data) {
                var res = data.split(",");
                if (res[0] == "0000") {
                    var errCode = "Code (" + res[0] + ") : " + res[1];
                    $.notify(errCode, "success");
                } else {
                    var errCode = "Code (" + res[0] + ") : " + res[1];
                    $.notify(errCode, "error");
                    //fix
                    //$('#se-pre-con').delay(100).fadeOut();
                    return;
                }

                notification();
                initialDataTableStaff($('#i_queue_dept_staff').val());
                
                
                
            },
            error: function(data) {

            }
        });

});
/*
Update status
*/
$(".btnstatus").click(function(){
   var i_queue = $(this).attr("data-i_queue");
   var ref_no = $(this).attr("data-ref");
   var id = $(this).attr("data-id");
   var app_rej = '0';
   if($(this).hasClass('approve')){
      $(this).addClass('reject btn-warning');
      $(this).removeClass('approve btn-success');
      $(this).html('<i class="fa fa-times"></i> กำลังดำเนินการ');
      app_rej = '0';
  }else if($(this).hasClass('reject')){
      $(this).removeClass('reject btn-warning');
      $(this).addClass('approve btn-success');
      $(this).html('<i class="fa fa-check"></i> สำเร็จ');
      app_rej = '1';
  }


$.post("controller/queue/createController.php", { func : "UpdateStatus", id : id , i_status : app_rej , i_queue : i_queue , ref_no : ref_no  }, function(data){ 
var res = data.split(",");
                if (res[0] == "0000") {
                    var errCode = "Code (" + res[0] + ") : " + res[1];
                    $.notify(errCode, "success");
                    location.reload();
                    //$('#'+id).delay(100).fadeOut();
                } else {
                    var errCode = "Code (" + res[0] + ") : " + res[1];
                    $.notify(errCode, "error");
                    //fix
                    //$('#se-pre-con').delay(100).fadeOut();
                    return;
                }
	});
 
     
     
  });
/*
tb_employee
*/
function getDDLEmployee(i_dept) {
    //alert(i_dept)
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLEmployeeDept&id='+i_dept,
        beforeSend: function() {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function(data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function(i, item) {
                var txt_status = (language == "th" ? item.text : item.text);
                htmlOption += "<option value='" + item.id + "'>" + txt_status + "</option>";
            });
            $("#i_staff_id").html(htmlOption);


        },
        error: function(data) {
            getDDLInsuranceType();
        }

    });
}

function initialDataTable(first) {
    $.ajax({
        type: 'GET',
        url: 'controller/exp/createController.php?func=dataTable',
        beforeSend: function() {
            $('#se-pre-con').fadeIn(100);
        },
        success: function(data) {
            if (data == '') {
                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            var res = JSON.parse(data);
            var JsonData = [];
            $.each(res, function(i, item) {

                var col_checkbox = "";
                var col_refno = item.s_po_daily_ref;
                var col_license = item.s_firstname+" "+item.s_lastname;
                //var col_name = item.s_firstname+" "+item.s_lastname;
                var col_name = item.s_comp_th;


                var col_caryear = item.s_po_daily_ref;
                var col_carbrand = item.s_po_daily_ref;
                var col_cargen = item.s_po_daily_ref;
                var col_carsub = item.s_po_daily_ref;
                var col_insurance = item.s_po_daily_ref;
//                var col_dmg = item.i_dmg;
                var col_inout = item.s_po_daily_ref;


                var col_status = "";
                var col_edit = "";
                var col_delete = "";
                var col_view = "";

                col_checkbox = '<span class="md-checkbox has-success" style="padding-right: 0px;">';
                col_checkbox += '  <input type="checkbox" id="checkbox_' + i + '" name="checkboxItem" class="md-check"';
                col_checkbox += '  value="' + item.i_po_daily + '" onclick=remove_select_all("checkbox_' + i + '")>';
                col_checkbox += '  <label for="checkbox_' + i + '">';
                col_checkbox += '    <span class="inc"></span>';
                col_checkbox += '    <span class="check"></span>';
                col_checkbox += '    <span class="box"></span> </label>';
                col_checkbox += '</span>';




                col_status = '';
                col_status += '     <span class="badge badge-' + colorStatus(item.s_status) + '">' +   (language == "th" ? item.status_th : item.status_en) + '</span>';
                col_status += '';



                col_view += '<a href="exp_daily_views.php?func=edit&id=' + item.i_po_daily + '" class="btn btn-circle btn-icon-only blue" style="width:32px;height:32px" target="_blank">';
                col_view += ' <i class="fa fa-eye"></i>';
                col_view += '</a>';
                
                col_edit += '<a href="exp_daily_createManage.php?func=edit&id=' + item.i_po_daily + '" class="btn btn-circle btn-icon-only blue" style="width:32px;height:32px">';
                col_edit += ' <i class="fa fa-edit"></i>';
                col_edit += '</a>';

                col_delete += '<a href="' + (disable != "" ? '#' : 'javascript:Confirm(\'' + item.i_po_daily + '\',\'delete\');') + '" style="width:33px;height:33px" class="btn btn-circle btn-icon-only red" ' + disable + '>';
                col_delete += ' <i class="fa fa-archive" ></i>';
                col_delete += '</a>';


                var addRow = [
                    col_checkbox,
                    col_refno,
                     
                     
                     
                    col_name,
                    col_license,
                    col_caryear,
                    col_carbrand,
                    col_cargen,
                    col_carsub,
                    //col_insurance,
//                    col_dmg,
                    col_inout,
                    col_status,
                    col_view,
                    col_edit,
                    col_delete
                ]

                JsonData.push(addRow);

            });
            if (first == "TRUE") {
                $datatable.dataTable({
                    data: JsonData,
                    order: [
                        [1, 'desc'],
                        [11, 'asc']
                    ],
                    columnDefs: [
                        { "orderable": false, "targets": 0 }
                    ]
                });
            } else {

                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.rows.add(JsonData);
                datatable.draw();
            }
            notification();
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function(data) {

        }

    });
}

function colorStatus(status) {
    if (status == "R12") {
        return "success";
    } else if (status == "R0") {
        return "danger";
    }else{
        return "warning";
    }
}

function sortHidden(status) {
    if (status == "R1") {
        return "<span style='display:none;'>1</span>";
    } else if (status == "R2") {
        return "<span style='display:none;'>2</span>";
    } else if (status == "R3") {
        return "<span style='display:none;'>3</span>";
    } else if (status == "R4") {
        return "<span style='display:none;'>4</span>";
    } else if (status == "R5") {
        return "<span style='display:none;'>5</span>";
    } else if (status == "R6") {
        return "<span style='display:none;'>6</span>";
    } else if (status == "R7") {
        return "<span style='display:none;'>7</span>";
    } else if (status == "R8") {
        return "<span style='display:none;'>8</span>";
    }else if (status == "R9") {
        return "<span style='display:none;'>9</span>";
    }else if (status == "R10") {
        return "<span style='display:none;'>10</span>";
    }else if (status == "R11") {
        return "<span style='display:none;'>11</span>";
    }else if (status == "R12") {
        return "<span style='display:none;'>12</span>";
    }else if (status == "R0") {
        return "<span style='display:none;'>13</span>";
    }else if (status == "RX") {
        return "<span style='display:none;'>X</span>";
    }
}


$('#checkbox14').click(function() {
    var checkboxes = $('input[name$=checkboxItem]');
    var array = [];
    $('input[name$="checkboxItem"]').each(function() {
        array.push($(this).attr('id'));
    });
    if ($(this).is(':checked')) {
        checkboxes.prop('checked', true);
        var names = [];
        names = jQuery.unique(array);
        $.each(names, function(key, value) {
            $('input:checkbox[id=' + value + ']').attr('checked', true);
        });
    } else {
        checkboxes.prop('checked', false);
        var names = [];
        names = jQuery.unique(array);
        $.each(names, function(key, value) {
            $('input:checkbox[id=' + value + ']').attr('checked', false);
        });
    }
});

function remove_select_all(id) {
    var selected = [];
    if ($("#" + id).is(':checked')) {
        $('input:checkbox[id=' + id + ']').attr('checked', true);

        //set element select all selected
        var array = [];
        $('input[name$="checkboxItem"]').each(function() {
            array.push($(this).attr('id'));
        });
        var names = [];
        names = jQuery.unique(array);
        $.each(names, function(key, value) {
            if ($("#" + value).is(':checked')) {
                selected.push($("#" + value).val());
            }
        });
        if (selected.length == array.length) {
            var ck_select_all = $('#checkbox14');
            ck_select_all.prop('checked', true);
        }


    } else {
        $('input:checkbox[id=' + id + ']').attr('checked', false);
        var ck_select_all = $('#checkbox14');
        ck_select_all.prop('checked', false);
    }
}

function deleteAll() {
    $('#se-pre-con').fadeIn(100);
    $.notify.addStyle('foo', {
        html: "<div>" +
            "<div class='clearfix'>" +
            "<div class='title' data-notify-html='title'/>" +
            "<div class='buttons'>" +
            "<button class='notify-all-no btn red'>" + cancel + "</button>" +
            "<button class='notify-all-yes btn green'>" + yes + "</button>" +
            "</div>" +
            "</div>" +
            "</div>"
    });

    $.notify({
        title: titleCancel,
        button: 'Confirm'
    }, {
        style: 'foo',
        autoHide: false,
        clickToHide: false
    });

}
$(document).on('click', '.notifyjs-foo-base .notify-all-no', function() {
    $('#se-pre-con').delay(100).fadeOut();
    $(this).trigger('notify-hide');
});
$(document).on('click', '.notifyjs-foo-base .notify-all-yes', function() {
    $(this).trigger('notify-hide');
    var selected = [];
    var array = [];
    $('input[name$="checkboxItem"]').each(function() {
        array.push($(this).attr('id'));
    });
    var names = [];
    names = jQuery.unique(array);
    $.each(names, function(key, value) {
        if ($("#" + value).is(':checked')) {
            //alert($("#" + value).val());
            selected.push($("#" + value).val());

        }
    });
    var jsonData = selected;

    $.ajax({
        type: 'GET',
        url: 'controller/repair/createController.php',
        data: { data: jsonData, func: "deleteAll" },
        beforeSend: function() {
            $('#se-pre-con').fadeIn(100);
        },
        success: function(data) {

            var res = data.split(",");
            if (res[0] == "0000") {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "success");
            } else {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "error");

            }
            $('#se-pre-con').delay(100).fadeOut();
            initialDataTable("FALSE");
        },
        error: function(data) {

        }

    });

});






function edit() {
    
    $.ajax({
        type: 'GET',
 
        url: 'controller/exp/createController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function() {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function(data) {
            var res = JSON.parse(data);
            $.each(res, function(i, item) {
                debugger;
                $("#s_po_daily_ref").val(item.s_po_daily_ref);
                $("#d_daily_order").val(item.d_daily_order);
                $("#i_daily_shop").val(item.i_daily_shop);
                $("#i_daily_receive").val(item.i_daily_receive);
                $("#d_daily_receive").val(item.d_daily_receive);
                
                $("#status").val(item.s_status);
                
                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);
                
            });
            warring();
            //            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function(data) {

        }

    });
}







function Confirm(txt, func) {
    $('#se-pre-con').fadeIn(100);
    $.notify.addStyle('foo', {
        html: "<div>" +
            "<div class='clearfix'>" +
            "<div class='title' data-notify-html='title'/>" +
            "<div class='buttons'>" +
            "<input type='hidden' id='id' value='" + txt + "' />" +
            "<input type='hidden' id='func' value='" + func + "' />" +
            "<button class='notify-no btn red'>" + cancel + "</button>" +
            "<button class='notify-yes btn green'>" + yes + "</button>" +
            "</div>" +
            "</div>" +
            "</div>"
    });

    $.notify({
        title: titleCancel,
        button: 'Confirm'
    }, {
        style: 'foo',
        autoHide: false,
        clickToHide: false
    });

}
$(document).on('click', '.notifyjs-foo-base .notify-no', function() {
    $('#se-pre-con').delay(100).fadeOut();
    $(this).trigger('notify-hide');
});
$(document).on('click', '.notifyjs-foo-base .notify-yes', function() {
    $(this).trigger('notify-hide');
    var id = $("#id").val();
    var func = $("#func").val();

    $.ajax({
        type: 'GET',
        url: 'controller/repair/createController.php?func=' + func + '&id=' + id,
        beforeSend: function() {
            $('#se-pre-con').fadeIn(100);
        },
        success: function(data) {

            var res = data.split(",");
            if (res[0] == "0000") {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "success");
            } else {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "error");

            }
            $('#se-pre-con').delay(100).fadeOut();
            initialDataTable("FALSE");
        },
        error: function(data) {

        }

    });

});