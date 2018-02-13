function getDDLStatus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLStatusRepart',
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

            initialCheckBox();

        },
        error: function (data) {
            getDDLInsuranceType();
        }

    });
}

function initialCheckBox() {

    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=CheckBoxCheckRepair',
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == "") {
//                htmlOption += "<option value=''>" + pleaseSelect + "</option>";
//                $("#").html(htmlOption);
                return;
            }
            var htmlOption = "";
            var res = JSON.parse(data);
            var count = 1;
            $.each(res, function (i, item) {
                if (count == 2) {
                    count = 0;
                }


                if (count == 0) {
                    htmlOption += '<div class="row">';
                }

                htmlOption += '<div class="col-md-3 col-sm-12" style="padding-top: 10px;display:inline-flex;">';
                htmlOption += '<span class=" md-checkbox has-success" >';
                htmlOption += '  <input disabled type="checkbox" id="i_repair_item_' + item.i_repair_item + '" name="i_repair_item_' + item.i_repair_item + '" class="md-check"';
                htmlOption += '  value="' + item.i_repair_item + '" >';
                htmlOption += '  <label for="i_repair_item_' + item.i_repair_item + '">';
                htmlOption += '    <span class="inc"></span>';
                htmlOption += '    <span class="check"></span>';
                htmlOption += '    <span class="box"></span> ' + item.s_repair_name + '</label>';
                htmlOption += '</span>';
//                htmlOption += ' &nbsp;<a href="javascript:UploadMultifile(' + item.i_repair_item + ');"><span class="fa fa-cloud-upload"></span></a>';

                htmlOption += '<a id="imgpopup_' + item.i_repair_item + '" title="รูปภาพประกอบ" class="example-image-link" href="" data-lightbox="example-' + item.i_repair_item + '">';
                htmlOption += ' <span><img src="images/photos-app-icon.png" width="18px" height="18px" id="img_' + item.i_repair_item + '" name="img_' + item.i_repair_item + '"  style="display:none;" ></span>';
                htmlOption += '</a>';
//                htmlOption += '<input type="hidden" id="ck_' + item.i_repair_item + '" name="ck_' + item.i_repair_item + '" value="" style="display:none;" >';
//
//                htmlOption += '<input type="file" id="file_' + item.i_repair_item + '" name="file_' + item.i_repair_item + '" value="" style="display:none;" onchange="return fileValidation(' + item.i_repair_item + ')"  >';

                htmlOption += '</div>';





                htmlOption += '<div class="col-md-3 col-sm-12">';
                htmlOption += '<div class="form-group form-md-line-input has-success" style="padding-top:0px !important;" >';
                htmlOption += '<input disabled type="text" class="form-control bold required" id="s_repair_item_' + item.i_repair_item + '" name="s_repair_item_' + item.i_repair_item + '" >';
                htmlOption += '</div>';
                htmlOption += '</div>';

//                htmlOption += '<div class="col-md-1">';
//                htmlOption += '</div>';
                if (count == 0) {
                    htmlOption += "</div>";
                }

                count++;

            });

            $("#div_checkbox_repair").html(htmlOption);
            initialCheckBoxOther();
        },
        error: function (data) {

        }

    });




}


function UploadMultifile(id) {
    $('#file_' + id).click();
}

function UploadMultifileOther(id) {
    $('#files_' + id).click();
}


function fileValidation(id) {
    $('#img_' + id).attr('style', 'display:none;');
    var fileInput = document.getElementById('file_' + id);
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if ($('#file_' + id).get(0).files.length != 0) {
        if (!allowedExtensions.exec(filePath)) {
            var errCode = "Code (2201) : ประเภทไฟล์ที่ทำการอัพโหลดไม่ถูกต้อง";
            $.notify(errCode, "error");
            fileInput.value = '';
            return false;
        } else {
            //Image preview
            if (fileInput.files && fileInput.files[0]) {

                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imgpopup_' + id).attr('href', e.target.result)
                };
                reader.readAsDataURL(fileInput.files[0]);
                $('#img_' + id).attr('style', 'display:block;');
                $('#ck_' + id).val('');
            }
        }
    }

}


