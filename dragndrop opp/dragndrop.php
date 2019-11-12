<?php

?>
<html>
    <head>
        <title>drag and drop</title>
        <style>
            #object{
                height: 150px;
                width: 30 0;
                border: 5px;
            }
            #drop{
                height: 500px;
                width: 45%;
                border: 5px;
                background-color: greenyellow;
                margin: 5px;
                float: right; 
            }
            #drag{
                height: 500px;
                width: 45%;
                border: 5px;
                background-color: greenyellow;
                margin: 5px;
                float: left; 
            }
            .empty{
                display: inline;
            }
            .fill{
                
            }
            body{
                background-color: darksalmon;
            }
        </style>
        <script>
            var id;
          //drag functions
          function dragStart(event){
           id=event.target.id;
           //  alert (id);
          }
//          function dragEnd(){
//              console.log('end');
//          }
//      //
        //function s for the drop zone 
        //preventing the default setting 
          function dragOver(event){
             event.preventDefault();
          }
          //
          //allowing a drop event 
          function drop(event){
             event.target.append(document.getElementById(id));
          }
//          function dragEnter(){
//              console.log('enter');
//          }
//          function dragLeave(){
//              console.log('leave');
//          }
           
        </script>
    </head>
    <body>
        <div id="drop" ondragover="dragOver(event)" ondrop="drop(event)">
           
        </div> 
        <div id="drag"  ondragover="dragOver(event)" ondrop="drop(event)">
            <div id='object'  draggable="true" ondragstart="dragStart(event)">
                <svg height="140" width="500">
                    <ellipse cx="200" cy="80" rx="100" ry="50"      
                    style="fill:yellow;stroke:purple;stroke-width:2" />
                </svg>
            </div>
        </div>
    </body>
</html>