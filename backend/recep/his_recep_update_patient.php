<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update_patient']))
		{
            $pat_hospial_NR=$_POST['pat_hospital_NR'];
			$pat_fname=$_POST['pat_fname'];
			$pat_middle_name=$_POST['pat_middle_name'];
			$pat_number=$_POST['pat_number'];
            $pat_lname=$_POST['pat_lname'];
            $pat_balozi=$_POST['pat_balozi'];
            $pat_tribe=$_POST['pat_tribe'];
            $pat_dob = $_POST['pat_dob'];
            $pat_age = $_POST['pat_age'];
            $pat_sex = $_POST['pat_sex'];
            $pat_addr=$_POST['pat_addr'];
            $pat_religion=$_POST['pat_religion'];
            $pat_health_fund=$_POST['pat_health_fund'];
            $pat_first_time=$_POST['pat_first_time'];
            $pat_membership_number=$_POST['pat_membership_number'];
            $pat_occupation=$_POST['pat_occupation'];
            $pat_national_id=$_POST['pat_national_id'];
            $pat_region=$_POST['pat_region'];
            $pat_district=$_POST['pat_district'];
            $pat_word=$_POST['pat_word'];
            $pat_village=$_POST['pat_village'];
            $pat_phone=$_POST['pat_phone'];
            $pat_registered_by=$_POST['pat_registered_by'];
            $pat_number=$_POST['pat_number']; 
            //sql to insert captured values
            $query="UPDATE his_patients SET pat_hospital_NR=?,pat_fname=?,pat_middle_name=?, pat_lname=?,pat_balozi=?,pat_tribe=?,pat_dob=?,pat_age=?,pat_sex=?,pat_addr=?, 
            pat_religion=?, pat_health_fund=?,pat_first_time=?,pat_membership_number=?,pat_occupation=?,pat_national_id=?,pat_region=?, pat_district=?, pat_word=?, pat_village=?,pat_phone=?, pat_registered_by=? WHERE pat_number=?";

			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssssssisssssssisisssss',$pat_hospial_NR, $pat_fname, $pat_middle_name, $pat_lname, $pat_balozi, $pat_tribe, $pat_dob, $pat_age, $pat_sex, $pat_addr, $pat_religion, $pat_health_fund, $pat_first_time, $pat_membership_number, $pat_occupation, $pat_national_id, $pat_region, $pat_district, $pat_word, $pat_village, $pat_phone, $pat_registered_by, $pat_number);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Record is updated Successfully..!";
			}
			else {
				$err = "Error in Updating record.";
			}
			
		// header('location:his_rec_manage_patients.php');
		}
        
        

        
?>

