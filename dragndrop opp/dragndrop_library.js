//
class dragndrop{
    //
    //This class requires a line and an ellipse for its construction 
    constructor(){ 
        //Get the svg element where the drag and drop is bound. which 
        //creates the instance of the class on load 
        this.svg= document.querySelector('svg');
        //
        //Add this removes any other element that could have been selectes an retains 
        //only the target element as tthe selected element 
         this.svg.addEventListener('click', (evt)=>{this.remove_selected(evt);}, false);
        //
        //the arrow function was used inoder this can refer to the class dragndrop not svg 
        //Add the event listeners from which the line is bound.
        //Occurs upon the mouse touch on an element
        this.svg.addEventListener('mousedown', (evt)=>{this.start_drag(evt);}, false);
        //
        //Occurs when the user moves the mouse over the element also 
        //called a drag.
        this.svg.addEventListener('mousemove', (evt)=>{this.drag(evt);}, false);
        //
        //occurs when the left mouse button is released over the selected
        // element also called a dragend.
        this.svg.addEventListener('mouseup', (evt)=>{this.end_drag(evt);}, false);
    }
    //Removes the property of selected from all the entities to all the ellipses in the dome
    remove_selected(evt){
        //
        //Ensure that the ellipses are the only elements that can have a selected option
        if (evt.target.classList.contains('draggable')) {
            //
            //Get all the ellipses from the dome 
            const collection =document.querySelectorAll('ellipse');
            //
            //loop through the collection and remove the attribute of selected 
            collection.forEach($e=>{
                //
                //Remove the attribute of selected
                $e.removeAttribute('selected');
            });
            //
            //Set the selected element to be dragged to be the one clicked  
            //{the target element to which the drag will occurs}
            const selected_element= evt.target;
            selected_element.setAttribute('selected', true);
      }
    }

    //Get the current coodinates of the element both client and offset and 
    //any translational coodinates 
    start_drag(evt) {
        //
        //Ensure that the ellipses are the only draggable elements
        if (evt.target.classList.contains('draggable')) {
            //
            //set when deburging after noticing if the property svg is a null
            let svg= document.querySelector('svg');
            //
            //Set the selected element to be dragged 
            //{the target element to which thedrag occurs}
             this.selected_element= evt.target;       
            //
            //Set the mouse position during the drag
            this.offset = this.get_mouse_position(evt);
            //
            //Including the transform property to the selected element 
            var transforms = this.selected_element.transform.baseVal;
            //
            // The transform should be a translate bound in the svg element. 
            if (transforms.length === 0 || transforms.getItem(0).type !== SVGTransform.SVG_TRANSFORM_TRANSLATE) {
                //
                // Create an transform that translates by (x,y) since it is two
                // dimentional stored in a variable translate before appending.
                var translate = svg.createSVGTransform();
                //
                //Set the translate parameters as 0,0 since no change in position at the drag start 
                translate.setTranslate(0, 0);
                //
                //Apend the the translate parameter to the selected element
                this.selected_element.transform.baseVal.insertItemBefore(translate, 0);
             }
            //
            //
            this.$transform = transforms.getItem(0);
            //
            //Get the translated mouse position both in the x and the y 
            //direction after setting the x,y translate parameters to 0,0
            this.offset.x -= this.$transform.matrix.e;
            this.offset.y -= this.$transform.matrix.f;
            //
            //Initialize the current coodinates of the selected element
            // {real coodinates or user coodinates}
            this.cx = this.selected_element.getAttribute('cx');
            this.cy= this.selected_element.getAttribute('cy');
        }
    }

    //Returns the translated coodinates in svg version as X and Y coodinates 
    get_mouse_position(evt) {
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

    //Change the translate arguments from 0 to new position to allow 
    //a change in position 
      drag(evt) {
        //
        //The drag function can only take if there is a selected element to
        // avoid dragging the entire svg element 
        if (this.selected_element) {
            //
            //set the new translated position as a variable coord
            //The actual coodinates ofter the translation of the selected element}
            this.coord = this.get_mouse_position(evt);
            //
            //Pass the arguments of the translate as the distance between
            // the mouse position and the translated position. 
            this.$transform.setTranslate(this.coord.x - this.offset.x, this.coord.y - this.offset.y);
        }
        //
        //Drag the entity companions as well
        this.drag_line_companions();
        this.drag_text_companions();
        
    }
    
    //By default, there are no line companions to drag, so this does noting. This 
    //gets overidden in the extenden
    drag_line_companions(){}
    
    //By default, there are no text companions to drag, so this does noting. This 
    //gets ovveridden in the extende.
    drag_text_companions(){}
    
    //Set the selected element to null to end the drag process
    end_drag(evt) {
        //Set the selected eleement to null
        this.selected_element = false;
    }
}

class dragndrop_ex extends dragndrop{
    //
    //To instances of this class
    constructor(){
        //
        //parent const
        super();
        //

    }

