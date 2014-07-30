<?php
/*
 * Очищает табл. list_of_tables за критериями: дата создания запроса, кол-во записей в табл. tab_...Б кол-во запросов в месяц.
 */

define('HOST_NAME','localhost');
define('DB_NAME','pricezapch');
define('DB_USER','yuriy');
define('DB_PASS','1976');
$driver = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

# MySQL с PDO_MYSQL
$DBH = new PDO('mysql:host='.HOST_NAME.';dbname='.DB_NAME.'', DB_USER, DB_PASS, $driver );

# Генерируются исключения, которые позволяют аккуратно обрабатывать ошибки и скрывать данные
//$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
# Oшибок генеррируются стандартные предупреждения PHP. Удобен для отладки
$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );


$STH = $DBH->query('SELECT name_tab
                    FROM list_of_tables
                    WHERE amount_items=0 AND last_access_time <"'.date('Y-m-d H:i:s',time()-60).'"', PDO::FETCH_OBJ);

if($STH->rowCount()!=0) {

    while($row = $STH->fetch()) {
        $DBH->exec("DROP TABLE ".$row->name_tab."");
    }

    $data = array('amount_items'=>0,'dt'=>date('Y-m-d H:i:s',time()-60));
    $STH = $DBH->prepare("DELETE FROM list_of_tables WHERE amount_items=:amount_items AND last_access_time<:dt");
    $STH->execute($data);

    print "Success";

} else {
    print "No update";
}














