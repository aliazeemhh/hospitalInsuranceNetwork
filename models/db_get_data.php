<?php
namespace models;

require '../models/db_insert_data.php';

use models\db_insert_data as db_insert_data;

class db_get_data extends db_insert_data
{
  public $insertData;
  function __construct()
  {

  }
  public function insertData()
  {
    $insertData = new db_insert_data();
  }
}

?>
