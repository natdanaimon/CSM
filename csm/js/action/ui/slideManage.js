function getDDLStatus() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLStatusActive',
        beforeSend: function ()
        {
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
            getDDLPosition();
        },
        error: function (data) {

        }

    });
}

function getDDLPosition() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonController.php?func=DDLPosition',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                htmlOption += "<option value='" + item.i_position + "'>" + item.s_detail + "</option>";
            });
            $("#i_position").html(htmlOption);
            if (keyEdit != "") {
                edit();
            }
        },
        error: function (data) {

        }

    });
}


function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/ui/slideController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            $("#tmp_img_p1").val("");
            $('#img1').attr('src', 'images/no-image.png');
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;

                $("#i_index").val(item.i_index);
                $("#i_position").val(item.i_position);
                $("#s_desc_hl").val(item.s_desc_hl);
                $("#s_desc_nm").val(item.s_desc_nm);



                $("#status").val(item.s_status);

                if (item.s_image != "") {
                    $('#img1').attr('src', 'upload/slide/' + item.s_image);
                    $("#tmp_img_p1").val(item.s_image);
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
            url: 'controller/ui/slideController.php',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function ()
            {
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
            }, error: function (data) {

            }
        });
    });
}
