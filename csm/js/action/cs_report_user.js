var dp_appr = 0;
var dp_pend = 0;
var dp_rej = 0;

var wd_appr = 0;
var wd_pend = 0;
var wd_rej = 0;

var total = 0;


function clearForm() {
    $('#se-pre-con').fadeIn();

    $("#d_start").val(current_date);
    $("#d_end").val(current_date);
//    $("#s_website").val("");
    $("#s_username").val("");
    $("#fullname").val("");
    $("#phone").val("");
    $('#content-report').css("display", "none");
    $('#content-subreport').empty();
    $('#content-subreport').css("display", "none");
    $('#se-pre-con').delay(100).fadeOut();
}

function DDLWebsite() {
    $.ajax({
        type: 'GET',
        url: 'controller/commonCSController.php?func=DDLWebsite',
        beforeSend: function ()
        {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var htmlOption = "";
            var res = JSON.parse(data);
            htmlOption += "<option value='ALL'>" + label_all + "</option>";
            $.each(res, function (i, item) {
                var txt = item.s_website;
                htmlOption += "<option value='" + item.i_web + "'>" + txt + "</option>";
            });

            $("#i_web").html(htmlOption);

        },
        error: function (data) {

        }

    });
}

function search() {

    $('#se-pre-con').fadeIn();
    var Jsdata = $("#form-action").serialize();
    $.ajax({
        type: 'POST',
        url: 'controller/reportUserController.php',
        data: Jsdata,
        beforeSend: function ()
        {

        },
        success: function (data) {
            debugger;
            html = "";
            htmlScript = "";

//            $('#content-report').empty();
            $('#content-subreport').empty();
            if (data == "") {
                $.notify(lb_search_noInfo, "error");
                $('#se-pre-con').delay(100).fadeOut();
                $('#content-subreport').css("display", "none");
                $('#content-report').css("display", "none");
                return;
            }
            var res = JSON.parse(data);
            htmlScript += "<script>function loadscript(){"
            $.each(res, function (i, item) {
                html += '     <div class="row" style="border-bottom: 1px solid #999;" >';
                html += '        <div class="col-md-6"> ';
                html += '               <div class="row static-info align-reverse" >';

                html += '                <div id="donutchart_' + item.s_username + '"></div>';

                html += '               </div>';
                html += '        </div>';




                html += '        <div class="col-md-6">';
                html += '            <div class="well">';
                html += '                <div class="row static-info align-reverse">';
                html += '                    <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_dp_appr + ': </div>';
                html += '                    <div class="col-md-3 value"> ' + item.rs_dp_appr + ' ฿</div>';
                html += '                </div>';
                html += '                <div class="row static-info align-reverse">';
                html += '                <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_dp_appr_bonus + ': </div>';
                html += '                    <div class="col-md-3 value"> ' + item.rs_dp_appr_bonus + ' ฿</div>';
                html += '                </div>';
                html += '                <div class="row static-info align-reverse">';
                html += '                    <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_dp_appr_bonus_special + ': </div>';
                html += '                    <div class="col-md-3 value"> ' + item.rs_dp_appr_bonus_spcial + ' ฿</div>';
                html += '                </div>';
                html += '                <div class="row static-info align-reverse">';
                html += '                    <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_dp_pend + ': </div>';
                html += '                    <div class="col-md-3 value"> ' + item.rs_dp_pend + ' ฿</div>';
                html += '                </div>';
                html += '                <div class="row static-info align-reverse">';
                html += '                    <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_dp_rej + ': </div>';
                html += '                    <div class="col-md-3 value"> ' + item.rs_dp_rej + ' ฿</div>';
                html += '                </div>';

                html += '                <hr>';
                html += '                <div class="row static-info align-reverse">';
                html += '                    <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_wd_appr + ': </div>';
                html += '                    <div class="col-md-3 value"> ' + item.rs_wd_appr + ' ฿</div>';
                html += '                </div>';
                html += '                <div class="row static-info align-reverse">';
                html += '                    <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_wd_pend + ': </div>';
                html += '                    <div class="col-md-3 value"> ' + item.rs_wd_pend + ' ฿</div>';
                html += '               </div>';
                html += '                <div class="row static-info align-reverse">';
                html += '                    <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_wd_rej + ': </div>';
                html += '                    <div class="col-md-3 value"> ' + item.rs_wd_rej + ' ฿</div>';
                html += '                </div>';

                html += '                <hr>';
                html += '                <div class="row static-info align-reverse">';
                html += '                    <div class="col-md-8 name" style="font-weight: bold;"> ' + lb_cs_rs_result + ': </div>';
                html += '                    <div class="col-md-3 value" > <span id="rs_result" style="color:' + item.rs_result_color + ';" class="doubleUnderline">' + item.rs_result + '</span> ฿</div>';
                html += '                </div>';
                html += '            </div>';
                html += '       </div>';
                html += '    </div> ';


                html += ' <script type="text/javascript"> ';
                html += ' function loadScript_' + item.s_username + '(){ ';
                html += '            google.charts.setOnLoadCallback(drawChart_' + item.s_username + ');';
                html += '            function drawChart_' + item.s_username + '() {';

                html += '                var data = new google.visualization.DataTable();';
                html += '                    data.addColumn("string", "Effort");';
                html += '                    data.addColumn("number", "Amount given");';
                html += '                    data.addColumn({type: "string", role: "tooltip"});';
                html += '                    data.addRows([';
                html += '                    ["Deposit", ' + item.no_dp.toFixed(0) + ', "' + item.rs_dp_appr + ' Bath.\\nDeposit : '+item.no_dp.toFixed(0)+'%"],';
                html += '                    ["Withdraw", ' + item.no_wd.toFixed(0) + ', "' + item.rs_wd_appr + ' Bath.\\nWithdraw : '+item.no_wd.toFixed(0)+'%"],';
                html += '                    ["Total", ' + item.no_to.toFixed(0) + ', "' + item.rs_tt_appr + ' Bath.\\nTotal : '+item.no_to.toFixed(0)+'%"]';
                html += '                    ]);';




                html += '                var options = {';
                html += '                    title: "' + lb_cs_username + ' : ' + item.s_username + ' \\n\\n ' + lb_cs_by_fullname + ' : ' + item.s_fullname + '    ",';
                html += '                    colors: ["#66ff33", "#ff0066", "#00ccff"],';
                html += '                    pieHole: 0.4,';
                html += '                    color: "#f1f4f7",';
                html += '                    width: 700,';
                html += '                    height: 350,';
                html += '                    is3D: true';
                html += '               };';
                html += '                var chart = new google.visualization.PieChart(document.getElementById("donutchart_' + item.s_username + '"));';
                html += '            chart.draw(data, options);';
                html += '            }';
                html += ' }';
                html += ' </script>';




                html += '<br/>';

                htmlScript += 'loadScript_' + item.s_username + '();\n';



            });
            htmlScript += "}</script>"


            $('#content-subreport').append(html + htmlScript);
            $('#content-subreport').css("display", "block");
            $('#content-report').css("display", "block");
            loadscript();
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {
            $('#se-pre-con').delay(100).fadeOut();
        }

    });


}


function colorStatusCS(status) {
    if (status == "APPR") {
        return "success";
    } else if (status == "PEND") {
        return "warning";
    } else if (status == "REJ") {
        return "danger";
    }
}

function sortHidden(status) {
    if (status == "APPR") {
        return "<span style='display:none;'>2</span>";
    } else if (status == "PEND") {
        return "<span style='display:none;'>1</span>";
    } else if (status == "REJ") {
        return "<span style='display:none;'>3</span>";
    }
}

function countReport(type, amount, status) {
    amount = parseInt(amount);
    if (type == "DEPOSIT") {
        if (status == "APPR") {
            dp_appr += amount;
        } else if (status == "PEND") {
            dp_pend += amount;
        } else if (status == "REJ") {
            dp_rej += amount;
        }
    } else if (type == "WITHDRAW") {
        if (status == "APPR") {
            wd_appr += amount;
        } else if (status == "PEND") {
            wd_pend += amount;
        } else if (status == "REJ") {
            wd_rej += amount;
        }
    }

}
function countReportBonus(type, amount, status) {
    amount = parseInt(amount);
    if (type == "DEPOSIT") {
        if (status == "APPR") {
            dp_appr_bonus += amount;
        }
    }
}
function countReportBonusSpecial(type, amount, status) {
    amount = parseInt(amount);
    if (type == "DEPOSIT") {
        if (status == "APPR") {
            dp_appr_bonus_special += amount;
        }
    }
}

