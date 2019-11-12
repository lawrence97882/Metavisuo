<html>
    <head>
        <meta charset="UTF-8">
        <title>KevinLindseyI</title>
    </head>
    
    <body>
        <script src="./node_modules/kld-intersections/dist/index-umd.js"></script>

        <!-- circle and rectangle-->
        <script>
            const ShapeInfo = KldIntersections.ShapeInfo;
            const Intersection = KldIntersections.Intersection;
            const circle = ShapeInfo.circle(0, 0, 50);
            const rectangle = ShapeInfo.rectangle(0, 0, 60, 30);
            console.log(circle);
            console.log(rectangle);
            const result = Intersection.intersect(circle, rectangle);
            console.log(result);
            const intersectionSVG = result.points.map(p => {
            return `<circle cx="${p.x.toFixed(3)}" cy="${p.y.toFixed(3)}" r="2" stroke="red" fill="none"/>`;
            }).join("\n    ");
            const svg = `<svg xmlns="http://www.w3.org/2000/svg">
            <g transform="translate(75,75)">
            <circle cx="${circle.args[0].x}" cy="${circle.args[0].y}" r="${circle.args[1]}" stroke="blue" fill="none"/>
            <rect x="${rectangle.args[0].x}" y="${rectangle.args[0].y}" width="${rectangle.args[1].x}" height="${rectangle.args[1].y}" fill="none" stroke="green"/>
            ${intersectionSVG}
            </g>
            </svg>`;
            document.write(svg);
            console.log(svg);
        </script>
    </body>    
</html>
