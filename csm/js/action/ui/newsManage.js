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
            if (keyEdit != "") {
                setTimeout(edit, 2000);
//                edit();
            } else {
                unloading();
            }
        },
        error: function (data) {

        }

    });
}


function edit() {
    debugger;
    var _th = true;
    var _en = true;
    $.ajax({
        type: 'GET',
        url: 'controller/ui/newsController.php?func=getInfo&id=' + keyEdit,
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            $("#tmp_img_p1").val("");
            $("#tmp_img_p2").val("");
            $('#img1').attr('src', 'images/no-image.png');
            $('#img2').attr('src', 'images/no-image.png');
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;

                $("#i_index").val(item.i_index);

                $("#i_view").val(item.i_view);
                $("#i_vote").val(item.i_vote);



                $("#s_subject").val(item.s_subject);
                $("#s_detail").val(item.s_detail);


                recursiveSetValue("", item.s_detail);




                $("#status").val(item.s_status);
                if (item.s_img_p1 != "") {
                    $('#img1').attr('src', 'upload/news/' + item.s_img_p1);
                    $("#tmp_img_p1").val(item.s_img_p1);
                }
                if (item.s_img_p2 != "") {
                    $('#img2').attr('src', 'upload/news/' + item.s_img_p2);
                    $("#tmp_img_p2").val(item.s_img_p2);
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

    function recursiveSetValue(lang, value) {
        debugger;
        if (lang == "th") {
            CKEDITOR.instances.s_detail_th.setData(value, function () {

                if (this.checkDirty() && _th) {
                    _th = false;
                    recursiveSetValue(lang, value);
                } else {

                }
            });
        } else if (lang == "en") {
            CKEDITOR.instances.s_detail_en.setData(value, function () {

                if (this.checkDirty() && _en) {
                    _en = false;
                    recursiveSetValue(lang, value);
                } else {

                }
            });
        } else {
            CKEDITOR.instances.s_detail.setData(value, function () {

                if (this.checkDirty() && _other) {
                    _other = false;
                    recursiveSetValue(lang, value);
                } else {

                }
            });
        }
    }



}

function save() {
    $('#form-action').submit(function (e) {
        var s_detail = CKEDITOR.instances['s_detail'].getData();
        $('#s_detail').val(s_detail);

        e.preventDefault();
        console.log($(this).serialize());
        var formData = new FormData($(this)[0]);
        $.ajax({
            type: 'POST',
            url: 'controller/ui/newsController.php',
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






