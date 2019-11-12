<html>
    <head>
        <title>login</title>
       <script>
           //
           //the function for the text 
            async function getText(){
               //
               let res = await fetch('static_dbase.php');
               let data =  await res.json();
               console.log(data);
                   
           }
       </script>
    </head>
    
    <body>
        <button id ="get" onclick="getText()"> get the text</button>
    </body>
</html>