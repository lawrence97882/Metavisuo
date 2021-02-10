import { Injectable } from '@angular/core';
import { TestBed } from '@angular/core/testing';
import * as library from "../models/library";

@Injectable({
  providedIn: 'root'
})
export class ServerService {

  constructor() { }
  //
    //Simplifies the windows equivalent fetch method with the following 
    //behaviour.
    //If the fetch was successful, we return the result; otherwise the fetch 
    //fails with an exception.
    //partcular static methods are specifed static:true....
    //It returns the same as result as the method  in php 
   async  exec<
    // 
    //Get the type that represents...
    //...classes in the library namespace, organised as an object, e.g.,
    //{database:object, record:object, node:object }
    classes extends typeof library,
    //
    //...the classname as string inorder to comply with the formdata.append parameters i.e.,
    //string|blob
    class_name extends Extract<keyof classes, string>,
    //
    //...A class in the library namespace, e.g.,
    //class node { 
    //  export: (..args: any)=> any,
    //  prototype: new (...args:any)=>any
    //}
    $class extends classes[class_name],
    // 
    //... the constructor parameters without using the predefined construction parameter.
    //cargs extends $class extends new (...args: infer c) => any ? c : never,
    cargs extends ConstructorParameters<$class>,
    //
    //...The  instance type of the constructor directly without using the predefined construction
    //instance extends $class extends new (...args: any) => infer r ? r : never,
    instance extends InstanceType<$class>,
    // 
    //...The object method name.
    method_name extends keyof instance,
    // 
    //...The object method
    method extends instance[method_name], //extends { (...args: any): any } ? instance[method_name] : never,
    // 
    //....the method arguments 
    margs extends method extends { (...args: infer p): any } ? p : never,
    // 
    //...The return type 
    $return extends ReturnType<method>,
>(
    //
    //The class of the php class to execute.
     class_name: class_name,
     //
     cargs:cargs,
     //
     method_name:method_name,
     //
     margs:margs    
    ):Promise<$return>{
        //
        //Prepare to collect the data to send to the server
        const formdata = new FormData();
        //
        //Add to the form, the class to create objets on the server
        formdata.append('class', class_name);
        //
        //Add the class constructor arguments
        formdata.append('cargs', JSON.stringify(cargs));
        //
        //Add the method to execute on the class
        formdata.append('method', method_name);
        //
        //Add the method parameters 
        formdata.append('margs', JSON.stringify(margs));
        //
        //Prepare  to fetch using a post
        const init = {
            method:'post',
            body:formdata
        };        
        //
        //Fetch and wait for the response, using the (shared) export file
        const response = await fetch('/library/v/export.php', init);
        //
        //Get the text from the response. This can never fail
        const text = await response.text();
        //
        //Prepare to convert the text to json, setting ok to true if succesful
        //....
        let ok:boolean, result, html:string;
        //
        //The output is expected to be a json string that has the follwing 
        //pattern: {ok, result, html} where result, if ok, is the data of 
        //available choices. The json might fail
        try{
            //Try to convert the text into json
            const output = JSON.parse(text);
            //
            //Destructure the output; the html go lost
            ({ ok, result, html } = output);
            // 
            // 
            return result;
       }
        //
        //Invalid json;this must be an error
        catch (ex) {
            // 
            //Compile a usefull error message
            const msg = `message: "${(<Error>ex).message}". text = "${text}"`;
            //
            throw new Error(msg);
        }
    }
    
    //
    //
    //Post the given file to the server at the given folder.
    async post_file(
        file:  Blob,
        path :string
    ):Promise<{ok:boolean, result:any, html:string}>{
        //
        //1. Create a form data object
        const formData = new FormData();
        //
        //2. Append the file to the form data object
        //
        //Attach the folder name where the file will go
        formData.append('path', path);
        //
        //Attach the actual file to the form data 
        formData.append("file", file);
        //     
        //4. Prepare a fetch initialization file using the form data
        const init = {
            method: 'POST',
            body: formData
        };
        //
        //5. Use the initialization object to send the file to the server
        const response = await fetch('export.php?post_file=true', init);
        //
        //await for the output which has the following structure
        //{ok, result, html}
        //ok
        const  output= await response.json();
        //
        return output;
    }
    //
    //Fetching static methods
   async  ifetch<
        //
        //Define a type for... 
        //...the collection of classes in the library namespace.
        classes extends typeof library,
        // 
        //...all the class names that index the classes.
        class_name extends Extract<keyof classes,string>,
        // 
        //...a class in the library name spaces
        $class extends classes[class_name],
        // 
        //...a static method name of class in the library namespace 
        method_name extends Extract<keyof $class,string>,
        // 
        //...a static method of a $class in the library namespace
        method extends Exclude< 
            Extract<$class[method_name], (...args: any) => any>,
            "prototype"
        >,
        
