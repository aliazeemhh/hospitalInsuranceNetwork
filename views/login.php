<?php
  if(!empty($_SESSION['status']) && (!empty($_GET['dashboard'])))
  {
    if($_SESSION['status'] == "success")
    {
      $this->start_session($_SESSION);
    }
  }
  else if(!empty($_POST['username']) && !empty($_POST['password']) && empty($_GET['userDetail']))
  {
    $this->submit_query();
  }
  else
  {
?>
 <div class="page-wrapper">
   <div class="left-pannel pannel-img">

   </div>
   <div class="right-pannel">
     <img src="web/img/hin-logo.svg">
     <header class="header">
       <h1>
           SIGN IN
       </h1>
       Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
     </header>
     <form class="login" action="?" method="post">
       <input type="text" class="username" name="username"  placeholder="Username" value="<?php if(isset($_COOKIE["login_username"])) {echo $_COOKIE["login_username"];} ?>">
       <input type="password" class="password" name="password"  placeholder="Password" value="<?php if(isset($_COOKIE["login_password"])) {echo $_COOKIE["login_password"];} ?>">
       <label>
         <input type="checkbox" class="checkbox" name="remember" value="Remember me next time" checked>
         <span>Remember me next time</span>
       </label>
       <input type="submit" name="signin" class="button" value="SIGN IN">
     </form>
     <?php if(isset($_GET['userDetail'])) {?>
       <span class="invalid"> Invalid login </span>
     <?php } ?>
     <!-- <a href="#">Forgot Password?</a> -->
     <div id="copyright">
       Copyright(c) 2018 Health Insurance Network
     </div>
   </div>
 </div>
 <?php
  }
 ?>
