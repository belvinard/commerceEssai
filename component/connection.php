<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

   $host = "localhost";
   $login = "root";
   $pass = "";
   $dbname = "shoping";

   try{
    $conn = new PDO("mysql:host=$host;dbname=$dbname",$login, $pass);

    //echo "Connection successfully";
   }
   catch(PDOException $e){
    echo "Error : " . $e->getMessage();
   }


?>