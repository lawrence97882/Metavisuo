<?php
//
//Create a standard object to track (error) status, return result and buffered
//html.
$output= new stdClass();
//
//Trap any runtime error that may arise
try{
    //
    //Start the buffering as early as possible
    ob_start();
    //
    //deburging
    $_SESSION['username']='mutallco';
    $_SESSION['password']='mutall_2015';
    $dbname='majormco';
    //
    //Include definitions for classes accessible to this index file, e.g., the 
    //database, entity, column and input. 
    require 'library.php';
    //
    //Test if the class name is provided by the user. If not, re-direct to the
    //default home page.
    if (!isset($_REQUEST['class'])){
        //
        //Class name not provided. Go to the default home page
        //
        //Get the full directory of this file.
        $dir = __DIR__; 
        //
        //Workout the defaut websites as $name.php where $name is the base name
        //of the direcfory
        //$location= get_website($dir);
        //
        //Re-direct to the home page. (Note. Make sure tat there is no echoing
        //before a header is sent!!)
        header('Location: $location');
    }
    //
    //The class was providec by the user. The method must also be provided; 
    //otherwise we report an error
    // 
    //Retrieve and set the classname from the url 
     $class=$_REQUEST['class'];
    //
    //Test if there is a method set 
    if(!isset($_REQUEST['method'])){
        //
        //METHOD NOT KNOWN 
        //
        //Die and throw an exception that a method must be set 
        throw new Exception('The method of the class to execute must be set');
    }
    //
    //METHOD KNOWN 
    //Retrieve and set the method from the query string 
    $method= $_REQUEST['method'];
    //
    //Determine if the desired method is static or not. By default it is dynanic,
    //i.e., not static
    //
    if ($_REQUEST['static']){
        //
        //Execute the methord whose result is obtained as the html. 
        $result = $class::$method();
    }
    else{
        //
        //Create an object of the class on assumption that the class is not static 
        $obj= new $class();
        //
        //Execute the methord whose result is obtained as the html. 
        $result = $obj->$method;
    }
    //
    //This the status of the process
    $output->ok=true;
    //
    //This is the Expected result from the calling method
    $output->result = $result;
    
}
catch (Exception $ex){
    //
    //Get the error message that was thrown
    $error = $ex->getMessage();
    //
    $buffer = ob_end_clean();
    //
    $output->ok=false;
    //
    $output->result = $error;
 }
 finally{
    //
    //Clearing and$ collecting the buffer as html required to.... 
    $buffer = ob_end_clean();
    //
    //This is any html output thrown in the process of program execution
    $output->html = $buffer;
    //
    echo json_encode($output);
 }
