<?php

$start = microtime(true);

//Various excel formats supported by PHPExcel library
$excel_readers = array(
    'Excel5',
    'Excel2003XML',
    'Excel2007'
);

require_once 'Classes/PHPExcel.php';

$reader = PHPExcel_IOFactory::createReader('Excel5');
$reader->setReadDataOnly(true);

$path = '123.xls';
$excel = $reader->load($path);

$writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
$writer->setDelimiter(',');
$writer->setEnclosure('');
$writer->setLineEnding("\r\n");

$writer->save('data.csv');
unset($writer);


/*
class chunkReadFilter implements PHPExcel_Reader_IReadFilter {
    private $_startRow = 0;
    private $_endRow = 0;

    public function setRows($startRow, $chunkSize) {
        $this->_startRow    = $startRow;
        $this->_endRow      = $startRow + $chunkSize;
    }

    public function readCell($column, $row, $worksheetName = '') {
        if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
            return true;
        }
        return false;
    }
}

$startRow = 2;
$chunkSize = 4;
$chunkFilter = new chunkReadFilter();

$c=1;
while ($startRow <= 25) {

    $chunkFilter->setRows($startRow,$chunkSize);

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objReader->setReadFilter($chunkFilter);
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load('123.xls');

    $writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    $writer->setDelimiter(',');
    $writer->setEnclosure('');
    $writer->setLineEnding("\r\n");

    $writer->save('data-'.$c.'.csv');

    unset($writer);
    unset($objReader);
    unset($objPHPExcel);

    $startRow += $chunkSize;
    $c++;
    if($c>3) break;

}
*/





























echo 'File saved to csv format';

//if(file_exists("data.csv")) {

    $connection = new mysqli("localhost", "yuriy", "1976", "pricezapch");
    $connection->set_charset("utf8");

    $sql = "LOAD DATA LOCAL INFILE 'data.csv'
            REPLACE INTO TABLE pricedb1
            CHARACTER SET utf8
            FIELDS TERMINATED BY ','
            LINES TERMINATED BY '\r\n'
            IGNORE 1 LINES
            (brend,model,name,article,units,price,valuta,status,availability,uid)";


    //$connection->query($sql);
    /*$connection->query("INSERT INTO pricedb1 (brend,model,name,article,units,price,valuta,status,availability,uid)
                        VALUES ('111','222','333','444','555',6,'777','888','999',3)");*/


//}



echo "<br>Время выполнения скрипта: ".(microtime(true) - $start);

?>