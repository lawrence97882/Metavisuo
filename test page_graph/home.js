/* global viewbox_, step */

//
//New javascript class of home that enbles dome manipulation using the mouse events
class home{
    constructor(){
        //
        //Set the svg for manipulation
       this.set_svg(); 
       //
       //initialize the viewbox to null
       const viewbox_= null;
       //
       //Define the constants used for viewbox 
       const step = 100;
    }
   //Loading a page sets the viewbox property
    set_svg(){
        //Get the svg property  
       let svg = window.document.querySelector('svg');
       return svg;
    }
    
    //The view box property that controls panning and zooming.
    get viewbox(){
        //
        //If the viewbox is empty, fill it from the svg
        if (viewbox_.length===0){
            //
            //Get the svg tag 
            this.svg = this.set_svg();
            //
            //Retrieve the viewBox attribute
            let viewbox = this.svg.getAttribute('viewBox');
            //
            //split the view box properties using the space 
            let $split_strs = viewbox.split(" ");
            //
            //Convert the strings to numbers
            viewbox_ = $split_strs.map($x=>{ return parseInt($x);});
        }
        //
        return viewbox_;            ;
    }
    
    set viewbox($v){
        viewbox_ = $v;
    }
    
    
    //zoom function. True direction means to zoom out
    zoom(dir=true){
        //
        //get the third component of the viewbox which is the zoom
        let $zoom = this.viewbox[2];
        //
        //Set the direction to + r -
        let $sign = dir ? 1:-1;
        //
        //Increase/decrease zoom by, say, 100
        $zoom = $zoom + step*$sign;
        //
        //Replace the 2nd and 3rd split values with the new zoom value
        this.viewbox[2] = $zoom;
        this.viewbox[3] = $zoom;
        //
        //Turn the array into text
        let $viewboxstr = this.viewbox.join(" ");
        //
        //Assign the new view box to the svg viewBox Attribute
        document.querySelector('svg').setAttribute('viewBox', $viewboxstr);
    }
    //
    //Spans the graph to the left and to the right
    side_pan(dir=true){
            
        //
        //Geet the first compnent of the viewbox array which is the side pan 
        let $span = this.viewbox[0];
        //
        //Set the direction to + r -
        let $sign = dir ? 1:-1;
        //
        //Increase/decrease zoom by, say, 100
        $span = $span + step*$sign;
        //
        //Replace the 1st element of the viewbox which is the side pan
        this.viewbox[0] = $span;
        //
        //Turn the array into text
        let $viewboxstr = this.viewbox.join(" ");
        //
        //Assign the new view box to the svg viewBox Attribute
        document.querySelector('svg').setAttribute('viewBox', $viewboxstr);
    }
    //
    //pans the chart in up down direction
    top_pan(dir=true){
       //
        //Geet the second compnent of the viewbox array which is the top pan 
        let $span = this.viewbox[1];
        //
        //Set the direction to + r -
        let $sign = dir ? 1:-1;
        //
        //Increase/decrease zoom by, say, 100
        $span = $span + step*$sign;
        //
        //Replace the 2nd element of the viewbox which is the top pan
        this.viewbox[1] = $span;
        //
        //Turn the array into text
        let $viewboxstr = this.viewbox.join(" ");
        //
        //Assign the new view box to the svg viewBox Attribute
        document.querySelector('svg').setAttribute('viewBox', $viewboxstr);
    }
     
}
