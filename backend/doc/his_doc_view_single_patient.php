<?php
session_start();
include 'assets/inc/config.php';
include 'assets/inc/checklogin.php';
check_login();

$doc_id = $_SESSION['doc_id'];
// $doc_number = $_SERVER['doc_number'];

// Assign patient to Laboratory or Pharmacy
$pat_number=$_GET['pat_number'];
$pat_id=$_GET['pat_id'];
if (isset($_POST['assign_laboratory'])) {
    $pat_assigned_to = 'Laboratory';

    $query = "UPDATE his_patients SET pat_assigned_to = ? WHERE pat_id = ?";
    $stmt = $mysqli -> prepare($query);
    $stmt -> bind_param('si', $pat_assigned_to, $pat_id);
    $stmt -> execute();

    //declare a variable which will be passed to alert function
    if ($stmt) {
        $success = "Patient Sent to Laboratory";
        header('location: his_doc_manage_patient.php');
    } else {
        $err = "Please Try Again or Try Later";
    }

} else if (isset($_POST['assign_pharmacy'])) {
    $pat_assigned_to = 'Pharmacy';

    $query = "UPDATE his_patients SET pat_assigned_to = ? WHERE pat_id = ?";
    $stmt = $mysqli -> prepare($query);
    $stmt -> bind_param('si', $pat_assigned_to, $pat_id);
    $stmt -> execute();

    //declare a variable which will be passed to alert function
    if ($stmt) {
        $success = "Patient Sent to Pharmacy";
    } else {
        $err = "Please Try Again or Try Later";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'assets/inc/head.php';?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include "assets/inc/nav.php";?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include "assets/inc/sidebar.php";?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <!--Get Details Of A Single User And Display Them Here-->
        <?php
            $pat_number = $_GET['pat_number'];
            $pat_id = $_GET['pat_id'];
            $ret = "SELECT  * FROM his_patients WHERE pat_id=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $pat_id);
            $stmt->execute(); //ok
            $res = $stmt->get_result();
            //$cnt=1;
            while ($row = $res->fetch_object()) {
                $mysqlDateTime = $row->pat_registration_date;
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
                                        <li class="breadcrumb-item"><a
                                                href="his_doc_dashboard.php">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="his_doc_manage_patient.php">Patients</a>
                                        </li>
                                        <li class="breadcrumb-item active">View Patients
                                        </li>
                                    </ol>
                                </div>
                                <h4 class="page-title"><?php echo $row->pat_fname; ?>
                                    <?php echo $row->pat_middle_name; ?>
                                    <?php echo $row->pat_lname; ?>'s Profile</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-4 col-xl-4">
                            <div class="card-box text-center">
                                <img src="assets/images/users/patient.png"
                                    class="rounded-circle avatar-lg img-thumbnail"
                                    alt="profile-image">


                                <div class="text-left mt-3">

                                    <p class="text-muted mb-2 font-13"><strong>Full Name
                                            :</strong> <span
                                            class="ml-2"><?php echo $row->pat_fname; ?>
                                            <?php echo $row->pat_middle_name; ?>
                                            <?php echo $row->pat_lname; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Mobile
                                            :</strong><span
                                            class="ml-2"><?php echo $row->pat_phone; ?></span>
                                    </p>
                                    <p class="text-muted mb-2 font-13"><strong>Address
                                            :</strong> <span
                                            class="ml-2"><?php echo $row->pat_addr; ?></span>
                                    </p>
                                    <p class="text-muted mb-2 font-13"><strong>Date Of
                                            Birth :</strong> <span
                                            class="ml-2"><?php echo $row->pat_dob; ?></span>
                                    </p>
                                    <p class="text-muted mb-2 font-13"><strong>Age
                                            :</strong> <span
                                            class="ml-2"><?php echo $row->pat_age; ?>
                                            Years</span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Ailment
                                            :</strong> <span
                                            class="ml-2"><?php echo $row->pat_ailment; ?></span>
                                    </p>
                                    <hr>
                                    
                                    <p class="text-muted mb-1 font-13"><strong>Date Recorded :</strong> <span class="ml-2"><?php echo date("d/m/Y - h:m", strtotime($mysqlDateTime));?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Assigned to:</strong> <span class="ml-2 text-success fw-bold"><?php echo $row->pat_assigned_to; ?></span></p>
                                    <p class="text-muted mb-2 font-13"><strong>Room Number:</strong> <span class="ml-2 text-success fw-bold"><?php echo $row->pat_select_doctor; ?></span></p>
                                    <hr>

                                    <?php
                                        $assign_lab_display = $assign_phar_display = 'none';

                                        if (($row->pat_diagnosis_status) == 'Not Done') {
                                            $display = 'none';
                                        } else if (($row->pat_diagnosis_status) == 'Preliminary, Done') {
                                            $assign_lab_display = '';
                                        } else if (($row->pat_diagnosis_status) == 'Final, Done') {
                                            $assign_phar_display = '';
                                        }
                                    ?>

                                    <form method="post">
                                        <div class="my-1 d-<?php echo $assign_lab_display; ?>" align="center">
                                            <button type="submit" class="ladda-button btn btn-success btn-sm" name="assign_laboratory" data-style="expand-right">Send to Laboratory</button>
                                        </div>
                                        <div class="my-1 d-<?php echo $assign_phar_display; ?>" align="center">
                                            <button type="submit" class="ladda-button btn btn-success btn-sm" name="assign_pharmacy" data-style="expand-right">Send to Pharmacy</button>
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
                                        <a href="#vitals" data-toggle="tab"
                                            aria-expanded="true" class="nav-link active">
                                            Vitals
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#diagnosis" data-toggle="tab"
                                            aria-expanded="true" class="nav-link ">
                                            Diagnosis
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#lab_records" data-toggle="tab"
                                            aria-expanded="false" class="nav-link">
                                            Lab Records
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#prescription" data-toggle="tab"
                                            aria-expanded="false" class="nav-link">
                                            Prescription
                                        </a>
                                    </li>
                                </ul>
                                <!--Medical History-->
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="vitals">
                                        <div class="table-responsive">
                                            <?php

                                                $vit_pat_number = $_GET['pat_number'];
                                                $ret = "SELECT  * FROM his_vitals WHERE vit_pat_number = '$vit_pat_number'";
                                                $stmt = $mysqli->prepare($ret);
                                                // $stmt->bind_param('i',$vit_pat_number );
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                //$cnt=1;

                                            ?>
                                            <table class="table table-borderless mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Weight</th>
                                                        <th>Height</th>
                                                        <th>Head Circumference</th>
                                                        <th>Body Temperature</th>
                                                        <th>Saturation</th>
                                                        <th>Heart Rate/Pulse</th>
                                                        <th>Respiratory Rate</th>
                                                        <th>Blood Pressure</th>
                                                        <th>Date Recorded</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                    while ($row = $res->fetch_object()) {
                                                        $mysqlDateTime = $row->vit_daterec; //trim timestamp to date

                                                        if ($row) {
                                                            echo '
                                                            <div class="mb-2" align="right">
                                                                <a href="his_nur_update_single_patient_vitals.php?pat_number=' . $row->vit_pat_number . '&vit_number=' . $row->vit_number . '" class="btn btn-sm btn-success"><i class="mdi mdi-pen"></i> Update Vitals</a>
                                                            </div>
                                                            ';
                                                        }

                                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $row->vit_weight; ?>kg
                                                        </td>
                                                        <td><?php echo $row->vit_height; ?>cm
                                                        </td>
                                                        <td><?php echo $row->vit_headcircumf; ?>cm
                                                        </td>
                                                        <td><?php echo $row->vit_bodytemp; ?>°C
                                                        </td>
                                                        <td><?php echo $row->vit_saturation; ?>°C
                                                        </td>
                                                        <td><?php echo $row->vit_heartpulse; ?>BPM
                                                        </td>
                                                        <td><?php echo $row->vit_resprate; ?>bpm
                                                        </td>
                                                        <td><?php echo $row->vit_bloodpress; ?>mmHg
                                                        </td>
                                                        <td><?php echo date("Y-m-d", strtotime($mysqlDateTime)); ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <?php }?>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end vitals content-->

                                    <div class="tab-pane show" id="diagnosis">
                                        <ul class="nav nav-pills navtab-bg nav-justified mt-2">
                                            <li class="nav-item">
                                                <a href="#preliminary_diagnosis" data-toggle="tab"
                                                    aria-expanded="true" class="nav-link active">
                                                    Preliminary Diagnosis
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#final_diagnosis" data-toggle="tab"
                                                    aria-expanded="true" class="nav-link">
                                                    Final Diagnosis
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="preliminary_diagnosis">
                                                <?php
                                                    // $pat_res = $res->fetch_object();
                                                    // $pat_diagnosis_status = $_GET['pat_diagnosis_status'];

                                                    // if ($pat_diagnosis_status == 'Not recorded') {
                                                        echo '
                                                        <div class="mt-2" align="center"><a href="his_doc_add_single_patient_diagnosis.php?pat_id=' . $pat_id . '&&pat_number=' . $pat_number . '&&diagnosis_type=pre_diagnosis" class="text-primary ">Add Preliminary Diagnosis</a></div>
                                                            ';
                                                    // }

                                                ?>

                                            </div>

                                            <div class="tab-pane show" id="final_diagnosis">
                                            <?php
                                                    // $pat_res = $res->fetch_object();
                                                    // $pat_diagnosis_status = $_GET['pat_diagnosis_status'];

                                                    // if ($pat_diagnosis_status == 'Not recorded') {
                                                        echo '
                                                            <div class="mt-2" align="center"><a href="his_doc_add_single_patient_diagnosis.php?pat_id=' . $pat_id . '&&pat_number=' . $pat_number . '&&diagnosis_type=fn_diagnosis" class="text-primary">Add Final Diagnosis</a></div>
                                                            ';
                                                    // }

                                                ?>
                                                
                                                
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- end diagnosis content-->

                                <!--  lab record start-->
                                <div class="tab-pane show" id="lab_records">
                                        <ul class="nav nav-pills navtab-bg nav-justified mt-2">
                                            <li class="nav-item">
                                                <a href="#preliminary_diagnosis" data-toggle="tab"
                                                    aria-expanded="true" class="nav-link active">
                                                    Laboratory Test
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#final_diagnosis" data-toggle="tab"
                                                    aria-expanded="true" class="nav-link">
                                                    Laboratory Report
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane show active" id="preliminary_diagnosis">
                                                <?php
                                                    // $pat_res = $res->fetch_object();
                                                    // $pat_diagnosis_status = $_GET['pat_diagnosis_status'];

                                                    // if ($pat_diagnosis_status == 'Not recorded') {
                                                        echo '
                                                        <div class="mt-2" align="center"><a href="his_doc_add_single_patient_diagnosis.php?pat_id=' . $pat_id . '&&pat_number=' . $pat_number . '&&diagnosis_type=pre_diagnosis" class="text-primary ">Add Laboratory Test</a></div>
                                                            ';
                                                    // }

                                                ?>

                                            </div>

                                            <div class="tab-pane show" id="final_diagnosis">
                                            <?php
                                                    // $pat_res = $res->fetch_object();
                                                    // $pat_diagnosis_status = $_GET['pat_diagnosis_status'];

                                                    // if ($pat_diagnosis_status == 'Not recorded') {
                                                        echo '
                                                            <div class="mt-2" align="center"><a href="his_doc_add_single_patient_diagnosis.php?pat_id=' . $pat_id . '&&pat_number=' . $pat_number . '&&diagnosis_type=fn_diagnosis" class="text-primary">View Laboratory Report</a></div>
                                                            ';
                                                    // }

                                                ?>
                                                
                                                
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="tab-pane show" id="lab_records">
                                    <ul class="list-unstyled timeline-sm">
                                        <?php
                                            $lab_pat_number = $_GET['pat_number'];
                                            $ret = "SELECT  * FROM his_laboratory WHERE  	lab_pat_number  ='$lab_pat_number'";
                                            $stmt = $mysqli->prepare($ret);
                                            // $stmt->bind_param('i',$lab_pat_number);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            //$cnt=1;

                                            while ($row = $res->fetch_object()) {
                                                $mysqlDateTime = $row->lab_date_rec; //trim timestamp to date

                                        ?>
                                        <li class="timeline-sm-item">
                                            <span
                                                class="timeline-sm-date"><?php echo date("Y-m-d", strtotime($mysqlDateTime)); ?></span>
                                            <h3 class="mt-0 mb-1">
                                                <?php echo $row->lab_pat_ailment; ?></h3>
                                            <hr>
                                            <h5>
                                                Laboratory Tests
                                            </h5>

                                            <p class="text-muted mt-2">
                                                <?php echo $row->lab_pat_tests; ?>
                                            </p>
                                            <hr>
                                            <h5>
                                                Laboratory Results
                                            </h5>

                                            <p class="text-muted mt-2">
                                                <?php echo $row->lab_pat_results; ?>
                                            </p>
                                            <hr>

                                        </li>
                                        <?php }?>
                                    </ul>
                                </div>
                                <!-- end lab records content-->

                                <div class="tab-pane show" id="prescription">
                                <div class="mt-2" align="center"><a href="his_doc_add_single_patient_prescription.php?pat_id=<?php echo $pat_id; ?>&&pat_number=<?php echo $pat_number; ?>" class="text-primary">Add Prescription</a></div>
                                    <ul class="list-unstyled timeline-sm">
                                        <?php
                                            $pres_pat_number = $_GET['pat_number'];
                                            $ret = "SELECT  * FROM his_prescriptions WHERE pres_pat_number = '$pres_pat_number'";
                                            $stmt = $mysqli->prepare($ret);
                                            // $stmt->bind_param('i',$pres_pat_number );
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            //$cnt=1;

                                            while ($row = $res->fetch_object()) {
                                                $mysqlDateTime = $row->pres_date; //trim timestamp to date

                                        ?>
                                        <li class="timeline-sm-item">
                                            <span
                                                class="timeline-sm-date"><?php echo date("Y-m-d", strtotime($mysqlDateTime)); ?></span>
                                            <h5 class="mt-0 mb-1">
                                                <?php echo $row->pres_pat_ailment; ?></h5>
                                            <p class="text-muted mt-2">
                                                <?php echo $row->pres_ins; ?>
                                            </p>

                                        </li>
                                        <?php }?>
                                    </ul>
                                </div> <!-- end tab-pane -->
                                <!-- end prescription content-->

                            </div> <!-- end tab-content -->
                        </div> <!-- end card-box-->

            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->

    </div> <!-- content -->

    <!-- Footer Start -->
    <?php include 'assets/inc/footer.php';?>
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

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>


</html>