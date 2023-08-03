<?php
class dbh{
   public function connect(){
    try{
         $username="root";
         $password="";
         $dbh=new PDO('mysql:host=localhost; dbname=hmisphp',$username,$password);
         return $dbh;
       }
   catch (PDOException $e) {
    print "error" .$e->getMessage() .'<br/>';
    die();

   }


   }
}







?>