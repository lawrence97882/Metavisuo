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
         <script src="./node_modules/kld-intersections/dist/index-umd.js"></script>      
        <script>
          let ellipse = {
              cx:120,
              cy:150,
              rx:30,
              ry:20
          }; 
           let ellipse1 = {
              cx:200,
              cy:150,
          }; 
          let ellipse2 = {
              cx:300,
              cy:200,
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
                    fill='blue'  font-size="10px">ellipse0 </text>`
                
                //Attribute reference line 
                +`<g class="rotate(80deg)">
                    <line 
                      x1="${ellipse.cx}" 
                      y1="${ellipse.cy}" 
                      x2="${ellipse.cx}" 
                      y2="${ellipse.cy-dy*(count-1)-ellipse.ry-margin}"
                      style="stroke:black;stroke-width:1" id="columns"/>`

                  //Attributes
                  +`<text x='${ellipse.cx}' y='${ellipse.cy-dy*(count-1)-ellipse.ry-margin}' font-size="6px">
                      <tspan x='${ellipse.cx}' fill='red'>name</tspan>
                      <tspan dy='${dy}' x='${ellipse.cx}'>age</tspan>
                      <tspan dy='${dy}' x='${ellipse.cx}'>birthday</tspan>
                      <tspan dy='${dy}' x='${ellipse.cx}'>residence</tspan>
                  </text>`      
               +`</g>
            </g>
            <g >`
            
               //Reference
                +`<ellipse 
                    fill="yellow" 
                    cx="${ellipse1.cx}" 
                    cy="${ellipse1.cy}" 
                    rx="${ellipse.rx}" 
                    ry="${ellipse.ry}" 
                    id="ellipsetwo" 
                    class="draggable"                
                    />`
                
                //Label
                +`<text  
                    x='${ellipse1.cx}' 
                    y='${ellipse1.cy + ellipse.rx}'
                    text-anchor='middle'    
                    fill='blue'  font-size="10px">ellipse1 </text>`
                
                //Attribute reference line 
                +`<g class="rotate(80deg)">
                    <line 
                      x1="${ellipse1.cx}" 
                      y1="${ellipse1.cy}" 
                      x2="${ellipse1.cx}" 
                      y2="${ellipse1.cy-dy*(count-1)-ellipse.ry-margin}"
                      style="stroke:black;stroke-width:0.1" id="columns"/>`

                  //Attributes
                  +`<text x='${ellipse1.cx}' y='${ellipse1.cy-dy*(count-1)-ellipse.ry-margin}' font-size="6px">
                      <tspan x='${ellipse1.cx}' fill='red'>name</tspan>
                      <tspan dy='${dy}' x='${ellipse1.cx}'>age</tspan>
                      <tspan dy='${dy}' x='${ellipse1.cx}'>birthday</tspan>
                      <tspan dy='${dy}' x='${ellipse1.cx}'>residence</tspan>
                  </text>`      
               +`</g>
            </g>
             <g >`
            
               //Reference
                +`<ellipse 
                    fill="yellow" 
                    cx="${ellipse2.cx}" 
                    cy="${ellipse2.cy}" 
                    rx="${ellipse.rx}" 
                    ry="${ellipse.ry}" 
                    id="ellipsethree" 
                    class="draggable"                
                    />`
                
                //Label
                +`<text  
                    x='${ellipse2.cx}' 
                    y='${ellipse2.cy + ellipse.rx}'
                    text-anchor='middle'    
                    fill='blue'  font-size="10px">ellipse2 </text>`
                
                //Attribute reference line 
                +`<g class="rotate(80deg)">
                    <line 
                      x1="${ellipse2.cx}" 
                      y1="${ellipse2.cy}" 
                      x2="${ellipse2.cx}" 
                      y2="${ellipse2.cy-dy*(count-1)-ellipse.ry-margin}"
                      style="stroke:black;stroke-width:0.1" id="columns"/>`

                  //Attributes
                  +`<text x='${ellipse2.cx}' y='${ellipse2.cy-dy*(count-1)-ellipse.ry-margin}' font-size="6px">
                      <tspan x='${ellipse2.cx}' fill='red'>name</tspan>
                      <tspan dy='${dy}' x='${ellipse2.cx}'>age</tspan>
                      <tspan dy='${dy}' x='${ellipse2.cx}'>birthday</tspan>
                      <tspan dy='${dy}' x='${ellipse2.cx}'>residence</tspan>
                  </text>`      
               +`</g>
            </g>
                <line x1="${ellipse.cx}" y1="${ellipse.cy}" x2="${ellipse1.cx}" y2="${ellipse1.cy}" z   style="stroke:black;stroke-width:2"
                id="ellipseonetoellipsetwo" z-index="0"/> 
                <line x1="${ellipse.cx}" y1="${ellipse.cy}" x2="${ellipse2.cx}" y2="${ellipse2.cy}" z   style="stroke:black;stroke-width:2"
                id="ellipseonetoellipsethree" z-index="0"/> 
            </svg>`
        );    
        </script>
        
    </body>
</html>