    //Allows a drag of the ellipse including its line relation 
    drag_line_companions(){
         //
        //Get the line which has the same coodinates as the ellipse 
       var lines= document.querySelectorAll('line');
        //
        //loop through all the lines to abtain the start and the end attributes 
        //then compare them with the cordinates centre of the ellipse 
        lines.forEach($e=>{
            //
            //Get the line id which contains the name of the ellipse linked to it
            let line = $e.getAttribute('id');
            let lname = line.split("to");
            //
            //When the first member of the array matches the ellipse line cane the 
            //start of the line to the new translted coodinates 
            if(this.selected_element.getAttribute('id')=== lname[0]){
                $e.setAttribute('x1', this.coord.x);
                $e.setAttribute('y1', this.coord.y);
            }
            //
            //when resembles the second change the end of the line 
            else if(this.selected_element.getAttribute('id')=== lname[1]){
               $e.setAttribute('x2', this.coord.x);
               $e.setAttribute('y2', this.coord.y); 
            }
            //
            //if not equal do nothing 
            else{
                //    
            }
            //
            //Update the cx and the cy of the ellipse;
            this.selected_element.setAttribute('cx', this.offset.x);
            this.selected_element.setAttribute('cy', this.offset.y);
     });
    }
    
}

//This new class extends the drag functionality in a group <g>tag 
class dragndrop_group extends dragndrop {
   //
   //the constructor
   constructor (){
       //
       //parent constuctor 
       super();
   }
   //
   //Overwritting the drag function and this time dragging the entire group
   start_drag(evt){
       //
       //ensure that we can only drag a group g tag
       if (evt.target.classList.contains('draggable')) {
            //
            //set when deburging after noticing that the property svg is a null
            let svg= document.querySelector('svg');
            //
            //The selected element that is suppost to be dragged 
             this.selected_element= evt.target;
             //
            this.selected_element.setAttribute('selected', true);
             //
            //get the parent group tag <g> to be draged
            this.selected_group= this.selected_element.parentElement;
            //
            //Set the mouse position during the drag
            this. offset = this.get_mouse_position(evt);
            //
            //Including the transform property to the selected element 
            var transforms = this.selected_group.transform.baseVal;
            //
            // The transform should be a translate bound in the svg element. 
            if (transforms.length === 0 || transforms.getItem(0).type !== SVGTransform.SVG_TRANSFORM_TRANSLATE) {
                //
                // Create an transform that translates by (x,y) since it is two
                // dimentional stored in a variable translate before appending.
                var translate = svg.createSVGTransform();
                //
                //Set the translate parameters as 0,0 since no change in position at the drag start 
                translate.setTranslate(0, 0);
                //
                //Apend the the translate parameter to the selected element
                this.selected_group.transform.baseVal.insertItemBefore(translate, 0);
             }
            //
            //
            this.$transform = transforms.getItem(0);
            //
            //Get the translated mouse position both in the x and the y 
            //direction after setting the x,y translate parameters to 0,0
            this.offset.x -= this.$transform.matrix.e;
            this.offset.y -= this.$transform.matrix.f;
        }
        else {
            
        }
        
   }
   //Change the translate arguments from 0 to new position to allow 
    //a change in position 
      drag(evt) {
        //
        //The drag function can only take if there is a selected element to
        // avoid dragging the entire svg element 
        if (this.selected_element) {
            //
            //set the new translated position as a variable coord
            //{the actual coodinates ofter the translation of the selected element}
            this.coord = this.get_mouse_position(evt);
            //
            //
            //Pass the arguments of the translate as the distance between
            // the mouse position and the translated position. 
            this.$transform.setTranslate(this.coord.x - this.offset.x, this.coord.y - this.offset.y);
        }
        //
        //Drag the entity companions as well
        this.drag_line_companions();  
    }
   //
   //drags the line and the circle that represents the start of a relation 
    drag_line_companions(){
        if (this.selected_element){
            //
            //Get the line which has the same coodinates as the ellipse 
            const lines= document.querySelectorAll('line');
             //
             //loop through all the lines to abtain the start and the end attributes 
             //then compare them with the id names of the ellipse 
             lines.forEach($e=>{
                 //
                 //Get the line id which contains the name of the ellipse linked to it
                 let line = $e.getAttribute('id');
                 let lname = line.split("to");
                 //
                 //get the entity name of the selected element 
                 const e_name= this.selected_element.getAttribute('id');
                 //
                 //When the first member of the array matches the ellipse set the 
                 //start of the line to the new translted coodinates 
                 if(e_name=== lname[0]){
                     //
                   const point=  this.entity_companion($e.getAttribute('x2'),$e.getAttribute('y2'));
                     $e.setAttribute('x1', point.x);
                     $e.setAttribute('y1', point.y);
                    //drag the circles that show the start of the relation
                    this.circle_drag(e_name, point);
                 }
                 //
                 //when resembles the second change the end of the line 
                 if(e_name=== lname[1]){
                    const point=  this.entity_companion($e.getAttribute('x1'),$e.getAttribute('y1'));
                    $e.setAttribute('x2', point.x);
                    $e.setAttribute('y2', point.y); 
                 }
                 //
                 //if not equal do nothing 
                 else{
                     //    
//                     console.log('true');
                 }
            });
  
            console.log(this.selected_element);
       }
    }
    //
    //Thi s is the entity component declared using the kevin lendsey library and 
    //return the intersection points
    entity_companion(x,y){
        //
        //convert the arguments into integers
         const end_x= parseInt(x);
         const  end_y= parseInt(y);   
        
         //
            //Define the coordinates of the drag ellipse which is the mouse position  
            const start = new KldIntersections.Point2D(this.coord.x, this.coord.y);
           //
           //{Pplot the selected entity ellipse that is undergoing the drag  
            const ellipse = KldIntersections.ShapeInfo.ellipse(start.x, start.y , 100, 50);
            //
            //Plot the line wich is to follow the ellipse intersection point 
            const line = KldIntersections.ShapeInfo.line(start.x, start.y, end_x, end_y);
            //
            //Get the intersections of the line and circles
            const intersection1 = KldIntersections.Intersection.intersect(ellipse, line);
            //
            //Retrieve the intersection 
            const p1 = intersection1.points[0]; 
            //
            //Return the intersection point 
            return p1;
    }
    //
    //Drags the circle that shows the relation
    circle_drag(e_name, point){
        //
        //Get all the circles 
        const circles= document.querySelectorAll('circle');
        //
        //loop through all the circles to obtain the one ferencing the selected element 
        circles.forEach($c=>{
            //
            //get the id of the circle
            let cname=$c.getAttribute('id');
            //split and  remain with the entity's name 
            let circle= cname.split("_");
            //
            //if circle name is equal to the ename change the coodinates
            if(e_name=== circle[1]){
                  //
                  $c.setAttribute('cx', point.x);
                  $c.setAttribute('cy', point.y);
            }
        });
        
    }

} 
class dragndrop_both extends dragndrop {
   //
   //the constructor
   constructor (){
       //
       //parent constuctor 
       super();
   }
   //
   //Overwritting the drag function and this time dragging the entire group
   start_drag(evt){
       //
       //ensure that we can only drag a group g tag
       if (evt.target.classList.contains('draggable')) {
            //
            //set when deburging after noticing that the property svg is a null
            let svg= document.querySelector('svg');
            //
            //The selected element that is suppost to be dragged 
             this.selected_element= evt.target; 
             //
            //get the parent group tag <g> to be draged
            this.selected_group= this.selected_element.parentElement;
            //
            //Set the mouse position during the drag
            this. offset = this.get_mouse_position(evt);
            //
            //Including the transform property to the selected element 
            var transforms = this.selected_group.transform.baseVal;
            //
            // The transform should be a translate bound in the svg element. 
            if (transforms.length === 0 || transforms.getItem(0).type !== SVGTransform.SVG_TRANSFORM_TRANSLATE) {
                //
                // Create an transform that translates by (x,y) since it is two
                // dimentional stored in a variable translate before appending.
                var translate = svg.createSVGTransform();
                //
                //Set the translate parameters as 0,0 since no change in position at the drag start 
                translate.setTranslate(0, 0);
                //
                //Apend the the translate parameter to the selected element
                this.selected_group.transform.baseVal.insertItemBefore(translate, 0);
             }
            //
            //
            this.$transform = transforms.getItem(0);
            //
            //Get the translated mouse position both in the x and the y 
            //direction after setting the x,y translate parameters to 0,0
            this.offset.x -= this.$transform.matrix.e;
            this.offset.y -= this.$transform.matrix.f;
        }
        else {
            
        }
   }
   //Change the translate arguments from 0 to new position to allow 
    //a change in position 
      drag(evt) {
        //
        //The drag function can only take if there is a selected element to
        // avoid dragging the entire svg element 
        if (this.selected_element) {
            //
            //set the new translated position as a variable coord
            //{the actual coodinates ofter the translation of the selected element}
            this.coord = this.get_mouse_position(evt);
            //
            //Pass the arguments of the translate as the distance between
            // the mouse position and the translated position. 
            this.$transform.setTranslate(this.coord.x - this.offset.x, this.coord.y - this.offset.y);
        }
        //
        //Drag the entity companions as well
        this.drag_line_companions();  
    }
   //
   //drags the line and the circle that represents the start of a relation 
    drag_line_companions(){
        if (this.selected_element){
            //
            //Get the line which has the same coodinates as the ellipse 
            const lines= document.querySelectorAll('line');
             //
             //loop through all the lines to abtain the start and the end attributes 
             //then compare them with the id names of the ellipse 
             lines.forEach($e=>{
                 //
                 //Get the line id which contains the name of the ellipse linked to it
                 let line = $e.getAttribute('id');
                 let lname = line.split("to");
                 //
                 //Get the entities referrenced by the relation as ref_start and the ref_end
                 const ref_start= lname[0];
                 const ref_end = lname[1];
                 //get the entity name of the selected element 
                 let e_name= this.selected_element.getAttribute('id');
                 //
                 //When the first member of the array matches the ellipse set the 
                 //start of the line to the new translted coodinates 
                 if(e_name=== lname[0]){
                     //
                     //the ref_start enables get the codinates of the start which are its attributes 
                   const points=  this.entity_companion(ref_end);
                    $e.setAttribute('x1', points[0].x);
                    $e.setAttribute('y1', points[0].y);
                    this.complete_line($e, points[1]);
//                    $e.setAttribute('y2', points[1].y);
//                    $e.setAttribute('x2', points[1].x);
                    //drag the circles that show the start of the relation
                   this.circle_drag(e_name, points);
                   
                 }
                 //
                 //when resembles the second change the end of the line 
                 if(e_name=== lname[1]){
                     //
                     //send the end entity as the referenced parameter to obtain 
                     //the coodinate of the start of the relation 
                    const points=  this.entity_companion(ref_start);
                    // Update the line relation to enable the drag allong with the entity 
                    $e.setAttribute('x2', points[0].x);
                    $e.setAttribute('y2', points[0].y); 
                   
                 }
                 //
                 //if not equal do nothing 
                 else{
                     //    
//                     console.log('true');
                 }
            });
        
       }
       
    }
    //
    //This is the entity component declared using the kevin lendsey library and 
    //return the intersection points
    entity_companion(name){
          // 
          //Get the entity referenced by this name 
          const _entity = document.getElementById(`${name}`);   
          //
          //Get the coodinates of the end entity as integers 
          let x =parseInt( _entity.getAttribute('cx'));
          let y =parseInt( _entity.getAttribute('cy'));
          //Define the coordinates of the drag ellipse which is the mouse position  
          const start = new KldIntersections.Point2D(this.coord.x, this.coord.y);
          //
          //Define the coodinates of the end entity 
          const end = new KldIntersections.Point2D(x, y); 
           //
           //Pplot the selected entity ellipse that is undergoing the drag  
            const ellipse1 = KldIntersections.ShapeInfo.ellipse(start.x, start.y , 100, 50);
            //Pplot the selected entity ellipse that is undergoing the drag  
            const ellipse2 = KldIntersections.ShapeInfo.ellipse(end.x, end.y , 100, 50);
            //
            //Plot the line wich is to follow the ellipse intersection point 
            const line = KldIntersections.ShapeInfo.line(start.x, start.y, end.x, end.y);
            //
            //Get the intersections of the line and circles
            const intersection1 = KldIntersections.Intersection.intersect(ellipse1, line);
            const intersection2 = KldIntersections.Intersection.intersect(ellipse2, line);
            //
            //Points is an array where the intersection points are saved
            const points=[];
            //
            //
            //Retrieve the intersection 
            const p1 = intersection1.points[0]; 
            points.push(p1);
            const p2 = intersection1.points[0];
            points.push(p2);
            //
            //Return the intersection points
            console.log(points);
            return points;
    }
    //
    //Drags the circle that shows the relation
    circle_drag(e_name, points){
        //
        //Get all the circles 
        const circles= document.querySelectorAll('circle');
        //
        //loop through all the circles to obtain the one ferencing the selected element 
        circles.forEach($c=>{
            //
            //get the id of the circle
            let cname=$c.getAttribute('id');
            //split and  remain with the entity's name 
            let circle= cname.split("_");
            //
            //if circle name is equal to the ename change the coodinates
            if(e_name=== circle[1]){
                  //
                  $c.setAttribute('cx', points[0].x);
                  $c.setAttribute('cy', points[0].y);
            }
        });
        
    }

} 