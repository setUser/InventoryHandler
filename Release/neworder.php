<?php
require_once 'Classes/PHPExcel.php';
require_once 'neworder.html';

//data to load
$data = PHPExcel_IOFactory::load('data.xlsx');
$data->setActiveSheetIndex(0);

//US FOODS style to save
$USFOODS = new PHPExcel();
$USFOODS->setActiveSheetIndex(0);
$USFOODS->setActiveSheetIndex(0)
    ->setCellValue('A1', 'US FOODS')
    ->setCellValue('A3', '#')
    ->setCellValue('B3', 'ITEM')
    ->setCellValue('C3', 'UNIT')
    ->setCellValue('D3', 'UNITS PER CS')
    ->setCellValue('E3', 'UNIT COST')
    ->setCellValue('F3', 'ORDER');
$USFOODS->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$USFOODS->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$USFOODS->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$USFOODS->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$USFOODS->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$USFOODS->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$USFOODS->getActiveSheet()->mergeCells('A1:F1');

//SYSCO style SC to save
$SYSCOSC = new PHPExcel();
$SYSCOSC->setActiveSheetIndex(0);
$SYSCOSC->setActiveSheetIndex(0)
    ->setCellValue('A1', 'SYSCO SC')
    ->setCellValue('A3', '#')
    ->setCellValue('B3', 'ITEM')
    ->setCellValue('C3', 'UNIT')
    ->setCellValue('D3', 'UNITS PER CS')
    ->setCellValue('E3', 'UNIT COST')
    ->setCellValue('F3', 'ORDER');
$SYSCOSC->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$SYSCOSC->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$SYSCOSC->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$SYSCOSC->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$SYSCOSC->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$SYSCOSC->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$SYSCOSC->getActiveSheet()->mergeCells('A1:F1');

//loop by data items
$i = 4;
while($item = $data->getActiveSheet()->getCell('A'.$i)->getValue() != ""){
    
    //data loaded
    $number = $i-3;
    $item = $data->getActiveSheet()->getCell('B'.$i)->getValue();
    $unit = $data->getActiveSheet()->getCell('C'.$i)->getValue();

    //US FOODS fields loaded
    $USunits_per_cs = $data->getActiveSheet()->getCell('D'.$i)->getValue();
    $USunit_cost = $data->getActiveSheet()->getCell('H'.$i)->getValue();

    //SYSCO SC fields loaded
    $SYSCOunits_per_cs = $data->getActiveSheet()->getCell('I'.$i)->getValue();
    $SYSCOunit_cost = $data->getActiveSheet()->getCell('M'.$i)->getValue();

    if (isset($_POST["submit"])) {
        //US to save
        $USFOODS->setActiveSheetIndex(0)
            ->setCellValue("A$i", $number)
            ->setCellValue("B$i", $item)
            ->setCellValue("C$i", $unit)

            ->setCellValue("D$i", $USunits_per_cs)
            ->setCellValue("E$i", $USunit_cost);
        
        //SYSCO to save
        $SYSCOSC->setActiveSheetIndex(0)
            ->setCellValue("A$i", $number)
            ->setCellValue("B$i", $item)
            ->setCellValue("C$i", $unit)

            ->setCellValue("D$i", $SYSCOunits_per_cs)
            ->setCellValue("E$i", $SYSCOunit_cost);

        //Price compare
        if ($USunit_cost < $SYSCOunit_cost) {
            $USFOODS->setActiveSheetIndex(0)->setCellValue("F$i", $_POST["$number"]);
        }
        else {
            $SYSCOSC->setActiveSheetIndex(0)->setCellValue("F$i", $_POST["$number"]);
        }
        header('Location:orders.php');
    }
    else {
        //HTML created
        echo "<tr><th>$number</th>
        <th>$item</th>
        <th>$unit</th>

        <th>$USunits_per_cs</th>";
        if ($USunit_cost < $SYSCOunit_cost) {
            echo "<td style='background-color:MediumSeaGreen;'>$USunit_cost</td>
            <td><input type='number'name='$number'></td>
            <td style='background-color:Tomato;'>$SYSCOunit_cost</td>";
        }
        else {
            echo "<td style='background-color:Tomato;'>$USunit_cost</td>
            <td><input type='number'name='$number'></td>
            <td style='background-color:MediumSeaGreen;'>$SYSCOunit_cost</td>";
        }
        echo "<th>$SYSCOunits_per_cs</th></tr>";
    }
    $i++;
}
echo "</form></table>";
if (isset($_POST["submit"])) {
    //data saved
    $file = PHPExcel_IOFactory::createWriter($USFOODS, 'Excel2007');
    $file->save("Orders/US FOODS/".$_POST["date"].'.xlsx');
    $file = PHPExcel_IOFactory::createWriter($SYSCOSC, 'Excel2007');
    $file->save("Orders/SYSCO SC/".$_POST["date"].'.xlsx');
}
?>