function fileValidations(id) {
    $('#imgs_' + id).attr('style', 'display:none;');
    var fileInput = document.getElementById('files_' + id);
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if ($('#files_' + id).get(0).files.length != 0) {
        if (!allowedExtensions.exec(filePath)) {
            var errCode = "Code (2201) : ประเภทไฟล์ที่ทำการอัพโหลดไม่ถูกต้อง";
            $.notify(errCode, "error");
            fileInput.value = '';
            return false;
        } else {
            //Image preview
            if (fileInput.files && fileInput.files[0]) {

                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imgpopups_' + id).attr('href', e.target.result)
                };
                reader.readAsDataURL(fileInput.files[0]);
                $('#imgs_' + id).attr('style', 'display:block;');
                $('#cks_' + id).val('');
            }
        }
    }

}



function initialCheckBoxOther() {
    var htmlOption = "";

    var count = 1;
    for (i = 1; i < 14; i++) {
        if (count == 2) {
            count = 0;
        }


        if (count == 0) {
            htmlOption += '<div class="row">';
        }

        htmlOption += '<div class="col-md-3 col-sm-12" style="padding-top: 10px;display:inline-flex;">';
        htmlOption += '<span class=" md-checkbox has-success" style="display: inherit;">';
        htmlOption += '  <input disabled type="checkbox" id="i_repair_subitem_' + i + '" name="i_repair_subitem_' + i + '" class="md-check"';
        htmlOption += '  value="' + i + '" >';
        htmlOption += '  <label for="i_repair_subitem_' + i + '">';
        htmlOption += '    <span class="inc"></span>';
        htmlOption += '    <span class="check"></span>';
        htmlOption += '    <span class="box"></span> ' + i + '.</label>';
//        htmlOption += ' &nbsp;<a href="javascript:UploadMultifileOther(' + i + ');"><span class="fa fa-cloud-upload"></span></a>';

        htmlOption += '<a id="imgpopups_' + i + '" title="รูปภาพประกอบ" class="example-image-link" href="" data-lightbox="examples-' + i + '">';
        htmlOption += ' <img src="images/photos-app-icon.png" width="18px" height="18px" id="imgs_' + i + '" name="imgs_' + i + '"  style="display:none;" >';
        htmlOption += '</a>';
//        htmlOption += '<input type="hidden" id="cks_' + i + '" name="cks_' + i + '" value="" style="display:none;" >';
//        htmlOption += '<input type="file" id="files_' + i + '" name="files_' + i + '" value="" style="display:none;" onchange="return fileValidations(' + i + ')"  >';

        htmlOption += '</div>';

        htmlOption += '<div class="col-md-3 col-sm-12">';
        htmlOption += '<div class="form-group form-md-line-input has-success" style="padding-top:0px !important;" >';
        htmlOption += '<input disabled type="text" class="form-control bold required" id="s_repair_subitem_' + i + '" name="s_repair_subitem_' + i + '" >';
        htmlOption += '</div>';
        htmlOption += '</div>';

//        htmlOption += '<div class="col-md-1">';
//        htmlOption += '</div>';
        if (count == 0) {
            htmlOption += "</div>";
        }

        count++;

    }

    $("#div_checkbox_repair_other").html(htmlOption);
    getDDLInsuranceType();

}



function getDDLInsuranceType() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLInsuranceType',
        beforeSend: function () {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            var html = "";
            $.each(res, function (i, item) {
                var checked = "";
                if (keyEdit == "") {
                    checked = (i == 0 ? "checked" : "");
                    if (checked != "") {
                        $('#i_ins_type').val(item.i_ins_type);
                    }
                }
                html += '<div class="md-radio">';
                html += '<input type="radio" id="i_ins_type' + item.i_ins_type + '" onchange="setRadio(\'' + item.i_ins_type + '\')"   value="' + item.i_ins_type + '" name="tmp_i_ins_type" class="md-radiobtn"  ' + checked + ' />';
                html += '<label for="i_ins_type' + item.i_ins_type + '">';
                html += '<span></span>';
                html += '<span class="check"></span>';
                html += '<span class="box"></span> ' + item.s_name + ' </label>';
                html += '</div>';

            });
            $("#insurance_type").html(html);
            getDDLPayType();
        },
        error: function (ddl) {

        }



    });
}



