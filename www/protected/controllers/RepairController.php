<?php

class RepairController extends Controller
{
	public function actionIndex()
	{
		$model = new RepairForm;

        if(isset($_POST['RepairForm']))
        {
            $model->attributes = $_POST['RepairForm'];
            if($model->validate())
            {
                $password_new = $this->make_password(10);

                $email = (string) mb_strtolower(str_replace(" ","",$_POST['RepairForm']['email']),'utf-8');
                $password  = (string) md5('alex_2014'.$password_new);

                if(Users::model()->updateAll(array('password'=>''.$password.''),'email="'.$email.'"'))
                {
                    //print $password_new;

                    //Send letter on email
                    $message = '<p>Приветсвуем на Сервисе Поиска Запчастей!<br>
                                Для входа в систему используйте новый пароль: '.$password_new.'
                                Не забудьте в своем профиле сменить этот пароль на свой.</p>';

                    Yii::app()->mailer->From = "admin@admin.com";
                    Yii::app()->mailer->FromName = "[Auto Find]";
                    Yii::app()->mailer->AddAddress("".$email."", 'Имя');
                    Yii::app()->mailer->IsHTML(true);
                    Yii::app()->mailer->Subject = "Востановление пароля на Auto Find";
                    Yii::app()->mailer->Body = $message;

                    if(!Yii::app()->mailer->Send()) {
                        Yii::app()->user->setFlash('failed-repair',Yii::t('repairPage','Error while sending message'));
                    }
                    else {
                        Yii::app()->user->setFlash('success-repair',Yii::t('repairPage','On email sent to the new password'));
                    }

                } else {
                    Yii::app()->user->setFlash('failed-repair',Yii::t('repairPage','Email is incorrect'));
                }
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

    //Generator password
    public function make_password($num_chars) {

        if(is_numeric($num_chars) && $num_chars>0 && (!is_null($num_chars)))
        {
            $password = '';
            $accepted_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()+';
            srand(((int)((double)microtime()*1000003)));
            for($i=0;$i<=$num_chars;$i++){
                $random_number = rand(0,(strlen($accepted_chars)-1));
                $password.=$accepted_chars[$random_number];
            }
            return $password;
        }

    }


}