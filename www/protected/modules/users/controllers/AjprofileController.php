<?php

class AjprofileController extends Controller {

    public function filters() {
        return array(
            'ajaxOnly + baseinfo',
        );
    }

    /**
     * Edit block profile user
     */
    public function actionBaseinfo() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $model = new Users;

            $model->setScenario('editBaseinfo');

            if(isset($_POST['Users']))
            {
                $model->attributes=$_POST['Users'];
                if($model->validate())
                {
                    switch($_POST['Users']['country']) {
                        case 9908: $country = 'Украина';    break;
                        case 3159: $country = 'Россия';     break;
                        case 248:  $country = 'Белоруссия'; break;
                        case 1894: $country = 'Казахстан';  break;
                    }

                    // Update and save in table
                    $base_info = Users::model()->updateByPk(Yii::app()->user->id,array(
                        'full_name' => (string) strip_tags(htmlspecialchars($_POST['Users']['full_name'])),
                        'company'   => (string) strip_tags(htmlspecialchars($_POST['Users']['company'])),
                        'country'   => $country,
                        'city'      => (string) strip_tags(htmlspecialchars($_POST['Users']['city'])),
                        'address'   => (string) strip_tags(htmlspecialchars($_POST['Users']['address'])),
                        'phone'     => (string) strip_tags(htmlspecialchars($_POST['Users']['phone'])),
                        'skype'     => (string) strip_tags(htmlspecialchars($_POST['Users']['skype'])),

                    ));

                    if($base_info) {
                        echo json_encode(array('response'=>'success'));

                    } else {
                        echo json_encode(array('response'=>'error'));
                    }

                    Yii::app()->end();
                }
                else {
                    $error = CActiveForm::validate($model);
                    echo $error;
                    Yii::app()->end();
                }
            }
        }
    }

    /**
     * Edit block security user
     */
    public function actionSecurity() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $model = new Users;
            $model->setScenario('editSecurity');

            if(isset($_POST['Users']))
            {
                $model->attributes=$_POST['Users'];
                if($model->validate())
                {
                    $password  = (string) md5('alex_2014'.$_POST['Users']['password']);
                    $security_info = Users::model()->updateByPk(Yii::app()->user->id,array('password' => $password));

                    if($security_info) {
                         echo json_encode(array('response'=>'success'));

                    } else {
                        echo json_encode(array('response'=>'error'));
                    }
                    Yii::app()->end();
                }
                else {
                    $error = CActiveForm::validate($model);
                    echo $error;
                    Yii::app()->end();
                }
            }

        }

    }

    /**
     * Edit block email user
     */
    public function actionEmail() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $model = new Users;
            $model->setScenario('editEmail');

            $model->attributes=$_POST['Users'];
            if($model->validate())
            {
                $email     = (string) mb_strtolower(str_replace(" ","",$_POST['Users']['email']),'utf-8');
                $user_id   = Yii::app()->user->id;
                $password  = (string) Users::model()->findByPk($user_id)->password;

                $email_info = Users::model()->updateByPk($user_id,array('email' => $email,'access_user' => '0',));

                if($email_info) {

                    //Send letter on email
                    $message = '<p>
                                <b>'.Yii::app()->user->getState("full_name").' приветсвуем на Сервисе Поиска Запчастей!</b>
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
                        echo json_encode(array('response'=>'error'));
                    }
                    else {
                        echo json_encode(array('response'=>'success'));
                    }

                } else {
                    echo json_encode(array('response'=>'error'));
                }
                Yii::app()->end();

            }
            else {
                $error = CActiveForm::validate($model);
                echo $error;
                Yii::app()->end();
            }
        }
    }

    /**
     * Upload logo user
     */
    public function actionUpload() {

        if(Yii::app()->request->isAjaxRequest)
        {
            Yii::import("ext.EAjaxUpload.qqFileUploader");

            $folder='files/'.Yii::app()->user->id.'/';
            $allowedExtensions = array('jpg','gif','png','jpeg');
            $sizeLimit = 3 * 1024 * 1024;
            // третий параметр свидетельствует о загрузке и преобразовании граф. файла в формат "jpg"
            $uploader = new qqFileUploader($allowedExtensions, $sizeLimit, Yii::app()->user->id);
            $result = $uploader->handleUpload($folder);
            echo json_encode($result);

            Yii::app()->end();
        }
    }

    /**
     * Delete logo user
     */
    public function actionDelete() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $dir_id = $_POST['id'];

            if(file_exists("files/".$dir_id."/logo".$dir_id.".jpg")) {

                if(unlink('files/'.$dir_id.'/logo'.$dir_id.'.jpg')) {
                    echo json_encode(array('response'=>'success'));
                } else {
                    echo json_encode(array('response'=>'error'));
                }
            }

            Yii::app()->end();
        }
    }
} 