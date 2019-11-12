<?php
    include 'library.php';
    //
    //get the database name from the url
    $dbname= 'majormco';
    //
    //create an instance of the database class 
    $dbase = new database($dbname);
    //
    //call the present function with the svg tag 
    echo $dbase->present(1200,4200,0,0);


