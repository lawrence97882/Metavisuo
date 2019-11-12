<?php

?>
<html>
    <head>
        <title>drag and drop</title>
        <style>
            .static {
              cursor: not-allowed;
            }
            .draggable {
              cursor: move;
            }
        </style>
         <script>
             //
             //Onload of the svg create dragable elements and add event listeners 
             //dragstart, drag and the dragend 
            function makeDraggable(evt) {
              //
              //Svg becomes the target element
              var svg = evt.target;
              //
              //Occurs when the user presses a mouse button over an element 
              //also called dragstart 
              svg.addEventListener('mousedown', startDrag, false);
              //
              //Occurs when the user moves the mouse over the element also 
              //called a drag.
              svg.addEventListener('mousemove', drag, false);
              //
              //occurs when the left mouse button is released over the selected
              // element also called a dragend.
              svg.addEventListener('mouseup', endDrag, false);
              //
              //the the target coodinates in reference to the window and the svg 
              function getMousePosition(evt) {
                var CTM = svg.getScreenCTM();
                return {
                x: (evt.clientX - CTM.e) / CTM.a,
                y: (evt.clientY - CTM.f) / CTM.d
              };
            }
            //
            //get the coodinates of the click in reference to the target 
          var selectedElement, offset, transform;
          //
          //Get the current coodinates of the element both client and offset and 
          //any translational coodinates 
          function startDrag(evt) {
            if (evt.target.classList.contains('draggable')) {
               selectedElement = evt.target;
               offset = getMousePosition(evt);
               //
              // Make sure the first transform on the element is a translate transform
              var transforms = selectedElement.transform.baseVal;
                if (transforms.length === 0 || transforms.getItem(0).type !== SVGTransform.SVG_TRANSFORM_TRANSLATE) {
                    //
                    // Create an transform that translates by (0, 0)
                    var translate = svg.createSVGTransform();
                    translate.setTranslate(0, 0);
                    selectedElement.transform.baseVal.insertItemBefore(translate, 0);
                 }
              // Get initial translation
              transform = transforms.getItem(0);
              offset.x -= transform.matrix.e;
              offset.y -= transform.matrix.f;
            }
          }
          //
          //Upon a drag get the new mouse position both the offset and the client 
          function drag(evt) {
            if (selectedElement) {
              var coord = getMousePosition(evt);
              transform.setTranslate(coord.x - offset.x, coord.y - offset.y);
              let y= evt.clientY;
             console.log(y);
            }
          }
          //
          //do nothing 
          function endDrag(evt) {
            selectedElement = false;
            
          }  
        }
         </script>
    </head>
    <body>
        <div id="drag">
            <div>
                <svg viewBox="0 0 500 500"
                      onload="makeDraggable(evt)">
                    <ellipse class="draggable" fill="#ff00af" cx="5" cy="5" rx="30" ry="20"/>
                    <ellipse class="draggable" fill="red" cx="35" cy="50" rx="30" ry="20"/>
                    <ellipse class="draggable" fill="yellow" cx="120" cy="200" rx="30" ry="20"/>
                </svg>
            </div>
        </div>
    </body>
</html>