<?php
    //
    //Enable reporting for all types
    set_error_handler(function($errno, $message, $filename, $lineno){
       throw new ErrorException($message, 0, $errno, $filename, $lineno); 
    });
    //
    //Access the definition of classes used in this project
    require "library.php";
    
    //Set the login credentials
    $_SERVER['username']='root';
    $_SERVER['password']='';
    //
    //Get the dataase name from the url 
    $dbname =$_REQUEST['dbname'];
    
    //1. Create a database
    $dbase = new database($dbname);
?>

<html>
    <head>
        <title>mutall_chart</title>
        <link rel="stylesheet" type="text/css" href="graph.css">
        
        <script src='library.js'></script>
        <script src='page_graph.js'></script>
        
        <script>
           
           //Convert the static PHP databse to an active JS version
           let $dbase = new database(<?php echo $dbase; ?>);
           //
           //Create a page graph object using the database from php
           var $page_graph = new page_graph($dbase);
           
           
        </script>
    </head>
    <body onload="$page_graph.$onload()">
        
        <div id="navigation">
            <table>
                <tr>
                    <td><button type="button" onclick="$page_graph.zoom(false)"><b>+</b></button></td>
                    <td rowspan="2"><button type="button" onclick="$page_graph.side_pan(true)"><b>&lt;</b></button></td>
                    <td><button type="button" onclick="$page_graph.top_pan(true)" ><b>˄</b></button></td>
                    <td rowspan="2"><button type="button"onclick="$page_graph.side_pan(false)"><b>&gt;</b></button></td>
                </tr>
                
                <tr>
                    <td><button type="button" onclick='$page_graph.zoom(true)'><b>-</b></button></td>
                     <td><button type="button" onclick="$page_graph.top_pan(false)"><b>˅</b></button></td>
                </tr>
            </table>
            <button onclick="$page_graph.create_record()">Create Record</button>
            <button onclick="$page_graph.review_records()">Review Records</button>
        </div>
        
        <div id="svg">
            <?php
            
            //
            //obtaining the argument dbname, zoom,pan_right and pan_top from the url
            $zoom = $_GET['zoom'];
            $pan_right=$_GET['pan_right'];
            $pan_top=$_GET['pan_top'];
            //
             //Present the database as graph of elipses and lines
            $dbase->present(3000, $zoom,$pan_right,$pan_top);
            //
            
            ?>
        </div>
    </body>
</html>