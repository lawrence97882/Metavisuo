<script src='library.js'></script>    
       static_dbase= async function get_static_dbase(){
        //fetch the static dbase from the php server file static_dbase.php
        let result= await fetch('static_dbase.php');
        //
        //The result are a text 
        let static_dbase = await result.json();
        //
        //retun the static database which is the results 
        return static_dbase;
    };
    
    
    //Create a database.js object using the database from php
    var dbase = new database(static_dbase);
    var dependency = dbase.entities.dependency;
    console.log(dependency);
       
