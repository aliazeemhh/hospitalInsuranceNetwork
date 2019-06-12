<?php
namespace controllers;

if(!empty($_POST['username']) && !empty($_POST['password']))
{
  require 'models/db_get_data.php';
}
elseif (!empty($_POST['role']) && !empty($_POST['sub_role']) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
  require '../models/db_get_data.php';
}

use models\db_get_data as db_get_data;
/**
 *
 */
class signup_login extends db_get_data
{
  function send_sms($to, $from, $sub, $msg)
  {
    $headers = "From: ".$from."\n";
    mail($to, $sub, $msg, $headers);
  }
  function getUserDetails()
  {
    if(!empty($_POST['username']) && !empty($_POST['password']))
    {
      $querying = new db_get_data();
      $getData = $querying->checkLogin($_POST['username'],  $_POST['password']);
      if($getData == "false")
      {
        $arr = ["status"=>"fail"];
        $_GET['userDetail']="fail";
      }
      else {
        if(!empty($_POST["remember"]))
        {
          setcookie("login_username", $_POST["username"], time() + (10*60*60*24*365));
          setcookie("login_password", $_POST["password"], time() + (10*60*60*24*365));
        }
        else
        {
          setcookie("login_username", "", -1);
          setcookie("login_password", "", -1);
        }
        //$this->send_sms("aliazeemh@gmail.com", "someo@unk.com", "test", "this is great!!");
        $userProfile = [];
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
  function getDateRange()
  {
    $querying = new db_get_data();
    return $querying->getSummaryAmount("", $_POST['role'], $_POST['sub_role'], $_POST['start_date'], $_POST['end_date']);

  }
}
$login_signup = new signup_login();
if (!empty($_POST['username']) && !empty($_POST['password'])) {
  $this->start_session($login_signup->getUserDetails());
}
elseif(!empty($_POST['role']) && !empty($_POST['sub_role']) && !empty($_POST['start_date']) && !empty($_POST['end_date']))
{
  echo json_encode($login_signup->getDateRange());
}

?>
