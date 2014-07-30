<?php

class DefaultController extends Controller
{

    /*
     * Management prices of users
     */
    public function actionIndex()
	{

        $connection = Yii::app()->db;
        $count=$connection->createCommand("SELECT COUNT(config_id) FROM config_import_tab")->queryScalar();
        $sql="SELECT config_id,date_update,access_add,table_name,fk_u_config FROM config_import_tab";

        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField'=>'config_id',
            'totalItemCount'=>$count,
            'sort'=>array(
                'attributes'=>array('access_add','date_update'),
                'defaultOrder'=>'date_update DESC',
            ),
            'pagination'=>array(
                'pageSize'=>10,
            ),
        ));

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

    /*
     * View price
     */
    public function actionView($tab)
    {
        $connection = Yii::app()->db;
        $count=$connection->createCommand("SELECT COUNT(pid) FROM ".$tab."")->queryScalar();
        $sql="SELECT * FROM ".$tab."";

        $dataProvider = new CSqlDataProvider($sql, array(
            'keyField'=>'pid',
            'totalItemCount'=>$count,
            'sort'=>array(
                'attributes'=>array('pid','price','brend','name','article'),
                'defaultOrder'=>'name ASC',
            ),
            'pagination'=>array(
                'pageSize'=>15,
            ),
        ));

        $this->render('view',array(
            'dataProvider'=>$dataProvider,
        ));
    }



}