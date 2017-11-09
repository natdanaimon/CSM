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
            getDDLInsurance();
        },
        error: function (data) {

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
        pathImg = "upload/brand/" + state.img;
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

            getDDLInsuranceType();

        },
        error: function (ddl) {

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
            getDDLInsurancePro();
        },
        error: function (ddl) {

        }



    });
}

function formatStatePro(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
            '<span><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
            );
    return $state;
}

function getDDLInsurancePro() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLInsurancePromotion',
        beforeSend: function () {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#i_ins_promotion").select2({
                data: res,
                templateResult: formatStatePro,
                templateSelection: formatStatePro

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
            '<span><img src="' + pathImg + '" width="50px" height="50px" class="img-flag" Style="margin-bottom: 5px;"/><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
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
            getDDLInsuranceRepair();

        },
        error: function (ddl) {

        }



    });
}

function formatStateRepair(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
            '<span><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
            );
    return $state;
}

function getDDLInsuranceRepair() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLInsuranceRepair',
        beforeSend: function () {},
        success: function (ddl) {
            var res = JSON.parse(ddl);
            $("#i_prcar_repair_type").select2({
                data: res,
                templateResult: formatStateRepair,
                templateSelection: formatStateRepair

            });

            if (keyEdit != "") {
                edit();
            }


        },
        error: function (ddl) {

        }



    });
}



function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/insurance/productController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#s_insurance_htext").val(item.s_insurance_htext);
                $("#i_ins_comp").val(item.i_ins_comp).trigger('change');
                //radio
                radio_type(item.i_ins_type);

                $("#s_car_code").val(item.s_car_code).trigger('change');

                $("#i_ins_promotion").val(item.i_ins_promotion).trigger('change');
                $("#f_price").val(item.f_price);
                $("#f_discount").val(item.f_discount);
                $("#f_point").val(item.f_point);

                //3-1
                $("#s_prcar_base").val(item.s_prcar_base);
                $("#s_prcar_fire").val(item.s_prcar_fire);
                $("#s_prcar_water").val(item.s_prcar_water);
                $("#s_prcar_repair").val(item.s_prcar_repair);
                $("#i_prcar_repair_type").val(item.i_prcar_repair_type).trigger('change');

                //3-2
                $("#s_prperson_per").val(item.s_prperson_per);
                $("#s_prperson_pertimes").val(item.s_prperson_pertimes);
                $("#s_prperson_outsider").val(item.s_prperson_outsider);

                //3-3
                $("#s_prother_personal").val(item.s_prother_personal);
                $("#s_prother_insurance").val(item.s_prother_insurance);
                $("#s_prother_medical").val(item.s_prother_medical);


                $("#status").val(item.s_status);

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
    var Jsdata = $("#form-action").serialize();
    debugger;
    $.ajax({
        type: 'POST',
        url: 'controller/insurance/productController.php',
        data: Jsdata,
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
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            $('#se-pre-con').delay(100).fadeOut();
            notification();
            $('#form-action').each(function () {
                getDDLStatus();
                this.reset();
            });
            //            location.reload();
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