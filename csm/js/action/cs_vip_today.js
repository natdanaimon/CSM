function clearForm() {
    $('#se-pre-con').fadeIn();
    $("#month").val(current_date);
    $('#content-today').css("display", "none");
    $('#today').html("");
    $('#txt-month').html("");
    $('#se-pre-con').delay(100).fadeOut();
}




var notData = "<tr><td colspan='2'>Not data</td></tr>";
var $datatable = $('#datatable');
function search() {

    $('#se-pre-con').fadeIn();
    var Jsdata = $("#form-action").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/vipTodayController.php',
        data: Jsdata,
        beforeSend: function ()
        {

        },
        success: function (data) {
            debugger;
            if (data == '') {
                $('#content-today').css("display", "none");
                $.notify(lb_search_noInfo, "error");
                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#today').html(notData);
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }


            var res = JSON.parse(data);
            if ((res == "")) {
                $('#content-report').css("display", "none");
                $.notify(lb_search_noInfo, "error");
                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#today').html(notData);
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }



            if (res != "") {
                var StringHTML = "";
                var m = "";
                var href = "#";
                $.each(res, function (i, item) {
                    m = item.month;
                    href = "pdf/pdfVipToDay.php?month=" + $("#month").val();
                    StringHTML += "<tr>";
                    StringHTML += "<td>" + item.username + "</td>";
                    StringHTML += "<td align=\"right\">" + number_format(item.turnover, 2) + "</td>";
                    StringHTML += "<td align=\"right\">" + number_format(item.pay, 2) + "</td>";
                    StringHTML += "<td style='color:red'>" + item.remark + "</td>";
                    StringHTML += "</tr>";
                });
                if (href != "#") {
                    $('#export-pdf').removeAttr("disabled");
                } else {
                    $('#export-pdf').attr("disabled", "disabled");
                }
                $('#export-pdf').attr("href", href);
                $('#txt-month').html(m);
                $('#today').html(StringHTML);
            } else {
                $('#today').html(notData);
            }




            $('#content-today').css("display", "block");
            $('#se-pre-con').delay(100).fadeOut();
        },
        error: function (data) {
            $('#se-pre-con').delay(100).fadeOut();
        }

    });
}

function getMonth(month) {
    var lanMonth = (language == "th" ? "th-th" : "en-us");
    var objDate = new Date(month),
            locale = lanMonth,
            month = objDate.toLocaleString(locale, {month: "long"});

    return objDate;

}


