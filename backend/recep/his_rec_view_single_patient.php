<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();

  $doc_id=$_SESSION['doc_id'];
  //$doc_number = $_SERVER['doc_number'];

    $pat_number=$_GET['pat_number'];
    $pat_id=$_GET['pat_id'];

    // Assign patient to Nurse
    if (isset($_POST['assign_nurse'])) {
        $pat_assigned_to = 'Nurse';
        $pat_vitals_status = 'Not captured';

        $query = "UPDATE his_patients SET pat_assigned_to = ?, pat_vitals_status = ? WHERE pat_id = ?";
        $stmt = $mysqli -> prepare($query);
        $stmt -> bind_param('ssi', $pat_assigned_to, $pat_vitals_status, $pat_id);
        $stmt -> execute();

        //declare a variable which will be passed to alert function
        if ($stmt) {
            $success = "Patient Assigned to Nurse";
        } else {
            $err = "Please Try Again or Try Later";
        }

    }

?>

<!DOCTYPE html>
    <html lang="en">

    <?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
             <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <?php

            // Get Details Of A Single User And Display Them Here
                $ret="SELECT  * FROM his_patients WHERE pat_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('i',$pat_id);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
            {
                $mysqlDateTime = $row->pat_date_joined;
            ?>
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
                                            <li class="breadcrumb-item"><a href="his_nur_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="his_nur_manage_patients.php">Patients</a></li>
                                            <li class="breadcrumb-item active">View Patients</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?>'s Profile</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <img src="assets/images/users/patient.png" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                    
                                    <div class="text-left mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->pat_fname;?> <?php echo $row->pat_lname;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ml-2"><?php echo $row->pat_phone;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Address :</strong> <span class="ml-2"><?php echo $row->pat_addr;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Date Of Birth :</strong> <span class="ml-2"><?php echo $row->pat_dob;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Age :</strong> <span class="ml-2"><?php echo $row->pat_age;?> Years</span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Ailment :</strong> <span class="ml-2"><?php echo $row->pat_ailment;?></span></p>
                                        <hr>
                                        <p class="text-muted mb-1 font-13"><strong>Date Recorded :</strong> <span class="ml-2"><?php echo date("d/m/Y - h:m", strtotime($mysqlDateTime));?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Assigned to:</strong> <span class="ml-2 text-success fw-bold"><?php echo $row->pat_assigned_to; ?></span></p>
                                        <hr>

                                        <?php
                                            $display = 'none';
                                            if (empty($row->pat_vitals_status) && empty($row->pat_assigned_to)) {
                                                $display = '';
                                            }
                                        ?>

                                        <form method="post" class="d-<?php echo $display; ?>">
                                            <div class="my-1 align-center">
                                                <button type="submit" class="ladda-button btn btn-success btn-sm" name="assign_nurse" data-style="expand-right">Assign Nurse</button>
                                            </div>
                                        </form>

                                    </div>
                                </div> <!-- end card-box -->
                            </div> <!-- end col-->
                            
                            <?php }?>

                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                            <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                Prescription
                                            </a>
                                        </li>
                                        
                                    </ul>
                                    <!--Medical History-->
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="aboutme">
                                             <ul class="list-unstyled timeline-sm">
                                                <?php
                                                    $pres_pat_number =$_GET['pat_number'];
                                                    $ret="SELECT  * FROM his_prescriptions WHERE pres_pat_number = '$pres_pat_number'";
                                                    $stmt= $mysqli->prepare($ret) ;
                                                    // $stmt->bind_param('i',$pres_pat_number );
                                                    $stmt->execute() ;//ok
                                                    $res=$stmt->get_result();
                                                    //$cnt=1;
                                                    
                                                    while($row=$res->fetch_object())
                                                        {
                                                    $mysqlDateTime = $row->pres_date; //trim timestamp to date

                                                ?>
                                                    <li class="timeline-sm-item">
                                                        <span class="timeline-sm-date"><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></span>
                                                        <h5 class="mt-0 mb-1"><?php echo $row->pres_pat_ailment;?></h5>
                                                        <p class="text-muted mt-2">
                                                            <?php echo $row->pres_ins;?>
                                                        </p>

                                                    </li>
                                                <?php }?>
                                            </ul>
                                           
                                        </div> <!-- end tab-pane -->
                                        <!-- end Prescription section content -->

                                            
                                                
                                    </div> <!-- end tab-content -->
                                </div> <!-- end card-box-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

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
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
        CKEDITOR.replace('editor')
        </script>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>

    </body>


</html>