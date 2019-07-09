<?php
$preSetLocation = "";
if (!empty($_POST['message']))
{
  $myfile = fopen($preSetLocation . $_POST['user2'] ."_logs_". $_POST['user'] . "/logs.txt", "w") or fopen($preSetLocation . $_POST['user'] ."_logs_". $_POST['user2'] . "/logs.txt", "w") or die("Unable to open file!");
  $today = date();
  $txt = $_POST['user'] ." ". $today . ": " . $_POST['message'];
  fwrite($myfile, $txt);
  fclose($myfile);
}

if(!empty($_GET['messages']))
{
  $myfile2 = fopen($preSetLocation . $_POST['user2'] ."_logs_". $_POST['user'] . "/logs.txt", "r") or fopen($preSetLocation . $_POST['user'] ."_logs_". $_POST['user2'] . "/logs.txt", "r");
  echo fread($myfile2,filesize("newfile.txt"));
  fclose($myfile2);
}
?>
