<?php
//require('views/login.php');
namespace controllers;

class SiteController
{
  static function behaviors()
  {
    require('views/login.php');//$this->render("views/login.php");
  }

}
SiteController::behaviors();
?>
