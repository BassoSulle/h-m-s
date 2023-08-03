<?php
session_start();
include 'assets/inc/config.php';

// Login doctor full name
$doc_name = $_SESSION['doc_fname'] . ' ' . $_SESSION['doc_lname'];
$pat_number = $_GET['pat_number'];
$pat_id = $_GET['pat_id'];

if (isset($_POST['specify_usage'])) {
    $pat_id = $_GET['pat_id'];
    $pat_number = $_GET['pat_number'];
    $medications = $_POST['pat_prescriptions'];
    $prescribing_doctor_name = $_POST['prescribing_doctor_name'];
       
}


if (isset($_POST['add_prescription'])) {
    
    $medications_data = $_POST['medication'];

    $loopFinished = false;

    //sql to insert captured values
    foreach($medications_data as $medication_id => $medication_data) {
        $prescribing_date = $_POST['prescribing_date'];
        // $pat_number = $_GET['pat_number'];
        $prescription_number = $_POST['prescription_number'];
        $prescribing_doctor_name = $_POST['prescribing_doctor_name'];
        $quantity_per_intake = $medication_data['quantity_per_intake'];
        $times_per_day = $medication_data['time_per_day'];
        $duration = $medication_data['days_to_take'];
        $dose_quantity = $medication_data['dose_quantity'];
        $medication_notes = $medication_data['medication_notes'];

        $query = "INSERT INTO his_prescription (pat_number, prescription_number, prescribing_doctor_name, medication, quantity_per_intake, times_per_day, duration, dose_quantity, medication_notes, prescribing_date) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt  = $mysqli->prepare($query);
        $rc    = $stmt->bind_param('sssssiisss', $pat_number, $prescription_number, $prescribing_doctor_name, $medication_id, $quantity_per_intake, $times_per_day, $duration, $dose_quantity, $medication_notes, $prescribing_date);
        $stmt->execute();

    }

    $loopFinished = true;
    $pat_prescription_status = 'Prescribed';

    $query2 = "UPDATE his_patients SET pat_prescription_status=? WHERE pat_number=?";
    $stmt2 = $mysqli->prepare($query2);
    $rc2 = $stmt2->bind_param('ss', $pat_prescription_status, $pat_number);
    $stmt2->execute();

    //declare a variable which will be passed to alert function
    if ($loopFinished && $stmt2) {
        $success = "Patient Prescriptions Saved";
        header('location: his_doc_view_single_patient.php?pat_id=' .$pat_id. '&&pat_number=' .$pat_number. '');

    } else {
        $err = "Please Try Again Or Try Later";
    }
}


// To capture date and time
$date = date("l d/m/Y", time());
$time = date("g:ia", time());

?>
<!--End Server Side-->

<!DOCTYPE html>
<html lang="en">

