<?php

class AjadminController extends Controller {

    public function filters() {
        return array(
            'ajaxOnly + status',
        );
    }

       /*
     * Update status in table config_import_tab
     */
    public function actionStatus() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $connection  = Yii::app()->db;

            $q   = (string) $_GET['q'];
            $id  = (int)    $_GET['id'];
            $uid = (int)    $_GET['uid'];

            // Unpublic or unlock
            if($q == "0" || $q == "2") {
                $connection->createCommand("DELETE FROM pricedb WHERE uid=".$uid."")->execute();
                $connection->createCommand("OPTIMIZE TABLE pricedb")->execute();
            }
            // Public
            else {
                $connection->createCommand("DELETE FROM pricedb WHERE uid=".$uid."")->execute();
                $connection->createCommand("INSERT INTO pricedb SELECT brend,model,name,article,units,price,status,availability,uid,rate FROM import_pu".$uid."")->execute();
                $connection->createCommand("OPTIMIZE TABLE pricedb")->execute();
            }

            $connection->createCommand("
                UPDATE config_import_tab SET access_add='".$q."' WHERE config_id=".$id."")->execute();
            echo json_encode(array('response'=>'success'));


        }
    }
} 