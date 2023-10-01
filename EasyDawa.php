<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
};
$servername= "localhost";
$username= "root";
$password= "";
$dbname= "easydawa";
//Create Connection
$conn = mysqli_connect($servername,$username,$password,$dbname);
 //Check connection
 if (!$conn) {
    die ("Connection failed: ". mysqli_connect_error());
}
