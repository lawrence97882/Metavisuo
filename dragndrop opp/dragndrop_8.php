<!--Extend dragndrop to support line following-->

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
        
        <!-- Include the source code  where the dragndrop class is defined -->
        <script src='dragndrop_library.js'></script>        
    </head>    
    <body>        
        <svg viewBox="0 0 500 500"  onload="new dragndrop_ex_text()" >
        
        <g transform="translate(200 50)" >
            <ellipse 
                fill="yellow" 
                cx="120" 
                cy="150" 
                rx="30" 
                ry="20" 
                id="ellipseone" 
                class="draggable"
                
                />
            
            <text  x='90' y='80'fill='black'>ellipseone </text>
            <line
                
        </g>
            
        </svg>        
    </body>
</html>