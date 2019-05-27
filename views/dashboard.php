<?php

 ?>
 <div class="hosp-dashboard-wrapper">
   <header>
     <img id="logo" src="web/img/hin-logo.svg">
     <form class="search">
       <input type="text" placeholder="CNIC, Mobile No., ID">
       <button type="submit" class="button" name="search-button">SEARCH CLIENT</button>
     </form>
     <div id= "user_name"> <img src="<?php echo $_SESSION['profile_image']; ?>"> <span>Welcome <?php echo $_SESSION['name']; ?></span></div>
   </header>
   <div id="dashboard-cont">
     <menu>
     	<div id="profile">
         	<img id= "prof-dp" src="web/img/profile_dp.jpg">
             <div id= "user"><b>Hospital Admin</b><br> <?php echo $_SESSION['email_id']; ?></div>

         </div>
         <div id="menu-items">
             <a href="?sys=dashboard">Dashboard</a>
             <a href="">Medical Tariff</a>
             <a href="">Insurers</a>
             <a href="">Hospitals</a>
             <a href="">Clients</a>
             <a href="">Subscriptions</a>
             <a href="">Messages</a>
             <a href="?sys=logout">Logout</a>
 		</div>
 	</menu>
  <div class="dashboard-views">
   <h2>Hospital Management Dashboard</h2>
    <div>
      <div class="status-cont"><b>APPROVALS</b></div>
      <div class="status-cont"><b>CLAIMS</b></div>
      <div class="status-cont"><b>INSURERS</b></div>
      <div class="status-cont"><b>BILLING</b></div>
    </div>
    <ol>
    <table>
 			  <tr>
     		 <th class="title">#</th>
         <th class="title">Name</th>
         <th class="title">Policy #</th>
         <th class="title">CNIC / HIC</th>
         <th class="title">Diagnosis</th>
         <th class="title">Insurer</th>
         <th class="title">Date & Time</th>
         <th class="title">Status</th>
         <th class="title">Action</th>
 			  </th>
    	  <tr>
          <td></td>
          <td><li>Ali</li></td>
          <td>215-32568-8</td>
          <td>42101-5356928-6</td>
          <td>High Fever</td>
          <td>NJI</td>
          <td>01/23/2018 10:59PM</td>
          <td class="status-approve">Approved</td>
          <td><div class="btn">View</div></td>

 			  </tr>
        <tr>
          <td></td>
          <td><li>Ali</li></td>
          <td>215-32568-8</td>
          <td>42101-5356928-6</td>
          <td>High Fever</td>
          <td>NJI</td>
          <td>01/23/2018 10:59PM</td>
          <td class="status-declined">Declined</td>
          <td><div class="btn">View</div></td>

        </tr>
        <tr>
          <td></td>
          <td><li>Ali</li></td>
          <td>215-32568-8</td>
          <td>42101-5356928-6</td>
          <td>High Fever</td>
          <td>NJI</td>
          <td>01/23/2018 10:59PM</td>
          <td class="status-pending">Pending</td>
          <td><div class="btn">Reminder</div></td>

        </tr>
             </table>
           </ol>
     </div>
     </div>
 </div>
