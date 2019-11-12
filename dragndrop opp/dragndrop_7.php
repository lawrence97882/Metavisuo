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
        <svg viewBox="0 0 500 500"  onload="new dragndrop_ex()" >
        <ellipse fill="blue" cx="120" cy="250" rx="30" ry="20" id="ellipsethree" class="draggable"/>
        <ellipse fill="black" cx="200" cy="250" rx="30" ry="20" id="ellipsefour" class="draggable"/>
        <ellipse fill="yellow" cx="120" cy="200" rx="30" ry="20" id="ellipseone" class="draggable"/>
        <ellipse fill="green" cx="200" cy="200" rx="30" ry="20" id= "ellipsetwo" z-index="200" class="draggable"/>
            <line x1="120" y1="200" x2="200" y2="200" z   style="stroke:black;stroke-width:2"
                          id="ellipseonetoellipsetwo" z-index="0"/>  
            <line x1="120" y1="200" x2="120" y2="250" style="stroke:black;stroke-width:2"
                          id="ellipseonetoellipsethree"/>   
            <line x1="120" y1="200" x2="200" y2="250" style="stroke:black;stroke-width:2"
                          id="ellipseonetoellipsefour"/>   
        </svg>        
    </body>
</html>