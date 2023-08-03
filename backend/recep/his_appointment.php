<?php
// include('user_registor.php');
	session_start();
	include('assets/inc/config.php');
    $pat_email=$_GET['pat_email'];
		if(isset($_POST['checknow']))
		{
          $pat_service=$_POST['service'];
          $pat_doc=$_POST['doctor'];
          $pat_date=$_POST['appo_date'];
          $pat_time=$_POST['appo_time'];
     
          $query = "UPDATE his_appointments SET service = ?, doctor = ?,appo_date=?, appo_time =? WHERE pat_email= ?";
          $stmt = $mysqli -> prepare($query);
          $stmt -> bind_param('sssss', $pat_service,$pat_doc,  $pat_date,$pat_time, $pat_email);
          $stmt -> execute();
      
            //declare a variable which will be passed to alert function
          if ($stmt) {
                $success = "Success! Your Order Is on Its Way";
            } else {
                $err = "Please Try Again or Try Later";
            }
      
        }
  
?>

<!DOCTYPE html>
<html lang="en">
 <!--Head-->
 <?php include('assets/inc/head.php');?>
    <body>
 <!-- end page title --> 
 <!-- Form row -->
 
            
                  <div class="row ">
                            <div class="col-12 ">
                                <div class="card ">
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                        <div class="col-8">
                                        <h4 class="header-title" ><strong>Make an appointment</strong></h4>
                                       
                                        <form method="post">
                                             <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <select class="form-control" name="service">
                                                        <option value="">Choose service</option>
                                                        <option value="Diabet">Diabet</option>
                                                        <option value="Cardiology">Cardiology</option> 
                                                        <option value="Cynaecology">Cynaecology</option>
                                                        <option value="Pediatric">Pediatric</option>
                                                        <option value="Pediatric">Emergency Care</option>
                                                        <option value="Pediatric">Surgery</option>
                                                        <option value="Pediatric">Internal Medicine</option>
                                                        <option value="Pediatric">Mental Health Care</option>

                                                    </select>
                                    
                                                </div>
                                             </div>
                                             <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <select class="form-control" name="doctor">
                                                        <option value="">select Doctor</option>
                                                        <option value="Elibariki Basso">Dr.Elibarikil Basso</option>
                                                        <option value="Bashiri Idd">Dr.Bashir Idd</option> 
                                                        <option value="Dr.Masoud">Dr. Masoud</option>
                                                        <option value="Dr.Masoud">Dr. David Mkumbo</option>
                                                        <option value="Dr.Masoud">Dr. Mawaka</option>


                                                    </select>
                                    
                                                </div>
                                             </div>
                                             <div class="form-row">
                                                <div class="form-group col-md-8">
                                                <select class="form-control" name="appo_date">
                                                       <option value="">select Date</option>
                                                       <option value="2023-07-17">July 17, 2023</option>
                                                       <option value="2023-07-12">July 12, 2023</option>
                                                       <option value="2023-07-09">July 09, 2023</option>
                                                       <option value="2023-07-01">July 01, 2023</option>
                                                </select>
                                    
                                                </div>
                                             </div>
                                             <div class="form-row">
                                                <div class="form-group col-md-8">
                                                <select class="form-control" name="appo_time">
                                                 <option value="">select Disireble time</option>
                                                  <option value="08:00">8:00 AM</option>
                                                  <option value="12:30">12:30 PM</option>
                                                  <option value="15:45">3:45 PM</option>
                                               </select>
                                               
                                               </div>
                                             </div>
                                             <br>

                                             <button type="submit" name="checknow" class="ladda-button btn btn-primary" data-style="expand-right">Check now</button>
                                            

                                             </div>
                                             </div>
                                             </div>
                                             </div>
                                             </div>
                                             </div>
                                          
                                                                

                                             
                                            

                                           



                                                
                                            </body>

</html>