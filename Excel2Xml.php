<?php
/**
 * CSV to XML
 *
 * A simple, speedy class to convert the CSV files to XML
 *
 * Features
 * 
 *	-	convert CSV file to XML
 *	-	Data sanitization
 *	-	PHP5 and PHP4 compatibility
 *
  */

Class csv2xml{
	var $rootNode = "root";
	var $recurringNode = "row_item";
	var $CSVFileName = "";

	//Function to set the root node for the XML
	function setRootNode($rootNode){
		$this->rootNode = $rootNode;
	}

	//Function to set the item node for the XML
	function setRecurringNode($recurringNode){
		$this->recurringNode = $recurringNode;
	}


	//Function to set the finame of the CSV file
	function setCSVFile($fileName){
		$this->CSVFileName = $fileName;
	}


	//Function to read and convert the CSV file to an XML file
	//The name of the CSV file will be the name of the XMl file with extension ".xml"
	function convertCSV2XML(){
		$row = 1;
		$columns = array();
		$num = 0;
		$isNumSet = false;

		$str = "<?xml version='1.0' encoding='ISO-8859-1'?>\n<" . $this->rootNode . ">\n";
			
		if (($handle = fopen($this->CSVFileName, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1024, ",")) !== FALSE) {
				$fieldCount = count($data); 
				if($row != 1)
					$str .= "<" . $this->recurringNode . ">\n";

				for ($c=0; $c < $fieldCount; $c++) {	
					if($row == 1 && $data[$c] != '' && !$isNumSet){
						$columns [] = preg_replace(array('/\./', '/\?/'), '', preg_replace(array('/\(/', '/\)/', '/ /', '/\//', '/__/'), '_', trim($data[$c])));
						$num++;
					}else{
						if($columns[$c] != '')
							$str .= "<{$columns[$c]}>" . preg_replace('/\&/', 'and', trim($data[$c])) . "</{$columns[$c]}>\n";
					}
				}
				
				if($row != 1)
					$str .= "</" .  $this->recurringNode . ">\n\n";

				$row++;
				$isNumSet = true;
			}
			fclose($handle);
		}
		
		$str .= '</' . $this->rootNode . '>';
		

		//Create & write the data to the XML file
		$filename = str_replace("csv" , "xml", strtolower($this->CSVFileName));

		  if (!$handle = fopen($filename, 'w+')) {
			 echo "Cannot open file ($filename)";
			 exit;
			}

		//Write the data to the XML file
		if (fwrite($handle, $str) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}else{
			echo "File converted successfully.<br/> Filename: <u>\"{$filename}\"</u>";
		}

		fclose($handle);
	}//Function end

}//End of th class
?> 
