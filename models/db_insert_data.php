<?php
namespace models;

require '../models/db_connect.php';

class db_insert_data
{
  public $openConnection;
  function __construct()
  {

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
    closeConnection($conn);
    //----------------
  }
  public function openConnection()
  {
    return OpenCon();
  }
  public function closeConnection($conn)
  {
    CloseCon($conn);
  }
}
?>
