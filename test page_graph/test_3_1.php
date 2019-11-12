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
    $dbase = new database('mutallco_majorm');
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
        <script src="./node_modules/kld-intersections/dist/index-umd.js"></script> 
        <script src='page_graph.js'></script>      
        <script>
           //
           //Create a page graph object using the database from php
           var $page_graph = new page_graph(<?php echo $request; ?>);
          //
          //Create a database.js object using the database from php
          const dbase = new database(<?php echo $static_dbase; ?>);
           
                      
        </script>
    </head>
    <body>
        
        <div id="navigation"></div>
        
        <svg id="content" height="3400" width="3400" viewbox="0 0 4200 4200">
            
        </svg>
        
        <script>       
           //Get the content div element and append the svg
           const svg= document.querySelector('#content'); 
           //
           const htmltext= dbase.present();
           
           
           
        </script>
    </body>
</html>