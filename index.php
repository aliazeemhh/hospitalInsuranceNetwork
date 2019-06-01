<?php
ob_start();
session_start();
?>
<script type="text/javascript" src="web/lib/jquery.min.js"></script>
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

<link rel="stylesheet" type="text/css" href="web/css/style.css"></link>
