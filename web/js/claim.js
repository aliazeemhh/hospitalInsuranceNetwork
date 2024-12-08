var props = {};
var ipid = "";
$.ajax({
  type:"POST",
  url:"../../controllers/submitQuery.php",
  data:{
    provider_detail: "userDetail",
    data:searchData
  },
  cache:false,
  dataType: 'json',
  success:function(response)
  {
    $("#participant_name").html(response.name);
    $("#policy_number").html(response.policy_number);
    $(".cnic").html(response.CNIC);
    $("#expiry").html(response.valid_date);
    $("#limit").html(response.total_limit);
    $("#room_limit").html(response.room_limit);
    $(".rightsec").html("");
    $(".participant_name").append("<option value='"+response.name+"' selected>"+response.name+"</option>");
    ipid = response.ipid;
    $.each(response.covered,function(key,data)
    {
      $(".participant_name").append("<option value='"+ data.covered_name +"'>"+ data.covered_name +"</option>");
      $(".rightsec").append("<div>"+data.covered_name+"</div>");
    });
  }
});
  $.ajax({
    type:"POST",
    url:"controllers/submitQuery.php",
    data:{provider_detail: "diagnosis"},
    cache:false,
    dataType: 'json',
    success:function(response)
    {
      var option = "";
      props = response;
      $(".diagnosis-list").html("");
      $.each(props,function(key,data){
        option += "<div data-id='"+data.diag_code+"'>"+data.diag_name+"</div>";
      });
      $(".diagnosis-list").append(option);
      renderClaimEvent();
    },
    error:function(e)
    {
      console.log(e);
    }
  });

  function renderClaimEvent()
  {
    var isclick = false;
    $("#diagnosis").click(function(){
      if(!isclick)
      {
        $(".diagnosis-list").toggleClass("hide");
      }
      isclick = false;
    });
    $(".diagnosis-list div").click(function(){
      $("#diagnosis").append("<span data-id='"+$(this).attr("data-id")+"'>"+$(this).html()+"</span>");
      $(this).addClass("hide");
      $("#diagnosis span").off("click");
      $("#diagnosis span").click(function(event){
        console.log(true);
        isclick = true;
        $(".diagnosis-list div[data-id="+$(this).attr("data-id")+"]").removeClass("hide");
        $(this).remove();
      });
    });
  }

  $(document).ready(function(){
    $("#postDate").datepicker();
    $("#postDate").datepicker( 'option', 'dateFormat','yy-mm-dd');
  })

  $("form#claim_form").submit(function(event){
    event.preventDefault();
    var arr = [];
    $("#diagnosis span").each(function(){
      arr.push($(this).attr("data-id"));
    })

    var formData = {
      patient_name:$(".participant_name").val(),
      name:$("#participant_name").html(),
      cnic:$("#cnic").html(),
      policy_number:$("#policy_number").html(),
      ipid:ipid,
      claim:$(this).find(".amt").val(),
      date:$(this).find("#postDate").val(),
      did:arr,
      hosp_id:hosp_id,
      case_type:$(this).find("input[name=casetype]:checked").val(),
      stay:$(this).find("#stay").val(),
      doctor_name:$(this).find("#drName").val(),
      post_by:user_id
    }
    var serialize = $.extend(true,{},formData);
    $.ajax({
      type:"POST",
      url:"../../controllers/submitQuery.php",
      data:serialize,
      cache:false,
      dataType: 'json',
      success:function(response)
      {
        window.location = "?sys=dashboard";
      }
    });
  });
