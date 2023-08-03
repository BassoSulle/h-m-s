<?php
session_start();
include 'assets/inc/config.php';

// Login doctor full name
$doc_name = $_SESSION['doc_fname'] . ' ' . $_SESSION['doc_lname'];

if (isset($_POST['add_patient'])) {
    // $pat_registration_date = $_POST['pat_registration_date'];
    $pat_fname   = $_POST['pat_fname'];
    $pat_mname   = $_POST['pat_mname'];
    $pat_surname = $_POST['pat_surname'];
    $pat_number  = $_POST['pat_number'];
    $pat_phone   = $_POST['pat_phone'];
    // $pat_type    = $_POST['pat_type'];
    $pat_addr               = $_POST['pat_addr'];
    $pat_age                = $_POST['pat_age'];
    $pat_dob                = $_POST['pat_dob'];
    $pat_sex                = $_POST['pat_sex'];
    $pat_religion           = $_POST['pat_religion'];
    $pat_tribe              = $_POST['pat_tribe'];
    $pat_occupation         = $_POST['pat_occupation'];
    $pat_nationalId_card_no = $_POST['pat_nationalId_card_no'];
    $pat_balozi             = $_POST['pat_balozi'];
    $pat_village            = $_POST['pat_village'];
    $pat_ward               = $_POST['pat_ward'];
    $pat_district           = $_POST['pat_district'];
    $pat_region             = $_POST['pat_region'];
    $pat_health_fund        = $_POST['pat_health_fund'];
    $pat_first_time         = $_POST['pat_first_time'];
    $pat_membership_no      = $_POST['pat_membership_no'];
    $pat_registrar          = $_POST['pat_registrar'];
    // $pat_ailment = $_POST['pat_ailment'];

    //sql to insert captured values
    $query = "insert into his_patients (pat_fname, pat_mname, pat_surname, pat_number, pat_age, pat_dob, pat_sex, pat_religion, pat_tribe, pat_occupation, pat_phone, pat_nationalId_card_no, pat_addr, pat_balozi, pat_village, pat_ward, pat_district, pat_region, pat_health_fund, pat_first_time, pat_membership_no, pat_registrar) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt  = $mysqli->prepare($query);
    $rc    = $stmt->bind_param('sssssissssssissssssssis', $pat_fname, $pat_mname, $pat_surname, $pat_number, $pat_age, $pat_dob, $pat_sex, $pat_religion, $pat_tribe, $pat_occupation, $pat_phone, $pat_nationalId_card_no, $pat_addr, $pat_balozi, $pat_village, $pat_ward, $pat_district, $pat_region, $pat_health_fund, $pat_first_time, $pat_membership_no, $pat_registrar);
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
                                                href="his_doc_manage_patients.php">Patients</a>
                                        </li>
                                        <li class="breadcrumb-item">View Patient
                                        </li>
                                        <li class="breadcrumb-item active">Add Patient
                                            Diagnosis
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
                                                <label class="col-form-label">Registration
                                                    Date and Time</label>
                                                <input type="text" required="required"
                                                    name="pat_registration_date"
                                                    value="<?php // echo $date. ' ' .$time; ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div
                                                class="form-group col-md-12 d-flex flex-row">
                                                <label
                                                    class="col-form-label col-md-2">Search
                                                    diagnosis </label>
                                                <input type="text" id="live_search"
                                                    class="form-control"
                                                    placeholder="Search medicine name ..."
                                                    autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="from-row mt-2">
                                            <select class="form-control" multiple
                                                name="prescriptions">
                                                <optgroup id="search_result">
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="form-row mt-3">
                                            <button type="submit" id="removeButton"
                                                class="ladda-button border btn btn-light ml-5 mr-5 col"
                                                data-style="expand-right"><i
                                                    class="mdi mdi-arrow-up text-danger"></i>
                                                Remove</button>
                                            <button type="submit"
                                                class="ladda-button border btn btn-light ml-5 mr-5 col"
                                                data-style="expand-right"
                                                id="addButton"><i
                                                    class="mdi mdi-arrow-down text-success"></i>
                                                Add</button>
                                        </div>
                                        <div class="from-row mt-3">
                                            <select class="form-control" multiple
                                                name="pat_prescription"
                                                id="secondSelector">
                                                <option value="<?php //; ?>"></option>
                                            </select>
                                        </div>
                                        <div class="form-row mt-3">
                                            <button type="submit"
                                                class="ladda-button btn btn-primary"
                                                data-style="expand-right"
                                                name="add_prescription">Specify
                                                usage</button>
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

    <!-- Live search -->
    <script>
        $( document ).ready( function () {
            $( '#live_search' ).keyup( function () {
                var input = $( this ).val();

                if ( input != "" ) {
                    $.ajax( {
                        url: "assets/inc/search.php",
                        method: "POST",
                        data: { input: input },

                        success: function ( data ) {
                            $( "#search_result" ).html( data );
                            $( "#search_result" ).css( "display", "block" );
                        }
                    } )
                } else {
                    $( "#search_result" ).css( "display", "none" );
                }
            } )
        } )
    </script>

    <!-- Add and Remove prescription(s) from a selector -->
    <script>
        // Array to store selected data from the second selector
        var selectedDataArray = [];

        // Function to update the second selector with selected items
        function updateSecondSelector () {
            var selectedOptions = $( "#firstSelector option:selected" );

            //  // Remove existing options from the second selector
            //  $("#secondSelector option").remove();
        }

        // Call the update function when the first selector changes
        $( "#firstSelector" ).on( "change", function () {
            updateSecondSelector();
        } );

        // Add click event to the "Add" button
        $( "#addButton" ).on( "click", function () {
            var selectedOptions = $( "#firstSelector option:selected" );
            selectedOptions.each( function () {
                $( "#secondSelector" ).append( $( this ).clone() );
            } );
            updateSelectedDataArray(); // Update the selectedDataArray
        } );

        // Click event for the remove button
        $( "#removeButton" ).on( "click", function () {
            var selectedOptions = $( "#secondSelector option:selected" );
            selectedOptions.each( function () {
                $( this ).remove();
            } );
            updateSelectedDataArray(); // Update the selectedDataArray
        } );

        // Function to update the selectedDataArray
        function updateSelectedDataArray () {
            selectedDataArray = [];
            $( "#secondSelector option" ).each( function () {
                selectedDataArray.push( $( this ).val() );
            } );
        }
    </script>

</body>

</html>