function getDDLPayType() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLPayType',
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_detail : item.s_detail);
                htmlOption += "<option value='" + item.s_pay_type + "'>" + txt_status + "</option>";
            });
            $("#s_pay_type").html(htmlOption);

            getDDLInsurance();

        },
        error: function (data) {
            getDDLProvince();
        }

    });
}


function formatStateComp(state) {
    if (!state.id) {
        return state.text;
    }
    var pathImg = "";
    if (state.img == "") {
        pathImg = "images/noImage.jpeg";
    } else {
        pathImg = "upload/compInsurance/" + state.img;
    }


    var $state = $(
            '<span><img src="' + pathImg + '" width="50px" height="50px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
            );
    return $state;
}

function getDDLInsurance() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLInsurance',
        beforeSend: function () {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#i_ins_comp").select2({
                data: res,
                templateResult: formatStateComp,
                templateSelection: formatStateComp

            });

            getDDLDamage();

        },
        error: function (ddl) {

        }



    });
}




function getDDLDamage() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLDamage',
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            htmlOption += "<option value=''>กรุณาเลือกข้อมูล</option>";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                var txt_status = (language == "th" ? item.s_dmg_th : item.s_dmg_en);
                htmlOption += "<option value='" + item.i_dmg + "'>" + txt_status + "</option>";
            });
            $("#i_dmg").html(htmlOption);

            getDDLTitle();

        },
        error: function (data) {
            getDDLProvince();
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
            getDDLYear();
            getDDLBrand();

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
                $('#div-refno').attr("style", "display:block");
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

function getDDLYear() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLYear',
        beforeSend: function () {},
        success: function (ddl) {
            debugger;
            var htmlOption = "";
            var res = JSON.parse(ddl);
            $.each(res, function (i, item) {
                htmlOption += "<option value='" + item.id + "'>" + item.text + "</option>";
            });
            $("#i_year").html(htmlOption);


        },
        error: function (ddl) {

        }



    });
}


function getDDLBrand() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLBrand',
        beforeSend: function () {},
        success: function (ddl) {
            debugger;
            var htmlOption = "";
            var res = JSON.parse(ddl);
            $.each(res, function (i, item) {
                htmlOption += "<option value='" + item.id + "'>" + item.id + " : " + item.text + "</option>";
            });
            $("#s_brand_code").html(htmlOption);
            getDDLGenSelect();

        },
        error: function (ddl) {

        }



    });
}

function getDDLGenSelect() {
    var brandCode = $("#s_brand_code").val();
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLGenerationSelect&s_brand_code=' + brandCode,
        beforeSend: function () {},
        success: function (ddl) {
            debugger;
            var htmlOption = "";
            var res = JSON.parse(ddl);
            $.each(res, function (i, item) {
                htmlOption += "<option value='" + item.s_gen_code + "'>" + item.s_gen_code + " : " + item.s_gen_name + "</option>";
            });
            $("#s_gen_code").html(htmlOption);


        },
        error: function (ddl) {

        }



    });
}


function getDDLGenSelectEdit(brandCode) {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLGenerationSelect&s_brand_code=' + brandCode,
        beforeSend: function () {},
        success: function (ddl) {
            debugger;
            var htmlOption = "";
            var res = JSON.parse(ddl);
            $.each(res, function (i, item) {
                htmlOption += "<option value='" + item.s_gen_code + "'>" + item.s_gen_code + " : " + item.s_gen_name + "</option>";
            });
            $("#s_gen_code").html(htmlOption);


        },
        error: function (ddl) {

        }
    });
}

