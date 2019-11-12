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
        </style>
        <script src='library.js'></script>   
    </head>
    <body>
        <div id="bg-image"></div>
        <form>
            <script>
                async function  show_entity(){
                    //
                    //initialize the name argument 
                    const name = 'majormco';
                    const $output =await mutall.fetch(  'database' ,'export_structure', {name});
                    //
                    //check is the $result has a stutus of okay to create the 
                    //dbase else alert the error message
                    if($output.ok){ 
                        //
                        //Open the dbase
                        const dbase = new database($output.object);
                        //
                        const ent =  dbase.entities['payment'];
                        //
                        //Get the html
                        const $html = ent.get_html();
                        //
                        //Get the form node
                        let $form = document.querySelector('form');
                        //
                        //Attach the html
                        $form.innerHTML = $html;
                    }
                    else {
                        console.log($result.html);
                    }
                    
                }
                show_entity();
            </script>

        </form>

    </body>
</html>
