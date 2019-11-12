<?php

?>
<html>
    <head>
        <title>drag and drop</title>
        <style>
            
            .draggable {
              cursor: move;
            }
        </style>
         <script>
             //
             //set the original coodinates 
             var cx, cy = null;
             //
             //the diference 
             var $cx ,$cy =null;
             //
             //Onload of the svg create dragable elements and add event listeners 
             //dragstart, drag and the dragend 
            function make_draggable(evt) {
              //
              //Svg becomes the target element
              var svg = evt.target;
              //
              //Occurs when the user presses a mouse button over an element 
              //also called dragstart 
              svg.addEventListener('mousedown', start_drag, false);
              //
              //Occurs when the user moves the mouse over the element also 
              //called a drag.
              svg.addEventListener('mousemove', drag, false);
              //
              //occurs when the left mouse button is released over the selected
              // element also called a dragend.
              svg.addEventListener('mouseup', end_drag, false);
              //
              //convert the mouse window position to the corresponding svg coodinates 
              function get_mouse_position(evt) {
                var CTM = svg.getScreenCTM();
                return {
                //
                //convert the window position of the mouse to the respective svg coodinate in x axis     
                x: (evt.clientX - CTM.e) / CTM.a,
                //
                //Convert the mouse window position to the coresonding coodinate in y axis
                y: (evt.clientY - CTM.f) / CTM.d
              };
            }  
            //
            //declaring the variables 
            //selected_element is the target element the offset is the mouse position
            //while the transform is the translated selected_element. 
          var selected_element, offset, transform;
          //
          //Get the current coodinates of the element both client and offset and 
          //any translational coodinates 
          function start_drag(evt) {
            if (evt.target.classList.contains('draggable')) {
               selected_element = evt.target;
               offset = get_mouse_position(evt);
               //
              // Make sure the first transform on the element is a translate transform
              var transforms = selected_element.transform.baseVal;
                if (transforms.length === 0 || transforms.getItem(0).type !== SVGTransform.SVG_TRANSFORM_TRANSLATE) {
                    //
                    // Create an transform that translates by (0, 0)
                    var translate = svg.createSVGTransform();
                    translate.setTranslate(0, 0);
                    selected_element.transform.baseVal.insertItemBefore(translate, 0);
                 }
              // Get initial translation
              transform = transforms.getItem(0);
              offset.x -= transform.matrix.e;
              offset.y -= transform.matrix.f;
              //
              //Initialize the current coodinates 
              cx = selected_element.getAttribute('cx');
              cy= selected_element.getAttribute('cy');
              console.log(selected_element);
              //
              //initialize the diference in the coodinates
              $cx= offset.x-cx;
              $cy= offset.y-cy;
              console.log(`start cx = ${offset.x} cy=${offset.y}`);
            }
          }
          //
          //Upon a drag get the new mouse position both the offset and the client 
          function drag(evt) {
            if (selected_element) {
              var coord = get_mouse_position(evt);
              transform.setTranslate(coord.x - offset.x, coord.y - offset.y); 
            }
          }
          //
          //retrieve the end  coodinates of the ellipse 
          function end_drag(evt) {
            //
            //get the mouse position at the end of the drag 
            offset = get_mouse_position(evt);
            //
            //get the new coodinates of the centere by sutracting the diference 
            //from the mouse coodinates 
            let ncx = offset.x-$cx;
            let ncy = offset.y-$cy;
            
            selected_element.setAttribute("cx", parseInt(ncx));
            selected_element.setAttribute("cy", parseInt(ncy));
            selected_element = false;
            
            console.log(`end cx = ${parseInt(ncx)} cy=${parseInt(ncy)}`);
             //
            //if the ether the x1 or the x2 if equal to the cx of the selected 
            //element change the coodinates of the line to the new coodinates
             relations(parseInt(ncx), parseInt(ncy));
         }
        }
        //
        //Maps the new coodinates of the line to the entity shift 
        function relations(ncx, ncy){
            //
            //Get the the line
            let line = document.getElementById('relation_one');
            //
            // Get the line line attributes x1 and x2 and store in an array
            let attrs = []; 
            attrs.push(line.getAttribute('x1'));
            attrs.push(line.getAttribute('x2'));
            
            //
            //Get the line to be modified coodinates
            if (cx===attrs[0]){
                line.setAttribute('x1', ncx);
                line.setAttribute('y1', ncy);
            }
            else if (cx===attrs[1]){
                line.setAttribute('x2', ncx);
                line.setAttribute('y2', ncy);
            }
            //
            //if no match do nothing
            else{
                //
            }
            console.log(line);
        }
      </script>
    </head>
    <body>
        <div id="drag">
            <div>
                <svg viewBox="0 0 500 500"
                      onload="make_draggable (evt)">
                    <ellipse class="draggable" fill="#ff00af" cx="5" cy="5" rx="30" ry="20"/>
                    <ellipse class="draggable" fill="red" cx="35" cy="50" rx="30" ry="20"/>
                    <ellipse class="draggable" fill="yellow" cx="120" cy="200" rx="30" ry="20"/>
                    <ellipse class="draggable" fill="green" cx="200" cy="200" rx="30" ry="20"/>
                    <line x1="120" y1="200" x2="200" y2="200" style="stroke:black;stroke-width:2"
                          id="relation_one"/>     
                </svg>
            </div>
        </div>
    </body>
</html>