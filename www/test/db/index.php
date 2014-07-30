<?php


/*
require 'Classes/PHPExcel.php';
require_once 'Classes/PHPExcel/IOFactory.php';

// Открываем файл
$xls = PHPExcel_IOFactory::load('price.xlsx');

// Устанавливаем индекс активного листа
//$xls->setActiveSheetIndex(0);

// Получаем активный лист
$sheet = $xls->getActiveSheet();

$sheet->setReadDataOnly(true);


// Обращаемся по индексу листа (0,1,2...)
//$sheet = $xls->getSheet(2);

// Обращаемся по имени листа (Лист1,Лист2...)
//$sheet = $xls->setActiveSheetIndexByName('Лист3');

// кол-во строк в листе
$highestRow = $sheet->getHighestRow(); // e.g. 10
print $highestRow.' - ';
// кол-во столбцов в листе
$highestColumn = $sheet->getHighestColumn(); // e.g 'F'
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g.
print $highestColumnIndex; // Индекс - это кол-во колонок в листе

echo "<table>";

// Получили строки и обойдем их в цикле
$rowIterator = $sheet->getRowIterator();

//print '<pre>';
//print_r($rowIterator);
//print '</pre>';
$i=0;
foreach ($rowIterator as $row) {
    // Получили ячейки текущей строки и обойдем их в цикле
    $cellIterator = $row->getCellIterator();
    echo "<tr>";
    foreach ($cellIterator as $cell) {
       // echo "<td>" . $i . "</td>";
        echo "<td>" . $cell->getCalculatedValue() . "</td>";
    }
    echo "</tr>";
    $i++;
}
echo "</table>";
echo "<hr>";

//$startMemory = memory_get_usage();
//$array = range(1, 1000000);
//echo memory_get_usage() - $startMemory, ' bytes';

/*
$startMemory = memory_get_usage();
for ($i = 0; $i < 1000000; ++$i) {
    $array[$i] = $i;
}
echo memory_get_usage() - $startMemory, ' bytes';

*/


/*
// Подключаем библиотеку
require_once 'Classes/PHPExcel.php';
//require_once 'Classes/PHPExcel/IOFactory.php';

// Функция преобразования листа Excel в таблицу MySQL, с учетом объединенных строк и столбцов.
// Значения берутся уже вычисленными. Параметры:
//     $worksheet - лист Excel
//     $connection - соединение с MySQL (mysqli)
//     $table_name - имя таблицы MySQL
//     $columns_name_line - строка с именами столбцов таблицы MySQL (0 - имена типа column + n)
function excel2mysql($worksheet, $connection, $table_name, $columns_name_line = 0) {
    // Проверяем соединение с MySQL
    if (!$connection->connect_error)
    {
        // Количество столбцов на листе Excel
        $columns_count = PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());

                // Количество строк на листе Excel
                $rows_count = $worksheet->getHighestRow();

                // Перебираем строки листа Excel
                for ($row = $columns_name_line + 1; $row <= $rows_count; $row++)
                {
                    // Строка со значениями всех столбцов в строке листа Excel
                    $value_str = "";
                    // Ячейка не объедененная
                    $flag = false;

                    // Перебираем столбцы листа Excel
                    for ($column = 0; $column < $columns_count; $column++)
                    {
                        // Ячейка листа Excel
                        $cell = $worksheet->getCellByColumnAndRow($column, $row);

                        // Перебираем массив объединенных ячеек листа Excel
                        foreach ($worksheet->getMergeCells() as $mergedCells)
                        {
                            // Если текущая ячейка - объединенная,
                            if ($cell->isInRange($mergedCells)) {
                                $flag = true;
                                break;
                            }
                        }
                        // Проверяем, что ячейка не объединенная: если нет, то берем ее значение
                        if(!$flag) {
                            $value_str .= "'".$cell->getCalculatedValue()."',";
                        }
                    }

                    // Обрезаем строку, убирая запятую в конце
                    $value_str = substr($value_str, 0, -1);

                    // Добавляем строку в таблицу MySQL
                    $connection->query("INSERT INTO ".$table_name." (brend,model,name,article,units,price,valuta,status,availability,uid) VALUES (".$value_str.")");
                }

    } else {
        return false;
    }

    return true;
}

$connection = new mysqli("localhost", "yuriy", "1976", "pricezapch");
$connection->set_charset("utf8");

// Загружаем файл Excel
$PHPExcel_file = PHPExcel_IOFactory::load("123.xls");

// Преобразуем первый лист Excel в таблицу MySQL
$PHPExcel_file->setActiveSheetIndex(0);
echo excel2mysql($PHPExcel_file->getActiveSheet(), $connection, "pricedb1", 1) ? "OK\n" : "FAIL\n";

// Перебираем все листы Excel и преобразуем в таблицу MySQL
foreach ($PHPExcel_file->getWorksheetIterator() as $index => $worksheet) {
    echo excel2mysql($worksheet, $connection, "excel2mysql" . ($index != 0 ? $index : ""), 1) ? "OK\n" : "FAIL\n";
}
*/

#################################
#################################
// $start = microtime(true);
// echo "<br>Время выполнения скрипта: ".(microtime(true) - $start);

?>

<html>
<head>
    <title>Импорт прайс-листа</title>
    <script src="jquery.js" type="text/javascript"></script>
    <script type="text/javascript">
        function repeat_import() {
            $.ajax({
                url: "import_xls.php",
                timeout: 50000,
                success: function(data){

                    if (data == "end") {
                        $("#content").html("<h2>Импорт завершен!</h2>");
                        $("#progress-bar").html("");
                        $("#but").css({display:'block'});
                    }
                    else if(data == "incorrect") {
                        $("#content").html("<h2>Некорректная таблица!</h2>");
                    }
                    else {
                        $("#content").html("<h2>" + data + "</h2>");
                        $("#progress-bar").append("sucI");
                        repeat_import();
                    }
                },
                complete: function(xhr, textStatus){
                    if (textStatus != "success") {
                        $("#progress-bar").append("comI");
                        repeat_import();
                    }
                },
                beforeSend: function() {
                    $("#progress-bar").html("Подождите завершения импорта, не закрывайте данную страницу!");
                    $("#but").css({display:'none'});
                    $("#content").html("");
                }
            });
        }

        function start(){
            repeat_import();
        };

    </script>
</head>

<body>

<h1>Импорт прайс-листа</h1>
<a href="javascript:start();" id="but">Начать импорт прайса</a>
<div id="progress-bar"></div>
<div id="content"></div>

</body>

</html>





