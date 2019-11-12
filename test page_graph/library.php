<?php
//Start the session, so that we can access the sesion variables - if we have not 
//started yet.
//To support the login process
session_start();
//
//For debugging purposes only. To be removed in the production version
$_SESSION['username']='mutallco';
$_SESSION['password']='mutall_2015';

//This super  class is a trait because php classes cannot extent more than one class
trait mutall{
    //
    //??????????
    static function index(){
        //
        //Test if the class name is provided by the user. If not, re-direct to the
        //default home page.
        if (!isset($_REQUEST['class'])){
            //
            //Class name not provided. Go to the default home page
            //Get the http that referered to this page
            $referer = $_SERVER['HTTP_REFERER'];
            //
            //Extract the url path
            $path = parse_url($referer, PHP_URL_PATH);
            //
            //Retrieve the directory
            $dir = pathinfo($path, PATHINFO_DIRNAME);
            //
            //Retrieve the basename,
            $basename = pathinfo($dir, PATHINFO_BASENAME);      
            //
            //The complete website directory 
            $location = "../$basename/$basename.php";
            //
            //Re-direct to the home page. (Note. Make sure tat there is no echoing
            //before a header is sent!!)
            header("Location: $location");
            exit();
        }
        //
        //The class was providec by the user. The method must also be provided; 
        //otherwise we report an error
        // 
        //Retrieve and set the classname from the url 
         $class=$_REQUEST['class'];
        //
        //Test if there is a method set 
        if(!isset($_REQUEST['method'])){
            //
            //METHOD NOT KNOWN 
            //
            //Die and throw an exception that a method must be set 
            throw new Exception('The method of the class to execute must be set');
        }
        //
        //METHOD KNOWN 
        //Retrieve and set the method from the query string 
        $method= $_REQUEST['method'];
        //
        //Determine if the desired method is static or not. By default it is dynanic,
        //i.e., not static
        if (isset($_REQUEST['static']) && $_REQUEST['static']){
            //
            //Execute the methord whose result is obtained as the html. 
            $result = $class::$method();
        }
        else{
            //
            //Create an object of the class on assumption that the class is not static 
            $obj= new $class();
            //
            //Execute the methord whose result is obtained as the html. 
            $result = $obj->$method();
        }
        //
        //This is the Expected result from the calling method
        return $result;
    }
    
    //
    function try_bind_arg($str, &$value){
        //
        //
        if (is_null($value)){
            //
            //Get the name fromthe server global variables
            
            //Initialy the database name is null unless provided by the user at the query string 
            if (isset($_REQUEST[$str])){
                //
                //Retrieve the name value
                $value= $_REQUEST[$str];
            }
            else{
                return false;
            }
        }
        
        //Set the named propertey to the argument value
        $this->$str = $value;
        //
        return true;
    }
    
    //
    function bind_arg($name, &$arg){
        //
        if (!$this->try_bind_arg( $name, $arg)){
            throw new Exception("Argument $name is not known");
        }
    }
    
    //Report exceptions in a more friendly fashion
    static function get_error($ex) {
        //
        //Replace the hash with a line break in teh terace message
        $trace = str_replace("#", "<br/>", $ex->getTraceAsString());
        //
        //Retirn the full message
        return $ex->getMessage() . "<br/>$trace";
    }
    
}

