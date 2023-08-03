<?php
session_start();
include('assets/inc/config.php');

// Login doctor full name
// $doc_name = $_SESSION['doc_fname'] . ' ' . $_SESSION['doc_lname'];
$pat_number = $_GET['pat_number'];
$pat_id = $_GET['pat_id'];

// Defined diagnosis type
$diagnosis_type = $_GET['diagnosis_type'];


if (isset($_POST['add_pre_diagnosis'])) {
    $pre_diagnosis_number = $_POST['pre_diagnosis_number'];
    $pat_number = $_GET['pat_number'];
    $pre_diagnosis = implode("* ", $_POST['pre_diagnosis']);
    // $diagnosis_notes       = $_POST['diagnosis'];
    $diagnosis_type        = 'Preliminary Diagnosis';
    $diagnosing_doctor_name = $_POST['diagnosing_doctor_name'];
    $pre_diagnosis_date        = $_POST['pre_diagnosis_date'];

    //sql to insert captured values
    $query = "INSERT INTO his_diagnosis (diagnosis_number, pat_number, diagnosis, /*diagnosis_notes,*/ diagnosis_type, diagnosing_doctor_name, diagnosis_date) VALUES(?,?,?,?,?,?)";
    $stmt  = $mysqli->prepare($query);
    $rc    = $stmt->bind_param('ssssss', $pre_diagnosis_number, $pat_number, $pre_diagnosis, /*$diagnosis_notes,*/ $diagnosis_type, $diagnosing_doctor_name, $pre_diagnosis_date);
    $stmt->execute();

     // Update patient diagnosis status
     $pat_diagnosis_status      = 'Preliminary, Done';

     $query2 = "UPDATE his_patients SET pat_diagnosis_status=? WHERE pat_number=?";
     $stmt2 = $mysqli->prepare($query2);
     $rc2 = $stmt2->bind_param('ss', $pat_diagnosis_status, $pat_number);
     $stmt2->execute();

    //declare a variable which will be passed to alert function
    if ($stmt && $stmt2) {
        $success = "Patient's Preliminarily Diagnosis Saved";
        header('location: his_doc_view_single_patient.php?pat_id=' .$pat_id. '&&pat_number=' .$pat_number. '');
    } else {
        $err = "Please Try Again Or Try Later";
    }

}
 else if (isset($_POST['add_fn_diagnosis'])) {
    $fn_diagnosis_number = $_POST['fn_diagnosis_number'];
    $pat_number            = $_GET['pat_number'];
    $fn_diagnosis             = implode("* ", $_POST['fn_diagnosis']);
    // $diagnosis_notes       = $_POST['diagnosis_notes'];
    $diagnosis_type        = 'Final Diagnosis';
    $diagnosing_doctor_name = $_POST['diagnosing_doctor_name'];
    $fn_diagnosis_date        = $_POST['fn_diagnosis_date'];

    // sql to insert captured values
    $query = "INSERT INTO his_diagnosis (diagnosis_number, pat_number, diagnosis, /*diagnosis_notes,*/ diagnosis_type,  diagnosing_doctor_name, diagnosis_date) VALUES(?,?,?,?,?,?)";
    $stmt  = $mysqli->prepare($query);
    $rc    = $stmt->bind_param('ssssss', $fn_diagnosis_number, $pat_number, $fn_diagnosis, /*$diagnosis_notes,*/ $diagnosis_type, $diagnosing_doctor_name, $fn_diagnosis_date);
    $stmt->execute();

    // Update patient diagnosis status
    $pat_diagnosis_status      = 'Final, Done';
    $pat_prescription_status      = 'Not Prescribed';

    $query2 = "UPDATE his_patients SET pat_diagnosis_status=?, pat_prescription_status=? WHERE pat_number=?";
    $stmt2 = $mysqli->prepare($query2);
    $rc2 = $stmt2->bind_param('sss', $pat_diagnosis_status, $pat_prescription_status, $pat_number);
    $stmt2->execute();


    //declare a variable which will be passed to alert function
    if ($stmt && $stmt2) {
        $success = "Patient's Final Diagnosis Saved";
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
    <style>
        select option.selected{
            color:black;
            /* background-color: green; */
        }
    </style>

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
                                                href="his_doc_manage_patient.php">Patients</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="his_doc_view_single_patient.php?pat_number=<?php echo $pat_number; ?>&&pat_id=<?php echo $pat_id; ?>">View Patient</a>
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
                        <div class="col-md-4">
                            <div class="card px-3">
                                <div class="card-body">
                                    <h4 class="header-title mb-2 text-center">Select
                                        Diagnosis</h4>
                                    <ul
                                        class="nav nav-pills navtab-bg nav-justified d-flex flex-column">
                                        <?php
                                        $pre_diagnosis = '';
                                        $fn_diagnosis  = '';

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
                                            <a href="#preliminary_diagnosis"
                                                data-toggle="tab" aria-expanded="true"
                                                class="nav-link <?php echo $pre_diagnosis; ?>">
                                                Preliminary Diagnosis
                                            </a>
                                        </li>
                                        <li class="nav-item mt-2">
                                            <a href="#final_diagnosis" data-toggle="tab"
                                                aria-expanded="true"
                                                class="nav-link <?php echo $fn_diagnosis; ?>">
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
                                        <div class="tab-pane show active"
                                            id="preliminary_diagnosis">
                                            <h4 class="header-title">
                                                <div class="row">
                                                    <div class="col-md-6">Preliminary
                                                        Diagnosis</div>
                                                    <div class="col-md-6 text-primary"
                                                        align="right"><strong>
                                                            <?php echo $date . ', ' . $time; ?>
                                                        </strong></div>
                                                </div>
                                            </h4>
                                            <!-- Preliminary diagnosis Form-->
                                            <form method="post" id="preForm" class="my-2">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6"
                                                        style="display: none;">
                                                        <label
                                                            class="col-form-label">Preliminary Diagnosis date</label>
                                                        <input type="text"
                                                            required="required"
                                                            name="pre_diagnosis_date"
                                                            value="<?php echo $date. ' ' .$time; ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row mt-3">
                                                    <div
                                                        class="form-group col-md-12 d-flex flex-row">
                                                        <label
                                                            class="col-form-label col-md-3">Search
                                                            diagnosis </label>
                                                        <input type="text"
                                                            id="live_search"
                                                            class="form-control"
                                                            placeholder="Search diagnosis Name or Code ..."
                                                            autocomplete="off">
                                                    </div>
                                                </div>

                                                <!-- All diagnosis with searched word -->
                                                <div class="from-row mb-3">
                                                    <select class="form-control"
                                                        id="firstSelector" multiple="multiple">
                                                    </select>
                                                </div>

                                                <div class="form-row">
                                                    <button type="button" id="removeButton" class="ladda-button border btn btn-light ml-5 mr-5 col"><i class="mdi mdi-arrow-up text-danger"></i>
                                                        Remove</button>
                                                    <button type="button" class="ladda-button border btn btn-light ml-5 mr-5 col" id="addButton"><i
                                                            class="mdi mdi-arrow-down text-success"></i>
                                                        Add</button>
                                                </div>

                                                <!-- Selected diagnosis -->
                                                <div class="from-row mt-3">
                                                    <div class="mb-3">
                                                        <select class="form-control"
                                                            multiple="multiple" name="pre_diagnosis[]"
                                                            id="secondSelector">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    
                                                    <div class="form-group col">
                                                        <label
                                                            class="col-form-label">Patient Diagnosed by: </label>
                                                        <input type="text"
                                                            class="form-control"
                                                            autocomplete="off"
                                                            value="<?php echo $doc_name; ?>" name="diagnosing_doctor_name">
                                                    </div>

                                                    <div class="col mt-4" align="right">
                                                        <div class="form-group col-md-2"
                                                            style="display:none;">
                                                            <?php
                                                                $length         = 5;
                                                                $pre_diagnosis_number = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
                                                            ?>
                                                            <label class="col-form-label">Preliminary Diagnosis
                                                                Number</label>
                                                            <input type="text" name="pre_diagnosis_number"
                                                                value="<?php echo $pre_diagnosis_number; ?>"
                                                                class="form-control">
                                                        </div>
                                                        <button type="submit"
                                                            class="ladda-button btn btn-primary"
                                                            data-style="expand-right"
                                                            name="add_pre_diagnosis" id="selectAllButton">Save</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--End Preliminary Diagnosis Form-->
                                         </div>

                                    <div class="tab-pane show" id="final_diagnosis">
                                            <h4 class="header-title">
                                                <div class="row">
                                                    <div class="col-md-6">Final Diagnosis
                                                    </div>
                                                    <div class="col-md-6 text-primary"
                                                        align="right"><strong>
                                                            <?php echo $date . ', ' . $time; ?>
                                                        </strong></div>
                                                </div>
                                                <!-- <div class="ml-2"></div> -->
                                            </h4>
                                            <!--Final Diagnosis Form-->
                                            <form method="post" id="fnForm" class="my-2">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6"
                                                        style="display: none;">
                                                        <label
                                                            class="col-form-label">Final Diagnosis date</label>
                                                        <input type="text"
                                                            required="required"
                                                            name="fn_diagnosis_date"
                                                            value="<?php echo $date. ' ' .$time; ?>"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-row mt-3">
                                                    <div
                                                        class="form-group col-md-12 d-flex flex-row">
                                                        <label
                                                            class="col-form-label col-md-3">Search
                                                            diagnosis </label>
                                                        <input type="text"
                                                            id="live_search2"
                                                            class="form-control"
                                                            placeholder="Search diagnosis Name or Code ..."
                                                            autocomplete="off">
                                                    </div>
                                                </div>

                                                <!-- All diagnosis with searched word -->
                                                <div class="from-row mb-3">
                                                    <select class="form-control"
                                                        id="firstSelector2" multiple="multiple">
                                                    </select>
                                                </div>

                                                <div class="form-row">
                                                    <button type="button" id="removeButton2"class="ladda-button border btn btn-light ml-5 mr-5 col"><i class="mdi mdi-arrow-ufp text-danger"></i>
                                                        Remove</button>
                                                    <button type="button" class="ladda-button border btn btn-light ml-5 mr-5 col" id="addButton2"><i class="mdi mdi-arrow-down text-success"></i>
                                                        Add</button>
                                                </div>

                                                <!-- selected Preliminary diagnosis -->
                                                <div class="from-row mt-3">
                                                    <div class="mb-3">
                                                        <select class="form-control"
                                                            multiple="multiple" name="fn_diagnosis[]"
                                                            id="secondSelector2">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label
                                                            class="col-form-label">Patient Diagnosed by: </label>
                                                        <input type="text"
                                                            class="form-control"
                                                            autocomplete="off"
                                                            value="<?php echo $doc_name; ?>" name="diagnosing_doctor_name">
                                                    </div>

                                                    <div class="col mt-4" align="right">
                                                        <div class="form-group col-md-2"
                                                            style="display:none;">
                                                            <?php
                                                                $length         = 5;
                                                                $fn_diagnosis_number = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
                                                            ?>
                                                            <label class="col-form-label">Final Diagnosis
                                                                Number</label>
                                                            <input type="text" name="fn_diagnosis_number"
                                                                value="<?php echo $fn_diagnosis_number; ?>"
                                                                class="form-control">
                                                        </div>
                                                        <button type="submit"
                                                            class="ladda-button btn btn-primary"
                                                            data-style="expand-right"
                                                            name="add_fn_diagnosis" id="selectAllButton2">Save and Finish</button>
                                                    </div>
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
        $( document ).ready( function () {
            $( '#live_search' ).keyup( function () {
                var input = $( this ).val();

                if ( input != "" ) {
                    $.ajax( {
                        url: "assets/inc/search.php",
                        method: "POST",
                        data: { input: input },

                        success: function ( data ) {
                            $( "#firstSelector" ).html( data );
                            $( "#firstSelector" ).css( "display", "block" );
                        }
                    } )
                }
            } )
        } )

        $( document ).ready( function () {
            $( '#live_search2' ).keyup( function () {
                var input = $( this ).val();

                if ( input != "" ) {
                    $.ajax( {
                        url: "assets/inc/search.php",
                        method: "POST",
                        data: { input: input },

                        success: function ( data ) {
                            $( "#firstSelector2" ).html( data );
                            $( "#firstSelector2" ).css( "display", "block" );
                        }
                    } )
                }
            } )
        } )
    </script>

    <!-- <script src="assets/js/diagnosis.js"></script> -->
    <!-- Add and Remove option(s) from a selector -->
    <script>
        // style the selected option
        const selectElement = document.getElementById('firstSelector');

        selectElement.addEventListener('change', () => {
            const options = selectElement.getElementsByTagName('option');
            // for (const option of options) {
            //     option.classList.remove('selected');
            // }

            const selectedOption = selectElement.options[selectElement.selectedIndex];
            selectedOption.classList.add('selected');
        });


        // For Preliminary diagnosis
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
                // $( "#secondSelector" ).append(selectedOptions);
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
                console.log( selectedDataArray.push( $( this ).val() ));
            } );
        }

         // Using jQuery (optional) to select All options in the second selector when submitting the data
         $(document).ready(function() {
            $("#selectAllButton").click(function() {
                $("#secondSelector option").prop("selected", true);
            });
        });
        


        // Fro Final diagnosis
        // Array to store selected data from the second selector
        var selectedDataArray2 = [];

        // Function to update the second selector with selected items
        function updateSecondSelector2 () {
            var selectedOptions2 = $( "#firstSelector2 option:selected" );

            //  // Remove existing options from the second selector
            //  $("#secondSelector option").remove();
        }

        // Call the update function when the first selector changes
        $( "#firstSelector2" ).on( "change", function () {
            updateSecondSelector2();
        } );

        // Add click event to the "Add" button
        $( "#addButton2" ).on( "click", function () {
            var selectedOptions2 = $( "#firstSelector2 option:selected" );
            selectedOptions2.each( function () {
                $( "#secondSelector2" ).append( $( this ).clone() );
            } );
            updateSelectedDataArray2(); // Update the selectedDataArray
        } );

        // Click event for the remove button
        $( "#removeButton2" ).on( "click", function () {
            var selectedOptions2 = $( "#secondSelector2 option:selected" );
            selectedOptions2.each( function () {
                $( this ).remove();
            } );
            updateSelectedDataArray2(); // Update the selectedDataArray
        } );


        // Function to update the selectedDataArray
        function updateSelectedDataArray2 () {
            selectedDataArray2 = [];
            $( "#secondSelector2 option" ).each( function () {
                selectedDataArray2.push( $( this ).val() );
            } );
        }

         // Using jQuery (optional) to select All options in the second selector when submitting the data
         $(document).ready(function() {
            $("#selectAllButton2").click(function() {
                $("#secondSelector2 option").prop("selected", true);
            });
        });
    </script>
   
</body>

</html>