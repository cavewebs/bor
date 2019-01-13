<?php
$servername = "localhost";
$username = "phpmyadmin";
$password = "ttsmuj";
$dbname = "soccer_api";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $conns = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conns->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    


   // gcloud compute scp /home/timchosen/Desktop/apiubor/apiubor lamp-tutorial:/var/www/html 