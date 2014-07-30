<?php
/*
 * Обновляет данные прайсов в таблицах tab_... на основе табл. pricedb
 */
define('HOST_NAME','localhost');
define('DB_NAME','pricezapch');
define('DB_USER','yuriy');
define('DB_PASS','1976');
$driver = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

$DBH = new PDO('mysql:host='.HOST_NAME.';dbname='.DB_NAME.'', DB_USER, DB_PASS, $driver );
$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );


$STH = $DBH->query('SELECT name_tab, query FROM list_of_tables', PDO::FETCH_OBJ);

if($STH->rowCount()!=0) {

    while($row = $STH->fetch())
    {

        //Очищаем таблицу
        $DBH->exec("TRUNCATE TABLE ".$row->name_tab."");

        // Обновляем данные в таблицах результатов поиска tab_... на основе поиска в общей табл. pricedb по каждому запросу
        $where_name        = 'false';
        $where_article     = 'false';
        $relevance_name    = 0;
        $relevance_article = 0;
        $words = explode(' ', $row->query);
        foreach($words as $w) {
            $where_name     .= ' OR name LIKE "'.$w.'%"';
            $where_article  .= ' OR article LIKE "'.$w.'%"';
            $relevance_name .= ' + ((CHAR_LENGTH(name) - CHAR_LENGTH(REPLACE(upper(name), upper("'.$w.'"), ""))) / CHAR_LENGTH("'.$w.'"))';
            $relevance_article .= ' + ((CHAR_LENGTH(article) - CHAR_LENGTH(REPLACE(upper(article), upper("'.$w.'"), ""))) / CHAR_LENGTH("'.$w.'"))';
        }
        $relevance_name .= ' as relevance_name';
        $relevance_article .= ' as relevance_article';

        $DBH->exec("
                    INSERT INTO ".$row->name_tab." (brend,model,name,article,units,price,status,availability,uid,rate,relevance)
                    SELECT brend,model,name,article,units,price,status,availability,uid,rate,".$relevance_name."
                    FROM pricedb WHERE ".$where_name." LIMIT 50
                    UNION ALL
                    SELECT brend,model,name,article,units,price,status,availability,uid,rate,".$relevance_article."
                    FROM pricedb WHERE ".$where_article." LIMIT 50");

        // Обновляем ставку за клик для каждого запроса в тбл. list_of_tables
        $DBH->exec("UPDATE list_of_tables SET rate=(SELECT MAX(rate) FROM ".$row->name_tab.") WHERE name_tab='".$row->name_tab."'");

        print $row->name_tab." - ".$row->query."<br>";
    }

    print "Success";

} else {
    print "No update";
}














