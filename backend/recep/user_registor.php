
  <?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['submit']))
		{
          $pat_fname=$_POST['pat_fname'];
          $pat_mname=$_POST['pat_mname'];
          $pat_surname=$_POST['pat_surname'];
          $pat_addr=$_POST['pat_addr'];
          $pat_phone=$_POST['pat_phone'];
          $pat_email=$_POST['pat_email'];
          $pat_pwd=$_POST['pat_pwd'];
          $pat_rptpwd=$_POST['pat_rptpwd'];
        
        
            //sql to insert captured values
			$query="INSERT INTO his_appointments(pat_fname, pat_mname, pat_surname, pat_addr, pat_phone,pat_pwd,pat_rptpwd,pat_email) VALUES(?,?,?,?,?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssisss',$pat_fname, $pat_mname, $pat_surname, $pat_addr, $pat_phone, $pat_pwd,$pat_rptpwd,$pat_email);
			$stmt->execute();

			if($stmt)
			{
				$success = "Patient Details Added";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
            header("location:his_appointment.php?pat_email=$pat_email");
            exit();
			
		}

        
?>
<!--End Server Side-->
<!--End Patient Registr-->

<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
  
    <body class="">

                        <!-- end page title --> 
                        <!-- Form row -->
                       
                    <div class="row justify-content-center" >
                            <div class="col-6 mx-5">
                                <div class="card">
                                    <div class="card-body ">
                                    <h4 class="header-title"><center><strong>Do not have an account yet! Sign up here!</strong></center></h4>
                            <!--Add Patient Form-->
                            <form method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-6 mx-5 ">
                                        <label class="col-form-label">First Name</label>
                                        <input type="text" required="required" name="pat_fname" class="form-control" placeholder="Patient's First Name">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6 mx-5">
                                        <label class="col-form-label">Middle name</label>
                                        <input type="text" required="required" name="pat_mname" class="form-control" placeholder="Patient's Middle Name">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6 mx-5">
                                        <label class="col-form-label">Surname</label>
                                        <input type="text" required="required" name="pat_surname" class="form-control" placeholder="Patient's Last Name">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 mx-5">
                                        <label class="col-form-label">Address</label>
                                        <input type="text" required="required" name="pat_addr" class="form-control" placeholder="Patient's Address">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 mx-5">
                                        <label class="col-form-label">Phone Number</label>
                                        <input type="text" required="required" name="pat_phone" class="form-control" placeholder="Patient's Phone number">
                                    </div>
                                </div>
                             
                                    <div class="form-row">
                                         <div class="form-group col-md-6 mx-5">
                                        <label for="inputPassword4" class="col-form-label">Password</label>
                                        <input required="required" type="password" name="pat_pwd" class="form-control"  id="inputPassword4" placeholder="Password">
                                    </div>

                                    </div>
                                    <div class="form-row">
                                         <div class="form-group col-md-6 mx-5">
                                        <label for="inputPassword4" class="col-form-label">Repeat password</label>
                                        <input required="required" type="password" name="pat_rptpwd" class="form-control"  id="inputPassword4" placeholder="repeat password">
                                    </div>
                                    </div>
                                   
                                
                                <div class="form-row">
                                    <div class="form-group col-md-6 mx-5">
                                        <label for="inputEmail4" class="col-form-label">Email</label>
                                        <input type="text" required="required" name="pat_email" class="form-control" placeholder=" Patient`s email">
                                    </div>
                                    </div>
                                    <button type="reset" name="" class="ladda-button btn btn-success  mx-5" data-style="expand-right">Clear</button>
                                    <button type="submit" name="submit" class="ladda-button btn btn-primary  mx-5" data-style="expand-right">submit</button>

                        </div>
                        </div>
                        </div>
                   
                           
                    </div>
                    
                   
</body>

</html>