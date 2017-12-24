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

                htmlOption += '<div class="col-md-2 col-sm-12" style="padding-top: 10px;">';
                htmlOption += '<span class=" md-checkbox has-success" >';
                htmlOption += '  <input type="checkbox" id="checkbox_' + i + '" name="checkboxItem" class="md-check"';
                htmlOption += '  value="' + item.i_repair_item + '" >';
                htmlOption += '  <label for="checkbox_' + i + '">';
                htmlOption += '    <span class="inc"></span>';
                htmlOption += '    <span class="check"></span>';
                htmlOption += '    <span class="box"></span> ' + item.s_repair_name + '</label>';
                htmlOption += '</span>';
                htmlOption += '</div>';





                htmlOption += '<div class="col-md-3 col-sm-12">';
                htmlOption += '<div class="form-group form-md-line-input has-success" style="padding-top:0px !important;" >';
                htmlOption += '<input type="text" class="form-control bold required" id="s_repair_item_' + item.i_repair_item + '" name="s_repair_item_' + item.i_repair_item + '" >';
                htmlOption += '</div>';
                htmlOption += '</div>';

                htmlOption += '<div class="col-md-1">';
                htmlOption += '</div>';
                if (count == 0) {
                    htmlOption += "</div>";
                }

                count++;

            });

            $("#div_checkbox_repair").html(htmlOption);
            getDDLInsuranceType();
        },
        error: function (data) {

        }

    });




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

            getDDLCar();

        },
        error: function (ddl) {

        }



    });
}



function formatStateCar(state) {
    if (!state.id) {
        return state.text;
    }
    var pathImg = "";
    if (state.img == "") {
        pathImg = "images/noCar.png";
    } else {
        pathImg = "upload/brand/" + state.img;
    }


    var $state = $(
            '<span><img src="' + pathImg + '" width="30px" height="30px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
            );
    return $state;
}

function getDDLCar() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLCar',
        beforeSend: function () {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#s_car_code").select2({
                data: res,
                templateResult: formatStateCar,
                templateSelection: formatStateCar

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


function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/repair/checkController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#i_customer").val(item.i_customer);

                //radio
                radio_type(item.i_ins_type);

                editCustomer(item.i_customer);
                $("#ref_no").val(item.ref_no);
                $("#i_ins_comp").val(item.i_ins_comp).trigger('change');
                $("#d_inbound").val(item.d_inbound);
                $("#d_outbound_confirm").val(item.d_outbound_confirm);

                $("#s_pay_type").val(item.s_pay_type);
//                $("#i_dmg").val(item.i_dmg);

                $("#s_car_code").val(item.s_car_code).trigger('change');
                $("#s_license").val(item.s_license);

                $("#s_type_capital").val(item.s_type_capital);
                $("#d_ins_exp").val(item.d_ins_exp);

                $("#status").val(item.s_status);
                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);
            });

            //$('#se-pre-con').delay(100).fadeOut();

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
                debugger;

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
            url: 'controller/repair/checkController.php',
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



