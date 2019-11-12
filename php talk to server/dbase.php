<?php
 function index($output){ 
    //
    //Start the buffering as early as possible. All html outputs will be 
    //bufferred 
    ob_start();
    //
    //deburging
    $_SESSION['username']='mutallco';
    $_SESSION['password']='mutall_2015';
    //$dbname='mutallco_majorm';
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
        //Get the http that referered to this page
        $referer = $_SERVER['HTTP_REFERER'];
        //
        //Extract the url path
        $path = parse_url($referer, PHP_URL_PATH);
        //
        //Retrieve the directory
        $dir = pathinfo($path, PATHINFO_DIRNAME);
        //
        //Retrieve the basename,
        $basename = pathinfo($dir, PATHINFO_BASENAME);      
        //
        //The complete website directory 
        $location = "../$basename/$basename.php";
        //
        //Re-direct to the home page. (Note. Make sure tat there is no echoing
        //before a header is sent!!)
        header("Location: $location");
        exit();
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
        $result = $obj->$method();
    }
    //
    //This is the Expected result from the calling method
    $output->result = $result;
    //
    $output->html = ob_end_clean();
}

 