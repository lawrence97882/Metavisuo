/* global mutall, await, fetch, self, $dbnames, $dbname, json_str, ellipses, entity, coodinate, sql, hidden_entites, Entity_relation, input, hidden_entities */

//
//Panning and zooming step (you may want to consider 2 steps, one for zooming
//the other for panning
const $step = 100;

var viewbox_ = [];

////This class was motivated by the need to preseent any data model in a graphical 
//way
class page_graph {

    //Use the querystring passed on from PHP to construct this page
    constructor($request) {
        //
        //set the url query string variables
        this.request = $request;
        //
        //Set the database to null so that the propeprty is bsible on the 
        //naviagtor. The actual value will be set when the database datails are
        //avaulable,
        this.dbase=null;
        //
        //Database access credentials (username and password) are set during login
        this.password = null;
        this.username = null;
        //
        //Boostraping
        window.onload = async () => {
            //
            //Test if the user is logged in and return a false if not logged
            //in else return a username if logged in  
            let $username = await page_graph.user_is_logged_in();
            
            //if the user in logged return dbase present
            if ($username) {
                //
                //get the logout button with id logout
                let logout = window.document.getElementById('logout');
                //
                //unset the attribute hidden
                logout.removeAttribute('hidden');
                logout.textContent = ($username + ' logout');
                //
                //show the view database button and populate it with database 
                
                let view = document.getElementById('open_dbase');
                view.removeAttribute('hidden');
                view.textContent = ('select a database');
                
                //how the user name in the navigation as a logout button
                //this.show_logout($username);
            } else {
                //
                //get the login button
                let logout = document.getElementById('logout');
                //
                //
                //get the login button
                let login = document.getElementById('login');
                login.removeAttribute('hidden');
                login.textContent = ('Please log in to access our services');
                //
                //Add a click even listener
                login.onclick = () => {
                    //
                    //Open the login window
                    let win = window.open("page_login.php");
                    //
                    win.onbeforeunload = async () => {

                        // 
                        //Hide the login button
                        login.setAttribute('hidden', true);
                        //
                        //Remove the hidden attribute fron logout
                        logout.removeAttribute('hidden');
                        logout.textContent = (win.username + ' logout');
                        //
                        //show the view database button
                        let view = document.getElementById('open_dbase');
                        view.removeAttribute('hidden');
                        view.textContent = ('select the database to open');
                        //
                        //Saving login credebntials for future use
                       // const d = await mutall.fetch('mutall', 'save_session', {username:win.username, password:win.password}});
                    };
                };
            }
            //See if we can open a requeted database
            //
            //Return a false if a database request us not found, otherwise 
            //the dabase name
            let dbname = await page_graph.database_request_found($request);
            //
            //If looged in and there is a database request, present it
            if ($username && dbname) {
                // 
                //Set the database name
                this.dbname = dbname;
                //
                //Set the dbase as a property of the main class pagegraph
                this.dbase = await this.get_dbase();
                //
                //get the svg inner html from the javascript library 
                let $svg = this.dbase.present();
                //
                //Get the svg element from the home page 
                let $content = document.getElementById("svg");
                //
                $content.innerHTML = $svg.innerHTML;
                //
                //
                //allow user to close the datadase 
                let  select = document.getElementById('open_dbase');
                select.setAttribute('hidden', true);
                //
                //get the clse button.
                let close = document.querySelector('#close_dbase');
                close.removeAttribute('hidden');
            }
            ;
        };
    }
    //
    //Returns the dbase which is obtained via the javascript library 
    async get_dbase() {
        //
        //Get the static database which is the php version of the database
        //this is to activate t he library.js
        //
        //The mutall class requires a class, method and any other support 
        //properties. 
        //
        //Fetch the database structure with all the entities and columns 
        
        const $dbase = await mutall.fetch('database', 'export_structure', {name:this.dbname});
          //
        //Create a javascript version of the database
        const dbase = new database($dbase);
        //
        //Return the javascript database
        return dbase;
    }
    //
    //Get the static dbase which aids in the creating of the javascript dbase object 
    static async get_static_dbase(dbname) {
        //
        //Initialize the arguments that are required
        const name = dbname;
        //
        //fetch the static dbase from the php server file static_dbase.php
        let result = await fetch('static_dbase.php');
        //
        //The result are a text 
        let svg = await result.text;
        //
        //retun the static database which is the results 
        return svg;
    }
    //
    //obtain the database request from the url using location.search
    static database_request_found($request) {
        //
        //tests if the url contains the dbname
        if (typeof $request['dbname'] === 'undefined' || $request['dbname'] === null) {
            //
            return false;
        } else {
            //
            //set the database name from the request property
            let dbname = $request['dbname'];
            return dbname;
        }
    }
    //
    //Return the username if logged in; otherwise false. 
    static async user_is_logged_in() {

        //Fetch the 'name' session variable from the server
        let res = await fetch('var_session.php');

        //
        //user object is the recieved json with status and a user name
        let userobject = await res.json();
        //
        //return a username if the user is logged in and a false if the user is 
        //not logged in 
        return userobject.status ? userobject.username : false;
    }