function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/repair/processController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#i_customer").val(item.i_customer);
                $("#ref_no").val(item.ref_no);
                //radio
                radio_type(item.i_ins_type);

                editCustomer(item.i_customer);

                editCheckBoxMain(item.ref_no);
                editCheckBoxOther(item.ref_no);

                setImageCount(item.ref_no);


                $("#i_ins_comp").val(item.i_ins_comp).trigger('change');
                $("#d_inbound").val(item.d_inbound);
                $("#d_outbound_confirm").val(item.d_outbound_confirm);

                $("#s_pay_type").val(item.s_pay_type);
                $("#i_dmg").val((item.i_dmg == "0" ? "" : item.i_dmg));

                $("#i_year").val(item.i_year);
                $("#s_brand_code").val(item.s_brand_code);
                getDDLGenSelectEdit(item.s_brand_code);
                $("#s_gen_code").val(item.s_gen_code);
//                $("#s_car_code").val(item.s_car_code).trigger('change');
                $("#s_license").val(item.s_license);

                $("#s_type_capital").val(item.s_type_capital);
                $("#d_ins_exp").val(item.d_ins_exp);








                debugger;
                initialDataTable("TRUE");


                $("#status").val(item.s_status);
                activeStep(item.s_status)
                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);



            });
//            FormDropzone.init();
            //$('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}

function activeStep(status) {
    debugger;
    var i = 1;
    for (i = 1; i < 12; i++) {
        $('#step' + i).removeAttr('style');
        $('#step' + i).attr('style', 'display:none;');
        $('#step' + 99).attr('style', 'display:none;');
    }
    debugger;
    var indexActive = parseInt(status.substring(1));
    indexActive = (indexActive - 1)
    $('#step' + indexActive).attr('style', 'display:block;');

    if (indexActive > 2) {
        $('#step' + 99).attr('style', 'display:block;');
    }

}

function setImageCount(id) {
    id = (id != '' ? id : ref_no);
    $.ajax({
        type: 'GET',
        url: 'controller/repair/processController.php?func=listImage&ref_no=' + id,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {


                if (item.step == 'lb-3' && item.cnt != '0') {
                    $("#lb-3").text(item.cnt);
                } else if (item.step == 'lb-4' && item.cnt != '0') {
                    $("#lb-4").text(item.cnt);
                } else if (item.step == 'lb-5' && item.cnt != '0') {
                    $("#lb-5").text(item.cnt);
                } else if (item.step == 'lb-6' && item.cnt != '0') {
                    $("#lb-6").text(item.cnt);
                } else if (item.step == 'lb-7' && item.cnt != '0') {
                    $("#lb-7").text(item.cnt);
                } else if (item.step == 'lb-8' && item.cnt != '0') {
                    $("#lb-8").text(item.cnt);
                } else if (item.step == 'lb-9' && item.cnt != '0') {
                    $("#lb-9").text(item.cnt);
                } else {
                    $("#" + item.step).text('');

                }





            });



        },
        error: function (data) {

        }

    });
}

