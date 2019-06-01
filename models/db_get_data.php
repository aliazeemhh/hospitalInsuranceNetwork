<?php
namespace models;

require 'models/db_connect.php';

class db_get_data
{
  public function checkLogin($username, $password)
  {
    $conn = OpenCon();
    $encrypt = $this->submitQuery($conn, $this->userLogin($username, $password));
    if($encrypt != "false")
    {
      if($encrypt['role']==1)
      {
        $details = $this->submitQuery($conn, $this->hospitalDetails($encrypt['sub_role']));
        $details['claim'] = $this->submitQuery($conn, $this->insurance_claim("hosp_id", $encrypt['sub_role']));

        foreach ($details['claim'] as $key => $value)
        {
          $details['claim'][$key] += $this->submitQuery($conn, $this->insurance_policy_holder("CNIC", $details['claim'][$key]['CNIC']));
          $details['claim'][$key] += $this->submitQuery($conn, $this->insurance_details($details['claim'][$key]['ipid']));
          $details['claim'][$key]["diagnoses"] = [];
          foreach (json_decode($value['did']) as $did => $did_code) {
            $details['claim'][$key]["diagnoses"][$did] = $this->submitQuery($conn, $this->diagnoses($did_code));
          }
        }

      }
      else if($encrypt['role']==2)
      {
        $details = $this->submitQuery($conn, $this->insuranceDetails($encrypt['sub_role']));
        $details['insurance'] = $this->submitQuery($conn, $this->insurance_policy_holder("ipid", $encrypt['sub_role']));
        $details['claim'] = $this->submitQuery($conn, $this->insurance_claim("ipid", $encrypt['sub_role']));

      }
      else if($encrypt['role']==3)
      {
        $details = $this->submitQuery($conn, $this->companyDetails($encrypt['sub_role']));
        $details['company'] = $this->submitQuery($conn, $this->insurance_policy_holder("company_id",$encrypt['sub_role']));
      }
      if(!empty($details))
      {
        foreach ($details as $key => $value) {
          $encrypt[$key] = $value;
        }
      }
    }
    CloseCon($conn);
    return $encrypt;
  }
  private function submitQuery($conn, $ins_sql)
  {
    $encrypt = $conn->query($ins_sql);
    if (mysqli_num_rows($encrypt) > 1)
    {
      $encrypted = $conn->query($ins_sql)->fetch_all();
      $getIndex = $conn->query($ins_sql)->fetch_assoc();
      $newIndex = [];
      foreach ($getIndex as $key => $value) {
        array_push($newIndex, $key);
      }
      $encryption = [];
      foreach ($encrypted as $key => $value) {
        $encryption[$key] = [];

        foreach ($value as $key1 => $value1) {
          $encryption[$key][$newIndex[$key1]] = $value1;
        }
      }
      $encrypt = $encryption;
    }
    else if (mysqli_num_rows($encrypt) > 0)
    {
      $encrypt = $encrypt->fetch_assoc();
    }
    else {
      $encrypt = "false";
    }
    return $encrypt;
  }
  private function userLogin($username, $password)
  {
    $hash = $this->mysql_41_password($password);
    return "SELECT name, username, profile_image, email_id, role, sub_role FROM hin_user WHERE username='$username' AND password='$hash'";
  }
  private function hospitalDetails($subrole)
  {
    return "SELECT hosp_id, hosp_name, did_supports, hosp_logo FROM hospital WHERE hosp_id=$subrole";
  }
  private function companyDetails($subrole)
  {
    return "SELECT company_name, address, phone_number, POC, logo AS 'company_logo' FROM company_hr WHERE company_id='$subrole'";
  }
  private function insurance_details($subrole)
  {
    return "SELECT insurance_code, insurance_comp_name, insurance_logo FROM insurance WHERE ipid='$subrole'";
  }
  private function insurance_policy_holder($searchFrom, $search)
  {
    return "SELECT policy_number, name, CNIC, mobile_number, valid_date, total_limit, limit_consumed, ipid, company_id, tf_id, fcid FROM insurance_policy_holder WHERE $searchFrom='$search'";
  }
  private function insurance_claim($searchFrom, $search)
  {
    return "SELECT claim_no, policy_number, CNIC, patient_name, ipid, claim_date, inprocess_claim, status, hosp_id, claim_amount, did FROM insurance_claim WHERE $searchFrom='$search'";
  }
  private function diagnoses($search)
  {
    return "SELECT did, diag_code, diag_name FROM diagnosis WHERE diag_code='$search'";
  }
  private function mysql_41_password($in)
  {
    $p = sha1($in, true);
    $p = sha1($p);
    return '*'.strtoupper($p);
  }
}

?>
