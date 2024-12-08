<?php
ob_start();
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="web/lib/jquery.min.js"></script>
<script type="text/javascript" src="web/lib/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="web/lib/jquery-ui.js"></script>
<script type="text/javascript" src="web/js/dashboard.js"></script>
<link rel="stylesheet" type="text/css" href="web/css/jquery.dataTables.min.css"></link>
<link rel="stylesheet" type="text/css" href="web/css/jquery-ui.css"></link>
<link rel="stylesheet" type="text/css" href="web/css/style.css"></link>
<link rel="stylesheet" type="text/css" href="web/css/hosp_patient_details_claims_info.css">
</head>
<body>
<?php
class main
{
  public function default()
  {
    return require('controllers/siteController.php');
  }
}
$mainSite = new main();
$mainSite->default();
?>
</body>
</html>
