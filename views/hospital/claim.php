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
                        <td id="participant_name">Policy Holder Name</td>
                    </tr>
                    <tr>
                        <td>Card No:</td>
                        <td id="policy_number">Policy Number</td>
                    </tr>
                    <tr>
                        <td>CNIC:</td>
                        <td id="cnic" class="cnic">CNIC Number</td>
                    </tr>
                    <tr>
                        <td>Valid Upto:</td>
                        <td id="expiry">Expiry Date</td>
                    </tr>
                    <tr>
                        <td>Hospitalization:</td>
                        <td id="limit">Limit</td>
                    </tr>
                    <tr>
                        <td>Room Limit:</td>
                        <td id="room_limit">Room Limit</td>
                    </tr>
                </table>
             </div>
            <div class="rightsec">
            </div>
        </div>
        <div class="footer">24 Hours Emergency Contact (021) 111-111-111</div>
    </div>
</div>
<div class="hosp-patient-details-claims-views">
    <div class="patient_info">
        <div class="policy_holder"><b>CNIC</b></div>
        <div class="policy_holder_name cnic">CNIC Number</div>
    </div>
    <div class="claim_form">
        <form id="claim_form">
            <table>
                    <tr>
                        <td></td>
                        <td> <input type="Submit" value="DISCHARGE"> <input type="Submit" value="TARIFF"></td>
                    </tr>
                    <tr>
                        <td>Cost Estimation</td>
                        <td><input type="text" class="amt" placeholder="1,000"></td>
                    </tr>
                    <tr>
                        <td>Case Type</td>
                        <td>
                            <input type="radio" label="Eligibility" name="casetype" value="0" checked>Eligibility
                            <input type="radio" label="Extension" name="casetype" value="1">Extension
                        </td>
                    </tr>
                    <tr>
                        <td>Length of Stay</td>
                        <td><input type="text" id="stay" placeholder="1 Day"></td>
                    </tr>
                    <tr>
                        <td>Diagnosis</td>
                        <td><div type="text" id="diagnosis" placeholder="High Fever"></div>
                            <div class="diagnosis-list hide">

                            </div>
                            <!-- <select type="text" id="diagnosis" placeholder="Type of Desease"><option selected disabled>Type of Desease</option></select> --></td>
                    </tr>
                    <tr>
                        <td>Date of Treatment</td>
                        <td><input type="text" id="postDate" placeholder="YYYY-MM-DD"></td>
                    </tr>
                    <tr>
                        <td>Doctor Details</td>
                        <td><input type="text" id="drName" placeholder="Doctor Name, Consultation and others"></td>
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

<script type="text/javascript" src="web/js/claim.js"></script>
