<?php

class AjpriceController extends Controller {

    public function filters() {
        return array(
            'ajaxOnly + upload, import, edit, delete, update',
        );
    }

    /**
     * Upload file into tmp
     */
    public function actionUpload() {

        if(Yii::app()->request->isAjaxRequest)
        {
            unset(Yii::app()->session['startRow']);
            unset(Yii::app()->session['fileName']);
            unset(Yii::app()->session['column']);
            unset(Yii::app()->session['currency']);
            unset(Yii::app()->session['ix']);
            unset(Yii::app()->request->cookies['fn']);

            // TRUNCATE TABLE USERS import_pu
            $connection  = Yii::app()->db;
            // import_pu5 - вместо 5 подставлять ID user
            $connection->createCommand("TRUNCATE TABLE import_pu".Yii::app()->user->id."")->execute();
            $connection->createCommand("DELETE FROM config_import_tab WHERE fk_u_config=".Yii::app()->user->id."")->execute();

            Yii::import("ext.EAjaxUpload.qqFileUploader");

            $folder='tmp/';// folder for uploaded files
            $allowedExtensions = array('xls','xlsx');   //array("jpg","jpeg","gif","exe","mov" and etc...
                $sizeLimit = 3 * 1024 * 1024;// maximum file size in bytes
                $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
                $result = $uploader->handleUpload($folder);

                //echo $result;// it's array {"success":true,"filename":"Price.xls"}
                Yii::app()->session['fileName'] = $result['filename'];
                echo json_encode($result);

            Yii::app()->end();
        }
    }

