
<?php
$start = microtime(true);

    //СТАРТ Считывание из файла Excel и запись в БД
    require_once "Excel/reader.php";
    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding("UTF-8"); //Кодировка выходных данных
    $data->read('123.xls');
    //$data->read('456.xlsx');

    for ($i=1; $i<=$data->sheets[0]["numRows"]; $i++)
    {
        $cell1 = addslashes(trim($data->sheets[0]["cells"][$i][1]));
        $cell2 = addslashes(trim($data->sheets[0]["cells"][$i][2]));
        $cell3 = addslashes(trim($data->sheets[0]["cells"][$i][3]));
        $cell4 = addslashes(trim($data->sheets[0]["cells"][$i][4]));
        $cell5 = addslashes(trim($data->sheets[0]["cells"][$i][5]));
        $cell6 = addslashes(trim($data->sheets[0]["cells"][$i][6]));

        print $cell1.' - '.$cell2.'<br>';

        //$ins="INSERT INTO `price` (`art`,`name`,`kol`,`price`,`val`,`ed`) VALUES('$cell1','$cell2','$cell3','$cell4','$cell5','$cell6')";
        //$query = mysql_query($ins);
        //if(!$query){  die('Ошибочка');
    }

echo "<br>Время выполнения скрипта: ".(microtime(true) - $start);

?>
