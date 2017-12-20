function getDDLStatus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLStatusActive',
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_detail_th : item.s_detail_en);
                htmlOption += "<option value='" + item.s_status + "'>" + txt_status + "</option>";
            });
            $("#status").html(htmlOption);

            getDDLTitle();

        },
        error: function (data) {
            getDDLTitle();
        }

    });
}

function getDDLTitle() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLTitle',
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_title_th : item.s_title_en);
                htmlOption += "<option value='" + item.i_title + "'>" + txt_status + "</option>";
            });
            $("#i_title").html(htmlOption);

            getDDLProvince();

        },
        error: function (data) {
            getDDLProvince();
        }

    });
}

function getDDLProvince() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLProvince',
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                htmlOption += "<option value=''>" + pleaseSelect + "</option>";
                $("#i_province").html(htmlOption);
                return;
            }
            var htmlOption = "";
            var res = JSON.parse(data);
            htmlOption += "<option value=''>" + pleaseSelect + "</option>";
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_name_th : item.s_name_en);
                htmlOption += "<option value='" + item.i_province + "'>" + txt_status + "</option>";
            });
            $("#i_province").html(htmlOption);
            getDDLAmphure();
            if (keyEdit != "") {
                $('#div-tb-refno').attr("style", "display:block");
                edit();
            }

        },
        error: function (data) {
            edit();
        }

    });
}

function getDDLAmphure() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLAmphure&i_province=' + $("#i_province").val(),
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                htmlOption += "<option value=''>" + pleaseSelect + "</option>";
                $("#i_amphure").html(htmlOption);
                getDDLDistrict();
                return;
            }
            var htmlOption = "";
            var res = JSON.parse(data);
            htmlOption += "<option value=''>" + pleaseSelect + "</option>";
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_name_th : item.s_name_en);
                htmlOption += "<option value='" + item.i_amphure + "'>" + txt_status + "</option>";
            });
            $("#i_amphure").html(htmlOption);
            getDDLDistrict();
        },
        error: function (data) {
            getDDLDistrict();
        }

    });
}

function getDDLDistrict() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLDistrict&i_amphure=' + $("#i_amphure").val(),
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                htmlOption += "<option value=''>" + pleaseSelect + "</option>";
                $("#i_district").html(htmlOption);
                getDDLZipcode();
                return;
            }
            var htmlOption = "";
            var res = JSON.parse(data);
            htmlOption += "<option value=''>" + pleaseSelect + "</option>";
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_name_th : item.s_name_en);
                htmlOption += "<option value='" + item.i_district + "'>" + txt_status + "</option>";
            });
            $("#i_district").html(htmlOption);
            getDDLZipcode();
        },
        error: function (data) {
            getDDLZipcode();
        }

    });
}

function getDDLZipcode() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLZipcode&i_district=' + $("#i_district").val(),
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                htmlOption += "<option value=''>" + pleaseSelect + "</option>";
                $("#i_zipcode").html(htmlOption);
                return;
            }
            var htmlOption = "";
            var res = JSON.parse(data);
            htmlOption += "<option value=''>" + pleaseSelect + "</option>";
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.i_zipcode : item.i_zipcode);
                htmlOption += "<option value='" + item.i_zipcode + "'>" + txt_status + "</option>";
            });
            $("#i_zipcode").html(htmlOption);

        },
        error: function (data) {

        }

    });
}


function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/customer/customerController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                initialDataTable("TRUE", item.i_customer);
                $("#i_title").val(item.i_title);
                $("#s_firstname").val(item.s_firstname);
                $("#s_lastname").val(item.s_lastname);

                $("#s_phone_1").val(item.s_phone_1);
                $("#s_phone_2").val(item.s_phone_2);

                $("#s_email").val(item.s_email);
                $("#s_line").val(item.s_line);

                $("#s_address").val(item.s_address);
                $("#i_province").val(item.i_province);
                //getDDLAmphure();
                //       $("#i_amphure").val(item.i_amphure); //
                //     getDDLDistrict();
                //   $("#i_district").val(item.i_district);
                //  getDDLZipcode();
                // $("#i_zipcode").val(item.i_zipcode);
                setDDLAmphure(item.i_amphure, item.i_district, item.i_zipcode);

                $("#status").val(item.s_status);
                $('#tmp_s_img').val(item.s_image);
                if (item.s_image != "") {
                    $('#img1').attr('src', 'upload/customer/' + item.s_image);
                }


                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);
            });

            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}


