<?php

class IndexController extends Controller
{

    /**
     * Check table in database
     * @param string $table
     * return array or boole value
     */
    private function existTable($table) {

        $connection = Yii::app()->db;
        $command = $connection->createCommand("SHOW TABLES LIKE '".$table."'");
        return $command->queryRow();
    }

   /*
    * Set cookie for user 30 day
    * @param string $table
    */
    private function setCookie($table) {

        $cookie = new CHttpCookie($table,$table);
        $cookie->expire = time()+2592000;
        Yii::app()->request->cookies[$table] = $cookie;
    }

    /*
     * Define current month and list column for table query_by_month
     * return array items: list column and name month
     */
    private function defineMonth() {

        switch(date("M")) {

            case 'Jan': $column = "1,0,0,0,0,0,0,0,0,0,0,0,".date("Y").","; $m='jan'; break;
            case 'Feb': $column = "0,1,0,0,0,0,0,0,0,0,0,0,".date("Y").","; $m='feb'; break;
            case 'Mar': $column = "0,0,1,0,0,0,0,0,0,0,0,0,".date("Y").","; $m='mar'; break;
            case 'Apr': $column = "0,0,0,1,0,0,0,0,0,0,0,0,".date("Y").","; $m='apr'; break;
            case 'May': $column = "0,0,0,0,1,0,0,0,0,0,0,0,".date("Y").","; $m='may'; break;
            case 'Jun': $column = "0,0,0,0,0,1,0,0,0,0,0,0,".date("Y").","; $m='jun'; break;
            case 'Jul': $column = "0,0,0,0,0,0,1,0,0,0,0,0,".date("Y").","; $m='jul'; break;
            case 'Aug': $column = "0,0,0,0,0,0,0,1,0,0,0,0,".date("Y").","; $m='aug'; break;
            case 'Sep': $column = "0,0,0,0,0,0,0,0,1,0,0,0,".date("Y").","; $m='sep'; break;
            case 'Oct': $column = "0,0,0,0,0,0,0,0,0,1,0,0,".date("Y").","; $m='oct'; break;
            case 'Nov': $column = "0,0,0,0,0,0,0,0,0,0,1,0,".date("Y").","; $m='nov'; break;
            case 'Dec': $column = "0,0,0,0,0,0,0,0,0,0,0,1,".date("Y").","; $m='des'; break;
        }

        return array('column'=>$column,'month'=>$m);
    }