<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
    <body>

        <!-- Begin page -->
        <div  id="wrapper">

            <!-- Topbar Start -->
            <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                            <li class="breadcrumb-item active">Add Patient</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Patient Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                                        <div class="col-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php
                                                     date_default_timezone_set('Africa/Dar_es_Salaam');
                                                    $currentDay= date('Y-m-d  H:i:s');
                                                  

                                                    ?>
                                                   
                                                    <h4><strong>Registration Day:<?php echo $currentDay?></strong></h4>
                                                   
                                                <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Patient Form-->

                                        <!-- Lets get data from the taken  id. -->
                                        <?php
                                        $pat_number=$_GET['pat_number'];
                                        $sql='SELECT * FROM his_patients WHERE pat_number=?';
                                        $stmt=$mysqli->prepare($sql);
                                        $stmt->bind_param('s',$pat_number);
                                        $stmt->execute();
                                        $result=$stmt->get_result();
                                        while($row=$result->fetch_object()){

                                        ?>

                                
                                        <form method="post">
                                             <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">Hospital file NR</label>
                                                    <input type="text" required="required" name="pat_hospital_NR"  class="form-control" value="<?php echo $row->pat_hospital_NR;?>" id="inputEmail4" placeholder="Hospital file NR">
                                                </div>
                                             </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">First Name</label>
                                                    <input type="text" required="required" name="pat_fname" class="form-control" value="<?php echo $row->pat_fname;?>" id="inputEmail4" placeholder="Patient's First Name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Father's Name</label>
                                                    <input required="required" type="text" name="pat_middle_name" class="form-control"  value="<?php echo $row->pat_middle_name;?>" id="inputPassword4" placeholder="Patient`s Last Name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Surname</label>
                                                    <input required="required" type="text" name="pat_lname" class="form-control"  value="<?php echo $row->pat_lname;?>" id="inputPassword4" placeholder="Patient`s Last Name">
                                                </div>

                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">Balozi</label>
                                                    <input type="text" name="pat_balozi" class="form-control" value="<?php echo $row->pat_balozi;?>" id="inputEmail4" placeholder="">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Tribe</label>
                                                    <select name="pat_tribe" value="<?php echo $row->pat_tribe;?>" id="" class="form-control">
                                                    <option value="" >Select</option>
                                                        <option value=" Chaga" >Chaga</option>
                                                        <option value=" Chaga">Iraq</option>
                                                        <option value=" Chaga">Nyakysa</option>
                                                        <option value=" Chaga">Sukuma</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">Date Of Birth</label>
                                                    <input type="text" required="required" name="pat_dob" class="form-control" value="<?php echo $row->pat_dob;?>" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Age</label>
                                                    <input required="required" type="text" name="pat_age" class="form-control"  value="<?php echo $row->pat_age;?>" id="inputPassword4" placeholder="Patient`s Age">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="form-label">Sex</label>
                                                    <div >
                                                        <div class="form-check from-check-inline">
                                                            <input type="radio" name="pat_sex" value="male <?php echo $row->pat_sex;?>" id="pat_male" class="form-check-input">
                                                            <label for="pat_male" class="form-check-label">male</label>
                                                        </div>
                                                        <div class="form-check from-check-inline">
                                                            <input type="radio" name="pat_sex" value="female <?php echo $row->pat_sex;?>" id="" class="form-check-input">
                                                            <label for="" class="form-check-label">female</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                            <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">Address</label>
                                                    <input type="text"  name="pat_addr" class="form-control" value="<?php echo $row->pat_addr;?>" id="inputEmail4" placeholder="">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Religion</label>
                                                    <select name="pat_religion" value="<?php echo $row->pat_religion;?>" id="" class="form-control">
                                                    <option value="" >Select religion</option>
                                                        <option value=" Christian" >Christian</option>
                                                        <option value=" Muslim">Muslim</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Healh Fund</label>
                                                    <select name="pat_health_fund" value="<?php echo $row->pat_health_fund;?>" id="" class="form-control">
                                                    <option value="" >Select Healh insuarance</option>
                                                        <option value=" Chaga" >National Health Insurance Fund (NHIF)</option>
                                                        <option value=" Chaga"> Private Health Insurance Companies</option>
                                                        
                                                    </select>
                                                </div>
                                                <hr>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="form-label">Is first Time Patient</label>
                                                    <div >
                                                        <div class="form-check from-check-inline">
                                                            <input type="radio" name="pat_first_time" value="yes" value="<?php echo $row->pat_first_time;?>" id="pat_male" class="form-check-input">
                                                            <label for="pat_yes" class="form-check-label">Yes</label>
                                                        </div>
                                                        <div class="form-check from-check-inline">
                                                            <input type="radio" name="pat_first_time" value="no"  id="" class="form-check-input">
                                                            <label for="" class="form-check-label">No</label>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Membership Number</label>
                                                    <input  type="text" name="pat_membership_number" class="form-control" value="<?php echo $row->pat_membership_number;?>" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Occupation</label>
                                                    <input  type="text" name="pat_occupation" class="form-control" value="<?php echo $row->pat_occupation;?>" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">National ID</label>
                                                    <input  type="text" name="pat_national_id" class="form-control" value="<?php echo $row->pat_national_id;?>" id="inputCity">
                                                </div>
                                                
                                            </div>
                                            <div class="form-row">
                                            <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Region</label>
                                                    <select name="pat_region" value="<?php echo $row->pat_region;?>" id="" class="form-control">
                                                    <option value="" >Select region</option>
                                                        <option value=" Chaga" >Dar es Salaam</option>
                                                        <option value=" Chaga">Arusha</option>
                                                        <option value=" Chaga">Dodoma</option>
                                                        <option value=" Chaga">Singida</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">District</label>
                                                    <select name="pat_district" value="<?php echo $row->pat_district;?>" id="" class="form-control">
                                                    <option value="" >---Select District</option>
                                                        <option value=" Chaga" >Ilala</option>
                                                        <option value=" Chaga">Ubungo</option>
                                                        <option value=" Chaga"></option>
                                                        <option value=" Chaga"></option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Word</label>
                                                    <select name="pat_word" value="<?php echo $row->pat_word;?>" id="" class="form-control">
                                                    <option value="" >---Select Word</option>
                                                        <option value=" Chaga" >jdfhfh</option>
                                                        <option value=" Chaga">nfdfd</option>
                                                        <option value=" Chaga">jbcjs</option>
                                                        <option value=" Chaga">Sukuma</option>
                                                    </select>
                                                </div>
                                            </div>
            
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Village</label>
                                                    <input required="required" type="text" name="pat_village" class="form-control" value="<?php echo $row->pat_village;?>" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Mobile Number</label>
                                                    <input  type="text" name="pat_phone" class="form-control" value="<?php echo $row->pat_phone;?>" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label" >Registered by:</label>
                                                    <input required="required" type="text" name="pat_registered_by" class="form-control" value="<?php echo $row->pat_registered_by;?>" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-2" style="display:none">
                                                    <?php 
                                                        $length = 5;    
                                                        $patient_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                    ?>
                                                    <label for="inputZip" class="col-form-label">Patient Number</label>
                                                    <input type="text" name="pat_number" value="<?php echo $patient_number;?>" class="form-control" value="<?php echo $row->pat_number;?>" id="inputZip">
                                                </div>
                                               
                                            </div>
                                            <button type="reset" name="" class="ladda-button btn btn-success" data-style="expand-right">Clear</button>

                                            <button type="submit" name="update_patient" class="ladda-button btn btn-primary" data-style="expand-right">Update Patient</button>
                                            

                                        </form>

                                                </div>
                                            </div>
                
                                        
                                        <!--End Patient Form-->
                                        </div>

                                        <div class="col-4  ">
                                            <div class="card px-3">
                                                <div class="card-body">

                                                </div>
                                                <div class=" d-flex flex-column align-items-center justify-content-center">                                           
                                            <div class="card ">
                                                
                                                <form method="GET" class="" >
                                                <div class="mb-3 ">
                                                    <input type="text" class="form-control py-2" name="card_no" placeholder="NHIF Card No">
                                                </div>
                                                <button class="btn btn-primary mb-3" name="NHIF"> GET NHIF CARD DETAILS</button>

                                                </form>
                                                 <?php 

                                                //  if(isset($_GET['card_no']))
                                                //   {
                                                //      id = mysqli_real_escape_string($mysqli, $_GET['card_no']);

                                                //     $sql  = mysqli_query($mysqli, "SELECT * FROM his_patients WHERE pat_number = '$ id'");

                                                    

                                                //     while($row = mysqli_fetch_array($sql))
                                                //     {

                                                 ?>
                                               
                                                <div class="parag">
                                                    <p><strong>Full Name:</strong><span class="ml-2">
                                                        <? //=$row['pat_fname'].' '.$row['pat_lname'];?> 
                                                    </span></p>
                                                    <p><strong>Card status:</strong><span class="ml-2">
                                                        <? //=$row['pat_type']; ?>
                                                    </span></p>
                                                    <p><strong>Authorization:</strong><span class="ml-2"> 
                                                        <? //=$row['pat_addr']; ?>
                                                    </span></p>
                                                    <p><strong>Authorization Number:</strong><span class="ml-2">
                                                        <? //=$row['pat_phone']; ?>
                                                    </span></p>
                                                    <p><strong>Remarks:</strong><span class="ml-2">
                                                        <? //=$row['pat_ailment']; ?></span></p>
                                                </div>

                                                <?php   
                                            // }

                                            
                                                //   }
                                            ?>
                                              
                                            </div>
                                        </div>

                                            </div>
                                            
                                        </div>
                                        </div>
                                                <?php } ?>
                                        
                                 <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>