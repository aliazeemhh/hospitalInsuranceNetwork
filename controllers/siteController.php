<?php
//require('views/login.php');
namespace main;

class siteController
{
  private $is_active_sessions;
  private $user_details=[];
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
      require("views/login.php");
    }
    else if($param=="")
    {
      $this->behavior();
    }
    else
    {
      $rep = str_replace("views/","",str_replace(".php","",$param));
      return header("Location:".$param);
    }
  }
  public function start_session($userDetail)
  {
    $this->user_details = [];
    foreach ($userDetail as $key => $value)
    {
      $this->user_details["$key"] = $value;
    }
    if($this->user_details["$key"] == "success")
    {
          echo "successfully loaded!!!";
          session_start();
          $this->is_active_session("views/dashboard.php");
    }
    else
    {
      $this->is_active_session("");
    }

   // $this->start_session();

  }

}

$siteController = new siteController();
$siteController->behavior();
?>
