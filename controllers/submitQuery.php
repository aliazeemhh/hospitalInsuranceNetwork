<?php
namespace controllers;

if(isset($_POST['username']) && isset($_POST['password']))
{
  require 'models/db_get_data.php';
}

use models\db_get_data as db_get_data;
/**
 *
 */
class signup_login extends db_get_data
{

  function __construct()
  {

  }
  function getUserDetails()
  {
    if(isset($_POST['username']) && isset($_POST['password']))
    {
      $querying = new db_get_data();
      $getData = $querying->checkLogin($_POST['username'],  $_POST['password']);
      if($getData == "false")
      {
        $arr = ["status"=>"fail"];
        $_GET['userDetail']="fail";
      }
      else {
        //session_destroy();
        setcookie("PHPSESSID","",-1);
        if(!empty($_POST["remember"]))
        {
          setcookie("login_username",$_POST["username"],time()+ (10*365*24*60*60));
          setcookie("login_password",$_POST["password"],time()+ (10*365*24*60*60));
        }
        else
        {
          setcookie("login_username","",-1);
          setcookie("login_password","",-1);
        }
        $userProfile = [];
        session_start();
        $_COOKIE['PHPSESSID'] = session_id();
        $_SESSION['status'] = "success";
        foreach ($getData as $key => $value)
        {
          if(!is_numeric($key))
          {
            $_SESSION[$key] = $value;
          }
        }
        $arr = ["status"=>"success"];
      }
      return $arr;
    }
  }
}
$login_signup = new signup_login();
$this->start_session($login_signup->getUserDetails());
?>
