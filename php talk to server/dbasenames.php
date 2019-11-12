<?php
$_SESSION['username']='mutallco';
$_SESSION['password']='mutall_2015';
//
//Start the session by uncluding the php library to create an dbase object 
include 'library.php';
//
//Create a new datase object without a name
$database = new database();
//
// Specify what you want to get from the database
$sql = "select schema_name as dbname "
        . "from schemata "
        . "where not(schema_name in ('MYSQL', 'PERFORMANCE_SCHEMA', 'phpmyadmin')) ";
//
//Execute the $sql on the $database to get the $result note the database  class is an extended pdo
$result = $database->query($sql);
//
//Put the data in an $array
$array = $result->fetchAll(PDO::FETCH_ASSOC);
//
//decode the array into a json
$jvalues = json_encode($array);
 //
 echo $jvalues;
 



