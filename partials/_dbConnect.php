<?php
$servername = "remotemysql.com";
$username = "SYpaFnSb09";
$password = "3cvBbYoIhv";
$database = "SYpaFnSb09";

$conn = mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("Sorry we failed to establish the connection". mysqli_connect_error());
}
?>