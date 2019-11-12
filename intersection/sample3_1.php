<!-- Use clipPath to fill a positioned image -->
<html>
    <head>
        <title>relations</title>
    </head>
    <body>
        <!-- Linking to the Kevin Lindey library -->
        <script src="./node_modules/kld-intersections/dist/index-umd.js"></script>
        <script>
            //
            //Define the coordinates of the circle centers 
            

            const start = new KldIntersections.Point2D(100, 50);
            //
            //Us the library to define circle1, centered on 25/30 with radius 50. 
            //What units are these figures? How to we scale them to %?

            const start_ellipse = KldIntersections.ShapeInfo.ellipse(start.x, start.y, 15, 20);
            //
            //Draw a line from the center of circle 1 to the center of circl2
            const line = KldIntersections.ShapeInfo.line(start.x, start.y, 150, 25);
            //
            //Get the intersections of the line and circles
            const intersection1 = KldIntersections.Intersection.intersect(start_ellipse, line);
            //
            //Retrieve the intersection points, p1 and p2
            const p1 = intersection1.points[0];
            //
            //Construct the svg element from the circle1 
            const svg =
                    `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400"> 
           
                       <line 
                            x1="${p1.x}" 
                            y1="${p1.y}" 
                            x2="150" 
                            y2="25"
                            stroke="red"
                           />
                            
                       <circle 
                            cx="${p1.x}" 
                            cy="${p1.y}" 
                            r="5" 
                            fill="green"/>
                </svg>`;
            //
            //Write the svg text to the browser.
            document.write(svg);

        </script>
    </body>
</html>

