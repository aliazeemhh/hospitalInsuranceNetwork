<?php
namespace models;

//require 'models/db_connect.php';
//require 'models/db_connect.php';

class db_insert_data
{
  public $openConnection;
  function __construct()
  {

  }
  public function db_insert($table_name,$column,$values)
  {
    $conn = OpenCon();
    $col_lngth = count($column);
    $col_str = $val_str="";
    for ($i=0;$i<$col_lngth;$i++)
    {
      if ($i!=0)
      {
        if (is_array($values[$i]))
        {
          //echo implode(" ",$values[$i]);
          $val_str .= ',\'["' . implode(" ",$values[$i]) . '"]\'';

        }
        elseif(($column[$i] == "inprocess_claim") || ($column[$i] == "status") || ($column[$i] == "hosp_id"))
        {
          $val_str .= "," . $values[$i];
        }
        else
        {
          $val_str .= ",'" . $values[$i] . "'";
        }
        $col_str .= ",`".$column[$i]."`";
      }
      else
      {
       $val_str .= "'" . $values[$i] . "'";
       $col_str .= "`".$column[$i]."`";
      }
    }
    //**------------------------

    //----------------send to insert query
    $ins_sql = "INSERT INTO `$table_name` ($col_str) VALUES ($val_str)";
    if ($conn->query($ins_sql)===true)
    {
      //echo $col_str . " " . $val_str;
    }
    else
    {
      echo $ins_sql ." <br/>";
      echo $conn->error;
    }
    CloseCon($conn);
    //----------------
  }
}
?>