        // 
        //...input parameters of a method of a class in the library namespace 
        $parameters extends Parameters<method>,
        // 
        //...a return value of a method of a class in the library namespace 
        $return extends ReturnType<method>
        
    >(
        //
        //The class of the php object to use.
        class_name :class_name,
        //
        //The static method name to execute on the class. 
        method_name :method_name,
        //
        //The method parameters
        margs: $parameters
        
    ):Promise<$return>{
        //
        //Prepare to collect the data to send to the server
        const formdata = new FormData();
        //
        //Add to the form, the class name to create objets on the server
        formdata.append('class', class_name);
        //
        //Add the method to execute on the class
        formdata.append('method', method_name);
        //
        //Add the method parameters 
        formdata.append('margs', JSON.stringify(margs));
        //
        //Prepare  to fetch using a post
        const init = {
            method:'post',
            body:formdata
        };        
        //
        //Fetch and wait for the response, using the (shared) export file
        const response = await fetch('/library/v/export.php?is_static=true', init);
        //
        //Get the text from the response. This can never fail
        const text = await response.text();
        //
        //Prepare to convert the text to json, setting ok to true if succesful
        //....
        let ok:boolean, result:$return, html:string;
        //
        //The output is expected to be a json string that has the follwing 
        //pattern: {ok, result, html} where result, if ok, is the data of 
        //available choices. The json might fail
        try{
            //Try to convert the text into json
            const output = JSON.parse(text);
            //
            //Destructure the output; the html go lost
            ({ ok, result, html } = output);
            // 
            // 
            return result;
       }
        //
        //Invalid json;this must be an error
        catch (ex) {
             throw new Error((<Error>ex).message);
        }
    }

type get_constructor_args<T> = T extends new (...args: infer c) => any ? c : never;


//For debugging
export declare function debug<
    // 
    //Get the type that represents...
    //...classes in the library namespace, organised as an object, e.g.,
    //{database:object, record:object, node:object }
    classes extends typeof library,
    //
    //...the classname as string inorder to comply with the formdata.append parameters i.e.,
    //string|blob
    class_name extends Extract<keyof classes, string>,
    //
    //...A class in the library namespace, e.g.,
    //class node { 
    //  export: (..args: any)=> any,
    //  prototype: new (...args:any)=>any
    //}
    $class extends classes[class_name],
    // 
    //... the constructor parameters without using the predefined construction parameter.
    //cargs extends $class extends new (...args: infer c) => any ? c : never,
    cargs extends ConstructorParameters<$class>,
    //
    //...The  instance type of the constructor directly without using the predefined construction
    //instance extends $class extends new (...args: any) => infer r ? r : never,
    instance extends InstanceType<$class>,
    // 
    //...The object method name.
    method_name extends keyof instance,
    // 
    //...The object method
    method extends instance[method_name], 
    // 
    //....the method arguments 
    margs extends method extends { (...args: infer p): any } ? p : never,
    // 
    //...The return type 
    $return extends ReturnType<method>,
>(
    //
    //The class of the php class to execute.
     class_name: class_name,
    //cargs:cargs
    //y:y
    //$prototype:$prototype
    method_name:method_name,
    //prototype_keys:prototype_keys
    //instance_keys :instance_keys
    //method:method
    margs:margs
    //
    //
    //$class:$class
    // 
    //x: x,    
        
): void;

//
//Test the debug function.
//debug("database",[],"get")
//exec("database", ["dfgf"], "get_sql_data", ["gf"]); 
  
}
