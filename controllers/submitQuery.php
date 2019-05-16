<?php
namespace controllers;

require '../models/db_get_data.php';

use models\db_get_data as db_get_data;
/**
 *
 */
class signup_login extends db_get_data
{

  function __construct()
  {
    if(isset($_POST['username']) && $_POST['password'])
    {
      $querying = new db_get_data();
      $querying->insertData();
    }
    // code...
  }
}
$login = new signup_login();
?>
