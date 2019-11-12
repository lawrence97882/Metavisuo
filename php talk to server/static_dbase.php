
<?php
    require 'library.php';
    //
    //get the database name from the url
    //$dbname= 'majormco';
    //
    //create an instance of the database class 
    $dbase = new database('mullco_rental');
    //
    //Get the encoded verson of the static dbase 
    echo $dbase;
    
    