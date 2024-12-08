<?php
namespace models;
if (!function_exists('OpenCon'))
{
  if ((!empty($_POST['role']) && !empty($_POST['sub_role']) && !empty($_POST['start_date']) && !empty($_POST['end_date']))
      || (!empty($_POST['provider_detail'])) || (!empty($_POST['patient_name'])))
  {
    require '../models/db_connect.php';
  }
  else
  {
    require 'models/db_connect.php';
  }
  class db_get_data
  {
    public function checkLogin($username, $password)
    {
      $conn = OpenCon();
      $encrypt = $this->submitQuery($conn, $this->userLogin($username, $password));
      //$encrypt = $this->getDashboardDetials($encrypt);
      CloseCon($conn);
      return $encrypt;
    }
    public function getDashboardDetials($encrypt="false")
    {
      if($encrypt != "false")
      {
        $conn = OpenCon();
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
          $details['summary'] = $this->submitQuery($conn, $this->hosp_summary($encrypt['sub_role']));
          //$details['summary'] = $this->getSummaryAmount($conn, 1,1,'2019-04-25', '2019-06-03');
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
        CloseCon($conn);
      }
      return $encrypt;
    }
    public function getProviderDetails($conn="")
    {
      $isConn = false;
      if($conn == "")
      {
        $isConn = true;
        $conn = OpenCon();
      }
      if($_POST['provider_detail'] == "insurance")
      {
        $provider = $this->submitQuery($conn, $this->insurance_details());
      }
      if($_POST['provider_detail'] == "diagnosis")
      {
        $provider = $this->submitQuery($conn, $this->diagnoses());
      }
      if($_POST['provider_detail'] == "userDetail" && $_POST['data'])
      {
        $provider = $this->submitQuery($conn, $this->user_info_insurance_policy_holder($_POST['data']));
        $provider['covered'] = $this->submitQuery($conn, $this->ins_ph_coverage($provider['fcid']));
      }
      if($isConn == true)
      {
        CloseCon($conn);
      }
      return $provider;
    }
    public function getHospSummary($conn="", $id)
    {
      if($conn == "")
      {
        $isConn = true;
        $conn = OpenCon();
      }
      $summary = $this->submitQuery($conn, $this->hosp_summary($id));
      if($isConn == true)
      {
        CloseCon($conn);
      }
      return $summary;
    }
    public function getSummaryAmount($conn="", $role,$id, $startDate, $endDate)
    {
      $isConn = false;
      if($conn == "")
      {
        $isConn = true;
        $conn = OpenCon();
      }
      $summary = [];
      if($role == 1)
      {
        $summary['startDate'] = $this->submitQuery($conn, $this->hosp_summary($id,$startDate));
        $summary['endDate'] = $this->submitQuery($conn, $this->hosp_summary($id,$endDate));
        $summary['amount'] = [
                               "claim_num" => ($summary['endDate']['claim_num'] - $summary['startDate']['claim_num']),
                               "claim_amt" => ($summary['endDate']['claim_amt'] - $summary['startDate']['claim_amt']),
                               "approval_num" => ($summary['endDate']['approval_num'] - $summary['startDate']['approval_num']),
                               "approval_amt" => ($summary['endDate']['approval_amt'] - $summary['startDate']['approval_amt']),
                               "billing_num" => ($summary['endDate']['billing_num'] - $summary['startDate']['billing_num']),
                               "billing_amt" => ($summary['endDate']['billing_amt'] - $summary['startDate']['billing_amt']),
                               "insurer_num" => ($summary['endDate']['insurer_num'] - $summary['startDate']['insurer_num']),
                               "insurer_amt" => ($summary['endDate']['insurer_amt'] - $summary['startDate']['insurer_amt'])
                             ];
      }
      if($isConn == true)
      {
        CloseCon($conn);
      }
      return $summary['amount'];
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
      return "SELECT uid, name, username, profile_image, email_id, role, sub_role FROM hin_user WHERE username='$username' AND password='$hash'";
    }
    private function hospitalDetails($subrole)
    {
      return "SELECT hosp_id, hosp_name, did_supports, hosp_logo FROM hospital WHERE hosp_id=$subrole";
    }
    private function companyDetails($subrole)
    {
      return "SELECT company_name, address, phone_number, POC, logo AS 'company_logo' FROM company_hr WHERE company_id='$subrole'";
    }
    private function insurance_details($subrole = "")
    {
      if($subrole != "")
      {
        return "SELECT insurance_code, insurance_comp_name, insurance_logo FROM insurance WHERE ipid='$subrole'";
      }
      else
      {
        return "SELECT insurance_code, insurance_comp_name, ipid FROM insurance";
      }
    }
    private function insurance_policy_holder($searchFrom, $search)
    {
      return "SELECT policy_number, name, CNIC, mobile_number, valid_date, total_limit, limit_consumed, ipid, company_id, tf_id, fcid FROM insurance_policy_holder WHERE $searchFrom='$search'";
    }
    private function insurance_policy_holder_details($number, $ipid)
    {
      $today = date('y-m-d');
      return "SELECT policy_number, name, CNIC, mobile_number, valid_date, total_limit, limit_consumed, ipid, company_id, tf_id, fcid FROM insurance_policy_holder WHERE policy_number='$number' AND ipid='$ipid' ";
    }
    private function insurance_claim($searchFrom, $search)
    {
      return "SELECT claim_no, policy_number, CNIC, patient_name, ipid, claim_date, inprocess_claim, status, hosp_id, claim_amount, did FROM insurance_claim WHERE $searchFrom='$search'";
    }
    private function diagnoses($search = "")
    {
      if($search != "")
      {
        return "SELECT did, diag_code, diag_name FROM diagnosis WHERE diag_code='$search'";
      }
      else
      {
        return "SELECT did, diag_code, diag_name FROM diagnosis";
      }
    }
    private function insurance_claim_date($search, $starting, $ending)
    {
      return "SELECT claim_no, policy_number, CNIC, patient_name, ipid, claim_date, inprocess_claim, status, hosp_id, claim_amount, did FROM hosp_summary WHERE hosp_id='$search' AND (sub_date BETWEEN '$starting' AND '$ending'))";
    }
    private function hosp_summary($search, $ending="")
    {
      if($ending == "")
      {
        $ending=date('y-m-d');
      }
      return "SELECT claim_num, claim_amt, approval_num, approval_amt, billing_num, billing_amt, insurer_num, insurer_amt FROM hosp_summary WHERE hosp_id='$search' AND sub_date=(SELECT MAX(sub_date) FROM hosp_summary WHERE hosp_id='$search' AND (sub_date BETWEEN '1900-01-01' AND '$ending'))";
    }
    private function user_info_insurance_policy_holder($search = "")
    {
      return "SELECT policy_number, name, CNIC, mobile_number, valid_date, total_limit, room_limit, limit_consumed, ipid, company_id, tf_id, fcid FROM insurance_policy_holder WHERE BINARY (CNIC='$search' OR name='$search' OR policy_number='$search' OR mobile_number='$search')";
    }
    private function ins_ph_coverage($search = "")
    {
      return "SELECT fcid, covered_name, did_supports FROM ins_ph_coverage WHERE BINARY fcid='$search'";
    }
    private function mysql_41_password($in)
    {
      $p = sha1($in, true);
      $p = sha1($p);
      return '*'.strtoupper($p);
    }
  }
}
?>
