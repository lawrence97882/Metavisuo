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
        <title>test</title>
        <link rel="stylesheet" type="text/css" href="graph.css">
        <script src='library.js'></script>  
        <script src='dragndrop_library.js'></script> 
         <script src="./node_modules/kld-intersections/dist/index-umd.js"></script>
        <script>
           //
           //Create a database.js object using the database from php
           const dbase = new database(<?php echo $static_dbase; ?>);
           //text if the entities are an object
           //console.log(typeof dbase.entities.columns);// they are objects
           //
           //test if the columns are an object
           //console.log(typeof dbase.entities.columns);//they are objects
           //
           //convert the entities to arrays using keys
           const vendor = dbase.entities.client;
           //console.log( vendor.cx);
           let graphic = vendor.graphic_text;
           //console.log(graphic);
            //console.log(vendor);
            console.log(dbase.present());
           document.querySelector('svg');
           //console.log(document.getElementById("svg"));
          
           //
           //convert the entities to arrays using values which are the required 
           const y = Object.values(dbase.entities);
           //
           //loop through all the entities and obtain tne dependency 
           y.forEach(entity =>{
               //console.log(`name = ${entity.name} and dependency =${entity.dependency}`);
 
           }); 
           //
           //convert the columns into arrays to get the name 
           //const array_column= Object.valueOf(dbase.
        </script>
    </head>
    <body>
        <svg width="1600" height="1600" id="svg">
 
        </svg> 
    </body>
</html>