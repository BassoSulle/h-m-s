<?php
session_start();
include('assets/inc/config.php');

// Login doctor full name
$doc_name = $_SESSION['doc_fname']. ' ' .$_SESSION['doc_lname'];

// Defined diagnosis type
 $diagnosis_type = $_GET['diagnosis_type'];


if (isset($_POST['add_patient'])) {
    // $pat_registration_date = $_POST['pat_registration_date'];
    $pat_fname  = $_POST['pat_fname'];
    $pat_mname  = $_POST['pat_mname'];
    $pat_surname  = $_POST['pat_surname'];
    $pat_number = $_POST['pat_number'];
    $pat_phone  = $_POST['pat_phone'];
    // $pat_type    = $_POST['pat_type'];
    $pat_addr                  = $_POST['pat_addr'];
    $pat_age                   = $_POST['pat_age'];
    $pat_dob                   = $_POST['pat_dob'];
    $pat_sex                   = $_POST['pat_sex'];
    $pat_religion              = $_POST['pat_religion'];
    $pat_tribe                 = $_POST['pat_tribe'];
    $pat_occupation            = $_POST['pat_occupation'];
    $pat_nationalId_card_no    = $_POST['pat_nationalId_card_no'];
    $pat_balozi                = $_POST['pat_balozi'];
    $pat_village               = $_POST['pat_village'];
    $pat_ward                  = $_POST['pat_ward'];
    $pat_district              = $_POST['pat_district'];
    $pat_region                = $_POST['pat_region'];
    $pat_health_fund = $_POST['pat_health_fund'];
    $pat_first_time            = $_POST['pat_first_time'];
    $pat_membership_no         = $_POST['pat_membership_no'];
    $pat_registrar             = $_POST['pat_registrar'];
    // $pat_ailment = $_POST['pat_ailment'];

    //sql to insert captured values
    $query = "insert into his_patients (pat_fname, pat_mname, pat_surname, pat_number, pat_age, pat_dob, pat_sex, pat_religion, pat_tribe, pat_occupation, pat_phone, pat_nationalId_card_no, pat_addr, pat_balozi, pat_village, pat_ward, pat_district, pat_region, pat_health_fund, pat_first_time, pat_membership_no, pat_registrar) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt  = $mysqli->prepare($query);
    $rc    = $stmt->bind_param('sssssissssssissssssssis',$pat_fname, $pat_mname, $pat_surname, $pat_number, $pat_age, $pat_dob, $pat_sex, $pat_religion, $pat_tribe, $pat_occupation, $pat_phone, $pat_nationalId_card_no, $pat_addr, $pat_balozi, $pat_village, $pat_ward, $pat_district, $pat_region, $pat_health_fund, $pat_first_time, $pat_membership_no, $pat_registrar);
    $stmt->execute();
   
    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Patient Details Added";
    } else {
        $err = "Please Try Again Or Try Later";
    }


}



// To capture date and time
$date = date("l d/m/Y", time());
$time = date("g:ia", time());

?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">

