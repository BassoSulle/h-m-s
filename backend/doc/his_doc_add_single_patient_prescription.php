<?php

session_start();
include 'assets/inc/config.php';

// Login doctor full name
$doc_name = $_SESSION['doc_fname'] . ' ' . $_SESSION['doc_lname'];
$doc_id = $_SESSION['doc_id'];
$doc_number = $_SESSION['doc_number'];
$pat_number = $_GET['pat_number'];
$pat_id = $_GET['pat_id'];


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
                                        <li class="breadcrumb-item"><a href="his_doc_view_single_patient.php?pat_number=<?php echo $pat_number; ?>&&pat_id=<?php echo $pat_id; ?>">View Patient</a></li>
                                        <li class="breadcrumb-item active">Add Prescription
                                        </li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Add Patient Prescription</h4>
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
                                            <div class="col-md-6"></div>
                                            <div class="col-md-6 text-primary"
                                                align="right">
                                                <strong>
                                                    <?php echo $date . ', ' . $time; ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </h4>
                                    <form method="post" action="his_doc_single_patient_pres_usage.php?pat_id=<?php echo $pat_id ?>&&pat_number=<?php echo $pat_number; ?>" id="preForm" class="my-2">
                                                <div class="form-row mt-3">
                                                    <div
                                                        class="form-group col-md-12 d-flex flex-row">
                                                        <label
                                                            class="col-form-label col-md-3">Search
                                                            prescription </label>
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
                                                    <button type="button" id="removeButton" class="ladda-button border btn btn-light ml-5 mr-5 col"><i class="mdi mdi-arrow-up text-danger"></i>Remove</button>
                                                    <button type="button" class="ladda-button border btn btn-light ml-5 mr-5 col" id="addButton"><i class="mdi mdi-arrow-down text-success"></i>
                                                        Add</button>
                                                </div>

                                                <!-- Selected prescriptions -->
                                                <div class="from-row mt-3">
                                                    <div class="mb-3">
                                                        <select class="form-control"
                                                            multiple="multiple" name="pat_prescriptions[]"
                                                            id="secondSelector">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label
                                                            class="col-form-label">Patient Prescribed by: </label>
                                                        <input type="text"
                                                            class="form-control"
                                                            autocomplete="off"
                                                            value="<?php echo $doc_name; ?>" name="prescribing_doctor_name">
                                                    </div>

                                                    <div class="col mt-4" align="right">
                                                        <button type="submit"
                                                            class="ladda-button btn btn-primary"
                                                            data-style="expand-right"
                                                            name="specify_usage" id="selectAllButton">Specify usage</button>
                                                    </div>
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
                            $( "#firstSelector" ).html( data );
                            $( "#firstSelector" ).css( "display", "block" );
                        }
                    } )
                }
            } )
        } )
    </script>

    <!-- Add and Remove prescription(s) from a selector -->
    <script>
        const selectElement = document.getElementById('firstSelector');

            selectElement.addEventListener('change', () => {
                const options = selectElement.getElementsByTagName('option');
                // for (const option of options) {
                //     option.classList.remove('selected');
                // }

                const selectedOption = selectElement.options[selectElement.selectedIndex];
                selectedOption.classList.add('selected');
            });



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

        // Using jQuery (optional) to select All options in the second selector when submitting the data
        $(document).ready(function() {
            $("#selectAllButton").click(function() {
                $("#secondSelector option").prop("selected", true);
            });
        });
    </script>

</body>

</html>