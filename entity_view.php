<html>
    <head>
        <title>login</title>
        <style>
            h2{
                color: blue;
                text-decoration: green;

            }
            textarea{
                background-color: bisque;
                color:green;

            }           
            label{
                display:block;
                color: blue;
                margin-top: 2%;

            }
            span:after{
                content: ":"; 
            }

            span{
                font-size:30px;
                font-family:serif;
                font:larger;

            }
            input{
                background-color: bisque;
                color:green;
            }

            body{
                text-align: center;
                /*padding-top: 30%;*/
            }

            form{
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
            }
            #bg-image{
                background:url("Mutall1.JPG"); 
                opacity: 0.2;
                height: 100vh;
            }
            button{
                background-color: #4CAF50; /* Green */
                border: none;
                color: red;
                padding: 15px 32px;
                display: inline-block;
                font-size: 16px;
              }
            
        </style>
    </head>
    
    <body>
        <label>Entity name:<input name="ename" readonly="true"/></label>
        <label>Title <input type="text" name="title"/></label>
        <label><input type="checkbox" name="reporting"/>Reporting </label>
        <label><input type="checkbox" name="administration"/>Administration</label>
        <label><input type="checkbox" name="visible"/>invisible</label>
        <label>coordinates cx:<input type="text" name="cx"/> cy:<input type="text" name="cy"/></label>
        <button id="save">Save</button> <button id="cancel">cancel</button>
        
        
    </body>
</html>