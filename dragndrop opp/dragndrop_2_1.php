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
        
        <script>
            //
            var 
                //
                //The ellipse that raised the drag_start, drag and drag_end event. 
                selected_element,
                //
                //The mouse position in the browser window. 
                offset,
                //
                //The transformed ellipse with the new coodinates 
                transform;
                
            //Returns the translated coodinates in svg version as X and Y coodinates 
            function get_mouse_position(evt) {
                //
                //Get the parent svg element with the listeners  
                const svg = document.querySelector('svg');
                //
                //Translating the DOM window coodinates to svg 
                var CTM = svg.getScreenCTM();
                //
                //Return two properties the x and the y reprresenting the x and y coodinates.
                return {
                    //
                    //The equivalent cx in svg coodinates as x.
                    x: (evt.clientX - CTM.e) / CTM.a,
                    //
                    //The equivalent cy in svg coodinates as y. 
                    y: (evt.clientY - CTM.f) / CTM.d
                };
            } 
            
            //Get the current coodinates of the element both client and offset and 
            //any translational coodinates 
            function start_drag(evt) {
                //
                //initialize the selecteds element
                 selected_element = evt.target;
                //
                //Retrive the mouse position in svg coodinates both the x and the y.
                offset = get_mouse_position(evt);
            }
            
            //Translates the selected element and set its attributes the cx and 
            //cy to the new position 
            function drag(evt) {
                //
                //Ensures that the drag can only take place to a selected_element
                // not in an entire Svg
                if (selected_element){
                   //
                  //Get the original real/user coodinates for the center of selected elements 
                  let cx= selected_element.getAttribute('cx');
                  let cy= selected_element.getAttribute('cy');
                  //
                  //get the mouse position 
                  let m 
                }
                //
                //setAttribute of the selected 
                let cx= offset.x;
                let cy= offset.y;
                selected_element.setAttribute("cx", cx );
                selected_element.setAttribute("cy", cy);
                //
                //Get Element by line element 
                let line= document.querySelector('line');
                line.setAttribute('x2', cx);
                line.setAttribute('y2', cy);
                //
                //deburging 
                console.log(selected_element);
                console.log(line)
            }
            //Retrieve the end  coodinates of the ellipse. 
            function end_drag(evt) {
                //
                //get the mouse position at the end of the drag 
                offset = get_mouse_position(evt);
                //
                //set the selected element to null inorder to stop the drag 
                selected_element = false;
            }
            
        </script>
    </head>
    
    <body>
        
        <svg 
            viewBox="0 0 500 500" 
            onmousedown="start_drag(evt)" 
            onmousemove="drag(evt)" 
            onmouseup="end_drag(evt)"  
        >
            <ellipse fill="yellow" cx="120" cy="200" rx="30" ry="20"/>
            <ellipse fill="green" cx="200" cy="200" rx="30" ry="20"/>
            <line x1="120" y1="200" x2="200" y2="200" style="stroke:black;stroke-width:2"
                          id="relation_one"/>     
        </svg>
        
    </body>
</html>