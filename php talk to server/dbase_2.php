<?php
//
//create a std object result with a status, data or the error message durring login
$result= new stdClass();
//
//Catch any of the php errors that generated during the creation of the database 
try{
    //Start the buffering as ewaely as possible
    ob_start();
    //
    require 'library.php';
    //
    //get the database name from the url
    //$dbname = $_GET['dbname'];

    /*For this debugging version....*/

    $_SESSION['username']='mutallco';
    //$_SESSION['password']='mutall_2015';
    $dbname = "majormco";
    //
    //
    //creating an instance of the database model which is the static dbase since
    // it is encoded at the result 
    $dbase = new database();
    $dbase->present();
    
}
catch (Exception $ex){
    //
    //Get teh error message that wa thrown
    $msg = $ex->getMessage();
    echo $msg;
    
 }
