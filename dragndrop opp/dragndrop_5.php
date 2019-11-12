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
                //initialize the selected element
                 selected_element = evt.target;
                //
                //Retrieve the mouse position in svg coordinates both the x and the y.
                offset = get_mouse_position(evt);
                //
                // Make sure the first transform on the element is a translation
                var transforms = selected_element.transform.baseVal;
                //
                //if the origin of the translate is not at the center 
                if (transforms.length === 0 || transforms.getItem(0).type !== SVGTransform.SVG_TRANSFORM_TRANSLATE) {
                    //
                    // Get the svg inwhich the drag and drop is bound within 
                     const svg = document.querySelector('svg');
                    //
                    //Allow a shear the translate of the selected within the svg element 
                    var translate = svg.createSVGTransform();
                    //
                    //Set the new translates coodinates 
                    translate.setTranslate(0, 0);
                    //
                    // Append the new translate to the selected element to change 
                    // its position 
                    selected_element.transform.baseVal.insertItemBefore(translate, 0);
                }
                // Get initial translation
                transform = transforms.getItem(0);
                //
                //The transform matrix is in a negative direction to the mouse position 
                offset.x -= transform.matrix.e;
                offset.y -= transform.matrix.f;
                //
                //deburging 
                //console.log(cood.x);
            }
            
            //Translates the selected element and set its attributes the cx and 
            //cy to the new position 
            function drag(evt) {
                console.log(selected_element);
                //
                //Get the original real/user coodinates for the center of selected elements 
                let cx= selected_element.getAttribute('cx');
                let cy= selected_element.getAttribute('cy');
                //
                //deburging and testing 
                console.log('the user coodinates are' + cx +'and '+ cy);
                //
                //Ensures that the drag can only take place to a selected_element
                // not in an entire Svg
                if (selected_element){
                  //
                  //Get the new mouse coodinates at the position of the drag 
                  var coord = get_mouse_position(evt);
                  //
                  //Enable the shear transform by obtaining and setting the shear coodinates
                  transform.setTranslate(coord .x - offset.x, coord.y - offset.y); 
                }
                //
                //setAttribute of the selected 
                selected_element.setAttribute("cx", offset.x);
                selected_element.setAttribute("cy", offset.y);
                //
                //Get the line element 
                let line = document.querySelector('line');
                //
                // Get the line line attributes x1 and x2 and store in an array
                let attrs = []; 
                attrs.push(line.getAttribute('x1'));
                attrs.push(line.getAttribute('x2'));

                //
                //Get the line to be modified coodinates
                if (test(selected_element, line) === 1){
                    line.setAttribute('x1', offset.x);
                    line.setAttribute('y1', offset.y);
                    console.log(line);
                    console.log(selected_element);
                    
                }
                else if (test(selected_element, line) === 2){
                    line.setAttribute('x2', offset.x);
                    line.setAttribute('y2', offset.y);
                }
                //
                //if no match do nothing
                else{
                //
            }
                //
                //deburging 
//                console.log(selected_element);
//                console.log(line);
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
            
            function test(ellipse, line){
                let lineX1 = line.getAttribute('x1');
                let lineX2 = line.getAttribute('x2');
                if(ellipse.getAttribute('cx') === lineX1){
                    return 1;
                }else if(ellipse.getAttribute('cx') === lineX2){
                    return 2;
                }else{
                    return 0
                }
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