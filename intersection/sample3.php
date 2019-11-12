<!-- Use clipPath to fill a positioned image -->
<html>
    <head>
        <title>clippath</title>
    </head>
    <body>
        <!-- Linking to the Kevin Lindey library -->
        <script src="./node_modules/kld-intersections/dist/index-umd.js"></script>
        <script>
            //
            //Define the coordinates of the circle centers 
            //use clipPath to place an image inside the circle

            const c1 = new KldIntersections.Point2D(100, 50);
            const c2 = new KldIntersections.Point2D(150, 25);

            //
            //Us the library to define circle1, centered on 25/30 with radius 50. 
            //What units are these figures? How to we scale them to %?

            const circle1 = KldIntersections.ShapeInfo.circle(c1.x, c1.y, 15);

            //Define a second circle
            const circle2 = KldIntersections.ShapeInfo.circle(c2.x, c2.y, 15);
            //
            //Draw a line from the center of circle 1 to the center of circl2
            const line = KldIntersections.ShapeInfo.line(c1.x, c1.y, c2.x, c2.y);
            //
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
                    `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400"> 
                        <clipPath id="myCircle">    
                            <circle 
                                cx="${circle1.args[0].x}" 
                                cy="${circle1.args[0].y}" 
                                r="${circle1.args[1]}" 
                                stroke="blue" fill="none"/>
                        </clipPath>
                                
                        <image 
                            width="100" 
                            height="100" 
                            xlink:href="chickjoint.png" 
                            clip-path="url(#myCircle)"/>
                       
                        <clipPath id="Circle2">
                            <circle 
                                cx="${circle2.args[0].x}" 
                                cy="${circle2.args[0].y}" 
                                r="${circle2.args[1]}" 
                                stroke="red" fill="none"/>
                        </clipPath>
                             
                        <image 
                            width="300" 
                            height="50" 
                            xlink:href="eureka.png" 
                            clip-path="url(#Circle2)"/>
                        
                             
                       <line 
                            x1="${p1.x}" 
                            y1="${p1.y}" 
                            x2="${p2.x}" 
                            y2="${p2.y}"
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

