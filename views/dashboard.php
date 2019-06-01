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
 ?>
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
     <menu>
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
  <div class="dashboard-views">
   <h2><?php echo ($_SESSION['role']==0?"Admin":($_SESSION['role']==1?"Hospital Management":($_SESSION['role']==2?"Insurance Management":""))); ?> Dashboard</h2>
    <div>
      <div class="status-cont"><b>APPROVALS</b></div>
      <div class="status-cont"><b>CLAIMS</b></div>
      <div class="status-cont"><b>INSURERS</b></div>
      <div class="status-cont"><b>BILLING</b></div>
    </div>
    <ol>
    <table>
      <thead>
 			  <tr>
     		 <th class="title">#</th>
         <th class="title">Paitient Name</th>
         <th class="title">Name</th>
         <th class="title">Policy #</th>
         <th class="title">CNIC / HIC</th>
         <th class="title">Diagnosis</th>
         <th class="title">Insurer</th>
         <th class="title">Date & Time</th>
         <th class="title">Status</th>
         <th class="title">Action</th>
       </tr>
     </thead>
     <tbody>
    	  <tr>
          <td></td>
          <td><li>Ali</li></td>
          <td>Ali Az</td>
          <td>215-32568-8</td>
          <td>42101-5356928-6</td>
          <td>High Fever</td>
          <td>NJI</td>
          <td>01/23/2018 10:59PM</td>
          <td class="status-approve">Approved</td>
          <td><div class="btn">View</div></td>

 			  </tr>
        <tr>
          <td></td>
          <td><li>Ali</li></td>
          <td>Ali Az</td>
          <td>215-32568-8</td>
          <td>42101-5356928-6</td>
          <td>High Fever</td>
          <td>NJI</td>
          <td>01/23/2018 10:59PM</td>
          <td class="status-declined">Declined</td>
          <td><div class="btn">View</div></td>

        </tr>
        <tr>
          <td></td>
          <td><li>Ali</li></td>
          <td>Ali Az</td>
          <td>215-32568-8</td>
          <td>42101-5356928-6</td>
          <td>High Fever</td>
          <td>NJI</td>
          <td>01/23/2018 10:59PM</td>
          <td class="status-pending">Pending</td>
          <td><div class="btn">Reminder</div></td>

        </tr>
      </tbody>
         </table>
       </ol>
     </div>
   </div>
 </div>
<script type="text/javascript">
  function updateTable(data)
  {
    var length = data.length;
    try {
      data = $.extend(true,{},data);

      var tableData = "<tr>"+
                        "<td></td>";
      $.each(data, function(key,value)
      {
        if (key == 0)
        {
          tableData += "<td><li>"+value+"</li></td>";
        }
        else if(length-1 > key)
        {
          tableData += "<td>"+value+"</td>";
        }
        else {
          tableData += getStatus(value);
        }
      });
      tableData += "</tr>";
      console.log(tableData);
      $('table tbody').append(tableData);
    } catch (e) {
      window.onload = function()
      {
        data = $.extend(true,{},data);
        console.log(data.length);
        var tableData = "<tr>"+
                          "<td></td>";
        $.each(data, function(key,value)
        {
          if (key == 0)
          {
            tableData += "<td><li>"+value+"</li></td>";
          }
          else if(length-1 > key)
          {
            tableData += "<td>"+value+"</td>";
          }
          else
          {
            tableData += getStatus(value);
          }
        });
        tableData += "</tr>";

        $('table tbody').append(tableData);

      }
    }
  }
  function getStatus(arr)
  {
    console.log(arr);
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
</script>
<?php
foreach ($_SESSION['claim'] as $key => $value) {
  //echo $value['patient_name'];
   //echo [$value['patient_name'], $value['name'], $value['policy_number'], $value['CNIC'], $value['diagnosis'][0]['diag_name'], $value['insurance_code'], $value['claim_date']];
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
