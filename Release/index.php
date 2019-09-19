<?php
require_once 'Classes/PHPExcel.php';
require_once 'index.html';

//data to load
$data = PHPExcel_IOFactory::load('data.xlsx');
$data->setActiveSheetIndex(0);

//US FOODS FILE to load
$dir = scandir('./Lists/US FOODS/');
$USlast_week_file_name = $dir[count($dir)-2];
$USlast_week_file = PHPExcel_IOFactory::load('./Lists/US FOODS/'.$USlast_week_file_name);
$USlast_week_file->setActiveSheetIndex(0);
$USthis_week_file_name = $dir[count($dir)-1];
$USthis_week_file = PHPExcel_IOFactory::load('./Lists/US FOODS/'.$USthis_week_file_name);
$USthis_week_file->setActiveSheetIndex(0);

//SYSCO SC FILE to load
$dir = scandir('./Lists/SYSCO SC/');
$SYSCOlast_week_file_name = $dir[count($dir)-2];
$SYSCOlast_week_file = PHPExcel_IOFactory::load('./Lists/SYSCO SC/'.$USlast_week_file_name);
$SYSCOlast_week_file->setActiveSheetIndex(0);
$SYSCOthis_week_file_name = $dir[count($dir)-1];
$SYSCOthis_week_file = PHPExcel_IOFactory::load('./Lists/SYSCO SC/'.$USthis_week_file_name);
$SYSCOthis_week_file->setActiveSheetIndex(0);

//data style to save
$excel = new PHPExcel();
$excel->setActiveSheetIndex(0)
    ->setCellValue('D2', 'US FOODS')
    ->setCellValue('I2', 'SYSCO SC')
    ->setCellValue('A3', '#')
    ->setCellValue('B3', 'ITEM')
    ->setCellValue('C3', 'UNIT')
    ->setCellValue('D3', 'UNITS PER CS')
    ->setCellValue('E3', 'Last Week')
    ->setCellValue('F3', 'This Week')
    ->setCellValue('G3', 'weekly change')
    ->setCellValue('H3', 'UNIT COST')
    ->setCellValue('I3', 'UNITS PER CS')
    ->setCellValue('J3', 'Last Week')
    ->setCellValue('K3', 'This Week')
    ->setCellValue('L3', 'weekly change')
    ->setCellValue('M3', 'UNIT COST');
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$excel->getActiveSheet()->mergeCells('D2:H2');
$excel->getActiveSheet()->mergeCells('I2:M2');

//loop by data items
$i = 4;
while($item = $data->getActiveSheet()->getCell('A'.$i)->getValue() != ""){
    
    //data loaded
    $number = $i-3;
    $item = $data->getActiveSheet()->getCell('B'.$i)->getValue();
    $unit = $data->getActiveSheet()->getCell('C'.$i)->getValue();

    //US FOODS fields loaded
    $USunits_per_cs = $data->getActiveSheet()->getCell('D'.$i)->getValue();
    $USlast_week = $USlast_week_file->getActiveSheet()->getCell('B'.$i)->getValue();
    $USthis_week = $USthis_week_file->getActiveSheet()->getCell('B'.$i)->getValue();
    $USweekly_change = floor(($USthis_week-$USlast_week)*100)/100;
    $USunit_cost = floor(($USthis_week/$USunits_per_cs)*100)/100;

    //SYSCO SC fields loaded
    $SYSCOunits_per_cs = $data->getActiveSheet()->getCell('I'.$i)->getValue();
    $SYSCOlast_week = $SYSCOlast_week_file->getActiveSheet()->getCell('B'.$i)->getValue();
    $SYSCOthis_week = $SYSCOthis_week_file->getActiveSheet()->getCell('B'.$i)->getValue();
    $SYSCOweekly_change = floor(($SYSCOthis_week-$SYSCOlast_week)*100)/100;
    $SYSCOunit_cost = floor(($SYSCOthis_week/$SYSCOunits_per_cs)*100)/100;

    //HTML created
    echo "<tr><th>$number</th>
    <th>$item</th>
    <th>$unit</th>

    <th>$USunits_per_cs</th>
    <td>$USlast_week</td>
    <td>$USthis_week</td>
    <td>$USweekly_change</td>
    <td>$USunit_cost</td>

    <th>$SYSCOunits_per_cs</th>
    <td>$SYSCOlast_week</td>
    <td>$SYSCOthis_week</td>
    <td>$SYSCOweekly_change</td>
    <td>$SYSCOunit_cost</td></tr>";
    
    //data to save
    $excel->setActiveSheetIndex(0)
        ->setCellValue("A$i", $number)
        ->setCellValue("B$i", $item)
        ->setCellValue("C$i", $unit)

        ->setCellValue("D$i", $USunits_per_cs)
        ->setCellValue("E$i", $USlast_week)
        ->setCellValue("F$i", $USthis_week)
        ->setCellValue("G$i", $USweekly_change)
        ->setCellValue("H$i", $USunit_cost)

        ->setCellValue("I$i", $SYSCOunits_per_cs)
        ->setCellValue("J$i", $SYSCOlast_week)
        ->setCellValue("K$i", $SYSCOthis_week)
        ->setCellValue("L$i", $SYSCOweekly_change)
        ->setCellValue("M$i", $SYSCOunit_cost);
    $i++;
}
echo "</table>";

//data saved
$file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$file->save('data.xlsx');
?>