    //Loading a page sets the viewbox property
    set_svg() {
        //Get the svg property  
        let svg = window.document.querySelector('svg');
        return svg;
    }

    //The view box property that controls panning and zooming.
    get viewbox() {
        //
        //If eh viewbox is empty, fill it from the svg
        if (viewbox_.length === 0) {
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
            viewbox_ = $split_strs.map($x => {
                return parseInt($x);
            });
        }
        //
        return viewbox_;
        ;
    }

    set viewbox($v) {
        viewbox_ = $v;
    }

    //zoom function. True direction means to zoom out
    zoom(dir = true) {
        //
        //get the third component of the viewbox which is the zoom
        let $zoom = this.viewbox[2];
        //
        //Set the direction to + r -
        let $sign = dir ? 1 : -1;
        //
        //Increase/decrease zoom by, say, 100
        $zoom = $zoom + $step * $sign;
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
    side_pan(dir = true) {

        //
        //Geet the first compnent of the viewbox array which is the side pan 
        let $span = this.viewbox[0];
        //
        //Set the direction to + r -
        let $sign = dir ? 1 : -1;
        //
        //Increase/decrease zoom by, say, 100
        $span = $span + $step * $sign;
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
    top_pan(dir = true) {
        //
        //Geet the second compnent of the viewbox array which is the top pan 
        let $span = this.viewbox[1];
        //
        //Set the direction to + r -
        let $sign = dir ? 1 : -1;
        //
        //Increase/decrease zoom by, say, 100
        $span = $span + $step * $sign;
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
    //
    //Select the given entity element
    select($entity) {
        //
        //Select all the entities with a selected class
        let $entities = document.querySelectorAll('ellipse');
        //
        //Remove the selected attribute from all the entities
        $entities.forEach($e => {
            $e.removeAttribute('selected');
        });
        //
        //Set the selected attribute to true
        $entity.setAttribute('selected', 'true');

    }

    //Review the database records for the selexted entity
    review_record() {
         }
    
    
    //Create a new record for the selected entity using a new window
    create_records() {
        //
        //Get the $name of the selected entity using the id
        let $tname = document.querySelector('[selected=true]').id;
        //
        //Open an empty brand new window
        let $win = window.open("page_create.php");
        //
        $win.onload = () => {
            //
            //Get the $body element of $win (window).
            let $body = $win.document.querySelector('form');
            //
            //looping through all the columns to create a label inputs
            for (let $cname in this.dbase.entities[$tname].columns) {

                //
                //Get the named column
                let $column = this.dbase.entities[$tname].columns[$cname];
                //
                //Append all the column as lables appended to the body of the new window 
                $column.display($body);

            };
        };

    }
    
    //
    //Alter the metadata (via comment) of the selected entity.
    entity_alter(entity=null){
        //
        //
        if (entity===null){
            //
            //Get the affected/selected entity that we want to alter. The altering 
            //an entity can only happen if there is a selected element 
            
            const selection = document.querySelector('[selected=true]');
            //
            //If no selected element send and alert the there must be a selected element 
            if(selection===null){
                alert('Select an element to do this operation');
                return;
            }  
            //
            //1. Get the selected entity's name
            const ename= selection.id; 
           //  
            entity = this.dbase.entities[ename];
        }
        
        //
        //Get the current comment for this entity 
        const comment= entity.comment;
        const ellipse = document.getElementById(`${entity.name}`);
        //
        //Update the comment coodinates to make them current
        comment.cx= parseInt( ellipse.getAttribute('newx'));
        comment.cy= parseInt( ellipse.getAttribute('newy'));
        //
        //The new dialogue should contain a form with three checkboxes reporting, 
        //administration, and visible ,  text input for title, the cx and the cy
        //and a save button
        //
        //Open a new window based on the foxed template, entity_view.php
        let win = window.open("entity_view.php","mywindow", "location=1,status=1,scrollbars=0,width=500,height=300,resizable=0");
         //IN FUTURE THINK ON HOW TO DO THE SAME TASK WITHOUT A TEMPLATE WINDOW
         //
         //On internet find out the diference between the window.open and the  window.openDialog
        win.onload =() => {
//          //
            //Set the name of the entity 
            win.document.querySelector(`[name='ename']`).value=entity.name;
            //
            //Get the key value pairs in the comment to assigned values on the 
            //input tags
            //
            //loop through the comment key values pairs and append their value to
            //new window input tags
            for(let key in entity.comment){
                //
                //
                const value = entity.comment[key];
                //
                //Get the named element
                const elem = win.document.querySelector(`[name='${key}']`);
                //
                //If boolean the value should be checked 
                if (typeof value === "boolean"){
                   //
                   //Set the checked attribute to true 
                   elem.setAttribute("checked", value);
                 }else{
                    //
                    //Use the value to fill the window
                    elem.value= value;
                }
            }
            //
            //Add an event listener to the save to enable the save button to enable a save
            //
            //get the save button 
            const save=win.document.getElementById('save');
            //
            //Add a click event listener for saving
            save.addEventListener('click',async()=>{
                //
                //Get all the inputs
                const inputs = win.document.querySelectorAll('input');
                //
                //map the array and only return the name and the value as key value pairs 
                 for(let i=0; i<inputs.length; i++){
                     let input = inputs[i];
                    //
                    //if the input is a textbox return the checked attribute value as the input
                    if (input.type === "checkbox"){
                       input.value=input.checked;
                    }
                    //
                    //Get the comment property name
                    let key= input.name;
                    //
                    //update the comment property 
                   comment[key]= input.value;
                }
                    //
                //This comment can either be saves in the database or at the windows local storage 
                //for now we save in this entity comment 
                //
                //
                //encode the entire comment to make it a json format 
                const comment_str = JSON.stringify(comment);
                //
                //Save the newly updated  comment to the database as a comment  
                //
                //Generate the sql for the alter command 
                const sql = "ALTER TABLE "
                //
                //The name of the table to be altered is the name of the coodinate 
                +`${entity.name} `
                // 
                //Update the comment to now fit the the new view of reporting 
                + "COMMENT "
                    //
                    //The cooment information has to be in a json format ie'{"cx":5500,"cy":3300,......}'
                +`'${comment_str}'`;
                //Execute the sql in the server side 
                await mutall.fetch('database', 'query', {sql});
                //
                //Close the window
                 win.close();
            });
            //
            //get the cancel bu tton 
            const cancel=win.document.getElementById('cancel');
            //
            //Close the  window 
            cancel.addEventListener('click', ()=>{win.close();});
        };    
    }
    
    //
    //Updates the comment with the respective updates
    save_comment(pg, report, adm, visible, title){
        //
        //1. Save reporting
        //Add an event listener that saves the property 
        report.addEventListener( 'change', function() {
            if(this.checked) {
                  // Checkbox is checked..
                  pg.save_reporting();
            } else {
            // Checkbox is not checked..
            }
         });
       //
       //2.0 save administration
       adm.addEventListener( 'change', function() {
            if(this.checked) {
                  // Checkbox is checked..
                  pg.save_administation();
            } else {
            // Checkbox is not checked..
            }
         });
       //
       //3. save visible 
       visible.addEventListener( 'change', function() {
            if(this.checked) {
                  // Checkbox is checked..
                  pg.save_visible();
            } else {
            // Checkbox is not checked..
            }
         });
       //
       //4.0 save the title which
       title.addEventListener( 'input', function() {
            if(this.checked) {
                  // Checkbox is checked..
                  pg.save_title(this.value);
            } else {
            // Checkbox is not checked..
            }
         });
    }

    //Open a new database...
    open_dbase() {
        //
        //Create html select tag and append it to the 'open database' menu to display
        // all the database names that are available for openning 
        const selector = document.createElement("select");
        //
        //Fetch all the database names that are available at the local host.
        //
        //specify the query to retrueve teh databanse names 
        const sql = "select schema_name as dbname "
            //
            //The database names are at the table schemata in the information schema
            +"from schemata ";
            //
            //Only the user database names can be retieved using for opening  
            +"where not(schema_name in ('MYSQL', 'PERFORMANCE_SCHEMA', 'phpmyadmin')) ";
         //
         //The database to query isnthe information schema
         const name = "mysql:host=localhost;dbname=information_schema";
         //
         //The log in credentials are also required
         const username= `mutallco`;
         const password = `mutall_2015`;
         //
        // Fetch the database names 
         const myfetch = async ()=>{
            //The mutall class requires a class, method and the database login credentials
             const dbnames = await mutall.fetch('database', 'get_sql_data', {name, username, password, sql});             
             //
            //Append all fetched the database names to the selector 
            dbnames.forEach($dbname => {
                 let dbasename = $dbname.dbname;
                 //
                 //Createan option using the $dbname
                 let  $option = document.createElement('option');
                 //
                 //Set the text content as the dbase name 
                 $option.textContent = dbasename;
                 //
                 //Append the child option to the selector
                 selector.appendChild($option);
                });
            //
            //Add an onchange eventlistner to the select to enable openning and 
            //setting of the dbase using the selected database name. 
            selector.addEventListener('change', async() => {
                //
                //Retrieve the selected option
                let sel = document.querySelector('select');
                this.dbname = sel.options[sel.selectedIndex].text;
                //
                //Get the static database which is the php version of the database
                //this is to activate the library.js           
                this.dbase = await this.get_dbase();
                //
                //get the svg inner html from the javascript library 
                let $svg = this.dbase.present();
                //
                //Get the svg element from the home page 
                let $content = document.getElementById("svg");
                //
                $content.innerHTML = $svg.innerHTML;
                //
                //change the text content of the view database to close database
                //get the close dbase button 
                let close = document.getElementById('close_dbase');
                close.removeAttribute('hidden');
                close.textContent = 'close' + this.dbname;
            });
            //
            //Append the select to the div content 
            document.getElementById("select").append(selector);
        };
        //
        myfetch();
        
    }
    
    //Removes the property of selected from all the entities to all the ellipses in the dome
    remove_selected(){
        //
        //Get all the ellipses from the dome 
        const collection =document.querySelectorAll('ellipse');
        console.log(collection);
        //
        //loop through the collection and remove the attribute of selected 
        collection.forEach($e=>{
            console.log($e);
            //
            //Remove the attribute of selected
            $e.removeAttribute('selected');
        });
    }
    //
    //displays a list of hidden element that are part of this database and upon select 
    //sets the invisible comment to false and the element becomes visible 
     show_element(){
         //
         //Get all the entities with the invisible attribute 
         //
         //Get all the entities 
         const entities = this.dbase.entities;
         //
         //filter entities and remain with only those with a hidden attribute at the comment
         //
         //declare an empty array to store the hidden entities
         const  hidden_entities= [];
         //
         //loop through the entities and pust only those with hidden attribute into the array 
         for (let [key, value] of Object.entries(entities)) {
           //Get the comment in this entity 
            const visible = value.comment.visible;
            //
            //If the visible true push the entity into the array 
             if (visible==='true'){
                 //
                 //push the entity into the array 
                 hidden_entities.push([key]);
            } 
         }
         //
         //Add to the hidden entities the entities that were temporarily hidden 
         //these are those that have the css hidden attribute set to true 
          //Get all the ellipses
        const ellipses= document.querySelectorAll('ellipse');
        //
        //loop through each ellipse inorder to push all those with a hidden 
        //attribute into the array
        for(let i=0; i<ellipses.length; i++){
            //
            //Get the ith ellipse
            const ellipse= ellipses[i];
            //
            //Get the hidden attributes
            const hidden =ellipse.getAttribute('hidden'); 
            //
            //If true push the name into the hidden entities 
            if (hidden ==='true'){
                hidden_entities.push(ellipse.getAttribute('id'));
                console.log('true');
            }
        }
        //
        //Create a select list
        const select= document.createElement('select');
        //
        //loop through the hidden names creating an option for each and appending each to the  select
        hidden_entities.forEach(name=>{
            //
            //Create an option 
            let option = document.createElement('option');
            //
            //Set the text content of the option this name 
            option.textContent=`${name}`;
            //
            //Append the option to the select 
            select.appendChild(option);
        });
         //
         //Get the navigator of the page graph 
         const selector = document.getElementById('hidden_entities');
         //
         //Append the select to the navigator of the page_graph
         selector.appendChild(select);
            //
            //Add an onchange event listener to the select 
             select.addEventListener('change', async show => { 
                 //
                //Retrieve the selected option
                let sel = document.querySelector('select');
                let ename = sel.options[sel.selectedIndex].text;
                //
                //Get the comment of te selected element 
                this.comment= this.dbase.entities[ename].comment;
                //
                //change the visible property to false and update the database 
                this.comment.visible=false;
                //
                //get the svg inner html from the javascript library 
                let $svg = this.dbase.present(this.comment);
                //
                //Get the svg element from the home page 
                let $content = document.getElementById("svg");
                //
                $content.innerHTML = $svg.innerHTML;
                
                 //
                 //Save the current coodinates of the entity 
                 this.save_structure();
                 //
                });
         
      }
    //
    //This methord creates an array consisting of objects where the coordinates
    //of various ellipses are saved for further altering of the database structure 
       async save_structure() {
        //
        //Get all the new coordinates of the entities
        const coordinates = this.get_coordinates();
        //
        //formulate sql alter comand statements to save the structure 
        const sqls = coordinates.map(coordinate=>{
            const {name, cx, cy} = coordinate;
            //
            //Fomulate teh alter command
            const alter = this.get_alter(name, cx, cy);
            return  alter;
        });
        //
        const jsonstr = JSON.stringify(sqls);
        
        //Set the database credentials 
        //1. name
         name= this.dbname;
        //
        //Save the corrdinates to the database
        const text=await mutall.fetch('database', 'update_entity_coordinates', {sqls:jsonstr});
    }
     //
     //return the alter command that can modify the comment to save the new coodinates
     get_alter(name, cx, cy){
        //
        //Get the existing entity comment 
        const comment= this.dbase.entities[name].comment;
        //
        //Add coodinates to the comment if they do not exist or update the existing ones
        //
        //update the coodinates of this entity 
        comment.cx= cx;
        comment.cy= cy;                
        //
        //Stringify the comment
        const comment_str = JSON.stringify(comment); 
        //
        //Hint: Use the alter command to update the comment 
        const alter = "ALTER TABLE "
            //
            //The name of the table to be altered is the name of the coodinate 
            +`${name} `
            // 
             //Change the comment of the table to new coodinates since it is from where 
                //coordinates are saved in the database
            + "COMMENT "
                //
                //The coodinates updates must be in json format i.e '{"cx":5500,"cy":3300}'
            +`'${comment_str}'`;
     return alter;
     }
     
    //Returns all the coordinates of the entities of the current database
    get_coordinates(){
        //
        //Let coordinates be an empty array where we will save all the coodinates
        //of the ellipses for saving 
        const coordinates = [];
        //
        //Get the collection of all the entities represented by the ellipses   
        const ellipses = document.querySelectorAll('ellipse');
        //
        //Loop through the collection of the ellpses to obtain the new coodinates of each 
        ellipses.forEach($e => {
            //
            //this is the object to which we save the coodinates 
            const coordinate = {};
            //
            //Get the name of the entity
            coordinate.name =$e.getAttribute('id');
            // 
            // Test if the entity has saved its new coodinates
            // 
            //1.Does not contains the new coodinates save the previous old coodinates
            if (parseInt($e.getAttribute('newx'))===0){
               //
               //set the coodinate 
               coordinate.cx= $e.getAttribute('cx');
               coordinate.cy= $e.getAttribute('cy');
               //
                //Collect the x and y coordinates of the  ellipses into an array
                //Push the coodinate to the array 
                coordinates.push(coordinate);
            }
            //
            // New coordinates have been saved 
            else {
               coordinate.cx = parseInt($e.getAttribute('newx'));
               coordinate.cy = parseInt($e.getAttribute('newy'));
               //  
               //
                //Collect the x and y coordinates of the  ellipses into an array
                //Push the coodinate to the array 
                coordinates.push(coordinate);
            }
            //
            //Collect the x and y coordinates of the  ellipses into an array
            //Push the coodinate to the array 
            coordinates.push(coordinate);
        });
        //
        return coordinates;
    }

    //
    //on click we close the database 
    close_dbase() {
        //
        //Get the content element tag that contains the database graph
        let content = document.querySelector('#content');
        //
        //Set its inner html to nothing 
        content.innerHTML = "";
        //
        //Get the close database button and hide it 
        let button = document.querySelector('#close_dbase');
        button.setAttribute('hidden', true);
        //
        //show the open database button 
        let open = document.getElementById('open_dbase');
        open.removeAttribute('hidden');
    }

    //
    //hide the logout button; show the login button  
    async loggingout() {
        //
        //end session in php
        let res = await fetch('end session.php');
        //
        //the promise contains the logout message 
        let data = await res.text();
        //
        //Write the output message on the window 
        alert(data);
        //
        //hide the logout button 
        let logout = document.getElementById('logout');
        logout.setAttribute('hidden', true);
        //
        //Hide the view database
        let view = document.getElementById('open_dbase');
        view.setAttribute('hidden', true);
        //
        //show the login button 
        let login = document.getElementById('login');
        login.removeAttribute('hidden');
        login.textContent = 'please login to acces our services';
        login.onclick = () => {
            //
            //Open the login window
            let win = window.open("page_login.php");
            //
            win.onbeforeunload = () => {
                // 
                //Hide the login button
                login.setAttribute('hidden', true);
                //
                //remove the hidden attribute fron logout
                logout.removeAttribute('hidden');
                logout.textContent = win.username + ' logout';
                //
                //show the view database button
                let view = document.getElementById('open_dbase');
                view.removeAttribute('hidden');
                view.textContent = ('view the database');
            };
        };
        //
        //Get the content element tag that contains the database graph
        let content = document.querySelector('#content');
        //
        //Set its inner html to nothing 
        content.innerHTML = "";
        //
        //Get the close database button and hide it 
        let button = document.querySelector('#close_dbase');
        button.setAttribute('hidden', true);
    }
    //NOTE ASK IF THIS SHOULD BE DONE AT THE DATABASE LEVEL 
    //
    //Creates diferent database views on the window local storage to enable the
    // users have diferent specialized database graph 
    database_view(){
        
        
    }
    //
    //opens a new window with all the properties of a column and allows users 
    //to edit the changes 
    alter_column(){
        //
        //Get the selected element which is an ellipse and a text tspan
        const selected = document.querySelectorAll('[selected=true]');
        console.log(selected);
        //
        //loop to obtain the column name and the entity name
        for(let i=0; i<selected.length; i++){
            const element= selected[i];
            //
            //Get the entity name where the column belongs
            if (element==="ellipse"){
               const entity_name= element.id; 
            }
            //
            //Get the column name 
            if (element==="tspan"){
               const column_name= element.textContent; 
            }
        }
        //
        //Get the column 
        const column = this.dbase.entities[entity_name].columns[column_name];
        //
        //Open a new window
        //
        //Onload create inputs with the column  datatype, name , title and show if indexed 
        //
        //before unload save the input data 
        
    }
    //
    //Sets the attribute hidden to true to the selected element to hide its visibility 
    hide_element(evt) {
        //
        //Get the selected elements name which is its id.
        const element = document.querySelector('[selected=true]').id;
        //
        //Get the selected group containing the text and the attributes t spans 
        const group = document.getElementById(`${element}_group`);
        //
        //Set attribute hidden to the selected element to true 
        group.setAttribute('hidden', true);
        //
        //Hide any circle that reference this entity
        if (document.getElementById(`ref_${element}`)===null || document.getElementById(`ref_${element}`)===undefined){
            //
            //do nothing
        }
        else{
            let circle = document.getElementById(`ref_${element}`);
            //
            //hide the circle
            circle.setAttribute('hidden', true);  
            //
        }
        //Get all the relation inorder to hide all the relation related with the 
        //selected element 
        const relations = document.querySelectorAll('line');
        //
        //loop through all the lines 
        relations.forEach($e => {
            //
            //Get the id
            let line_name = $e.getAttribute('id');
            //
            //Split the line names to obtain the entities linked by the line 
            let e_name = line_name.split('to');
            //
            //Test if the relation starts from the selected element
            if (e_name[0] === element) {
                //
                //Set the hidden attribute to true 
                $e.setAttribute('hidden', true);
                //
                //Test if there is a circle referencing this relation
                if (document.getElementById(`ref_${e_name[1]}`)===null || document.getElementById(`ref_${e_name[1]}`)===undefined){
                    //
                    //do nothing
                }
                //
                //Hide any circle that reference the relation 
                else{
                    let circle = document.getElementById(`ref_${e_name[1]}`);
                    //
                    //hide the circle
                    circle.setAttribute('hidden', true);
               }
            }
            //
            //Test if the relation ends at the selected element 
            else if (e_name[1] === element) {
                //
                //Set the hidden attribute to true 
                $e.setAttribute('hidden', true);
                //Test if there is a circle referencing this relation
                if (document.getElementById(`ref_${e_name[0]}`)===null || document.getElementById(`ref_${e_name[0]}`)===undefined){
                    //
                    //do nothing
                }
                //
                //Hide any circle that reference the relation 
                else{
                    let circle = document.getElementById(`ref_${e_name[0]}`);
                    //
                    //hide the circle
                    circle.setAttribute('hidden', true);
               } 
            }
        });
       //
       //save the visible property at the database 
       //this.save_visible();
    }
    
}

