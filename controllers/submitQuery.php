<?php
namespace controllers;

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email_id']))
{
  require 'models/db_insert_data.php';
}
else if(isset($_POST['username']) && isset($_POST['password']))
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
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email_id']) && isset($_POST['role']) && isset($_POST['sub_role']))
    {
      $querying = new db_insert_data();
      $querying->insertData();
    }
    else if(isset($_POST['username']) && isset($_POST['password']))
    {
      $querying = new db_get_data();
      $getData = $querying->checkLogin($_POST['username'],  $_POST['password']);
      if($getData == "false")
      {
        $arr = ["status"=>"fail", "result"=>"user details was not found"];
      }
      else {
        if(!empty($_POST["remember"]))
        {
          setcookie("login_username",$_POST["username"],time()+ (10*365*24*60*60));
          setcookie("login_password",$_POST["password"],time()+ (10*365*24*60*60));
        }
        $userProfile = [];
        foreach ($getData as $key => $value)
        {
          if(!is_numeric($key))
          {
            $userProfile[$key] = $value;
          }
        }
        $arr = ["status"=>"success", "result"=>$userProfile, "issetCookie"=>!empty($_POST["remember"])];
      }
      return $arr;
    }
  }
}
$login_signup = new signup_login();
$this->start_session($login_signup->getUserDetails());
?>
