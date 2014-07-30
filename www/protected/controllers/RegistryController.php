<?php

class RegistryController extends Controller
{

    public function actionIndex()
	{


        //echo Yii::app()->language;




        Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/jquery.cookie.js');
        Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/registry/identify.js');

        /*
        $arrData['__utMonik']          = Yii::app()->request->cookies['__utMonik']->value;
        $arrData['__utDepth']          = Yii::app()->request->cookies['__utDepth']->value;
        $arrData['__utFlash']          = Yii::app()->request->cookies['__utFlash']->value;
        $arrData['__utJava']           = Yii::app()->request->cookies['__utJava']->value;
        $arrData['__utCook']           = Yii::app()->request->cookies['__utCook']->value;
        $arrData['__utZone']           = Yii::app()->request->cookies['__utZone']->value;
        $arrData['__utPlagins']        = Yii::app()->request->cookies['__utPlagins']->value;
        $arrData['__utPlat']           = Yii::app()->request->cookies['__utPlat']->value;

        $arrData['httpAccept']         = $_SERVER['HTTP_ACCEPT'];          //типа документа +9       +
        $arrData['httpAcceptLanguage'] = $_SERVER['HTTP_ACCEPT_LANGUAGE']; // предпочтения клиента относительно языка +10

        $arrData['browser'] = Identify::checkBrowser();

        print '<pre>';
        print_r(Identify::collect());
        print '</pre>';
        */

        $model=new Users();


        $model->setScenario('registration');

        if(isset($_POST['Users']))
        {

            //Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/lib/jquery.cookie.js');
            //Yii::app()->getClientScript()->registerScriptFile( Yii::app()->baseUrl.'/js/registry/identify.js');

            if(!isset(Yii::app()->request->cookies['__tuc']))
            {
                //check enable cookie on browser
                if(isset(Yii::app()->request->cookies['__utCook']))
                {
                    $model->attributes=$_POST['Users'];

                    if($model->validate())
                    {

                        $connection = Yii::app()->db;
                        $command = $connection->createCommand('SELECT
                                                                appName,
                                                                appVersion,
                                                                cookieEnabled,
                                                                javaEnabled,
                                                                plaginEnabled,
                                                                platform,
                                                                screen,
                                                                colorDepth,
                                                                flash,
                                                                httpLanguage,
                                                                httpAccept,
                                                                dataZone,
                                                                ipAdress,
                                                                city,
                                                                region,
                                                                country,
                                                                latitude,
                                                                longitude
                                                           FROM identify_users');
                        $result  = $command->queryAll($command);

                        $match_percent = 0;
                        $flag          = false;

                        if(is_array($result))
                        {
                            //Получаем данные о пользователи
                            $arr = Identify::collect();

                            //Сверяем полученные данные с данными из БД (по каждому кртерию)
                            foreach($result as $val) {

                                if($val['appName'] == $arr['browser']) {
                                    $match_percent += 0.081847248;
                                }
                                if($val['appVersion'] == $arr['version']) {
                                    $match_percent += 0.118123798;
                                }
                                if($val['cookieEnabled'] == $arr['__utCook']) {
                                    $match_percent += 0.000194953;
                                }
                                if($val['javaEnabled'] == $arr['__utJava']) {
                                    $match_percent += 0.000194953;
                                }
                                if($val['plaginEnabled'] == $arr['__utPlagins']) {
                                    $match_percent += 0.320531032;
                                }
                                if($val['platform'] == $arr['__utPlat']) {
                                    $match_percent += 0.000394953;
                                }
                                if($val['screen'] == $arr['__utMonik']) {
                                    $match_percent += 0.069818299;
                                }
                                if($val['colorDepth'] == $arr['__utDepth']) {
                                    $match_percent += 0.069818299;
                                }
                                if($val['flash'] == $arr['__utFlash']) {
                                    $match_percent += 0.081847248;
                                }
                                if($val['httpLanguage'] == $arr['httpAcceptLanguage']) {
                                    $match_percent += 0.035509264;
                                }
                                if($val['httpAccept'] == $arr['httpAccept']) {
                                    $match_percent += 0.015509264;
                                }
                                if($val['dataZone'] == $arr['__utZone']) {
                                    $match_percent += 0.06374125;
                                }
                                if($val['ipAdress'] == $arr['ip']) {
                                    $match_percent += 0.50545622;
                                }
                                if($val['city'] == $arr['city']) {
                                    $match_percent += 0.30545622;
                                }
                                if($val['region'] == $arr['region']) {
                                    $match_percent += 0.30545622;
                                }
                                if($val['country'] == $arr['country']) {
                                    $match_percent += 0.01545622;
                                }
                                if($val['latitude'] == $arr['latitude']) {
                                    $match_percent += 0.1545622;
                                }
                                if($val['longitude'] == $arr['longitude']) {
                                    $match_percent += 0.1545622;
                                }
                                //Проверка порога значение коэфициента
                                //setcookie('SID',$match_percent,time()+60*60*24*1825,'/registry/');

                                if($match_percent >= 1.687567401) {
                                    $flag = true;
                                    break;
                                }
                                $match_percent = null;
                            }
                        }

                        if(!$flag)
                        {
                            $transaction=$connection->beginTransaction();
                            try
                            {
                                switch($_POST['Users']['country']) {
                                    case 9908: $country = 'Украина';    break;
                                    case 3159: $country = 'Россия';     break;
                                    case 248:  $country = 'Белоруссия'; break;
                                    case 1894: $country = 'Казахстан';  break;
                                }

                                $full_name = (string) strip_tags(htmlspecialchars($_POST['Users']['full_name']));
                                $company   = (string) strip_tags(htmlspecialchars($_POST['Users']['company']));
                                $city      = (string) strip_tags(htmlspecialchars($_POST['Users']['city']));
                                $email     = (string) mb_strtolower(str_replace(" ","",$_POST['Users']['email']));
                                $password  = (string) md5('alex_2014'.$_POST['Users']['password']);

                                $sql1 = "INSERT INTO users (full_name,company,country,city,email,password,date_of_registration)
                                         VALUES ('".$full_name."','".$company."','".$country."','".$city."','".$email."','".$password."','".date('Y-m-d')."')";

                                $connection->createCommand($sql1)->execute();
                                $user_id   = (int) Yii::app()->db->lastInsertID;

                                //Добавляем в табл. идентификация данные о пользователе
                                $sql2 = "INSERT INTO identify_users (
                                            appName,
                                            appVersion,
                                            cookieEnabled,
                                            javaEnabled,
                                            plaginEnabled,
                                            platform,
                                            screen,
                                            colorDepth,
                                            flash,
                                            httpLanguage,
                                            httpAccept,
                                            dataZone,
                                            ipAdress,
                                            city,
                                            region,
                                            country,
                                            latitude,
                                            longitude,
                                            fk_uid)
                                          VALUES (
                                            '".$arr['browser']."',
                                            '".$arr['version']."',
                                            '".$arr['__utCook']."',
                                            '".$arr['__utJava']."',
                                            '".$arr['__utPlagins']."',
                                            '".$arr['__utPlat']."',
                                            '".$arr['__utMonik']."',
                                            '".$arr['__utDepth']."',
                                            '".$arr['__utFlash']."',
                                            '".$arr['httpAcceptLanguage']."',
                                            '".$arr['httpAccept']."',
                                            '".$arr['__utZone']."',
                                            '".$arr['ip']."',
                                            '".$arr['city']."',
                                            '".$arr['region']."',
                                            '".$arr['country']."',
                                            '".$arr['latitude']."',
                                            '".$arr['longitude']."',
                                            $user_id)";

                                $connection->createCommand($sql2)->execute();

                                //Create table for current user with name - import_puID
                                $sql3 ="CREATE TABLE IF NOT EXISTS import_pu".$user_id." (
                                        pid          INT(11)               NOT NULL AUTO_INCREMENT,
                                        brend        VARCHAR(200)          NOT NULL,
                                        model        VARCHAR(200)          NOT NULL,
                                        name         VARCHAR(200)          NOT NULL,
                                        article      VARCHAR(200)          NOT NULL,
                                        units        CHAR(50)              NOT NULL,
                                        price        FLOAT        UNSIGNED NOT NULL,
                                        status       VARCHAR(100)          NOT NULL,
                                        availability VARCHAR(100)          NOT NULL,
                                        uid          INT(10)      UNSIGNED NOT NULL,
                                        rate         FLOAT        DEFAULT 0.1,
                                        PRIMARY KEY  (pid),
                                        INDEX ix_name (name(7)),
                                        INDEX ix_article (article(7)),
                                        INDEX ix_rate (rate)
                                      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table for current user'";

                                $connection->createCommand($sql3)->execute();

                                $transaction->commit();
                            }
                            catch(Exception $e){
                                $transaction->rollback();
                                $flag = true;
                            }

                            if(!$flag)
                            {
                                //Create folder for user
                                if(!file_exists('files/'.$user_id.'')) {
                                    mkdir('files/'.$user_id.'');
                                    copy('files/index.html','files/'.$user_id.'/index.html');
                                }

                                //Create time-stamp at cookie 5 year
                                if(!isset(Yii::app()->request->cookies['__tuc'])) { setcookie('__tuc',md5('identifyUsers'),time()+60*60*24*1825); }

                                //Send letter on email
                                $message = '<p>
                                <b>'.$full_name.' приветсвуем на Сервисе Поиска Запчастей!</b>
                                <br> Подтвердите свою регистрацию перейдя по
                                <a href="'.Yii::app()->request->hostInfo.'/registry/act?_ukey='.$password.'&uid='.$user_id.'&__utime='.time().'">
                                ссылке
                                </a> или скопируйте '.Yii::app()->request->hostInfo.'/registry/act?_ukey='.$password.'&uid='.$user_id.'&__utime='.time().'
                                </p>';

                                Yii::app()->mailer->From = "admin@admin.com";
                                Yii::app()->mailer->FromName = "[Auto Find]";
                                Yii::app()->mailer->AddAddress("".$email."", 'Имя');
                                Yii::app()->mailer->IsHTML(true);
                                Yii::app()->mailer->Subject = "Auto Find верификация аккаунта";
                                Yii::app()->mailer->Body = $message;

                                if(!Yii::app()->mailer->Send()) {
                                    Yii::app()->user->setFlash('failed-registration',Yii::t('registrationPage','Error while sending message'));
                                }
                                else {
                                    Yii::app()->user->setFlash('success-registration',Yii::t('registrationPage','On your mail sent to you with further instructions'));
                                }
                            }
                        }
                        else {
                            Yii::app()->user->setFlash('failed-registration',Yii::t('registrationPage','You are already registered').".");
                        }
                    }
                }
                else {
                    Yii::app()->user->setFlash('failed-registration',Yii::t('registrationPage','To work correctly, turn the cookie settings'));
                }
            }
            else {
                Yii::app()->user->setFlash('failed-registration',Yii::t('registrationPage','You are already registered').".");
            }
        }

        if(Yii::app()->user->isGuest){
            $this->render('index',array(
                'model' => $model
            ));
        } else {
            $this->redirect(Yii::app()->user->returnUrl);
        }
	}


    /**
     * Function activation account from mail
     */
    public function actionAct()
    {

        if(isset($_GET['_ukey']))
        {
            //$model = new Users();
            $uid = intval($_GET['uid']);
            $str = Users::model()->findByPk($uid);
            $key = $str->password;

            if($key === $_GET['_ukey'] && $str->access_user === '0')
            {
                $cookieID = new CHttpCookie('__utId',$uid);
                Yii::app()->request->cookies['__utId']  = $cookieID;

                $model_auto_login = new LoginForm();
                $_POST['LoginForm']['username'] = $str->email;
                $_POST['LoginForm']['password'] = $str->password;

                $model_auto_login->attributes = $_POST['LoginForm'];

                if($model_auto_login->login())
                {
                    unset(Yii::app()->request->cookies['__utId']);

                    if(Users::model()->updateByPk($uid,array('access_user'=>'1')))
                    {
                        //print 'success';
                        $this->redirect('/users/');
                    }
                    else {
                        //print 1;
                        $this->redirect('/');
                    }
                }
                else {
                    //print 2;
                    $this->redirect("/");
                }
            }
            else {
                //print 3;
                $this->redirect("/");
            }
        }

    }


}