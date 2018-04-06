var $datatable = $('#datatable');


function initialStaff(id) {
    $.ajax({
        type: 'GET',
        url: 'controller/queue/createController.php?func=dataTableStaff&id=+'+id,
        beforeSend: function () {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {

            if (data == '') {
                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            var res = JSON.parse(data);
            var JsonData = [];
            $.each(res, function (i, item) {



                var col_name = (language == "th" ? item.s_title_th : item.s_title_en) + " " + item.s_firstname + " " + item.s_lastname;
                var col_phone = item.s_phone_1;



                col_name = '<a href="javascript:setCust(' + item.i_customer + ');">' + col_name + '</a>';
                col_phone = '<a href="javascript:setCust(' + item.i_customer + ');">' + col_phone + '</a>';


                var addRow = [
                    col_name,
                    col_phone
                ]

                JsonData.push(addRow);

            });
            if (first == "TRUE") {
                $datatable.dataTable({
                    data: JsonData,
                    order: [
                        [0, 'asc'],
                        [1, 'asc']
                    ],
                    columnDefs: [
                        {"orderable": false, "targets": 0}
                    ]
                });
            } else {

                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.rows.add(JsonData);
                datatable.draw();
            }
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}



function initialRef(first) {
    $.ajax({
        type: 'GET',
        url: 'controller/queue/refController.php?func=dataTable',
        beforeSend: function () {
            $('#se-pre-con').fadeIn(100);
        },
        success: function (data) {

            if (data == '') {
                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.draw();
                $('#se-pre-con').delay(100).fadeOut();
                return;
            }
            var res = JSON.parse(data);
            var JsonData = [];
            $.each(res, function (i, item) {



                var col_name = (language == "th" ? item.s_title_th : item.s_title_en) + " " + item.s_firstname + " " + item.s_lastname;
                var col_phone = item.s_phone_1;



                col_name = '<a href="javascript:setCust(' + item.i_customer + ');">' + col_name + '</a>';
                col_phone = '<a href="javascript:setCust(' + item.i_customer + ');">' + col_phone + '</a>';


                var addRow = [
                    col_name,
                    col_phone
                ]

                JsonData.push(addRow);

            });
            if (first == "TRUE") {
                $datatable.dataTable({
                    data: JsonData,
                    order: [
                        [0, 'asc'],
                        [1, 'asc']
                    ],
                    columnDefs: [
                        {"orderable": false, "targets": 0}
                    ]
                });
            } else {

                var datatable = $datatable.dataTable().api();
                $('.dataTables_empty').remove();
                datatable.clear();
                datatable.rows.add(JsonData);
                datatable.draw();
            }
            $('#se-pre-con').delay(100).fadeOut();

        },
        error: function (data) {

        }

    });
}






function setRef(id) {

    $.ajax({
        type: 'GET',
        url: 'controller/queue/refController.php?func=getInfo&id=' + id,
        beforeSend: function () {
            //$('#se-pre-con').fadeIn(100);
        },
        success: function (data) {
            var res = JSON.parse(data);
            $.each(res, function (i, item) {
                debugger;

                $("#i_customer").val(id);

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

            $('#searchCust').modal('hide');

        },
        error: function (data) {

        }

    });
}