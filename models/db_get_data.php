<?php
namespace models;

require 'models/db_connect.php';

class db_get_data
{
  public function checkLogin($username, $password)
  {
    $conn = OpenCon();
    $hash = $this->mysql_41_password($password);
    $ins_sql = "SELECT name, username, email_id, role, sub_role FROM hin_user WHERE username='$username' AND password='$hash'";
    $encrypt = $conn->query($ins_sql);
    if (mysqli_num_rows($encrypt) > 0)
    {
      $encrypt = $encrypt->fetch_array();
    }
    else {
      $encrypt = "false";
    }
    CloseCon($conn);
    return $encrypt;
  }
  public function mysql_41_password($in)
  {
    $p = sha1($in, true);
    $p = sha1($p);
    return '*'.strtoupper($p);
  }
}

?>
