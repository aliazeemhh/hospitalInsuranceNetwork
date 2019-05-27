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
    if(!empty($_GET['sys']))
    {
      switch($_GET['sys'])
      {
        case  "logout":
        session_destroy();
        break;
        case "dashboard":
        $param = "dashboard";
        break;
      }
    }
    $this->is_active_sessions = session_status();
    if(($this->is_active_sessions == 1) || ($this->is_active_sessions == 0) || empty($_SESSION['name']))
    {

      return require("views/login.php");
    }
    else if($param=="")
    {
      return require("views/dashboard.php");
    }
    else
    {
      //header("views/".$param.".php?".$_COOKIE['PHPSESSID']);
      //header("?SESSION=".$_COOKIE['PHPSESSID']);

      return require("views/".$param.".php");
    }
  }
  public function start_session($userDetail)
  {
    $this->user_details = [];
    foreach ($userDetail as $key => $value)
    {
      $this->user_details["$key"] = $value;
    }
    if($this->user_details["status"] == "success")
    {
      $this->is_active_session("dashboard");
    }
    else
    {
      $this->is_active_session("");
    }

   // $this->start_session();

  }
  public function submit_query()
  {
    require 'controllers/submitQuery.php';

    //use controllers\signup_login as signup_login;
  }

}

$siteController = new siteController();
$siteController->behavior();
?>
