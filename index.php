<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__.'/src/SimpleXLSX.php';

echo '<pre>';

$xlsxFolder = './xlsx/';
$csvOutputFolder = './csv/';

$xlsxFiles = [];

echo 'Source File:'.PHP_EOL;
foreach (scanDir($xlsxFolder) as $key => $value) {
  if (strpos($value,'.xlsx')) {
    $xlsxFiles[] = $value;
    echo $value.PHP_EOL;
  }
}

if (!count($xlsxFiles)) {
  die('No file in source dir');
}

echo PHP_EOL;

foreach ($xlsxFiles as $key => $value) {

  $fp = fopen($csvOutputFolder.' '.date('Y-m-d').' '.str_replace('.xlsx','.csv',$value), 'w');
  $xslxData = [];

  if ( $xlsx = SimpleXLSX::parse($xlsxFolder.$value) ) {
  	$xslxData =  $xlsx->rows();
  } else {
  	echo SimpleXLSX::parseError().PHP_EOL;
  }

  foreach ($xslxData as $fields) {
      fputcsv($fp, $fields, ';');
  }

  fclose($fp);

}

// Print created File

echo 'Created File '.PHP_EOL;

foreach (scanDir($csvOutputFolder) as $key => $value) {
  if (strpos($value,'.csv')) {
    echo $value.PHP_EOL;
  }
}
