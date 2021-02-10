import { Component, OnInit } from '@angular/core';
import * as schema from "../../models/schemats";

@Component({
  selector: 'database',
  templateUrl: './database.component.html',
  styleUrls: ['./database.component.css']
})
export class DatabaseComponent implements OnInit {
  // 
  //This class is purposely ment for the display of a database
  //hence the optional database property. The property is optional
  //since it will not be initialized during construction but rather 
  //by a database selector onchange event.
  public database?: schema.database;
  // 
  //The svg where all the entities will be displayed
  public svg?: HTMLOrSVGElement;
  constructor() { }
  // 
  //This is the database selector event listener that retrieves a new 
  //static structure from the server in and uses it to create a new database 
  //that is to be displayed.
  public async change_db(evt: Event): Promise<void>{
    // 
    //Get the selector that evoked this event 
    const selector = <HTMLSelectElement>evt.target;
    // 
    //Get the selected database to be displayed 
    const dbname = selector.value;
    // 
    //Use the dbname to retrieve a new static dbase
    const dbase_: schema.Idatabase = await this.get_dbase();
    // 
    //Create the schema database 
    this.database = new schema.database(dbase_);
    // 
    //Display this database to the svg
    this.show();
  }
  // 
  //Displays the this database on the svg with entities as ellipses and lines as 
  //relations 
  private show() {
    // 
    //Get the svg to append displays
    const svg = document.querySelector("svg")!;
    // 
    //if the database is not ready by this time prompt the user to select a 
    //database and die
    if (this.database === undefined) {
      alert("please select a database");
      return;
    }
    // 
    //Loop through all the entities each creating its ellipse for display 
    for (let entity in this.database.entities) {
      const group = document.createElement("g");
      //
    }
  }

  ngOnInit(): void {
  }

}
