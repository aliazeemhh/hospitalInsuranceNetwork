<?php
//require('views/login.php');
namespace main;

class siteController
{
  private $is_active_sessions;
  public function behavior()
  {
    return require('views/main.php');//$this->render("views/login.php");
  }

  public function is_active_session($param="")
  {
    //$this->set_session();
    $this->is_active_sessions = session_status();
    if($this->is_active_sessions == 1 || $this->is_active_sessions == 0)
    {
      return require("views/login.php");
    }
    else if($param=="")
    {
      $this->behavior();
    }
    else
    {
      $rep = str_replace("views/","",str_replace(".php","",$param));
      return require($param);
    }
  }
  public function start_session()
  {
    session_start();
  }
  public function form()
  {
    echo $_POST;
  }
}

$siteController = new siteController();
$siteController->behavior();
?>
