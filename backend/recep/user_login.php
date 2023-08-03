
  <!-- <?php include('../classes/signup.inc.php');?> -->

<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
  
    <body class="align-items:center">

                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="">
                        <div class="row " >
                     
                           <div class="col-6 ">
                            
                            <div class="card">
                                <div class="card-body">
                                   <h3>LOG IN</h3> 
                                <h4 class="header-title"><strong>Do not have an account yet!<a href="user_registor.php"> Sign up here! </a></strong></h4>
                        
                        <form action= ""  method="post">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4" class="col-form-label">User name</label>
                                    <input type="text" required="required" name="pat_username" class="form-control" id="inputEmail4" placeholder="Patient's User  Name">
                                </div>
                            </div>
                
                                <div class="form-row">
                                     <div class="form-group col-md-6">
                                    <label for="inputPassword4" class="col-form-label">Password</label>
                                    <input required="required" type="password" name="pat_pwd" class="form-control"  id="inputPassword4" placeholder="Password">
                                    <br>
                                <button type="submit" name="submit" class="ladda-button btn btn-primary" data-style="expand-right">Log in</button>
                            </div>
                                

                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    
                   
</body>

</html>