    /**
     * Create table results query
     * @param string $table
     * @param string $query
     * @param string $query_original
     */
    private function createTableResult($table,$query,$query_original) {

        $connection = Yii::app()->db;

        $connection->createCommand("
                CREATE TABLE IF NOT EXISTS ".$table." (
                    brend      VARCHAR(200)          NOT NULL,
                    model      VARCHAR(200)          NOT NULL,
                    name       VARCHAR(200)          NOT NULL,
                    article    VARCHAR(200)          NOT NULL,
                    units      CHAR(50)              NOT NULL,
                    price      FLOAT        UNSIGNED NOT NULL,
                    status     VARCHAR(100)          NOT NULL,
                    availability VARCHAR(100)        NOT NULL,
                    uid        INT          UNSIGNED NOT NULL,
                    rate       FLOAT        DEFAULT 0.1,
                    relevance  FLOAT                 NOT NULL,
                    INDEX ix_rel (relevance),
                    INDEX ix_name (name),
                    INDEX ix_article (article),
                    INDEX ix_rate (rate)
                ) ENGINE = MyISAM DEFAULT CHARSET=utf8")->execute();

        $where_name        = 'false';
        $where_article     = 'false';
        $relevance_name    = 0;
        $relevance_article = 0;
        $words = explode(' ', $query);
        foreach($words as $w) {
            $where_name     .= ' OR name LIKE "'.$w.'%"';
            $where_article  .= ' OR article LIKE "'.$w.'%"';
            $relevance_name .= ' + ((CHAR_LENGTH(name) - CHAR_LENGTH(REPLACE(upper(name), upper("'.$w.'"), ""))) / CHAR_LENGTH("'.$w.'"))';
            $relevance_article .= ' + ((CHAR_LENGTH(article) - CHAR_LENGTH(REPLACE(upper(article), upper("'.$w.'"), ""))) / CHAR_LENGTH("'.$w.'"))';
        }
        $relevance_name .= ' AS relevance_name';
        $relevance_article .= ' AS relevance_article';

        // Здесь подключение к другой базе где будут находиться все временные таблицы запросов типа tab_4cfd01df...
        // Во избижании множества таблиц все таблицы размещаем в другой базе
        $amaunt_items = $connection->createCommand("
                    INSERT INTO ".$table." (brend,model,name,article,units,price,status,availability,uid,rate,relevance)
                    SELECT brend,model,name,article,units,price,status,availability,uid,rate,".$relevance_name."
                    FROM pricedb WHERE ".$where_name." LIMIT 50
                    UNION ALL
                    SELECT brend,model,name,article,units,price,status,availability,uid,rate,".$relevance_article."
                    FROM pricedb WHERE ".$where_article." LIMIT 50")->execute();


        $transaction=$connection->beginTransaction();
        try
        {
            $last_access_time  = date('Y-m-d H:i:s');
            $connection->createCommand("
                    INSERT INTO list_of_tables (name_tab, last_access_time, query, amount_items)
                    VALUES ('".$table."','".$last_access_time."','".$query_original."',".$amaunt_items.")")->execute();

            $last_id = (int) Yii::app()->db->lastInsertID;

            $connection->createCommand("
            INSERT INTO query_by_month (jan,feb,mar,apr,may,jun,jul,aug,sep,oct,nov,des,current_year,fkq_id)
            VALUES (".$this->defineMonth()['column'].$last_id.")")->execute();

            $transaction->commit();
        }
        catch(Exception $e){
            $transaction->rollback();
        }
    }


    /**
     * Update data table list_of_tables
     * @param string $table
     */
    private function updateTable($table) {

        $connection = Yii::app()->db;

        $result = $connection->createCommand("
                SELECT query_by_month.current_year AS year
                FROM query_by_month,list_of_tables
                WHERE list_of_tables.name_tab='".$table."' AND
                      list_of_tables.tab_id = query_by_month.fkq_id")->queryRow();


        if(date('Y') != $result['year']) {
         $connection->createCommand("UPDATE list_of_tables,query_by_month
                                    SET query_by_month.current_year='".date('Y')."',
                                        query_by_month.".$this->defineMonth()['month']."=0
                                    WHERE list_of_tables.tab_id = query_by_month.fkq_id AND
                                          list_of_tables.name_tab='".$table."'")->execute();
         }

        $amount_query =!isset(Yii::app()->request->cookies[$table]->value)?
            ",query_by_month.".$this->defineMonth()['month']."=query_by_month.".$this->defineMonth()['month']."+1":"";

        $connection->createCommand("UPDATE list_of_tables,query_by_month
                                    SET list_of_tables.last_access_time='".date('Y-m-d H:i:s')."'".$amount_query."
                                    WHERE list_of_tables.tab_id = query_by_month.fkq_id AND
                                          list_of_tables.name_tab='".$table."'")->execute();
    }


    /**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {

		//$start = microtime(true);

        if(!empty($_GET['q']))
        {
            $query = !empty($_GET['q'])?$_GET['q']:$_GET['query'];

            $query = mb_substr($query, 0, 64,"utf-8"); //сократим поисковый запрос до 64 символов
            $query = mb_strtolower($query, "utf-8");   //приведем его к нижнему регистру
            $query = strtr($query, array('ё' => 'е')); //производим замену буквы ё на е
            $query = preg_replace("/\'/", '', $query); //удаляем одинарные
            $query = preg_replace('/\"/', '', $query); //удаляем двойные кавычки
            $query = strip_tags($query);               //удаляем все HTML сущности
            $query = trim(preg_replace('/\s+/', ' ', $query)); //пробелы заменяем единичными экземплярами

            if(!empty($query) && mb_strlen($query, "utf-8") >= 3)
            {
                $count = 0;
                $q = '';
                $words = explode(' ', $query);
                foreach($words as $w) {
                    if (in_array($w, Yii::app()->stopwr->listWords())) continue; //отсеивать стоп-слова
                    if (mb_strlen($w,'utf-8')<3) continue; //если длинна каждого слова меньше 3 символов
                    if ($count++ > 4) break; //не больше 5-ти слов в запросе
                    $w = Yii::app()->stemru->stem_word($w); //выделяем корень слова (лемма)
                    $q .= $w.' ';
                }

                if(empty($q)) { $this->redirect('/'); }

                $query_original = $query; //оригинальный запрос пользователя
                $query = trim($q); //обработанный запрос с выделение основы слов (леммы)

                // Проверяем запрос в сессии (впервые пользователь вводит запрос поиска)
                if(!isset(Yii::app()->session['query']))
                {
                    // Сохранить в сессию запросы
                    Yii::app()->session->add("query",$query); //преобразованный запрос
                    Yii::app()->session->add("query_original",$query_original); //оригинальный запрос
                    Yii::app()->session->add("tab",md5($query));

                    $tab_name = 'tab_'.md5($query);

                    // Если табл. не сущуствует в БД - создаем ее на основание запроса
                    if(!$this->existTable($tab_name)) {
                        $this->createTableResult($tab_name,$query,$query_original);
                    } else {
                        $this->updateTable($tab_name);
                    }
                    $this->setCookie($tab_name);
                    //print 'First query';
                }
                else {

                    // если поисковый запрос не изменился
                    if(Yii::app()->session->get("query")===$query)
                    {
                        $tab_name = 'tab_'.Yii::app()->session->get("tab");

                        if(!isset(Yii::app()->request->cookies[$tab_name])) {
                            $this->setCookie($tab_name);
                        }
                        $this->updateTable($tab_name);
                        //print 'Query no change';
                    }
                    // если поисковый запрос изменился
                    else  {

                        Yii::app()->session->add("query",$query); //преобразованный запрос
                        Yii::app()->session->add("query_original",$query_original); //оригинальный запрос
                        Yii::app()->session->add("tab",md5($query));

                        $tab_name = 'tab_'.Yii::app()->session->get("tab");

                        // Если табл. не сущуствует в БД - создаем ее на основание запроса
                        if(!$this->existTable($tab_name)) {
                            $this->createTableResult($tab_name,$query,$query_original);

                        } else {
                            $this->updateTable($tab_name);
                            //print 'Table exist yet.';
                        }
                        //устанавливаем куки
                        $this->setCookie($tab_name);

                        //print 'Query change';
                    }
                }
            }
		}

        #############################################
        //Если табл. в БД существует по заданному запросу и переменная сессии с названием табл.
        if(!empty($_GET['q']))
        {
            $connection = Yii::app()->db;
            $count=$connection->createCommand("SELECT COUNT(uid) FROM "."tab_".Yii::app()->session->get("tab")."")->queryScalar();
            $sql="SELECT brend,model,name,article,units,price,status,availability,uid FROM "."tab_".Yii::app()->session->get("tab")." ORDER BY rate DESC, relevance DESC, price ASC";

            $dataProvider = new CSqlDataProvider($sql, array(
                'keyField'=>'name',
                'totalItemCount'=>$count,
                'sort'=>array(
                    //'attributes'=>array('price','brend'),
                    //'defaultOrder'=>'price ASC',
                ),
                'pagination'=>array(
                    'pageSize'=>3,
                ),
            ));


            Yii::app()->user->setFlash('result-search',"success.");
        }

        $this->render('index',array(
            'dataProvider'=>!empty($dataProvider)?$dataProvider:null,
            'count'=>!empty($count)?$count:null,
            'query'=>!empty($query)?$query:null,
            'modelOrder'=> new OrderForm,
        ));



		//echo "Время выполнения скрипта: ".(microtime(true) - $start);


	}

}