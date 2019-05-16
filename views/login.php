
 <div class="page-wrapper">
   <div class="left-pannel pannel-img">

   </div>
   <div class="right-pannel">
     <header class="header">
     </header>
     <form class="login" action="#" method="post">
       <input type="text" name="username"  placeholder="LOGIN ID">
       <input type="password" name="password"  placeholder="PASSWORD">
       <input type="submit" name="signin" value="SIGN IN">
       <input type="checkbox" name="check" value="Stay Signed in">
     </form>
     <a href="#">Forgot Password?</a>
   </div>
 </div>
 <?php
 function checkData()
 {
   $this->form();
 }
 ?>
 <script type="text/javascript">
 window.onload = function()
 {
   $(".login").submit(function(event)
   {
     event.preventDefault();
     //console.log($(this).find("input[name='username']").val());
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