//This class models/represents a database
class database extends PDO{
    //Define the public properties name, size, zoom  of the database to present
    //passed by the constroctor 
    public $name;
    public $size;
    public $zoom;
    public $pan_right;
    public $pan_top;
    //
    //An array of entties
    public $entities=[];
    //
    use mutall;
    //
    //This class can create an object with or without the dbase name since. 
    function __construct($name=null){
        //
        //Get the arguments required from the Query string or the url
        $this->try_bind_arg('name', $name);
        //
        // Open a $database
        //
        // Specify the database login credentials, e.g. $name, $username, $password
        $schema_name = "mysql:host=localhost;dbname=information_schema";
        //
        //Assuming that the user is logged in .....
        //throw an exeption if the username is not set 
        if(!isset($_SESSION['username'])){
            throw new Exception("Error the log in credential USERNAME must be set"); 
        }
        else{
           //
           //GET THE USER NAME FORM THE SESSION KEYS
           $username = $_SESSION['username'];
        }          
        //Throw an exception if the password is not set
        if(!isset($_SESSION['password'])){
            throw new Exception("Error the log in credentials PASSWORD must be set"); 
        }else{
            //
            //GET THE PASSWORD FROM THE SESSION KEYS 
           $password=$_SESSION['password'];
        
        }
        //1.2 Inheriting from the parent PDO
       parent::__construct($schema_name, $username, $password);
        //
        //1.3 Please report any datbase error
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //
        //Fill this database entities from table comments
        if (!is_null($this->name)){
            $this->entities = $this->get_entities();
        }    
        //
    }
    
    //Offload the properties from the source to the destination
    static function offload_properties($dest, $src){
        //
        // throuhg all the proprties of the source and each property to the
        //destination if it does not exist
        foreach($src as $key=>$value){
            //
            if (!isset($dest->$key)){
                $dest->$key = $value;
            }
            
        }
        return $dest;
    }
    //
   //Return all the entities of this database by querying the information schema
    function get_entities(){
        //
        //Start with a empty list of entities
        $entities = [];
        //
        //Let $sql be the statement for for retrieving the entities of this
        //database.
        $sql = "select "
            //    
            . "table_name as name, "
            //    
            . "table_comment as comment "
        . "from "
            . "tables "
        . "where "
            . "table_schema = '$this->name' "
            //
            //Exclude the views
            . "and table_type = 'BASE TABLE'";
        //
        //Execute the $sql on the the schema to get the $result
        $result = $this->query($sql);
        //
        //Retrueve the entires from the $result as an array
        $array = $result->fetchAll(PDO::FETCH_ASSOC);
        //
        //Display the $result by looping throuh the array to presebt each entity
        foreach($array as $row){
            //
            //Get the name of the entity; its the sane as that of the table.
            $name = $row['name'];
            //
            //Get the comment (json) string
            $comment_str = $row['comment'];
            //
            //Test if the comment is empty make it an empty json 
            if (empty($comment_str)){
                $comment_str= '{}';
            }
            //
            //Decode the comment json string to a php (stdClass) object
            $comment = json_decode($comment_str);
            //
            //Throw an error message in case $comment is not in the json format
            if (!$comment){
                throw new Exception("Error in entity $name. Invalid json :$comment_str"); 
            }
            //
            //Create a new entity passing the name, parent and the partially 
            //complete raw comment
            $entity = new entity($name, $this,$comment );
            //
            //Push the entity object to the array to be returned
            $entities[$name] = $entity;
        }
        //
        //Return the entity list.
        return $entities;
    }
    //
    //Displaying the entities and relation in form of ellipses and lines 
    function present($size,$zoom,$pan_right,$pan_top){
        //
        //For beburging before i start using the index file 
        $this->size=1200;
        $this->zoom=4200;
        $this->pan_top =0;
        $this->pan_right =0;
        //
        //set the random seed
        srand(0);
        //
        //Set the arguments as properties of the database 
//        $this->bind_arg('size', $size);
//        $this->bind_arg('zoom', $zoom);
//        $this->bind_arg('span_right', $pan_right);
//        $this->bind_arg('pan_top', $pan_top);
        //
        //
        //Open an svg tag
        echo "<svg "
            // the specified size will the value of the heigh and the width 
            . "height = '$size' "
                //
               // adding an onload listener to enable the drag and drop of the elements 
            . "width='$size'"
             // this is the view box properties the span and the zoom  
            . "viewbox= '$pan_right $pan_top $zoom $zoom'"
            . ">";
        //
        //Set the presenttaion properties, i.e., cx, cy and color of all the 
        //entities
        foreach($this->entities as $entity){
            $entity->cx = $entity->get_cx();
            $entity->cy = $entity->get_cy();
            $entity->color=$entity->get_color();
        }
        //
        //Present the entities
        foreach($this->entities as $entity){
            $entity->present();
        }    
        //
        //close the svg tag
        echo "</svg>";
    } 
    //
    //Returns a jason string if this database structure 
    function __toString() {
        //
        //Encoding the database structure to a json as a $jdbase(json dbase)
        $jdbase= json_encode($this);
        //
        //Throw an exception if $jbase was not properly encoded
        if(!$jdbase){
            return "Error in json encoding a database"; 
        }
        //
        //Return the string json vertion of the database structure
        return $jdbase;
    }
    //
    //Returns this database's structure 
    function export_structure(){
        //
        //Return this structure 
        return   $this;
    }
}

