<?php
    //
    //Enable reporting for all types
    set_error_handler(function($errno, $message, $filename, $lineno, array $context){
       throw new ErrorException($message, 0, $errno, $filename, $lineno); 
    });
    //
    //Access the definition of classes used in this project
    require "library.php";
    //
    //obtaining the argument dbname, zoom,pan_right and pan_top from the url
    $dbname = $_GET['dbname'];
    $zoom = $_GET['zoom'];
    $pan_right=$_GET['pan_right'];
    $pan_top=$_GET['pan_top'];

    //1. Create a database
    $dbase = new database($dbname, 4000, $zoom,$pan_right,$pan_top);
    //
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>mutall_chart</title>
        <link rel="stylesheet" type="text/css" href="graph.css">
        <script src="library.js"></script>
        
    </head>
    <body>
        <script>
            //Convert the database to a js structure
            $dbase_struct = <?php echo $dbase;?>;
            //
            $dbname = $dbase_struct.name;
            //
            //Convert the structure to a js database object
            $dbase = new database(name, $dbase_struct);
            //
            //Now present the database;
            $dbase.present();
        </script>
    </body>
</html>