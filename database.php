<?php

// ClaraDB
$server = 'us-cdbr-east-02.cleardb.com:3306';
$username = 'bd964ed620650a';
$password = 'a8bd083e';
$database = 'herok_59b4c55ab4de36a';

// LocalHost
$server2 = 'localhost:3306';
$username2 = 'root';
$password2 = '1234';
$database2 = 'kodeprintdb';


try {
  $conn =  mysqli_connect(
                $server, $username, $password);
        
        if (!$conn) {
            exit(header('location: ../500_page'));
        }
        //set the default client character set 
        mysqli_set_charset($conn, 'utf-8');

        // estableciendo la BDD
        mysqli_select_db($conn, $database);
        
        // Setiando los sertificados SSL
        mysqli_ssl_set( $conn,'bd964ed620650a-key.pem','bd964ed620650a-cert.pem','cleardb-ca.pem',NULL,NULL);   
} catch (PDOException $e) {
  die('Connection Failed: ' . $e->getMessage());
}


