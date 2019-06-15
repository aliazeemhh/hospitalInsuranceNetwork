function updateTable(data)
{
  var length = data.length;

    data = $.extend(true,{},data);

    var tableData = "<tr>"+
                      "<td class='col1'></td>";
    $.each(data, function(key,value)
    {
      var colNum = Number(key) + 2;
      if (key == 0)
      {
        tableData += "<td class='col"+colNum+"'>"+value+"</td>";
      }
      else if(length-1 > key)
      {
        tableData += "<td class='col"+colNum+"'>"+value+"</td>";
      }
      else {
        tableData += getStatus(value);
      }
    });
    tableData += "</tr>";
    $('#dataGrid tbody').append(tableData);
}
function getStatus(arr)
{
  if ((arr[0] == 0) && (arr[1] == 0))
  {
    return '<td class="status-declined">Declined</td><td><div class="btn">View</div></td>';
  }
  else if ((arr[0] == 1) && (arr[1] == 0))
  {
    return '<td class="status-pending">Pending</td><td><div class="btn">Reminder</div></td>';
  }
  else if ((arr[0] == 1) && (arr[1] == 1))
  {
    return '<td class="status-approve">Approved</td><td><div class="btn">View</div></td>';
  }
  else if ((arr[0] == 0) && (arr[1] == 1))
  {
    return '<td class="status-approve">Processed</td><td><div class="btn">View</div></td>';
  }
}
function setSummary(obj)
{
  $(".claims .num .number").html(obj.claim_num);
  $(".claims .amount .number").html(obj.claim_amt);
  $(".approvals .num .number").html(obj.approval_num);
  $(".approvals .amount .number").html(obj.approval_amt);
  $(".billings .num .number").html(obj.billing_num);
  $(".billings .amount .number").html(obj.billing_amt);
  $(".insurers .num .number").html(obj.insurer_num);
  $(".insurers .amount .number").html(obj.insurer_amt);
}
function getDateRange(contract)
{
  $(".claims, .approvals, .billings, .insurers").addClass(".loading")
  $.ajax({
      type:"POST",
      url:"controllers/submitQuery.php",
      data:contract,
      cache:false,
      dataType: 'json',
      success:function(response)
      {
        $(".claims, .approvals, .billings, .insurers").removeClass(".loading")
        setSummary(response);
      }
    });
}
function applySummaryFilter()
{
  if(($("#summaryFilter.customDateRange .customDate .start_date").val() != "") && ($("#summaryFilter.customDateRange .customDate .end_date").val() != ""))
  {
    getDateRange({role:"<?php echo $_SESSION['role']; ?>",sub_role:"<?php echo $_SESSION['sub_role']; ?>",start_date:$(this).val(),end_date:$("#summaryFilter.customDateRange .customDate .end_date").val()});
  }
  else
  {
    setSummary(summary);
  }
}
function applyTableFilter()
{
  var startDate = $("#dataGrid_filter .customDateRange .customDate .start_date").val();
  var endDate = $("#dataGrid_filter .customDateRange .customDate .end_date").val();
  if(startDate !="" && endDate !="")
  {
    $("#dataGrid tbody tr").hide();
    $("#dataGrid tbody tr").filter(function(){
      var trDate = $(this).find(".col8").html().split(" ")[0];

      var isYearLessSD = (Number(trDate.split("-")[0]) >= Number(startDate.split("-")[0]));
      var isYearGreatED = (Number(trDate.split("-")[0]) <= Number(endDate.split("-")[0]));

      var isMonthLessSD = (Number(trDate.split("-")[0]) > Number(startDate.split("-")[0]))?true:(Number(trDate.split("-")[1]) >= Number(startDate.split("-")[1]));
      var isMonthGreatED = (Number(trDate.split("-")[0]) < Number(endDate.split("-")[0]))?true:(Number(trDate.split("-")[1]) <= Number(endDate.split("-")[1]));

      var isDayLessSD = (Number(trDate.split("-")[0]) > Number(startDate.split("-")[0]))?true:(Number(trDate.split("-")[1]) > Number(startDate.split("-")[1])?true:Number(trDate.split("-")[2]) >= Number(startDate.split("-")[2]));
      var isDayGreatSD = (Number(trDate.split("-")[0]) < Number(endDate.split("-")[0]))?true:(Number(trDate.split("-")[1]) < Number(endDate.split("-")[1])?true:Number(trDate.split("-")[2]) <= Number(endDate.split("-")[2]));

      if(isYearLessSD && isYearGreatED && isMonthLessSD && isMonthGreatED && isDayLessSD && isDayGreatSD)
      {
        return $(this);
      }
    }).show();
  }
  else
  {
    $("#dataGrid tbody tr").show();
  }
}
function renderEvent()
{
  $('#dataGrid').DataTable();
  var datepickerInput = '<div class="customDateRange">' +
                          '<div class="customDate">' +
                            '<label>' +
                              '<input type="text" class="customDatePicker start_date" placeholder="Start Date...">' +
                              '<span class="calender"></span>' +
                            '</label>' +
                          '</div>' +
                          '<div class="customDate">' +
                            '<label>' +
                              '<input type="text" class="customDatePicker end_date" placeholder="End Date...">' +
                              '<span class="calender"></span>' +
                            '</label>' +
                          '</div>' +
                        '</div>';

  $("#dataGrid_filter").prepend(datepickerInput);
  $(".menu-btn").click(function(){
    $("menu").toggleClass("close");
    $(this).toggleClass("open");
  });
  $("#summaryFilter.customDateRange .customDate .start_date").change(applySummaryFilter());
  $("#summaryFilter.customDateRange .customDate .end_date").change(applySummaryFilter());
  $("#dataGrid_filter .customDateRange .customDate .start_date").change(function(){
    applyTableFilter();
  });
  $("#dataGrid_filter .customDateRange .customDate .end_date").change(function(){
    applyTableFilter();
  });
}
