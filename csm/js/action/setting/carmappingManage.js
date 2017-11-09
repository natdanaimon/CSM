function getDDLStatus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLStatusActive',
        beforeSend: function() {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function(data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function(i, item) {
                var txt_status = (language == "th" ? item.s_detail_th : item.s_detail_en);
                htmlOption += "<option value='" + item.s_status + "'>" + txt_status + "</option>";
            });
            $("#status").html(htmlOption);
            getDDLYear();
        },
        error: function(data) {

        }

    });
}


function formatStateYear(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
        '<span><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
    );
    return $state;
}

function getDDLYear() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLYear',
        beforeSend: function() {},
        success: function(ddl) {
            var res = JSON.parse(ddl);
            $("#i_year").select2({
                data: res,
                templateResult: formatStateYear,
                templateSelection: formatStateYear

            });
            getDDLBrand();

        },
        error: function(ddl) {

        }



    });
}


function formatStateBrand(state) {
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

function getDDLBrand() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLBrand',
        beforeSend: function() {},
        success: function(ddl) {
            var res = JSON.parse(ddl);
            $("#s_brand_code").select2({
                data: res,
                templateResult: formatStateBrand,
                templateSelection: formatStateBrand

            });
            getDDLGeneration();

        },
        error: function(ddl) {

        }



    });
}


function formatStateGeneration(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
        '<span><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
    );
    return $state;
}

function getDDLGeneration() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLGeneration',
        beforeSend: function() {},
        success: function(ddl) {
            var res = JSON.parse(ddl);
            $("#s_gen_code").select2({
                data: res,
                templateResult: formatStateGeneration,
                templateSelection: formatStateGeneration

            });
            getDDLSub();

        },
        error: function(ddl) {

        }



    });
}


function formatStateSub(state) {
    if (!state.id) {
        return state.text;
    }
    var $state = $(
        '<span><span style="color:black;font-weight:bold;"> ' + state.text + '</span></span>'
    );
    return $state;
}

function getDDLSub() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLSub',
        beforeSend: function() {},
        success: function(ddl) {
            var res = JSON.parse(ddl);
            $("#s_sub_code").select2({
                data: res,
                templateResult: formatStateSub,
                templateSelection: formatStateSub

            });
            if (keyEdit != "") {
                edit();
            }

        },
        error: function(ddl) {

        }



    });
}



function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/setting/mappingController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function() {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function(data) {
            var res = JSON.parse(data);
            $.each(res, function(i, item) {
                debugger;
                $("#i_year").val(item.i_year).trigger('change');
                $("#s_brand_code").val(item.s_brand_code).trigger('change');
                $("#s_gen_code").val(item.s_gen_code).trigger('change');
                $("#s_sub_code").val(item.s_sub_code).trigger('change');
                $("#status").val(item.s_status);

                $("#lb_create").text(item.s_create_by + " ( " + item.d_create + " )");
                var lb_edit = (item.s_update_by != "" ? item.s_update_by + " ( " + item.d_update + " )" : "-");
                $("#lb_edit").text(lb_edit);
            });

            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function(data) {

        }

    });
}





function save() {
    var Jsdata = $("#form-action").serialize();
    debugger;
    $.ajax({
        type: 'POST',
        url: 'controller/setting/mappingController.php',
        data: Jsdata,
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
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            $('#se-pre-con').delay(100).fadeOut();
            notification();
            $('#form-action').each(function() {
                getDDLStatus();
                this.reset();
            });
            //            location.reload();
        },
        error: function(data) {

        }

    });
}