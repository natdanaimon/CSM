
function edit() {
    $.ajax({
        type: 'GET',
        url: 'controller/setting/mailController.php?func=getInfo',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;
                $("#s_insurance").val(item.s_insurance);
                $("#s_claimonline").val(item.s_claimonline);
                $("#s_contacts").val(item.s_contacts);
                
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
        url: 'controller/setting/mailController.php',
        data: Jsdata,
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