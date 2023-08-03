<?php
class signup extends dbh{
    public function checkuser($username,$email){
         
         $stmt=$this->$connect()->prepare('INSERT INTO his_users(pat_username,pat_pwd,pat_rptpwd,pat_email) 
         VALUE(?,?,?,?);');

         $hashedpwd=password_hash($pwd,PASSWORD_DEFAULT);

    if(!$stmt->execute(array($username,$hashedpwd,$email))){
        $stmt=null;
        header("location:../recep/user_regiser.php?error=stmtfailed");
        exit();

    }
    $stmt=null;

    
} 

}






?>