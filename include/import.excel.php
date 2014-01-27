<?php

/** Include PHPExcel */
require './lib/PHPExcel/Classes/PHPExcel.php';

require_once "import.del.php";

class ImportExcel extends ImportDel {

  protected $ab = array();

  function ImportExcel($filename) {
    
    //
    // Load the Excel data to array
    //
    
  
  	$objPHPExcel = PHPExcel_IOFactory::load($filename);
  	$activeSheet=$objPHPExcel->setActiveSheetIndex(0);
  	$this->data=$activeSheet->toArray();
  	
    //
    // Load the array to address records
    //
    $this->row_offset = 1; // Skip header
    $this->col_offset = 0; 
    $this->convertToAddresses();
  }

  function getResult() {
  	return $this->ab;
  }  
}
?>