<?php
namespace controllers;

use models\db_get_data as db_get_data;
use models\db_insert_data as db_insert_data;

$session = "";

if(!empty($_POST['username']) && !empty($_POST['password']))
{
  require 'models/db_get_data.php';
}
elseif ((!empty($_POST['role']) &&
        !empty($_POST['sub_role']) &&
        !empty($_POST['start_date']) &&
        !empty($_POST['end_date'])) ||
        !empty($_POST['provider_detail']))
{
  require '../models/db_get_data.php';
}
elseif(!empty($_POST['patient_name']) && !empty($_POST['name']) && !empty($_POST['cnic']) && !empty($_POST['policy_number']))
{
  require '../models/db_get_data.php';
  require '../models/db_insert_data.php';


  class insertData extends db_insert_data
  {
    function submitClaim()
    {

      $db_insert_data = new db_insert_data();
      $querying = new db_get_data();
      $db_insert_data->db_insert("insurance_claim",
                                ['policy_number',          'CNIC',           'patient_name',          'ipid',     'claim_amount',   'claim_date',     'did', 'inprocess_claim', 'status',   'hosp_id'],
                                [$_POST['policy_number'], $_POST['cnic'], $_POST['patient_name'], $_POST['ipid'], $_POST['claim'], $_POST['date'], $_POST['did'],   '1',          '0', $_POST['hosp_id']]);

      $summary = $querying->getHospSummary("",'1');
      $summary["claim_num"] += 1;
      $summary["claim_amt"] += $_POST['claim'];
      $db_insert_data->db_insert("hosp_summary",
                                ['hosp_id',           'sub_date',      'claim_num',             'claim_amt',               'approval_num',            'approval_amt',       'billing_num',          'billing_amt',               'insurer_num',             'insurer_amt'],
                                [$_POST['hosp_id'], $_POST['date'], $summary["claim_num"], $summary["claim_amt"], $summary["approval_num"], $summary["approval_amt"], $summary["billing_num"], $summary["billing_amt"], $summary["insurer_num"], $summary["insurer_amt"]]);
      //$db_insert_data->db_insert($_POST['patient_name'], $_POST['name'], $_POST['cnic'], $_POST['policy_number'], $_POST['ipid'], $_POST['claim'], $_POST['date'], $_POST['desease']);
    }
  }
  $insertData = new insertData();
}
elseif ($_SESSION['status'] == "success") {
  require 'models/db_get_data.php';
}

/**
 *
 */
if(!function_exists('controllers\loginStats'))
{
  function loginStats ()
  {

  }
  class login extends db_get_data
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
    function getUserUpdatedData()
    {
      $querying = new db_get_data();
      if(!empty($_SESSION))
      {
        $session = $_SESSION;
      }
      else
      {
        $_SESSION = $session;
      }
      $getData = $querying->getDashboardDetials($_SESSION);
      return $getData;
    }
  }
}
/**
 *
 */

 $login_signup = new login();
 if (!empty($_SESSION['status']) && $_SESSION['status'] == "success")
 {
   //$login_signup = new signup_login();
   $arr = $login_signup->getUserUpdatedData();
   return $arr;
 }
 elseif (!empty($_POST['username']) && !empty($_POST['password']))
 {
   $this->start_session($login_signup->getUserDetails());
 }
 elseif(!empty($_POST['role']) && !empty($_POST['sub_role']) && !empty($_POST['start_date']) && !empty($_POST['end_date']))
 {
   //$login_signup = new signup_login();
   echo json_encode($login_signup->getDateRange());
 }
 elseif (!empty($_POST['provider_detail']))
 {
   $querying = new db_get_data();
   echo json_encode($querying->getProviderDetails());
 }
 elseif (!empty($_POST['patient_name']) && !empty($_POST['name']) && !empty($_POST['cnic']) && !empty($_POST['policy_number']) && !empty($_POST['ipid']) && !empty($_POST['claim']) && !empty($_POST['date']) && !empty($_POST['did']))
 {
   $insertData->submitClaim();
 }
?>