//Class that represents an entity
class entity{
    //
    //Name of the entity and the coodinates of the entity
    public $name;
    public $cy;
    public $cx;
    public $color;
    //
    //The json user information retrieved from the comment after it was decoded  
    public $comment;
    //
    //the parent class database protected to avoid recursion in json.
    protected $dbase;
    //
    //Defining the instance of a child class column that feed the entity with more 
    //properties popilated by the function get column()
    public $columns=[];
    //
    //Defining the array $induces that is used to store the indexed columns 
    //from the function get_induces 
    public $indices=[];
    //
    //Inherit the mutall traits
    use mutall;
    //
    // The entity constructor requires a) the entity name b) the parent database
    // and c) the partially complete comment as a json text. 
    function __construct($name, database $parent, $comment){
        //
        //initialize the name, parent database, json comment,column list in 
        //array format and the ccodinates the cx and the cy.
        $this->name = $name;
        $this->dbase= $parent;
        $this->comment = $comment;
        //
        //Set the the columms property from the informaton schema. The columns
        //will be either primary or not.
        $this->columns = $this->get_columns();
        //
        //Update the relevent ordinary columns to foreign columns using the 
        //referential constraits as guided by the key uage table.
        $this->update_columns();
        //
        //Add the indentification indices
        $this->indices = $this->get_indices();
    }
    //
    //Return the dbase property to a public access modification  
    function __get($name){
        switch($name){
            case 'dbase': return $this->dbase;
            default:throw new Exception("Unusual! Property $name not found.");    
        }
    }
    //
    //Sets cx coordinate of this entity. 
    function get_cx(){
        //
        //Returns a random value of coordinate cx is not set by the user 
        if(!isset($this->comment->cx)){
          $cx=rand(0, $this->dbase->size);
        }else{
           $cx=  $this->comment->cx; 
        }
        
        return $cx;
    }
    //
    //The function that assigns the cy coodinate
    function get_cy(){
        
        //Returns a random value of the cy if not set by user(randomly set)
        if(!isset($this->comment->cy)){
            $cy=rand(0, $this->dbase->size);
        } else {
          $cy= $this->comment->cy;  
        }
        return $cy;
    }
    //
    //Compute and return the color of this entity. 
    function get_color(){
       //
       $color = 'yellow';
       //
       //Test if this entity has any properties by pushing properties into an array
       $array = get_object_vars($this);
       //
       //counting all the components in the array
       $count = count($array);
       //
       //Return red for a new entity, i..e, one where this entity has no 
       //properties
       if ($count<2){
           $color = 'red';
       }
       //
       //Return the computer color
       return $color;
   }
    //
    //Returns the entity to be presented as boolean of true or false
    function visible(){
       if(isset($this->comment->remove)){
           return FALSE;
       } else {
            return TRUE; 
       }  
   }
    //
    //Returns the columns of this entity from the information schema 
    function get_columns(){
        //
        //Start with an empty list of columns
         $columns = [];
         //
        //Select the columns of this entity from the database's information schema
        $sql = "select "
            //
            //Shorten the column name
            . "column_name as name, "
            //
            //Specifying the type of data in that column
            . "data_type, "
             //
            //The column key so as to identify the primary keys
            . "column_key as `key`, "
              //
            //Extract any meta data json information in the comments
            . "column_comment as comment "
        . "from "
            //
            //The main driver of this query
            . "`columns` "
        . "where "
            //    
            // The table schema is the name of the database
            . "table_schema = '{$this->dbase->name}' "
            //
            //specifying the exact table to get the column from
            . "and table_name = '{$this->name}'";
        //
        //2. Execute the $sql on columns to get the $result
        $result = $this->dbase->query($sql);
        //
        //put the data in an $array
        $array = $result->fetchAll(PDO::FETCH_ASSOC);
        //
        //Loop throuh each row of the array to create a new column for each row
        //as a stdClass object
        foreach($array as $row){
            //
            //Name of the column
            $name = $row['name'];
            //
            //Create a new column and assign it a name
            $column = $this->create_new_column($name, $row);
            //
            //Add the column to the array to be returned
            $columns[$name]= $column; 
        }
        //        
         return $columns;        
     }
     //
     //Returns the columns as either ordinary or primary 
     function create_new_column($name,$row) {
        //
        // Return the column as primary if its key is set to PRI
         if (isset($row['key'])&& $row['key']=='PRI'){
             //
             //Createa primary key column
             $column= new column_primary($name, $this);
         }
         //
         //Create an ordinary column 
        else {
            $column=new column_attribute($name, $this);
        }
        //
        //Offload the remaining properties from $row
        database::offload_properties($column, $row);
        //
        //Remove the key property from the column
        unset($column->key);
        //
        //
        //Return the created column
        return $column;
     }
    
