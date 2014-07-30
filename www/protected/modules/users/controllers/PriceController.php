<?php

class PriceController extends Controller
{

    /**
     * @return array action filters
     */

    public function filters()
    {
        return array( 'accessControl');
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(

            array('allow',
                'actions'=>array('index'),
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
	{

        $connection = Yii::app()->db;

        if(!empty($_GET['act']) && $_GET['act'] == "upload") {

            $result = $connection->createCommand("SELECT course FROM exchange_rates")->queryAll();

            $arrCourse = array();

            foreach($result as $val) {
                $arrCourse[] = $val['course'];
            }
        }

        if(!empty($_GET['act']) && $_GET['act'] == "edit")
        {

            $modelPrice = new EditPrice();

            $count=$connection->createCommand("SELECT COUNT(uid) FROM import_pu".Yii::app()->user->id."")->queryScalar();
            $sql="SELECT pid,brend,model,name,article,units,price,status,availability,uid,rate FROM "."import_pu".Yii::app()->user->id."";

            $row = $connection->createCommand("SELECT
                COUNT(config_id),
                date_update,
                access_add,
                currency_price
                FROM config_import_tab
                WHERE fk_u_config=".Yii::app()->user->id."")->queryRow();

            if($row['COUNT(config_id)'] != 0) {
                $arrEdit = array();
                $arrEdit['lastUpdate'] = implode('-',array_reverse(explode('-',$row['date_update'])));
                $arrEdit['access']     = $row['access_add'];
                $arrEdit['currency']   = $row['currency_price'];
            }

            $dataProvider = new CSqlDataProvider($sql, array(
                'keyField'=>'name',
                'totalItemCount'=>$count,
                'sort'=>array(
                    'attributes'=>array('price','brend','name'),
                    'defaultOrder'=>'name ASC',
                ),
                'pagination'=>array(
                    'pageSize'=>10,
                ),
            ));
        }

        if(!empty($_GET['act']) && $_GET['act'] == "delete") {

            $count=$connection->createCommand("SELECT COUNT(uid) FROM import_pu".Yii::app()->user->id."")->queryScalar();
        }

        if(!empty($_GET['act']) && $_GET['act'] == "export")
        {
            if(!empty($_GET['export']) && $_GET['export']=='yes')
            {
                $excel = Yii::app()->export;
                $filename = 'Price'.Yii::app()->user->id.''; // name file
                Yii::app()->db->createCommand("SET NAMES cp1251")->execute();
                $command=$connection->createCommand("SELECT brend,model,name,article,units,price,valuta,status,availability
                                                     FROM import_pu".Yii::app()->user->id."");

                $result = $command->queryAll($command);

                if(is_array($result))
                {
                    $excel->InsertText('Brend');
                    $excel->InsertText('Model');
                    $excel->InsertText('Name');
                    $excel->InsertText('Article');
                    $excel->InsertText('Units');
                    $excel->InsertText('Price');
                    $excel->InsertText('Valuta');
                    $excel->InsertText('Status');
                    $excel->InsertText('Availability');

                    $excel->GoNewLine();

                    foreach($result as $row)
                    {
                        $excel->InsertText($row['brend']);
                        $excel->InsertText($row['model']);
                        $excel->InsertText($row['name']);
                        $excel->InsertText($row['article']);
                        $excel->InsertText($row['units']);
                        $excel->InsertText($row['price']);
                        $excel->InsertText($row['valuta']);
                        $excel->InsertText($row['status']);
                        $excel->InsertText($row['availability']);
                        $excel->GoNewLine();
                    }

                    $excel->SaveFile($filename);
                }
            }
        }

        if(!empty($_GET['act']) && $_GET['act'] == "view") {

            if(!empty($_GET['qOptions']))
            {

                $query = trim(strtolower($_GET['qOptions']));

                // Diagramm values ---
                $listMonth = $connection->createCommand("
                             SELECT m.jan, m.feb, m.mar, m.apr, m.may, m.jun, m.jul, m.aug, m.sep, m.oct, m.nov, m.des
                             FROM list_of_tables AS q, query_by_month AS m
                             WHERE q.tab_id = m.fkq_id AND q.query LIKE '".$query."%'")->queryRow();

                $count=$connection->createCommand("SELECT COUNT(tab_id) FROM list_of_tables WHERE query LIKE '".$query."%'")->queryScalar();

                $sql="SELECT
                        q.tab_id AS tab_id,
                        q.query AS query,
                        q.rate AS rate,
                        (m.jan + m.feb + m.mar + m.apr + m.may + m.jun + m.jul + m.aug + m.sep + m.oct + m.nov + m.des)/12 AS month
                      FROM list_of_tables AS q, query_by_month AS m
                      WHERE q.tab_id = m.fkq_id AND
                            q.query LIKE '".$query."%'
                      ORDER BY q.query ASC";

                $dataProvider = new CSqlDataProvider($sql, array(
                    'keyField'=>'tab_id',
                    'totalItemCount'=>$count,
                    'pagination'=>array(
                        'pageSize'=>3,
                    ),
                ));

            }

        }

        $this->render('index',array(
            'act'          => ''.!empty($_GET['act'])?$_GET['act']:'upload'.'',
            'dataProvider' => !empty($dataProvider)?$dataProvider:null,
            'modelPrice'   => !empty($modelPrice)?$modelPrice:null,
            'count'        => !empty($count)?$count:null,
            'arrEdit'      => isset($arrEdit)?$arrEdit:null,
            'arrCourse'    => isset($arrCourse)?$arrCourse:null,
            'listMonth'    => isset($listMonth)?$listMonth:null,
        ));
	}


}