<?php 
#grab the data from the user.
if(isset($_POST['submit'])) 
{
    $username=$_POST['pat_username'];
    $pwd=$_POST['pat_pwd'];
    $rpt_pwd=$_POST['pat_rptpwd'];
    $email=$_POST['pat_email'];


#instatiate the signupcontr class
include "../classes/dbh.classes.php";
include "../classes/signup.classes.php";
include "../classes/signup-contr.classes.php";

$signup=new signupcontr($username,$pwd,$rpt_pwd,$email);
#Running error handler and user sign up 
$signup->signupuser();
#going back to the font page.
header("location:../his_appointment.php?error=none");

}

?>