<html>
    <head>
        <title>login</title>
       <script>
           //
           //the function for the text 
           function getText(){
               //
               fetch('static_dbase.php')
                   //
                   //promises begin with a .then
                  .then(function(res){
                    //
                    //convert the string to text 
                    return res.json();
                    })    
                   //   
                  //now get the text results 
                  .then(function(data){
                    console.log(data);
                  })
                  //
                  //incase there  is an error
                  .catch(function(err){
                      console.log(err);
                  });
           }
       </script>
    </head>
    
    <body>
        <button id ="get" onclick="getText()"> get the text</button>
    </body>
</html>