<?php
namespace models;

class db_connect
{
  function OpenCon()
  {
     echo "db_con.php OpenCon function called<br>";
     $dbhost = "localhost";
     $dbuser = "root";
     $dbpass = "";
     $db = "health_insurance_network";
     $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
     return $conn;
  }

  function CloseCon($conn)
  {
    $conn -> close();
  }
}


 ?>