    //Update some ordinary columns to foreign columns base on the key column 
    //usage table
    function update_columns(){
        //
        //Set sql statement for selecting all foreign key columns of this table 
        //and database
        $sql = "select "
            //
            //Shorten the column name
            . "column_name as name, "
            //
            //Specify the referenced table
            . "referenced_table_name as tname "
        . "from "
            //
            //The main driver of this query
            . "key_column_usage "
        . "where "
            //    
            // The table schema is the name of the database
            . "referenced_table_schema = '{$this->dbase->name}' "
            //
            //specifying the exact table to get the column from
            . "and table_name = '{$this->name}'";
            
        //
        //Execute the $sql on columns to get the $result
        $result = $this->dbase->query($sql);
        //
        //Put the resulting data in an $array
        $array = $result->fetchAll(PDO::FETCH_ASSOC);
        //
        //looping through the result to compare the row name 
        foreach ($array as $row){
            //
            //The foreign key column name
            $name = $row['name'];
            //
            //Get the matching column from this entity
            $match= $this->columns[$name];
            //
            //Create a foreign key colum using the same name
            $foreign = new column_foreign($name, $this, $row['tname']);
            //
            //Offload all properties of the ordinary column to the foreign key 
            //version
            database::offload_properties($foreign, $match);
            //
            //Set the foreign key.
            $this->columns[$name] = $foreign;
           }
           
    }
    //
    //Get the indexwd column and return then in an array 
    function get_indices(){
        //
        //Initialize an empty array indices to store the index columns
        $indices=[];
        //
        //let sql be the select query that obtains the indexed columns 
        //from the table statistics
        $sql = "select "
            //
            //Shorten the column name
            . "column_name as cname, "
            //
            //specify the index name e.g id
            . "index_name as xname "
        . "from "
            //
            //The main driver of this query
            . "statistics "
        . "where "
            //    
            // The table schema is the name of the database
            . "index_schema = '{$this->dbase->name}' "
            //
            //specifying the exact table to get the column from
            . "and table_name = '{$this->name}'"
               // 
                //Only get the index id e.g. id2
            . "and index_name like 'id%'";   
        //
        //Execute the $sql on the schema to get the $result
        $result = $this->dbase->query($sql);
        //
        //Retrieve columns from the $result as an array
        $array = $result->fetchAll(PDO::FETCH_ASSOC);
        //
        //loop through each row to get the indexed columns of type id 
        foreach($array as $row){
            //
            //Get the column name of the indexed columns.
            $cname = $row['cname'];  
            //
            //Get the index name of the column 
            $xname =$row['xname'];
            //
            //storing the index in an array 
            $indixed_column[$xname][]=$cname;
            //
            //Pushn the two in a double array 
            $indices=$indixed_column;

        }
        return $indices;
    }
        
