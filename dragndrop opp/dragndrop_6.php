<html>
    <head>
        <title>drag and drop</title>
        
        <style>
            
            /*
            Change cursor to to "move" when hovering on an elipse*/
            ellipse {
              cursor: move;
            }
        </style>
        <script src='dragndrop.js'></script>
        <script>
             
        </script>
    </head>
    
    <body>
        
        <svg 
            viewBox="0 0 500 500" 
            onload="new dragndrop()"   
        >
            <ellipse fill="yellow" cx="120" cy="200" rx="30" ry="20"/>
            <ellipse fill="green" cx="200" cy="200" rx="30" ry="20"/>
            <line x1="120" y1="200" x2="200" y2="200" style="stroke:black;stroke-width:2"
                          id="relation_one"/>     
        </svg>
        
    </body>
</html>