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
        <script>
          let ellipse = {
              cx:120,
              cy:150,
              rx:30,
              ry:20
          }; 
          let dy= 6;
          let margin = 6;
          let count = 4;
        </script>
    </head>    
    <body>         
        <script>
        document.write(`    
        <svg viewBox="0 0 500 500"  onload="new dragndrop_group" >
        
            <g transform="translate( 0 0)" >`
            
               //Reference
                +`<ellipse 
                    fill="yellow" 
                    cx="${ellipse.cx}" 
                    cy="${ellipse.cy}" 
                    rx="${ellipse.rx}" 
                    ry="${ellipse.ry}" 
                    id="ellipseone" 
                    class="draggable"                
                    />`
                
                //Label
                +`<text  
                    x='${ellipse.cx}' 
                    y='${ellipse.cy + ellipse.rx}'
                    text-anchor='middle'    
                    fill='blue'  font-size="10px">ellipse1 </text>`
                
                //Attribute reference line 
                +`<g class="rotate(80deg)">
                    <line 
                      x1="${ellipse.cx}" 
                      y1="${ellipse.cy}" 
                      x2="${ellipse.cx}" 
                      y2="${ellipse.cy-dy*(count-1)-ellipse.ry-margin}"
                      style="stroke:black;stroke-width:0.1" id="columns"/>`

                  //Attributes
                  +`<text x='${ellipse.cx}' y='${ellipse.cy-dy*(count-1)-ellipse.ry-margin}' font-size="6px">
                      <tspan x='${ellipse.cx}' fill='red'>name</tspan>
                      <tspan dy='${dy}' x='${ellipse.cx}'>age</tspan>
                      <tspan dy='${dy}' x='${ellipse.cx}'>birthday</tspan>
                      <tspan dy='${dy}' x='${ellipse.cx}'>residence</tspan>
                  </text>`      
               +`</g>
            </g>
            </svg>`
        );    
        </script>
        
    </body>
</html>