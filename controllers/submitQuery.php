<?php
namespace controllers;

if(isset($_POST['username']) && $_POST['password'])
{
  require '../models/db_insert_data.php';
}
else if(isset($_GET['username']) && $_GET['password'])
{
  require '../models/db_get_data.php';
}

use models\db_get_data as db_get_data;
/**
 *
 */
class signup_login extends db_get_data
{

  function __construct()
  {
    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['email_id']) && isset($_POST['role']) && isset($_POST['sub_role']))
    {
      $querying = new db_insert_data();
      $querying->insertData();
    }
    else if(isset($_POST['username']) && isset($_POST['password']))
    {
      $querying = new db_get_data();
      $getData = $querying->checkLogin($_GET['username'],  $_GET['password']);
      if($getData == "false")
      {
        $arr = ["status"=>"fail", "response"=>"user details was not found"];
      }
      else {
        $userProfile = [];
        foreach ($getData as $key => $value)
        {
          if(!is_numeric($key))
          {
            $userProfile[$key] = $value;
          }
        }
        $arr = ["status"=>"success", "response"=>$userProfile];
      }
      echo json_encode($arr);
    }
  }
}
$login = new signup_login();
?>