function editCustomer(id) {

    $.ajax({
        type: 'GET',
        url: 'controller/customer/customerController.php?func=getInfo&id=' + id,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {


                $("#i_title").val(item.i_title);
                $("#s_firstname").val(item.s_firstname);
                $("#s_lastname").val(item.s_lastname);

                $("#s_phone_1").val(item.s_phone_1);
                $("#s_phone_2").val(item.s_phone_2);

                $("#s_email").val(item.s_email);
                $("#s_line").val(item.s_line);

                $("#s_address").val(item.s_address);
                $("#i_province").val(item.i_province);

                setDDLAmphure(item.i_amphure, item.i_district, item.i_zipcode);

            });
            var carInfo = $('#s_license').val() + " : " + $("#i_year option:selected").text() + " : " + $("#s_brand_code option:selected").text() + " : " + $("#s_gen_code option:selected").text();
            $("#ref_car_info").val(carInfo);
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}


function editCheckBoxMain(ref_no) {

    $.ajax({
        type: 'GET',
        url: 'controller/repair/processController.php?func=getCheckBoxMain&ref_no=' + ref_no,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == '') {
                return;
            }
            var res = JSON.parse(data);

            $.each(res, function (i, item) {


                $('input:checkbox[id="i_repair_item_' + item.i_repair_item + '"]').attr('checked', 'Y');
                $('#s_repair_item_' + item.i_repair_item).val(item.s_remark);

                $('#imgpopup_' + item.i_repair_item).attr('href', 'upload/step_checkrepair/' + item.s_filename)
                $('#img_' + item.i_repair_item).attr('style', 'display:block;');
                $('#ck_' + item.i_repair_item).val(item.s_filename);
            });

//            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}


function editCheckBoxOther(ref_no) {

    $.ajax({
        type: 'GET',
        url: 'controller/repair/processController.php?func=getCheckBoxOther&ref_no=' + ref_no,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            if (data == '') {
                return;
            }
            var res = JSON.parse(data);

            $.each(res, function (i, item) {


                setValSelected(1, item.i_repair_subitem1);
                setValSelected(2, item.i_repair_subitem2);
                setValSelected(3, item.i_repair_subitem3);
                setValSelected(4, item.i_repair_subitem4);
                setValSelected(5, item.i_repair_subitem5);
                setValSelected(6, item.i_repair_subitem6);
                setValSelected(7, item.i_repair_subitem7);
                setValSelected(8, item.i_repair_subitem8);
                setValSelected(9, item.i_repair_subitem9);
                setValSelected(10, item.i_repair_subitem10);
                setValSelected(11, item.i_repair_subitem11);
                setValSelected(12, item.i_repair_subitem12);
                setValSelected(13, item.i_repair_subitem13);

                $('#s_repair_subitem_1').val(item.s_txt_1);
                $('#s_repair_subitem_2').val(item.s_txt_2);
                $('#s_repair_subitem_3').val(item.s_txt_3);
                $('#s_repair_subitem_4').val(item.s_txt_4);
                $('#s_repair_subitem_5').val(item.s_txt_5);
                $('#s_repair_subitem_6').val(item.s_txt_6);
                $('#s_repair_subitem_7').val(item.s_txt_7);
                $('#s_repair_subitem_8').val(item.s_txt_8);
                $('#s_repair_subitem_9').val(item.s_txt_9);
                $('#s_repair_subitem_10').val(item.s_txt_10);
                $('#s_repair_subitem_11').val(item.s_txt_11);
                $('#s_repair_subitem_12').val(item.s_txt_12);
                $('#s_repair_subitem_13').val(item.s_txt_13);






                $('#imgpopups_1').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_1);
                $('#imgpopups_2').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_2);
                $('#imgpopups_3').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_3);
                $('#imgpopups_4').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_4);
                $('#imgpopups_5').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_5);
                $('#imgpopups_6').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_6);
                $('#imgpopups_7').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_7);
                $('#imgpopups_8').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_8);
                $('#imgpopups_9').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_9);
                $('#imgpopups_10').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_10);
                $('#imgpopups_11').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_11);
                $('#imgpopups_12').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_12);
                $('#imgpopups_13').attr('href', 'upload/step_checkrepair_other/' + item.s_filename_13);



                $('#cks_1').val(item.s_filename_1);
                $('#cks_2').val(item.s_filename_2);
                $('#cks_3').val(item.s_filename_3);
                $('#cks_4').val(item.s_filename_4);
                $('#cks_5').val(item.s_filename_5);
                $('#cks_6').val(item.s_filename_6);
                $('#cks_7').val(item.s_filename_7);
                $('#cks_8').val(item.s_filename_8);
                $('#cks_9').val(item.s_filename_9);
                $('#cks_10').val(item.s_filename_10);
                $('#cks_11').val(item.s_filename_11);
                $('#cks_12').val(item.s_filename_12);
                $('#cks_13').val(item.s_filename_13);





            });