function save() {
    $('#form-action').submit(function (e) {
        e.preventDefault();
        console.log($(this).serialize());
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: 'controller/customer/customerController.php',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#se-pre-con').fadeIn(100);
            },
            success: function (data) {
                var res = data.split(",");
                if (res[0] == "0000") {
                    var errCode = "Code (" + res[0] + ") : " + res[1];
                    $.notify(errCode, "success");
                } else {
                    var errCode = "Code (" + res[0] + ") : " + res[1];
                    $.notify(errCode, "error");
                    //fix
                    $('#se-pre-con').delay(100).fadeOut();
                    return;
                }

                notification();
                $('#form-action').each(function () {
                    setTimeout(reloadTime, 1000);
                });
            },
            error: function (data) {

            }
        });
    });
}



function setDDLAmphure(i_amphure, i_district, i_zipcode) {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLAmphure&i_province=' + $("#i_province").val(),
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                htmlOption += "<option value=''>" + pleaseSelect + "</option>";
                $("#i_amphure").html(htmlOption);
                getDDLDistrict();
                return;
            }
            var htmlOption = "";
            var res = JSON.parse(data);
            htmlOption += "<option value=''>" + pleaseSelect + "</option>";
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_name_th : item.s_name_en);
                htmlOption += "<option value='" + item.i_amphure + "'>" + txt_status + "</option>";
            });
            $("#i_amphure").html(htmlOption);
            $("#i_amphure").val(i_amphure);
            setDDLDistrict(i_amphure, i_district, i_zipcode);
        },
        error: function (data) {
            setDDLDistrict(i_amphure, i_district, i_zipcode);
        }

    });
}

function setDDLDistrict(i_amphure, i_district, i_zipcode) {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLDistrict&i_amphure=' + i_amphure,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                htmlOption += "<option value=''>" + pleaseSelect + "</option>";
                $("#i_district").html(htmlOption);
                getDDLZipcode();
                return;
            }
            var htmlOption = "";
            var res = JSON.parse(data);
            htmlOption += "<option value=''>" + pleaseSelect + "</option>";
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_name_th : item.s_name_en);
                htmlOption += "<option value='" + item.i_district + "'>" + txt_status + "</option>";
            });
            $("#i_district").html(htmlOption);
            $("#i_district").val(i_district);
            setDDLZipcode(i_amphure, i_district, i_zipcode);
        },
        error: function (data) {
            setDDLZipcode(i_amphure, i_district, i_zipcode);
        }

    });
}

function setDDLZipcode(i_amphure, i_district, i_zipcode) {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLZipcode&i_district=' + i_district,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
                htmlOption += "<option value=''>" + pleaseSelect + "</option>";
                $("#i_zipcode").html(htmlOption);
                return;
            }
            var htmlOption = "";
            var res = JSON.parse(data);
            htmlOption += "<option value=''>" + pleaseSelect + "</option>";
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.i_zipcode : item.i_zipcode);
                htmlOption += "<option value='" + item.i_zipcode + "'>" + txt_status + "</option>";
            });
            $("#i_zipcode").html(htmlOption);
            $("#i_zipcode").val(i_zipcode);

        },
        error: function (data) {

        }

    });
}







var $datatable = $('#datatable');

function initialDataTable(first, id) {
    $.ajax({
        type: 'GET',
        url: 'controller/repair/createController.php?func=dataTableKey&id=' + id,
        beforeSend: function () {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
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
            $.each(res, function (i, item) {

                var col_checkbox = "";
                var col_refno = "";
                var col_license = item.s_license;
                var col_car = item.i_year + " : " + item.i_brand + " : " + item.i_gen + " : " + item.i_sub;
                var col_status = "";


                col_refno = '<a href="#"   style="color:red;font-size: 16px;">';
                col_refno += item.ref_no;
                col_refno += '</a>';
         



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


                var addRow = [
                    col_refno,
                    col_license,
                    col_car,
                    col_status
                ]

                JsonData.push(addRow);

            });
            if (first == "TRUE") {
                $datatable.dataTable({
                    data: JsonData,
                    order: [
                        [0, 'desc']
                    ],
                    columnDefs: [
                        {"orderable": false, "targets": 0}
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
        error: function (data) {

        }

    });
}

function colorStatus(status) {
    if (status == "A") {
        return "success";
    } else if (status == "C") {
        return "danger";
    }
}

function sortHidden(status) {
    if (status == "A") {
        return "<span style='display:none;'>1</span>";
    } else if (status == "C") {
        return "<span style='display:none;'>2</span>";
    }
}
