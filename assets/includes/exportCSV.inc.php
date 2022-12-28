<?php
session_start();

/**
 * * https://mehulgohil.com/blog/how-to-export-data-to-csv-using-php/
 */

$header_args = array( "ID", "Data", "Importo", "Tipologia", "Stato");
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=movimenti.csv");
$output = fopen( "php://output", "w" );
ob_end_clean();
fputcsv($output, $header_args);

$data = $_SESSION["dataCSV"];
foreach($data as $data_item){
    fputcsv($output, $data_item);
}
die();