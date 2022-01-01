<?php

$connection = mysqli_connect("localhost","root","","libdb");

if(isset($_POST['login']))
{
    $user=$_POST['user'];
    $pass=$_POST['pass'];
    $query = "INSERT INTO log (user, password) VALUES ('$user', '$pass')";
    $query_run = mysqli_query($connection, $query);
}



?>