<?php

$getUserData = $this->getUserData();

foreach ($getUserData['claim'] as $key => $value) {
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
// setInterval(function()
// {
//   dashboardTable();
// },5);
 ?>
 <script type="text/javascript">

   var summary = <?php echo json_encode($getUserData['summary']); ?>;
   setSummary(summary);
  renderEvent();
 </script>
