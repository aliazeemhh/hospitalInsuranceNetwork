
 <div class="page-wrapper">
   <div class="left-pannel pannel-img">

   </div>
   <div class="right-pannel">
     <img src="/web/img/hin-logo.svg">
     <header class="header">
       <h1>
           SIGN IN
       </h1>
       Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
     </header>
     <form class="login" action="#" method="post">
       <input type="text" class="username" name="username"  placeholder="Username" value="<?php if(isset($_COOKIE["login_username"])) {echo $_COOKIE["login_username"];} ?>">
       <input type="password" class="password" name="password"  placeholder="Password" value="<?php if(isset($_COOKIE["login_password"])) {echo $_COOKIE["login_password"];} ?>">
       <label>
         <input type="checkbox" class="checkbox" name="remember" value="Remember me next time">
         <span>Remember me next time</span>
       </label>
       <input type="submit" name="signin" class="button" value="SIGN IN">
     </form>
     <!-- <a href="#">Forgot Password?</a> -->
     <div id="copyright">
       Copyright(c) 2018 Health Insurance Network
     </div>
   </div>
 </div>
 <?php
 function set_cookie($issetCookie)
 {
   if($issetCookie)
   {
     setcookie("login_username",$_POST["username"],time()+ (10*365*24*60*60));
     setcookie("login_password",$_POST["password"],time()+ (10*365*24*60*60));
   }
 }
 ?>
 <script type="text/javascript">
 window.onload = function()
 {
   $(".login").submit(function(event)
   {
     event.preventDefault();
     //console.log($(this).find("input[name='username']").val());
     if(($(".login input.username").val() == "") || ($(".login input.password").val() == ""))
     {
       return;
     }

     var form = $.extend(true,{},$(this).serialize().split("&"));
     var temp = {};
     $.each(form,function(key,data)
      {
        data = String(data).split("=");
        temp[data[0]] = data[1];

      });
      var data = $(this).serialize();

      $.ajax({
        type:"POST",
        url:"/controllers/submitQuery.php",
        data:data,
        cache:false,
        success:function(response)
        {
          console.log(response);
        }
      })
     //console.log(temp);
     // var formData = new FormData(temp);
     // var xhr = new XMLHttpRequest();
     // xhr.open("POST", "controllers/submitQuery.php",true);
     // console.log(formData);
     // xhr.send(temp);
   });

 }
 </script>
