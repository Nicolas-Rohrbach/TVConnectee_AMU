<?php
require_once("PHPExcel/IOFactory.php");
require_once ("PHPExcel.php");
require_once("PHPExcel/Worksheet.php");

function readTab($id){
    $file = glob($_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.*");
    foreach ($file as $i) {
        $filename = $i;
    }
$excelReader = PHPExcel_IOFactory::createReaderForFile($filename);
$excelObj = $excelReader->load($filename);
$worksheet = $excelObj->getSheet(0);
$lastRow = $worksheet->getHighestRow();

echo '
     <table class="tab_info">';
for ($row = 0; $row <= $lastRow; $row++) {
    if($row ==1) $var = 'style="background-color: #7E6A7C;"';
    else $var = '';
    echo '<tr style="font-size: 100%;"><td '.$var.'>';
    echo $worksheet->getCell('A'.$row)->getValue();
    echo '</td><td '.$var.'>';
    echo $worksheet->getCell('B'.$row)->getValue();
    echo '</td><td '.$var.'>';
    echo $worksheet->getCell('C'.$row)->getValue();
    echo "</td><tr>";
}
echo "</table>
";
}


