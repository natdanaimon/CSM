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
            if (keyEdit != "") {
                edit();
            }
        },
        error: function (data) {

        }

    });
}


var claimRef;
function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/insurance/claimController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#s_firstname").val(item.s_firstname);
                $("#s_lastname").val(item.s_lastname);
                $("#s_phone_1").val(item.s_phone_1);
                $("#s_phone_2").val(item.s_phone_2);
                $("#s_email").val(item.s_email);
                $("#s_line").val(item.s_line);
                $("#s_related").val(item.s_related);
                $("#s_claim_number").val(item.s_claim_number);


                if (item.s_owner == "1") {
                    $("#s_owner1").attr('checked', 'checked');
                } else if (item.s_owner == "2") {
                    $("#s_owner2").attr('checked', 'checked');
                    $("#div-ref").removeAttr('style');
                }

                claimRef = item.s_ref_image;





                //copy claim
                if (item.s_copy_claim != "" && typeof (item.s_copy_claim) != "undefined") {
                    var typeFile = item.s_copy_claim.substr(item.s_copy_claim.lastIndexOf('.') + 1);
                    if (typeFile == "pdf") {
                        $('#m_copy_claim').attr('src', 'images/pdf.png');
                        $('#s_copy_claim').removeAttr("data-lightbox");
                        $('#s_copy_claim').attr('title', item.s_copy_claim);
                        $('#s_copy_claim').attr('href', "javascript:window.open('upload/claim/" + item.s_copy_claim + "', 'MsgWindow','width=400,height=600');");
                    } else {
                        $('#s_copy_claim').attr('title', item.s_copy_citizen);
                        $('#s_copy_claim').attr('href', 'upload/claim/' + item.s_copy_claim);
                        $('#m_copy_claim').attr('src', 'upload/claim/' + item.s_copy_claim);
                    }
                }

                //driver
                if (item.s_copy_driver != "" && typeof (item.s_copy_driver) != "undefined") {
                    var typeFile = item.s_copy_driver.substr(item.s_copy_driver.lastIndexOf('.') + 1);
                    if (typeFile == "pdf") {
                        $('#m_copy_driver').attr('src', 'images/pdf.png');
                        $('#s_copy_driver').removeAttr("data-lightbox");
                        $('#s_copy_driver').attr('title', item.s_copy_driver);
                        $('#s_copy_driver').attr('href', "javascript:window.open('upload/claim/" + item.s_copy_driver + "', 'MsgWindow','width=400,height=600');");
                    } else {
                        $('#s_copy_driver').attr('title', item.s_copy_driver);
                        $('#s_copy_driver').attr('href', 'upload/claim/' + item.s_copy_driver);
                        $('#m_copy_driver').attr('src', 'upload/claim/' + item.s_copy_driver);
                    }
                }

                //insurance
                if (item.s_copy_insurance != "" && typeof (item.s_copy_insurance) != "undefined") {
                    var typeFile = item.s_copy_insurance.substr(item.s_copy_insurance.lastIndexOf('.') + 1);
                    if (typeFile == "pdf") {
                        $('#m_copy_insurance').attr('src', 'images/pdf.png');
                        $('#s_copy_insurance').removeAttr("data-lightbox");
                        $('#s_copy_insurance').attr('title', item.s_copy_insurance);
                        $('#s_copy_insurance').attr('href', "javascript:window.open('upload/claim/" + item.s_copy_insurance + "', 'MsgWindow','width=400,height=600');");
                    } else {
                        $('#s_copy_insurance').attr('title', item.s_copy_insurance);
                        $('#s_copy_insurance').attr('href', 'upload/claim/' + item.s_copy_insurance);
                        $('#m_copy_insurance').attr('src', 'upload/claim/' + item.s_copy_insurance);
                    }
                }

                //car
                if (item.s_copy_car != "" && typeof (item.s_copy_car) != "undefined") {
                    var typeFile = item.s_copy_car.substr(item.s_copy_car.lastIndexOf('.') + 1);
                    if (typeFile == "pdf") {
                        $('#m_copy_car').attr('src', 'images/pdf.png');
                        $('#s_copy_car').removeAttr("data-lightbox");
                        $('#s_copy_car').attr('title', item.s_copy_car);
                        $('#s_copy_car').attr('href', "javascript:window.open('upload/claim/" + item.s_copy_car + "', 'MsgWindow','width=400,height=600');");
                    } else {
                        $('#s_copy_car').attr('title', item.s_copy_car);
                        $('#s_copy_car').attr('href', 'upload/claim/' + item.s_copy_car);
                        $('#m_copy_car').attr('src', 'upload/claim/' + item.s_copy_car);
                    }
                }

                //pay
                if (item.s_copy_pay != "" && typeof (item.s_copy_pay) != "undefined") {
                    var typeFile = item.s_copy_pay.substr(item.s_copy_pay.lastIndexOf('.') + 1);
                    if (typeFile == "pdf") {
                        $('#m_copy_pay').attr('src', 'images/pdf.png');
                        $('#s_copy_pay').removeAttr("data-lightbox");
                        $('#s_copy_pay').attr('title', item.s_copy_pay);
                        $('#s_copy_pay').attr('href', "javascript:window.open('upload/claim/" + item.s_copy_pay + "', 'MsgWindow','width=400,height=600');");
                    } else {
                        $('#s_copy_pay').attr('title', item.s_copy_pay);
                        $('#s_copy_pay').attr('href', 'upload/claim/' + item.s_copy_pay);
                        $('#m_copy_pay').attr('src', 'upload/claim/' + item.s_copy_pay);
                    }
                }





                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);
            });
            editDetail();
//            $('#se-pre-con').delay(100).fadeOut();
        },
        error: function (data) {

        }

    });
}


function editDetail() {
    $.ajax({
        type: 'GET',
        url: 'controller/insurance/claimController.php?func=getInfoDetail&id=' + claimRef,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var html = "";
            var res = JSON.parse(data);            
            $.each(res, function (i, item) {
                debugger;
                html += '<div class="col-md-3">';
                html += '<div class="form-group form-md-line-input has-success">';
//                html += '<label for="form_control_1"><?= $_SESSION[lb_setClaim_carRegis] ?> <span class="required"></span></label>';
                html += '<div class="fileinput fileinput-new" data-provides="fileinput">';
                html += '<div class="fileinput-new thumbnail"  style="max-width: 205px; max-height: 160px;">';
                html += '<a id="" title="'+item.s_image+'" class="example-image-link" href="upload/claimDmg/'+item.s_image+'" data-lightbox="example-2">';
                html += '<img id="" src="upload/claimDmg/'+item.s_image+'" alt="" style="max-width: 195px; max-height: 145px;"/> ';
                html += '</a> ';
                html += '</div></div></div></div>';
            });
            $("#image-damage").html(html);
            $('#se-pre-con').delay(100).fadeOut();
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