 <?php
   //
    //Enable reporting for all types
    set_error_handler(function($errno, $message, $filename, $lineno){
       throw new ErrorException($message, 0, $errno, $filename, $lineno); 
    });
    //
    //Access the definition of classes used in this project
    include "library.php";
    //create an instance of the database class 
    $dbase = new database('mullco_rental');
    //
    //encode the static dbase 
    $static_dbase = json_encode($dbase);
       
?>

<html>
    <head>
        <title> Graph</title>
        <link rel="stylesheet" type="text/css" href="graph.css">
        <script src='dragndrop_library.js'></script> 
        <script src='library.js'></script>
        <script src='home.js'></script>
        <script src="./node_modules/kld-intersections/dist/index-umd.js"></script>      
        <script>
           //
           //Create a database.js object using the database from php
           const dbase = new database(<?php echo $static_dbase; ?>);
           //
           let client= dbase.entities.comment;
           console.log(client);
           
        </script>
    </head>
    <body>
        
        <div id="navigation">
          </div>
        
        <div id="content"> 
           <svg height="1200" width="1600" viewbox="100 -100 3000 2400" onload="new dragndrop_group"></svg>
        
        </div>
        <script>
           //Get the content div element and append the svg
           const content= document.querySelector(`svg`); 
           //
           let graph= dbase.present();
           //
           content.innerHTML=`${graph.innerHTML}`;
           
        </script>
    </body>
</html> 