    /**
     * Import file into DB
     */
    public function actionImport() {

        if(Yii::app()->request->isAjaxRequest)
        {

            spl_autoload_unregister(array('YiiBase','autoload'));
            Yii::import('ext.PHPExcel.Classes.PHPExcel', true);
            spl_autoload_register(array('YiiBase','autoload'));

            ### --- Define currency price --- ###
            Yii::app()->session['currency'] = !empty($_GET['currency'])?$_GET['currency']:'usa';


            ### --- Support parcer --- ###
            $connection  = Yii::app()->db;
            $xlsFile     = 'tmp/'.Yii::app()->session['fileName'].'';
            $chunkSize   = 1000;
            $exit        = false;

            if(isset(Yii::app()->session['startRow'])) {
                if(isset(Yii::app()->session['ix'])) {
                    if(Yii::app()->session['ix'] > Yii::app()->session['startRow']) {
                        $startRow = Yii::app()->session['ix'];
                    }
                    else { $startRow = Yii::app()->session['startRow'];}
                }
                else { $startRow = Yii::app()->session['startRow']; }
            }
            else { $startRow = 2;  }

            @$ext = strtolower(array_pop(explode(".", $xlsFile)));
            $objLib = ($ext == "xls") ? 'Excel5' : 'Excel2007';

            ### --- Check cells in sheet ---###
            if(!isset(Yii::app()->session['column']))
            {
                $chunkFilter = new chunkReadFilter();
                $chunkFilter->setRows(2,2);

                $objReader = PHPExcel_IOFactory::createReader($objLib);
                $objReader->setReadFilter($chunkFilter);
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load($xlsFile);
                $sheet = $objPHPExcel->getActiveSheet();
                // Count columns in file
                Yii::app()->session['column'] = $sheet->getHighestColumn();

                unset($objReader);
                unset($objPHPExcel);
                unset($chunkFilter);
            }

            // Check count columns and rows in file (9 8 7 = I H G)
            if(Yii::app()->session['column'] == 'H' ||
               Yii::app()->session['column'] == 'G' ||
               Yii::app()->session['column'] == 'F')
            {
                $chunkFilter = new chunkReadFilter();

                while ($startRow <= 35000 && !$exit)
                {
                    $chunkFilter->setRows($startRow,$chunkSize);

                    $objReader = PHPExcel_IOFactory::createReader($objLib);
                    $objReader->setReadFilter($chunkFilter);
                    $objReader->setReadDataOnly(true);
                    $objPHPExcel = $objReader->load($xlsFile);
                    $objWorksheet = $objPHPExcel->getActiveSheet();

                    $sql = "INSERT INTO import_pu".Yii::app()->user->id." (brend,model,name,article,units,price,status,availability,uid) VALUES";

                    $vowels = array(",","'","\"","(",")",":",";","{","}","^");

                    for ($i = $startRow; $i < $startRow + $chunkSize; $i++)
                    {
                        $value0 = str_replace($vowels, " ", strip_tags($objWorksheet->getCellByColumnAndRow(0,$i)->getValue())); // brend +
                        $value1 = str_replace($vowels, " ", strip_tags($objWorksheet->getCellByColumnAndRow(1,$i)->getValue())); // model +
                        $value2 = str_replace($vowels, " ", strip_tags($objWorksheet->getCellByColumnAndRow(2,$i)->getValue())); // name +
                        $value3 = str_replace($vowels, " ", strip_tags($objWorksheet->getCellByColumnAndRow(3,$i)->getValue())); // article +
                        $value4 = str_replace($vowels, " ", strip_tags($objWorksheet->getCellByColumnAndRow(4,$i)->getValue())); // units +
                        $value5 = $this->currencyConversion($objWorksheet->getCellByColumnAndRow(5,$i)->getValue());             // price +
                        $value6 = str_replace($vowels, " ", strip_tags($objWorksheet->getCellByColumnAndRow(6,$i)->getValue())); // status +
                        $value7 = str_replace($vowels, " ", strip_tags($objWorksheet->getCellByColumnAndRow(7,$i)->getValue())); // availability
                        $value8 = Yii::app()->user->id; // ID user - it's in session

                        Yii::app()->session['ix'] = $i;

                        $value_str="'".$value0."','".$value1."','".$value2."','".$value3."','".$value4."',".$value5.",'".$value6."','".$value7."',".$value8."";

                        if(!empty($value0) &&
                           !empty($value1) &&
                           !empty($value2) &&
                           !empty($value3) &&
                           !empty($value4) &&
                           !empty($value5)) {

                            $sql .= "(".$value_str."),";


                        } else {
                            $sql = substr($sql,0,-1);
                            $command = $connection->createCommand($sql)->execute();
                            $exit = true;  break;
                        }
                    }

                    if(!$exit) {
                        $sql = substr($sql,0,-1);
                        $command = $connection->createCommand($sql)->execute();
                    }

                    $startRow += $chunkSize;
                    Yii::app()->session['startRow'] = $startRow;

                    $cookie = new CHttpCookie('fn',ceil($startRow/35000*100));
                    Yii::app()->request->cookies['fn'] = $cookie;

                    unset($sql);
                    unset($objReader);
                    unset($objPHPExcel);
                    unset($cookie);
                }

                if($exit) { unlink($xlsFile); }

                // Add data in config table for import price
                $row = $connection->createCommand("SELECT COUNT(config_id) FROM config_import_tab WHERE fk_u_config=".Yii::app()->user->id."")->queryRow();
                if($row['COUNT(config_id)'] == 0) {
                    $connection->createCommand("
                        INSERT INTO config_import_tab (date_update, access_add, table_name, currency_price, fk_u_config)
                        VALUES ('".date('Y-m-d')."', '0', 'import_pu".Yii::app()->user->id."', '".Yii::app()->session['currency']."', ".Yii::app()->user->id.")")->execute();
                } else {
                    $connection->createCommand("
                        UPDATE config_import_tab
                        SET date_update='".date('Y-m-d')."',access_add='0' WHERE fk_u_config=".Yii::app()->user->id."")->execute();
                }

                echo "end";
            }
            else { echo "incorrect"; unlink($xlsFile); }

            Yii::app()->end();
        }
    }


   /*
    * Currency conversion in dollar USA
    */
    public function currencyConversion($val) {

        $connection  = Yii::app()->db;
        $result = $connection->createCommand("SELECT course FROM exchange_rates WHERE currency = '".Yii::app()->session['currency']."'")->queryRow();

        $vowels = array(",");
        $val = str_replace($vowels, ".", strip_tags($val));
        return (float) number_format($val / $result['course'],2);
    }

    /**
     * Edit position at price
     */
    public function actionEdit() {

        if(Yii::app()->request->isAjaxRequest)
        {

            $model = new EditPrice();

            if(isset($_POST['EditPrice']))
            {
                $model->attributes=$_POST['EditPrice'];
                if($model->validate())
                {
                    ### --- Define currency price --- ###
                    Yii::app()->session['currency'] = !empty($_POST['EditPrice']['valuta'])?$_POST['EditPrice']['valuta']:'usa';

                    $brend   = (string) strip_tags(htmlspecialchars($_POST['EditPrice']['brend']));
                    $model   = (string) strip_tags(htmlspecialchars($_POST['EditPrice']['model']));
                    $name    = (string) strip_tags(htmlspecialchars($_POST['EditPrice']['name']));
                    $article = (string) strip_tags(htmlspecialchars($_POST['EditPrice']['article']));
                    $units   = (string) strip_tags(htmlspecialchars($_POST['EditPrice']['units']));
                    $price   = (float)  $this->currencyConversion(str_replace(',','.',$_POST['EditPrice']['price']));
                    $status  = (string) strip_tags(htmlspecialchars($_POST['EditPrice']['status']));
                    $availability = (string) strip_tags(htmlspecialchars($_POST['EditPrice']['availability']));
                    $rate    = (float) $this->currencyConversion(str_replace(',','.',$_POST['EditPrice']['rate']));

                    $str = "<h5>".$name."</h5>
                            <b>Бренд:</b>        ".$brend."        <br>
                            <b>Модель:</b>       ".$model."        <br>
                            <b>Артикул:</b>      ".$article."      <br>
                            <b>Ед.измир.:</b>    ".$units."        <br>
                            <b>Цена:</b>         ".$price." $      <br>
                            <b>Состояние:</b>    ".$status."       <br>
                            <b>Наличие:</b>      ".$availability." <br>
                            <b>Сред. цена за клик:</b> ".$rate." $";

                    $connection = Yii::app()->db;
                    $connection->createCommand("UPDATE import_pu".Yii::app()->user->id." SET
                            brend='".$brend."',
                            model='".$model."',
                            name='".$name."',
                            article='".$article."',
                            units='".$units."',
                            price='".$price."',
                            status='".$status."',
                            availability='".$availability."',
                            rate=".$rate."
                        WHERE pid = ".(int) $_POST['pid']."")->execute();

                    // Update table config_import_tab
                    $connection->createCommand("
                        UPDATE config_import_tab
                        SET date_update='".date('Y-m-d')."',access_add='0' WHERE fk_u_config=".Yii::app()->user->id."")->execute();

                    echo json_encode(array('response'=>'success','str'=>$str));

                }
                else {
                    $error = CActiveForm::validate($model);
                    echo $error;
                    Yii::app()->end();
                }
            }
        }
    }


    /*
     * Delete price
     */
    public function actionDelete() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $connection  = Yii::app()->db;

            if(!empty($_GET['q_pid'])) {

                $connection->createCommand("DELETE FROM import_pu".Yii::app()->user->id." WHERE pid=".(int) $_GET['q_pid']."")->execute();
                echo json_encode(array('response'=>'success'));

            } else {

                // TRUNCATE TABLE USERS import_puID AND DELETE FROM TABLE config_import_tab
                $connection->createCommand("TRUNCATE TABLE import_pu".Yii::app()->user->id."")->execute();
                $connection->createCommand("DELETE FROM config_import_tab WHERE fk_u_config=".Yii::app()->user->id."")->execute();
                echo json_encode(array('response'=>'success'));
            }
        }
    }


    /*
     * Update table config_import_tab
     */
    public function actionUpdate() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $connection  = Yii::app()->db;
            $connection->createCommand("
                UPDATE config_import_tab
                SET date_update='".date('Y-m-d')."',access_add='0' WHERE fk_u_config=".Yii::app()->user->id."")->execute();
            echo json_encode(array('response'=>'success'));
        }
    }

    /*
     * Update table importID rate
     */
    public function actionURate() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $amount = (float) $this->currencyConversion(str_replace(",",".",$_POST['amount']));

            if(is_float($amount) && $amount > 0) {

                ### --- Define currency price --- ###
                Yii::app()->session['currency'] = !empty($_POST['valuta'])?$_POST['valuta']:'usa';

                $connection  = Yii::app()->db;
                $connection->createCommand("UPDATE import_pu".Yii::app()->user->id." SET rate=".$amount."")->execute();

                $connection->createCommand("
                UPDATE config_import_tab
                SET date_update='".date('Y-m-d')."',access_add='0',currency_price='".$_POST['valuta']."' WHERE fk_u_config=".Yii::app()->user->id."")->execute();

                echo json_encode(array('response'=>'success'));
            } else {
                echo json_encode(array('response'=>'error'));
            }

        }

    }

} 