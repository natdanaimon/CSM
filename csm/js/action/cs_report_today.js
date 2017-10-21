function clearForm() {
    $('#se-pre-con').fadeIn();
    $("#d_start").val(current_date);
    $('#content-report').css("display", "none");
    $('#rg').html("");
    $('#sum-rg').html("");
    $('#sum-dp').html("");
    $('#sum-wd').html("");
    $('#se-pre-con').delay(100).fadeOut();
}




var notData = "<tr><td colspan='2'>Not data</td></tr>";
var $datatable = $('#datatable');
function search() {

    $('#se-pre-con').fadeIn();
    var Jsdata = $("#form-action").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/reportTodayController.php',
        data: Jsdata,
        beforeSend: function ()
        {

        },
        success: function (data) {
            debugger;
            var sumRg = 0;
            var sumDp = 0;
            var sumWd = 0;
            if (data == '') {
                $('#content-report').css("display", "none");
                $.notify(lb_search_noInfo, "error");
                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#rg').html(notData);
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }


            var res = JSON.parse(data);
            if ((res[0].register == "" && res[0].deposit == "" && res[0].withdraw == "")) {
                $('#content-report').css("display", "none");
                $.notify(lb_search_noInfo, "error");
                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#rg').html(notData);
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }


            //register
            if (res[0].register != "") {
                var StringHTML = "";
                $.each(JSON.parse(res[0].register), function (i, item) {
                    sumRg++;
                    StringHTML += "<tr>";
                    StringHTML += "<td>" + item.s_username + "</td>";
                    StringHTML += "<td>" + item.cnt + "</td>";
                    StringHTML += "</tr>";
                });
                $('#rg').html(StringHTML);
            } else {
                $('#rg').html(notData);
            }





            //deposit
            if (res[0].deposit != "") {
                var StringHTML = "";
                $.each(JSON.parse(res[0].deposit), function (i, item) {
                    sumDp++;
                    StringHTML += "<tr>";
                    StringHTML += "<td>" + item.s_username + "</td>";
                    StringHTML += "<td>" + item.cnt + "</td>";
                    StringHTML += "</tr>";

                });
                $('#dp').html(StringHTML);
            } else {
                $('#dp').html(notData);
            }




            //withdraw
            if (res[0].withdraw != "") {
                var StringHTML = "";
                $.each(JSON.parse(res[0].withdraw), function (i, item) {
                    sumWd++;
                    StringHTML += "<tr>";
                    StringHTML += "<td>" + item.s_username + "</td>";
                    StringHTML += "<td>" + item.cnt + "</td>";
                    StringHTML += "</tr>";

                });
                $('#wd').html(StringHTML);
            } else {
                $('#wd').html(notData);
            }


            $('#sum-rg').html(sumRg);
            $('#sum-dp').html(sumDp);
            $('#sum-wd').html(sumWd);

            $('#content-report').css("display", "block");
            $('#se-pre-con').delay(100).fadeOut();
        },
        error: function (data) {
            $('#se-pre-con').delay(100).fadeOut();
        }

    });
}





