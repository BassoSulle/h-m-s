<?php

$servername="localhost";
$username="root";
$pwd="";
$dbname="hmisphp";

$conn=mysqli_connect($servername,$username,$pwd,$dbname);

if(!$conn){
    echo "Data failed to be inserted";

}
else echo "Data inserted successfully";
?>