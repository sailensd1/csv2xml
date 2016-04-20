<?php
/*-----------
This PHP file illustrates how to use the CSV2XML class to convert the CSV file to an XML.
-------------*/
include("Class_XLS2Xml.php");

//Create the instance of the class
$csv2xml = new csv2xml(); 

//Set the root node for the XML
$csv2xml->setRootNode("ROOT"); 

// Set the recurring node for the XML
$csv2xml->setRecurringNode("Presidents"); 

//Provide the CSV filemname
$csv2xml->setCSVFile("USPresident Wikipedia URLs Thmbs HS.csv"); 

//Convert the file
$csv2xml->convertCSV2XML(); 
?> 