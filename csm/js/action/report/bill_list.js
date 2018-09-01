var $datatable = $('#datatable');

function initialDataTable(first) {
  $.ajax({
    type: 'GET',
    url: 'controller/report/createController.php?func=dataTableBill',
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
        var col_checkbox = "";
        col_checkbox = '<span class="md-checkbox has-success" style="padding-right: 0px;">';
        col_checkbox += '  <input type="checkbox" id="checkbox_' + i + '" name="checkboxItem[]" class="md-check"';
        col_checkbox += '  value="' + item.id + '" >';
        col_checkbox += '  <label for="checkbox_' + i + '">';
        col_checkbox += '    <span class="inc"></span>';
        col_checkbox += '    <span class="check"></span>';
        col_checkbox += '    <span class="box"></span> </label>';
        col_checkbox += '</span>';

        var col_no = item.id;
        var col_by = item.s_code_by;
        var col_buy = item.s_code_buy;

        var col_print = "";

        col_print += '<a target="_blank" href="report/bill.php?id=' + item.id + '" style="width:33px;height:33px" class="btn btn-circle btn-icon-only green" >';
        col_print += ' <i class="fa fa-print" ></i>';
        col_print += '</a>';


        var addRow = [
          col_no,
          col_by,
          col_buy,
          col_print

        ]

        JsonData.push(addRow);

      });
      if (first == "TRUE") {
        $datatable.dataTable({
          data: JsonData,
          order: [
            [1, 'desc']
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

