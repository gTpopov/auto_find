<?php session_start();

require_once 'Classes/PHPExcel.php';

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

$connection = new mysqli("localhost", "yuriy", "1976", "pricezapch");
$connection->set_charset("utf8");

### --- Настройки парсера --- ###

$xlsFile     = '32371.xlsx'; // название файла

$chunkSize   = 4000; // размер считываемых строк за раз

$empty_value = 0;	//счетчик пустых знаений

$startRow    = isset($_SESSION['startRow'])? $_SESSION['startRow']: 2; // начинаем читать со строки 2 (по умолчанию)

// Выбор подключаемой библиотеки в зависимости от файла excel-2003 or excel-2007.
@$ext = strtolower(array_pop(explode(".", $xlsFile)));
$objLib = ($ext == "xls") ? 'Excel5' : 'Excel2007';

### --- Check cells in sheet ---###

$chunkFilter = new chunkReadFilter();
$chunkFilter->setRows(2,5);

$objReader = PHPExcel_IOFactory::createReader($objLib);
$objReader->setReadFilter($chunkFilter);
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load($xlsFile);
$sheet = $objPHPExcel->getActiveSheet();

$column = $sheet->getHighestColumn();
//$rows   = $sheet->getHighestRow();

//$_SESSION['rows'] = $rows;
$_SESSION['col']  = $column;

/*
// Проверка на кол-во столбцов в таблице (10 = I)
if($sheet->getHighestColumn() == 'I') {

    unset($objReader);
    unset($objPHPExcel);

    $chunkFilter = new chunkReadFilter();

    while ($startRow <= 65000) {

        $chunkFilter->setRows($startRow,$chunkSize); // устанавливаем знаечние фильтра

        $objReader = PHPExcel_IOFactory::createReader($objLib);
        $objReader->setReadFilter($chunkFilter);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($xlsFile);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        for ($i = $startRow; $i < $startRow + $chunkSize; $i++) 	//внутренний цикл по строкам
        {
            $value  = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();	//получаем первое знаение в строке
            $value1 = $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();	//получаем первое знаение в строке
            $value2 = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();	//получаем первое знаение в строке
            $value3 = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();	//получаем первое знаение в строке
            $value4 = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();	//получаем первое знаение в строке
            $value5 = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();	//получаем первое знаение в строке
            $value6 = $objWorksheet->getCellByColumnAndRow(6,$i)->getValue();	//получаем первое знаение в строке
            $value7 = $objWorksheet->getCellByColumnAndRow(7,$i)->getValue();	//получаем первое знаение в строке
            $value8 = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue();	//получаем первое знаение в строке
            $value9 = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue();	//получаем первое знаение в строке
            $value_str="'".$value."','".$value1."','".$value2."','".$value3."','".$value4."',".$value5.",'".$value6."','".$value7."','".$value8."',".$value9."";

            if(!empty($value)) {
                $q = $connection->query("INSERT INTO pricedb1 (brend,model,name,article,units,price,valuta,status,availability,uid) VALUES (".$value_str.")");

            } else {
                $empty_value++;
                $flag = 1;
                break;
            }
        }

        $startRow += $chunkSize;
        $_SESSION['startRow'] = $startRow;

        unset($objReader);
        unset($objPHPExcel);

        if($empty_value>0) { break; }
    }

    if(isset($flag)) {
        unset($_SESSION['startRow']);
        // удаляем загруженый ексель файл
    }

    echo "end";

} else { echo "incorrect"; }
*/
echo "end";