//            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}

function setValSelected(index, val) {
    var tmp = ((val != null && val != '') ? 'Y' : '')
    if (tmp == 'Y') {
        $('input:checkbox[id="i_repair_subitem_' + index + '"]').attr('checked', 'Y');
        $('#imgs_' + index).attr('style', 'display:block;');
    }

}


function saveCustomChangeStatus() {


    $.ajax({
        type: 'GET',
        url: 'controller/repair/processController.php?func=edit&status=' + $('#status').val() + '&id=' + $('#id').val(),
        // data: formData,
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
//            $('#form-action').each(function () {
//                setTimeout(reloadTime, 1000);
//            });
            getDDLStatus();
//            $('#se-pre-con').delay(100).fadeOut();
        },
        error: function (data) {

        }
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


function radio_type(setSelected) {
    var radios = $("input[type='radio']");
    for (i = 0; i < radios.length; i++) {
        radios[i].removeAttribute('checked')
    }
    $("#i_ins_type" + setSelected).attr('checked', 'checked');
    $("#i_ins_type").val(setSelected);
}


function setRadio(i) {
    $("#i_ins_type").val(i);
}



function addComment() {
    var ref_no = $('#ref_no').val();
    var s_comment = $('#s_comment').val();
    $.ajax({
        type: 'GET',
        url: 'controller/repair/commentController.php?func=comment&ref_no=' + ref_no + "&s_comment=" + s_comment,
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
                $('#s_comment').val('');
                initialDataTable("FALSE");
            } else {
                var errCode = "Code (" + res[0] + ") : " + res[1];
                $.notify(errCode, "error");
            }
            $('#se-pre-con').delay(100).fadeOut();

            return;
        },
        error: function (data) {

        }
    });
}



var $datatableComment = $('#datatable-comment');

function initialDataTable(first) {
    var ref_no = $('#ref_no').val();
    $.ajax({
        type: 'GET',
        url: 'controller/repair/commentController.php?func=dataTable&ref_no=' + ref_no,
        beforeSend: function () {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            debugger;
            if (data == '') {
                var datatable = $datatableComment.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                return;
            }
            var res = JSON.parse(data);
            var JsonData = [];
            $.each(res, function (i, item) {


                var refno = item.ref_no;
                var col_comment = item.s_comment + " : " + item.d_create;

                var col_delete = "";
                col_delete += '<a href="' + (disable != "" ? '#' : 'javascript:Confirm(\'' + item.i_comment + '\',\'delete\');') + '" style="width:30px;height:30px" class="btn btn-circle btn-icon-only red" ' + disable + '>';
                col_delete += ' <i class="fa fa-archive" ></i>';
                col_delete += '</a>';


                var addRow = [
                    col_delete,
                    col_comment
                ]

                JsonData.push(addRow);

            });
            if (first == "TRUE") {
                $datatableComment.dataTable({
                    data: JsonData,
                    order: [
//                        [1, 'desc'],
//                        [11, 'asc']
                    ],
                    columnDefs: [
                        {"orderable": false, "targets": 0},
                        {"orderable": false, "targets": 1}
                    ]
                });
            } else {

                var datatable = $datatableComment.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.rows.add(JsonData);
                datatable.draw();
            }

        },
        error: function (data) {

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
                "<input type='hidden' id='id_comment' value='" + txt + "' />" +
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
$(document).on('click', '.notifyjs-foo-base .notify-no', function () {
    $('#se-pre-con').delay(100).fadeOut();
    $(this).trigger('notify-hide');
});
$(document).on('click', '.notifyjs-foo-base .notify-yes', function () {
    $(this).trigger('notify-hide');
    var id = $("#id_comment").val();

    $.ajax({
        type: 'GET',
        url: 'controller/repair/commentController.php?func=delete&id=' + id,
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

            }
            initialDataTable("FALSE");
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });

});