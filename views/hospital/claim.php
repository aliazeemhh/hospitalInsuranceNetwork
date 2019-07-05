<?php  ?>
<script type="text/javascript">
  var searchData = "";
  searchData = $("#globalSearch").val();
  if(searchData == "")
  {
    window.location = "?sys=dashboard";
  }
</script>
<!-- <script type="text/javascript" src="web/lib/jquery.min.js"></script>
<script type="text/javascript" src="web/lib/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="web/lib/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="web/css/jquery.dataTables.min.css"></link>
<link rel="stylesheet" type="text/css" href="web/css/jquery-ui.css"></link> -->

<div class="hosp-patient-details-claims-views">
    <div class="patient_info">
        <div class="policy_holder"><b>Patient Name</b></div>
        <select class="policy_holder_name participant_name">Ali Muhammad</select>
    </div>
    <div class="insurance_card">
        <div class="header">Insurance Identification Card</div>
        <div class="inscardcontent">
            <div class="leftsec">
                <table>
                    <tr>
                        <td>Participant Name:</td>
                        <td id="participant_name">Talha Khan</td>
                    </tr>
                    <tr>
                        <td>Card No:</td>
                        <td id="policy_number">234012102</td>
                    </tr>
                    <tr>
                        <td>CNIC:</td>
                        <td id="cnic" class="cnic">42301-0000000-0</td>
                    </tr>
                    <tr>
                        <td>Valid Upto:</td>
                        <td id="expiry">14/02/2020</td>
                    </tr>
                    <tr>
                        <td>Hospitalization:</td>
                        <td id="limit">300,000</td>
                    </tr>
                    <tr>
                        <td>Room Limit:</td>
                        <td id="room_limit">9,000</td>
                    </tr>
                </table>
             </div>
            <div class="rightsec">
                <div>Saima Khan</div>
                <div>Altaf Ali</div>
                <div>Samar Khan</div>
            </div>
        </div>
        <div class="footer">24 Hours Emergency Contact (021) 111-111-111</div>
    </div>
</div>
<div class="hosp-patient-details-claims-views">
    <div class="patient_info">
        <div class="policy_holder"><b>CNIC</b></div>
        <div class="policy_holder_name cnic">41110-1251654-9</div>
    </div>
    <div class="claim_form">
        <form action="http://google.com">
            <table>
                    <tr>
                        <td></td>
                        <td> <input type="Submit" value="DISCHARGE"> <input type="Submit" value="TARIFF"></td>
                    </tr>
                    <tr>
                        <td>Cost Estimation</td>
                        <td><input type="text" placeholder="1,000"></td>
                    </tr>
                    <tr>
                        <td>Case Type</td>
                        <td>
                            <input type="radio" label="Eligibility" name="casetype">Eligibility
                            <input type="radio" label="Extension" name="casetype">Extension
                        </td>
                    </tr>
                    <tr>
                        <td>Length of Stay</td>
                        <td><input type="text" placeholder="1 Day"></td>
                    </tr>
                    <tr>
                        <td>Diagnosis</td>
                        <td><input type="text" placeholder="High Fever"><br/>
                            <!-- <select type="text" id="diagnosis" placeholder="Type of Desease"><option selected disabled>Type of Desease</option></select> --></td> 
                    </tr>
                    <tr>
                        <td>Date of Treatment</td>
                        <td><input type="text" placeholder="mm/dd/yyyy"></td>
                    </tr>
                    <tr>
                        <td>Doctor Details</td>
                        <td><input type="text" placeholder="Doctor Name, Consultation and others"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="Submit" value="SUBMIT"></td>
                    </tr>
                </table>
        </form>
    </div>
</div>
<!-- <form id="claim_form">
  Patient Name: <input type="text" placeholder="Patient Name" class="ptname" required><br/><br/>
  Policy Holder: <input type="text" placeholder="Name" class="pholder" required><br/><br/>
  CNIC: <input type="text" placeholder="CNIC without dash" class="cnic" required><br/><br/>
  Policy Number: <input type="text" placeholder="Number" class="pnumber" required><br/><br/>
  Insurer Name: <select id="insurerName" required><option selected disabled>Choose here</option></select><br/><br/>
  Claim Amount: <input type="text" placeholder="Amount" class="amt" required><br/><br/>
  Date: <input id="postDate" type="text" data-date-format="yyyy-mm-dd" placeholder="Date"><br/><br/>
  Diagnosis: <select type="text" id="diagnosis" placeholder="Type of Desease"><option selected disabled>Type of Desease</option></select><br/><br/>
  <input type="submit" value="Submit"/>
</form> -->

<script type="text/javascript">
var props = {};
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
    $(".participant_name").append("<option value='"+response.name+"' selected>"+response.name+"</option>")
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
    data:{provider_detail: "insurance"},
    cache:false,
    dataType: 'json',
    success:function(response)
    {
      console.log(response);
      var option = "";
      $.each(response,function(key,data){
        option += "<option value='"+data.ipid+"'>"+data.insurance_code+"</option>";
      });
      $("#insurerName").append(option);
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
      console.log(response);
      var option = "";
      props = response;
      $.each(props,function(key,data){
        option += "<option value='"+data.diag_code+"'>"+data.diag_name+"</option>";
      });
      $("#diagnosis").append(option);
    },
    error:function(e)
    {
      console.log(e);
    }
  });


  $(document).ready(function(){
    $("#postDate").datepicker();
    $("#postDate").datepicker( 'option', 'dateFormat','yy-mm-dd');

    // $("postDate").datapicker({
    //   default:{
    //
    //   }
    // })

  })

  $("#claim_form").submit(function(event){
    event.preventDefault();
    var arr = [];
    arr.push($(this).find("#diagnosis").val());
    var formData = {
      patient_name:$(this).find(".ptname").val(),
      name:$(this).find(".pholder").val(),
      cnic:$(this).find(".cnic").val(),
      policy_number:$(this).find(".pnumber").val(),
      ipid:$(this).find("#insurerName").val(),
      claim:$(this).find(".amt").val(),
      date:$(this).find("#postDate").val(),
      did:arr,
      hosp_id:1
    }
    var serialize = $.extend(true,{},formData);
    console.log(formData);
    $.ajax({
      type:"POST",
      url:"../../controllers/submitQuery.php",
      data:serialize,
      cache:false,
      dataType: 'json',
      success:function(response)
      {
        var option = "";
        props = response;
        $.each(props,function(key,data){
          option += "<option value='"+data.diag_code+"'>"+data.diag_name+"</option>";
        });
        $("#diagnosis").append(option);
      }
    });
  });
  console.log("rendering!!!");
</script>
