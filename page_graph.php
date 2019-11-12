 <?php
    //
    //Enable reporting for all types
    set_error_handler(function($errno, $message, $filename, $lineno){
       throw new ErrorException($message, 0, $errno, $filename, $lineno); 
    });
    //
    //Access the definition of classes used in this project
    include "library.php";
    //
    //Get the database name from the url 
    $request =json_encode($_REQUEST);
    
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
           
        </script>
    </head>
    <body>
        
        <div id="navigation">
            <button type="button" onclick="$page_graph.zoom(false)"><b>+</b></button>
            <button type="button" onclick="$page_graph.side_pan(true)"><b>&lt;</b></button>
            <button type="button" onclick="$page_graph.top_pan(true)" ><b>˄</b></button>
            <button type="button"onclick="$page_graph.side_pan(false)"><b>&gt;</b></button>
            <button type="button" onclick='$page_graph.zoom(true)'><b>-</b></button>
            <button type="button" onclick="$page_graph.top_pan(false)"><b>˅</b></button>
            <button onclick="$page_graph.create_records()">Create Record</button>
            <button  type="button" onclick="$page_graph.save_structure()">Save Structure</button>
            <button onclick="$page_graph.review_records()">Review Records</button>
            <button onclick="$page_graph.hide_element()">Hide element</button>
            <button onclick="$page_graph.show_element()">show element</button>
            <button onclick="$page_graph.database_view()">change view</button>
            <!--
            By default, the log in/out buttons are hidden-->
            <button onclick="$page_graph.loggingout()" id="logout" hidden="true" name="logout">logout</button>
            <button id="login" hidden="true">Login to access services</button>
            <button id="open_dbase" hidden="true" onclick="$page_graph.open_dbase()">Open database</button> 
            <button id="close_dbase" hidden="true" onclick="$page_graph.close_dbase()">Close database</button>
        </div>
        <div id="select">
                <button onclick="$page_graph.entity_alter()">Edit Element</button>
        </div> 
        <div id="content">
            
            <svg height="100%" width="100%" viewbox="100 -100 3000 2400" onload="new dragndrop_group()"id="svg">
                
            </svg>
        </div>
    </body>
</html> 