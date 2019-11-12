<!DOCTYPE html>
<html>
    <head>
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
                //font:larger;
                
            }
            input{
                background-color: bisque;
                color:green;
            }

            body{
                text-align: center;
                padding-top: 30%;
            }

            .bg-image{
                background:url("Mutall1.JPG") no-repeat center ;
                opacity: 0.2;
                height: 100vh;
                background-position:cenert top; 
            }
            form{
                margin-top: 100px;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
            }

        </style>
        <script>
            
        </script>
    </head>
    <body>
        
        <form class="bg-image">
            <h2>CLIENT REGISTRATION FORM</h2>
            <label><span>DATE</span><input type="date"></label>
            <label><span>USER NAME</span><input type="text" name="username" maxlength="50"></label>
            <label><span>AGE</span><input type="number" name="age" maxlength="3"></label>
            <label><span>CHECK THIS BOX IF MARRIED</span><input type="checkbox"></label>
            <label><span>DESCRIBE YOUR BUSINESS</span></label>
            <textarea rows="5" cols="60"></textarea>
        </form>

    </body>
</html>