    //
    //Present this entity as an elipse
    function present(){
        //
        //Show this entity only if it is not ignored.
        if ($this->visible()){
            //
            //
            //Draw the elipse to represent the entity
            echo "<g>"
            . "<ellipse " 
                ."cx='$this->cx'" 
                ."cy='$this->cy'" 
                ."rx='150'" 
                ."ry='50'"
                ."style='fill:$this->color'" 
                ."id='$this->name'"
                .'onclick="$page_graph.select(this)"'
                . 'class="draggable"'
            ."/>"
                
            . " <text " 
                     ."x='$this->cx'" 
                     ."y='$this->cy'"
                     ."text-anchor='middle'"    
                     ."fill='white'>$this->name"
                ."</text>"
           ."<g>"; 
            //
            //Draw the ;ines to represent the relations starting from this entity
            foreach($this->columns as $column){
                $column->present_relation();
            }      
        }
        
    }
    
}
//
// Class column that popilates all the entity column from the database information 
//schema table column of a given table name it is an abstract class hence no bjects can be made from it 
abstract class column {
    //
    //Define the parent entity class of the column
    protected $entity;
    //
    //Every column should have a name 
    public $name;
    //
    //Inherit the mutall traits
    use mutall;
    //
    //The class constructor
    function __construct($name, $type, entity $parent) {
        $this->entity=$parent; 
        $this->type=$type;
        $this->name = $name;
    }
    
    //By default, show nothing as a relation for an ordinary column.
    function present_relation(){
        //
    }
}
//
// This is the class that contains all the columns that are primary indexed keys 
//as obtained from the query 
class column_primary extends column{
    //
    //The class constructor 
    function __construct($name, entity $parent) {
        //
        parent::__construct($name, "primary", $parent);
    }
}
//
//Template for the second type of column called columns attribute
class column_attribute extends column{
    //
    //contains all the columns of type attribute 
     function __construct($name, entity $parent) {
         //
         //The parent constructor
         parent::__construct($name, "attribute", $parent);
     }
}
//
//This is the class that has all the columns which are pointers to other entities 
class column_foreign extends column{
    //
    //the name of the referenced table 
    public $ref_table_name;
    //
    //The class constructor
    function __construct($name, entity $parent,$table_name) {
        //
        //The parent constructor 
        parent::__construct($name, "foreign", $parent);
        //
        //Initializing the variables in the constructor
        $this->ref_table_name=$table_name;
        $this->name=$name;
    }
    //
    //Relation are presented by using this entity as the start entity and the 
    //ref_table_name as the name of the end entity  
    function present_relation(){
       //
       //Relations require a start and an end
       //
       //Let the start be this entity
       $start = $this->entity;
       //
       //Get the global dbase
       $dbase = $this->entity->dbase;
       //
       //Let the end be the entity named by the reference_table_name 
       $end = $dbase->entities[$this->ref_table_name];
        //
        //Display the relations inform of a line 
        echo "
            <line
                x1='$start->cx'
                y1='$start->cy'
                x2='$end->cx'
                y2='$end->cy'
                style ='fill: yellow'
                id='$start->name to $end->name'
                stroke:black;
                stroke-width:3;
            />";         
    }
}

//

