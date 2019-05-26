<?php
  if(isset($_POST['username']) && isset($_POST['password']) && !isset($_GET['userDetail']))
  {
      return require 'controllers/submitQuery.php';
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
 <script type="text/javascript">
 function createCookie(name, value, days) {
   var expires;

   if (days) {
     var date = new Date();
     date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
     expires = "; expires=" + date.toGMTString();
   } else {
     expires = "";
   }
   document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
 }
 // window.onload = function()
 // {
 //   $(".login").submit(function(event)
 //   {
 //     event.preventDefault();
 //     //console.log($(this).find("input[name='username']").val());
 //     if(($(".login input.username").val() == "") || ($(".login input.password").val() == ""))
 //     {
 //       return;
 //     }
 //
 //     var form = $.extend(true,{},$(this).serialize().split("&"));
 //     var temp = {};
 //     $.each(form,function(key,data)
 //      {
 //        data = String(data).split("=");
 //        temp[data[0]] = data[1];
 //
 //      });
 //      var data = $(this).serialize();
 //
 //      $.ajax({
 //        type:"POST",
 //        url:"controllers/submitQuery.php",
 //        data:data,
 //        cache:false,
 //        dataType: 'json',
 //        success:function(response)
 //        {
 //          if(response.status == "success")
 //          {
 //            if(response.issetCookie)
 //            {
 //              createCookie("login_username",$(".login input.username").val(), 100);
 //              createCookie("login_password",$(".login input.password").val(), 100);
 //            }
 //            $.ajax({
 //              type:"POST",
 //              url:"#",
 //              data:response.response,
 //              cache:false,
 //              dataType: 'json',
 //              success:function(response)
 //              {
 //
 //              }
 //            })
 //          }
 //        }
 //      })
 //   });

 }

 </script>
