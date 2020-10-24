<?php

// ClaraDB
$server = 'us-cdbr-east-02.cleardb.com:3306';
$username = 'bd964ed620650a';
$password = 'a8bd083e';
$database = 'herok_59b4c55ab4de36a';

// JawsDB
$server2 = 'l9dwvv6j64hlhpul.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306';
$username2 = 'dl14vknoavdr4do2';
$password2 = 'm4sigkbli3tsm5ga';
$database2 = 'dgxh3sl3rd7vft5w';


try {
  $conn =  mysqli_connect(
                $server,$username,$password);
        
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


