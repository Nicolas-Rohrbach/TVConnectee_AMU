<?php
require_once("PHPExcel/IOFactory.php");
require_once ("PHPExcel.php");
require_once("PHPExcel/Worksheet.php");

function testLectureExcel($id){
    $file = glob($_SERVER['DOCUMENT_ROOT'] ."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$id}.*");
    foreach ($file as $i) {
        $filename = $i;
    }
//$tmpfname = ABSPATH."/wp-content/plugins/TeleConnecteeAmu/views/Media/{$filenames}";
$excelReader = PHPExcel_IOFactory::createReaderForFile($filename);
$excelObj = $excelReader->load($filename);
$worksheet = $excelObj->getSheet(0);
$lastRow = $worksheet->getHighestRow();

echo "<table>";
for ($row = 1; $row <= $lastRow; $row++) {
    echo '<tr><td style="">';
    echo $worksheet->getCell('A'.$row)->getValue();
    echo "</td><td>";
    echo $worksheet->getCell('B'.$row)->getValue();
    echo "</td><td>";
    echo $worksheet->getCell('C'.$row)->getValue();
    echo "</td><tr>";
}
echo "</table>";

}