<!--Head-->
<?php include 'assets/inc/head.php'; ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include "assets/inc/nav.php"; ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include "assets/inc/sidebar.php"; ?>
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
                                        <li class="breadcrumb-item"><a
                                                href="his_doc_dashboard.php">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item"><a
                                                href="his_doc_manage_patient.php">Patients</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="his_doc_view_single_patient.php?pat_number=<?php echo $pat_number; ?>&&pat_id=<?php echo $pat_id; ?>">View Patient</a>
                                        </li>
                                        <li class="breadcrumb-item active">Prescription: Specify usage</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Specify medication usage</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Form row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card px-3 mx-2">
                                <div class="card-body">
                                    <h4 class="header-title">
                                        <div
                                            class="row justify-content-center align-items-center">
                                            <div class="col-md-6">Patient Prescriptions
                                            </div>
                                            <div class="col-md-6 text-primary"
                                                align="right">
                                                <strong>
                                                    <?php echo $date . ', ' . $time; ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </h4>
                                    <form method="post" class="my-3">
                                        <div class="form-row" style="display: none;">
                                            <div class="form-group">
                                                <label class="col-form-label">Prescribing date</label>
                                                <input type="text" required="required"
                                                    name="prescribing_date"
                                                    value="<?php echo $date. ' ' .$time; ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <?php 

                                            $i = 0;
                                            $j = 0;
                                            while($i < count($medications)) {
                                                $j++;

                                        ?>
                                        <div class="medication my-4">
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 mb-1">
                                                    
                                                    <?php echo "$j:"; ?><label class="form-label border-bottom border-primary text-dark px-3 mb-3"> <?php echo $medications[$i]; ?></label>
                                                    <input type="text" class="d-none" name="medication[<?php echo $medications[$i]; ?>][id]" id="" value="<?php echo $medications[$i]; ?>">
                                                    <div class="row g-5 align-items-center">
                                                    <div class="col-2">
                                                        <label class="form-label">Single Dose/Intake</label>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="row g-2 align-items-center ml-2">
                                                            <div class="col-8 px-0 ml-2">
                                                                <select id="" class="form-control form-control-sm js-example-basic-single" name="medication[<?php echo $medications[$i]; ?>][quantity_per_intake]">
                                                                    <option>Select..</option>
                                                                    <?php
                                                                        for($quantity_once = 1; $quantity_once < 45; ++$quantity_once) {
                                                                            echo "<option value='$quantity_once'>$quantity_once</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-2 px-0">
                                                                <label class="col-form-label">
                                                                tabs
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="row g-2 align-items-center">
                                                            <div class="col-5 px-0 ml-2 mr-0">
                                                                <label class="col-form-label">Times per day</label>
                                                            </div>
                                                            <div class="col-5 px-0 ml-2">
                                                                <select id="" class="form-control form-control-sm js-example-basic-single" name="medication[<?php echo $medications[$i]; ?>][time_per_day]">
                                                                    <option>Select..</option>
                                                                    <?php
                                                                        for($times_per_day = 1; $times_per_day < 45; ++$times_per_day) {
                                                                            echo "<option value='$times_per_day'>$times_per_day</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col-4">
                                                                <label class="col-form-label">Days</label>
                                                            </div>
                                                            <div class="col-8 px-0">
                                                                <select id="" class="form-control form-control-sm js-example-basic-single" name="medication[<?php echo $medications[$i]; ?>][days_to_take]">
                                                                    <option>Select..</option>
                                                                    <?php
                                                                        for($days = 1; $days < 45; ++$days) {
                                                                            echo "<option value='$days'>$days</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="row g-3 align-items-center ml-2">
                                                            <div class="col-6 px-0">
                                                                <label class="col-form-label">Total Dose/item</label>
                                                            </div>
                                                            <div class="col-5 px-0">
                                                                <input type="text" id="" class="form-control form-control-sm" style="height: 28px; border-color: #888888;" name="medication[<?php echo $medications[$i]; ?>][dose_quantity]">
                                                            </div>
                                                            <div class="col-1 px-0">
                                                                <label class="col-form-label">
                                                                tabs
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12 mb-0">
                                                    <div class="row g-5 align-items-center">
                                                    <div class="col-2">
                                                        <label class="form-label"></label>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="row g-2 align-items-center ml-2">
                                                            <div class="col">
                                                                <label id="" class="col-form-label">Stock balance: <span class="text-primary">123</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="row g-2 align-items-center">
                                                            <div class="col">
                                                                <label class="col-form-label">Min_level = <span class="text-primary">2</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="row g-3 align-items-center">
                                                            <div class="col px-0">
                                                                <label class="col-form-label">This Patient is tagged to pick drugs at: <span class="text-primary">GENERAL PHARMACY</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="form-row mt-3 pb-4 mx-auto align-items-center">
                                                <label class="col-2 col-form-label mr-3">Notes</label>
                                                <div class="col-7 pr-0">
                                                <input type="text" class="form-control form-control-sm" id="" placeholder="Put Remark here" name="medication[<?php echo $medications[$i]; ?>][medication_notes]">
                                                </div>
                                                <div class="col-2" align="right">
                                                    <button class="btn btn-info btn-sm">Delete</button>
                                                </div>
                                        </div>
                                    </div>

                                    <?php 
                                        ++$i;
                                            }
                                    ?>

                                        <div class="form-row mt-5">
                                                <label class="col-2 col-form-label mr-3">Prescribed by:</label>
                                                <div class="col-4 pr-0">
                                                <input type="text" class="form-control form-control-sm" name="prescribing_doctor_name" value="<?php echo $prescribing_doctor_name; ?>">
                                                </div>
                                        </div>
                                        <div class="form-row mt-3">
                                            <div class="form-group col-md-2"
                                                style="display:none;">
                                                <?php
                                                    $length         = 5;
                                                    $prescription_number = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
                                                ?>
                                                <label class="col-form-label">Prescription Number</label>
                                                <input type="text" name="prescription_number"
                                                    value="<?php echo $prescription_number; ?>"
                                                    class="form-control">
                                            </div>
                                            <button type="submit" 
                                                class="ladda-button btn btn-primary"
                                                data-style="expand-right"
                                                name="add_prescription">Save</button>
                                        </div>
                                    </form>
                                    <!--End Prescription Form-->
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->

                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include 'assets/inc/footer.php'; ?>
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

    <!-- Select tag js -->
    <script src="assets/js/select2.min.js"></script>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>

</body>

</html>