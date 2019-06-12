<?php
function getSessionData($arr, $val)
{
  foreach ($arr as $key => $value)
  {
    if(is_array($value))
    {
      getSessionData($value, $val."[".$key."]");
    }
    else
    {
      echo "<br/>SESSION".$val."[".$key."] => ".$value;
    }
  }
}
//getSessionData($_SESSION,"");
if($_SESSION['role'] == 1)
{
?>
 <script type="text/javascript">
  var hosp_id = "<?php echo $_SESSION['sub_role']; ?>";
  </script>
<?php
}
else if($_SESSION['role'] == 2)
{
  ?>
   <script type="text/javascript">
    var insurance_id = "<?php echo $_SESSION['sub_role']; ?>";
    </script>
  <?php
}
?>
 <script type="text/javascript">
  $(function(){
    $(".customDatePicker").datepicker();
    $(".customDatePicker").datepicker("option", "dateFormat", "yy-mm-dd" );
  })
 </script>
 <div class="hosp-dashboard-wrapper">
   <header>
     <img id="logo" src="web/img/hin-logo.svg">
     <form class="search">
       <input type="text" placeholder="CNIC, Mobile No., ID">
       <button type="submit" class="button" name="search-button">SEARCH CLIENT</button>
     </form>
     <div id="user_name"> <img src="<?php echo $_SESSION['profile_image']!=""?$_SESSION['profile_image']:"web/img/profile.jpg"; ?>"> <span>Welcome <?php echo $_SESSION['name']; ?></span></div>
   </header>
   <div id="dashboard-cont">
     <menu class="close">
     	<div id="profile">
         	<img id="prof-dp" src="<?php echo $_SESSION['profile_image']!=""?$_SESSION['profile_image']:"web/img/profile.jpg"; ?>">
             <div id="user"><b><?php echo ($_SESSION['role']==0?"Admin":($_SESSION['role']==1?"Hospital Management":($_SESSION['role']==2?"Insurance Management":"Company Management"))); ?></b><br> <?php echo $_SESSION['email_id']; ?></div>

         </div>
         <div id="menu-items">
             <a href="?sys=dashboard">Dashboard</a>
             <a href="">Medical Tariff</a>
             <a href="">Insurers</a>
             <a href="">Hospitals</a>
             <a href="">Clients</a>
             <a href="">Subscriptions</a>
             <a href="">Messages</a>
             <a href="?sys=logout">Logout</a>
     		</div>
     	</menu>
      <div class="menu-btn"></div>
      <div class="dashboard-views">
        <h2><?php echo ($_SESSION['role']==0?"Admin":($_SESSION['role']==1?"Hospital Management":($_SESSION['role']==2?"Insurance Management":""))); ?> Dashboard</h2>
        <div id="summaryFilter" class="customDateRange">
          <div class="customDate">
            <label>
              <input type="text" class="customDatePicker start_date" placeholder="Start Date...">
              <span class="calender"></span>
            </label>
          </div>
          <div class="customDate">
            <label>
              <input type="text" class="customDatePicker end_date" placeholder="End Date...">
              <span class="calender"></span>
            </label>
          </div>
        </div>
        <div class="hin-summary">
          <div class="claims status-cont"><b>CLAIMS</b>
            <div class="summary">
              <div class="center num"><div class="number">50</div><div class="text">Total Number</div></div>
              <span class="seperator"></span>
              <div class="center amount"><div class="number">500</div><div class="text">Total Amount</div></div>
            </div>
          </div>
          <div class="approvals status-cont"><b>APPROVALS</b>
            <div class="summary">
              <div class="center num"><div class="number">0</div><div class="text">Total Number</div></div>
              <span class="seperator"></span>
              <div class="center amount"><div class="number">0</div><div class="text">Total Amount</div></div>
            </div>
          </div>
          <div class="billings status-cont"><b>BILLING</b>
            <div class="summary">
              <div class="center num"><div class="number">0</div><div class="text">Total Number</div></div>
              <span class="seperator"></span>
              <div class="center amount"><div class="number">0</div><div class="text">Total Amount</div></div>
            </div>
          </div>
          <div class="insurers status-cont"><b>INSURERS</b>
            <div class="summary">
              <div class="center num"><div class="number">0</div><div class="text">Total Number</div></div>
              <span class="seperator"></span>
              <div class="center amount"><div class="number">0</div><div class="text">Total Amount</div></div>
            </div>
          </div>
        </div>
        <table id="dataGrid">
          <thead>
     			  <tr>
            <th class="title col1">#</th>
         		 <th class="title col2">Paitient Name</th>
             <th class="title col3">Name</th>
             <th class="title col4">Policy #</th>
             <th class="title col5">CNIC / HIC</th>
             <th class="title col6">Diagnosis</th>
             <th class="title col7">Insurer</th>
             <th class="title col8">Date & Time</th>
             <th class="title col9">Status</th>
             <th class="title col10">Action</th>
           </tr>
         </thead>
         <tbody>
         </tbody>
       </table>
     </div>
   </div>
 </div>
<script type="text/javascript">
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
  setSummary(<?php echo json_encode($_SESSION['summary']); ?>);
</script>
<?php
foreach ($_SESSION['claim'] as $key => $value) {
   ?>
    <script type="text/javascript">
      var table = [];
      table.push("<?php echo $value['patient_name']; ?>");
      table.push("<?php echo $value['name']; ?>");
      table.push("<?php echo $value['policy_number']; ?>");
      table.push("<?php echo $value['CNIC']; ?>");
      table.push("<?php
      foreach ($value['diagnoses'] as $key1 => $value1) {
        if($key1 > 0)
        {
          echo ", ";
        }
        echo $value1['diag_name'];
      }
      ?>");
      table.push("<?php echo $value['insurance_code']; ?>");
      table.push("<?php echo $value['claim_date']; ?>");
      table.push(["<?php echo $value['inprocess_claim']; ?>","<?php echo $value['status']; ?>"]);
      updateTable(table);
    </script>
   <?php
}
 ?>
 <script type="text/javascript">
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
  $("#summaryFilter.customDateRange .customDate .start_date").change(function()
  {
    console.log("*******");
    console.log($(this).val());
    console.log($("#summaryFilter.customDateRange .customDate .end_date").val());
    console.log("*******");
    if(($(this).val() != "") && ($("#summaryFilter.customDateRange .customDate .end_date").val()))
    {
      getDateRange({role:"<?php echo $_SESSION['role']; ?>",sub_role:"<?php echo $_SESSION['sub_role']; ?>",start_date:$(this).val(),end_date:$("#summaryFilter.customDateRange .customDate .end_date").val()});
    }
  });
  $("#summaryFilter.customDateRange .customDate .end_date").change(function()
  {
    console.log("*******");
    console.log($(this).val());
    console.log($("#summaryFilter.customDateRange .customDate .start_date").val());
    if(($(this).val() != "") && ($("#summaryFilter.customDateRange .customDate .start_date").val()))
    {
      getDateRange({role:"<?php echo $_SESSION['role']; ?>",sub_role:"<?php echo $_SESSION['sub_role']; ?>",start_date:$("#summaryFilter.customDateRange .customDate .start_date").val(),end_date:$(this).val()});
    }
    console.log("*******");
  })
 </script>
