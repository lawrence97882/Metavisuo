class dragndrop{
    //
    //This class requires a line and an ellipse for its construction 
    constructor(){              
        //
        //Get the svg element where the drag and drop is bound. which 
        //creates the instance of the class on load 
        this.svg= document.querySelector('svg');
        //
        //Add the event listeners from which the line is bound.
        //Occurs upon the mouse touch on an element
        this.svg.addEventListener('mousedown', this.start_drag, false);
        //
        //Occurs when the user moves the mouse over the element also 
        //called a drag.
        this.svg.addEventListener('mousemove', this.drag, false);
        //
        //occurs when the left mouse button is released over the selected
        // element also called a dragend.
        this.svg.addEventListener('mouseup', this.end_drag, false);
    }

    //Get the current coodinates of the element both client and offset and 
    //any translational coodinates 
    start_drag(evt) {
        //
        //set when deburging after noticing that the property svg is a null
        let svg= document.querySelector('svg');
        //
        //Set the selected element to be dragged 
        this.selected_element = evt.target;
        //
        //Set the mouse position during the drag
        this. offset = dragndrop.get_mouse_position(evt);
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
        this.cx = this.selected_element.getAttribute('cx');
        this.cy= this.selected_element.getAttribute('cy');
    }

    //Returns the translated coodinates in svg version as X and Y coodinates 
    static get_mouse_position(evt) {
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
            var coord = dragndrop.get_mouse_position(evt);
            //
            //Pass the arguments of the translate as the distance between
            // the mouse position and the translated position. 
            this.$transform.setTranslate(coord.x - this.offset.x, coord.y - this.offset.y);
        }
        //
        //include the line relation
        var relation = this.relation(this.selected_element);
    }

    //Set the selected element to null to end the drag process
    end_drag(evt) {
        //
        //Set the selected eleement to null
        this.selected_element = false;
    }
    
    //joins the ellipse with the relation it originates from  inorder to drag
    // them together
    relation(ellipse){
        //
        //Get the line which has the same coodinates as the ellipse 
        var line = document.querySelector('line');
        //
        //Get the line attributes x1 and x2
        let lineX1 = line.getAttribute('x1');
        let lineX2 = line.getAttribute('x2');
        //
        //when the coodinates of the ellipse are equivalent to the begining of the
        // line change the start coodinates of the line 
        if(this.cx=== lineX1){
            line.setAttribute('x1', this.offset.x);
            line.setAttribute('y1', this.offset.x);
        }
        //
        //when equal to the end change the end coodinates 
        else if(this.cx === lineX2){
           line.setAttribute('x2', this.offset.x);
           line.setAttribute('y2', this.offset.x); 
        }
        //
        //if not equal do nothing 
        else{
            //    
        }
        //
        //Update the cx and the cy;
        ellipse.setAttribute('cx', this.offset.x);
        ellipse.setAttribute('cy', this.offset.y);
    }
    

}