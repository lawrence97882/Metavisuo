<?php

?>
<html>
    <head>
        <title>drag and drop</title>
        <style>
            #obj{
                height: 150px;
                width: 300;
                border: 5px;
            }
            
                </style>
        <script>
           //
           //drag and drop using mouse events 
       
            function OnmouseDown(event) { 
               //
               //  start the process

               //  prepare to moving: make absolute and on top by z-index
           obj.style.position = 'absolute';
           obj.style.zIndex = 1000;
           //
           // move it out of any current parents directly into body
           // to make it positioned relative to the body
          document.body.append(obj);
          //
          // ...and put that absolutely positioned ball under the cursor
          moveAt(event.pageX, event.pageY);
          //
          // centers the obj at (pageX, pageY) coordinates
          function moveAt(pageX, pageY) {
                obj.style.left = pageX - obj.offsetWidth / 2 + 'px';
                obj.style.top = pageY - obj.offsetHeight / 2 + 'px';
           }
            //move the obj on mousemove
        document.addEventListener('mousemove', onMouseMove);
          //
          //attach the page coodinates upon mouse move and move the obj 
         function onMouseMove(event) {
               moveAt(event.pageX, event.pageY);
         }

        // drop the ball, remove unneeded handlers, do nothing on mouse up
         obj.onmouseup = function() {
            document.removeEventListener('mousemove', onMouseMove);
            obj.onmouseup = null;
        };
        };
           
        </script>
    </head>
    <body>
        <div id="drag">
            <div id='obj' draggable="true"  onmousedown="OnmouseDown(event)">
                <svg height="140" width="500">
                    <ellipse cx="200" cy="80" rx="100" ry="50"      
                    style="fill:yellow;stroke:purple;stroke-width:2"
                    />
                </svg>
            </div>
        </div>
    </body>
</html>