<?php
namespace models;

require '../models/db_connect.php';

use models\db_connect as db_connect;

class db_insert_data extends db_connect
{
  public $openConnection;
  function __construct()
  {
    echo $_POST['username'];
    echo $_POST['password'];
  }
  function db_insert($table_name,$column,$values)
  {
    $conn = openConnection();
    $col_lngth = count($column);
    $col_str = $val_str="";
    for ($i=0;$i<$col_lngth;$i++)
    {
      if ($i!=0)
      {
        $col_str .= ",";
        $val_str .= ",'" . $values[$i] . "'";
      }
      else
      {
       $val_str .= $values[$i];
      }
      $col_str .= $column[$i];
    }
    //**------------------------

    //----------------send to insert query
    $ins_sql = "INSERT INTO $table_name ($col_str) VALUES ($val_str)";
    if ($conn->query($ins_sql)===true)
    {
      echo $col_str . " " . $val_str;
    }
    else
    {
      echo $col_str . " " . $val_str . "<br>";
      echo $conn->error;
    }
    //----------------
  }
  public function openConnection()
  {
    $openConnection = new db_connect();
    return $openConnection->OpenCon();
  }
}
?>
