var $datatable = $('#datatable');

function initialDataTable(first) {
  $.ajax({
    type: 'GET',
    url: 'controller/report/createController.php?func=dataTableInvoice',
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

        var col_no = item.id;
        var col_refno = item.ref_no;
        var col_name = item.s_name;
        var col_license = item.s_license;
        var col_print = "";

        col_print += '<a target="_blank" href="report/invoice.php?id=' + item.id + '" style="width:33px;height:33px" class="btn btn-circle btn-icon-only green" >';
         col_print += ' <i class="fa fa-print" ></i>';
         col_print += '</a>';


        var addRow = [
          col_no,
          col_refno,
          col_name,
          col_license,
          col_print

        ]

        JsonData.push(addRow);

      });
      if (first == "TRUE") {
        $datatable.dataTable({
          data: JsonData,
          order: [
            [0, 'desc']
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
      notification();
      $('#se-pre-con').delay(100).fadeOut();

    },
    error: function (data) {

    }

  });
}

