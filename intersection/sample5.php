<html>
    <head>
        <title>kevlin </title>
    </head>
    <body>
        <!-- Linking to the Kevin Lindey library -->
        <script src="./node_modules/kld-intersections/dist/index-umd.js"></script>
        <script>
            //
            //Define the coordinates of the circle centers 
            const c1 = new KldIntersections.Point2D(600,200);
            const c2 = new KldIntersections.Point2D(200,200);
                      //
            //Us the library to define circle1, centered on 25/30 with radius 50. 
            //What units are these figures? How to we scale them to %?
            const circle1 = KldIntersections.ShapeInfo.circle(c1.x, c1.y, 15);
            
            //Define a second circle
            const circle2 = KldIntersections.ShapeInfo.circle(c2.x, c2.y, 15);
            //
            //Draw a line from the center of circle 1 to the center of circl2
            const chic = generate_svg(circle1, "chic joint","attribute");
            const eureka = generate_svg(circle2, "eureka water","attribute");
         
            const line = KldIntersections.ShapeInfo.line(c1.x, c1.y, c2.x, c2.y);
           //draw a line from the centre of one of the circles
            const line1 = KldIntersections.ShapeInfo.line(c2.x, c2.y,200,50);

               //Get the intersections of the line and circles
            const intersection1 = KldIntersections.Intersection.intersect(circle1, line);
            const intersection2 = KldIntersections.Intersection.intersect(circle2, line);
            //
            //Retrieve the intersection points, p1 and p2
            const p1 = intersection1.points[0];
            const p2 = intersection2.points[0];
            //
            //Construct the svg element from the circle1 
            const svg = 
                `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800"> 
                        <circle 
                            cx="${circle1.args[0].x}" 
                            cy="${circle1.args[0].y}" 
                            r="${circle1.args[1]}" 
                           stroke="blue" fill="none"/>
                            
                       <text x="${chic.name_x}" y="${chic.name_y}" fill="black">
                          ${chic.name}
                       </text>
                        
                        <circle 
                            cx="${circle2.args[0].x}" 
                            cy="${circle2.args[0].y}" 
                            r="${circle2.args[1]}" 
                           stroke="red" fill="none"/>
                            
                        <text x="${eureka.name_x}" y="${eureka.name_y}" fill="black">
                       ${eureka.name}
                        </text>
                       
                       <line 
                            x1="${p1.x}" 
                            y1="${p1.y}" 
                            x2="${p2.x}" 
                            y2="${p2.y}"
                            stroke="red"
                           />
                        <line 
                            x1="${c2.x}" 
                            y1="${c2.y}" 
                            x2="${200}" 
                            y2="${50}"
                            stroke="red"
                          />
                      
                         <text x="${attribute_x}" y="${attribute_y}" fill="black">
                       ${attribute.attribute}
                        </text>
                    
                                                      
                       <circle 
                            cx="${p1.x}" 
                            cy="${p1.y}" 
                            r="5" 
                            fill="green"/>
                         
                        </svg>`;
            //
            //Write the svg text to the browser.
            document.write(svg);
                     
            function generate_svg(circle, name,attribute){
                return {
                    cx: circle.args[0].x,
                    cy: circle.args[0].y, 
                    rx: circle.args[1],
                    
                    name: name,
                    name_x:  circle.args[0].x-30,
                    name_y: circle.args[0].y+50,
                    attribute:attribute,
                    attribute_x:line.args[0].x,
                    attribute_y:line.args[0].y
                        };
                }
        </script>
    </body>
</html>

