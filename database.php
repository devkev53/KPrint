<?php

$server = 'localhost:3306';
$username = 'root';
$password = '1234';
$database = 'kodeprintdb';

try {
  $conn =  mysqli_connect(
                "localhost:3306","root","1234");
        
        if (!$conn) {
            exit(exit(header('location: ../500_page'));
        }
        //set the default client character set 
        mysqli_set_charset($conn, 'utf-8');

        // estableciendo la BDD
        mysqli_select_db($conn, "kodeprintdb");       
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}