<!--Head-->
<?php include('assets/inc/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include("assets/inc/nav.php"); ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php"); ?>
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
                                                href="his_doc_manage_patients.php">Patients</a>
                                        </li>
                                        <li class="breadcrumb-item">View Patient
                                        </li>
                                        <li class="breadcrumb-item active">Add Patient Diagnosis
                                        </li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Add Patient Diagnosis</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Form row -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card px-3">
                                <div class="card-body">
                                    <h4 class="header-title mb-2 text-center">Select Diagnosis</h4>
                                    <ul class="nav nav-pills navtab-bg nav-justified d-flex flex-column">
                                    <?php 
                                            $pre_diagnosis = '';
                                            $fn_diagnosis = '';

                                            // create a switch
                                            switch ($diagnosis_type) {
                                                case 'pre_diagnosis':
                                                    $pre_diagnosis = 'active';
                                                    break;
                                                case 'fn_diagnosis':
                                                    $fn_diagnosis = 'active';
                                                    break;
                                                default:
                                                    $pre_diagnosis = $fn_diagnosis = '';
                                                    break;
                                            }

                                          ?>

                                            <li class="nav-item">
                                                <a href="#preliminary_diagnosis" data-toggle="tab"
                                                    aria-expanded="true" class="nav-link <?php echo $pre_diagnosis; ?>">
                                                    Preliminary Diagnosis
                                                </a>
                                            </li>
                                            <li class="nav-item mt-2">
                                                <a href="#final_diagnosis" data-toggle="tab"
                                                    aria-expanded="true" class="nav-link <?php echo $fn_diagnosis; ?>">
                                                    Final Diagnosis
                                                </a>
                                            </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card px-3">
                                <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="preliminary_diagnosis">
                                    <h4 class="header-title">
                                        <div class="row">
                                            <div class="col-md-6">Preliminary Diagnosis</div>
                                            <div class="col-md-6 text-primary" align="right"><strong><?php echo $date. ', ' .$time; ?></strong></div>
                                        </div>  
                                    </h4>
                                    <!-- Preliminary diagnosis Form-->
                                    <form method="post" class="my-2">
                                        <div class="form-row">
                                            <div class="form-group col-md-6" style="display: none;">
                                                <label class="col-form-label">Registration Date and Time</label>
                                                <input type="text" required="required"
                                                    name="pat_registration_date" value="<?php // echo $date. ' ' .$time; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mt-3">
                                            <div class="form-group col-md-12 d-flex flex-row">
                                                <label class="col-form-label col-md-3">Search diagnosis </label>
                                                <input type="text" id="live_search" class="form-control" placeholder="Search diagnosis Name or Code ..." autocomplete="off">
                                            </div>
                                        </div>

                                        <!-- All diagnosis with searched word -->
                                        <div class="from-row mb-3">
                                          <select class="form-control" id="firstSelector" multiple>
                                          <optgroup id="search_result"></optgroup>
                                          </select>
                                        </div>

                                        <div class="form-row">
                                            <button type="submit" id="removeButton"
                                            class="ladda-button border btn btn-light ml-5 mr-5 col"
                                            data-style="expand-right"><i class="mdi mdi-arrow-up text-danger"></i> Remove</button>
                                            <button type="submit"
                                            class="ladda-button border btn btn-light ml-5 mr-5 col"
                                            data-style="expand-right" id="addButton"><i class="mdi mdi-arrow-down text-success"></i> Add</button>
                                        </div>

                                        <!-- Selected diagnosis -->
                                        <div class="from-row mt-3">
                                            <div class="mb-3">
                                              <select class="form-control" multiple name="pat_diagnosis" id="secondSelector">
                                                <option value="<?php //; ?>" name="preliminary_diagnosis"></option>
                                              </select>
                                            </div>
                                        </div>
                                        
                                        <div align="right">
                                            <button type="submit"
                                            class="ladda-button btn btn-primary"
                                            data-style="expand-right" name="add_pre_diagnosis">Finish</button>
                                        </div>                                
                                            
                                    </form>
                                    <!--End Preliminary Diagnosis Form-->
                                </div>

                                <div class="tab-pane show" id="final_diagnosis">
                                <h4 class="header-title">
                                        <div class="row">
                                            <div class="col-md-6">Final Diagnosis</div>
                                            <div class="col-md-6 text-primary" align="right"><strong><?php echo $date. ', ' .$time; ?></strong></div>
                                        </div>  
                                        <!-- <div class="ml-2</div> -->
                                    </h4>
                                    <!--Final Diagnosis Form-->
                                    <form method="post" class="my-2">
                                        <div class="form-row">
                                            <div class="form-group col-md-6" style="display: none;">
                                                <label class="col-form-label">Registration Date and Time</label>
                                                <input type="text" required="required"
                                                    name="pat_registration_date" value="<?php // echo $date. ' ' .$time; ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row mt-3">
                                            <div class="form-group col-md-12 d-flex flex-row">
                                                <label class="col-form-label col-md-3">Search diagnosis </label>
                                                <input type="text" id="live_search2" class="form-control" placeholder="Search diagnosis Name or Code ..." autocomplete="off">
                                            </div>
                                        </div>

                                        <!-- All diagnosis with searched word -->
                                        <div class="from-row mb-3">
                                          <select class="form-control" id="firstSelector2" multiple>
                                          <optgroup id="search_result2"></optgroup>
                                          </select>
                                        </div>

                                        <div class="form-row">
                                            <button type="submit" id="removeButton2"
                                            class="ladda-button border btn btn-light ml-5 mr-5 col"
                                            data-style="expand-right"><i class="mdi mdi-arrow-up text-danger"></i> Remove</button>
                                            <button type="submit"
                                            class="ladda-button border btn btn-light ml-5 mr-5 col"
                                            data-style="expand-right" id="addButton2"><i class="mdi mdi-arrow-down text-success"></i> Add</button>
                                        </div>

                                        <!-- selected Preliminary diagnosis -->
                                        <div class="from-row mt-3">
                                              <select class="form-control" multiple name="pat_diagnosis" id="secondSelector2">
                                                <option value="<?php ?>"></option>
                                              </select>
                                        </div>
                                        
                                        <div class="mt-3" align="right">
                                            <button type="submit"
                                            class="ladda-button btn btn-primary"
                                            data-style="expand-right" name="add_fn_diagnosis">Finish</button>
                                        </div>                                
                                            
                                    </form>
                                    <!--End Final diagnosis Form-->
                                </div> 
                                </div> 
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->

                        
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include('assets/inc/footer.php'); ?>
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

    <!-- Live search -->
    <script>
        $(document).ready(function() {
            $('#live_search').keyup(function() {
                var input = $(this).val();

                if (input != "" ) {
                    $.ajax({
                        url: "assets/inc/search.php",
                        method: "POST",
                        data: {input : input},

                        success : function(data) {
                            $("#search_result").html(data);
                            $("#search_result").css("display", "block");
                        }
                    })
                } else {
                    $("#search_result").css("display", "none");
                }
            })
        })

        $(document).ready(function() {
            $('#live_search2').keyup(function() {
                var input = $(this).val();

                if (input != "" ) {
                    $.ajax({
                        url: "assets/inc/search.php",
                        method: "POST",
                        data: {input : input},

                        success : function(data) {
                            $("#search_result2").html(data);
                            $("#search_result2").css("display", "block");
                        }
                    })
                } else {
                    $("#search_result2").css("display", "none");
                }
            })
        })
    </script>

    <!-- Add and Remove option(s) from a selector -->
    <script>
        // For Preliminary diagnosis
        // Array to store selected data from the second selector
        var selectedDataArray = [];

        // Function to update the second selector with selected items
        function updateSecondSelector() {
            var selectedOptions = $("#firstSelector option:selected");
            
            //  // Remove existing options from the second selector
            //  $("#secondSelector option").remove();
        }

        // Call the update function when the first selector changes
        $("#firstSelector").on("change", function () {
            updateSecondSelector();
        });

        // Add click event to the "Add" button
        $("#addButton").on("click", function () {
            var selectedOptions = $("#firstSelector option:selected");
            selectedOptions.each(function () {
                $("#secondSelector").append($(this).clone());
            });
            updateSelectedDataArray(); // Update the selectedDataArray
        });

        // Click event for the remove button
        $("#removeButton").on("click", function () {
            var selectedOptions = $("#secondSelector option:selected");
            selectedOptions.each(function () {
                $(this).remove();
            });
            updateSelectedDataArray(); // Update the selectedDataArray
        });

        // Function to update the selectedDataArray
        function updateSelectedDataArray() {
            selectedDataArray = [];
            $("#secondSelector option").each(function () {
                selectedDataArray.push($(this).val());
            });
        }

        // Fro Final diagnosis
        // Array to store selected data from the second selector
        var selectedDataArray2 = [];

        // Function to update the second selector with selected items
        function updateSecondSelector2() {
            var selectedOptions2 = $("#firstSelector2 option:selected");
            
            //  // Remove existing options from the second selector
            //  $("#secondSelector option").remove();
        }

        // Call the update function when the first selector changes
        $("#firstSelector2").on("change", function () {
            updateSecondSelector2();
        });

        // Add click event to the "Add" button
        $("#addButton2").on("click", function () {
            var selectedOptions2 = $("#firstSelector2 option:selected");
            selectedOptions2.each(function () {
                $("#secondSelector2").append($(this).clone());
            });
            updateSelectedDataArray2(); // Update the selectedDataArray
        });

        // Click event for the remove button
        $("#removeButton2").on("click", function () {
            var selectedOptions2 = $("#secondSelector2 option:selected");
            selectedOptions2.each(function () {
                $(this).remove();
            });
            updateSelectedDataArray2(); // Update the selectedDataArray
        });

        // Function to update the selectedDataArray
        function updateSelectedDataArray2() {
            selectedDataArray2 = [];
            $("#secondSelector2 option").each(function () {
                selectedDataArray2.push($(this).val());
            });
        }
    </script>

</body>

</html>