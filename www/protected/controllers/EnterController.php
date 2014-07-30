<?php

class EnterController extends Controller
{
	public function actionIndex()
	{

        $model = new LoginForm();

        if(isset($_POST['LoginForm']))
        {
            $model->attributes = $_POST['LoginForm'];
            if($model->validate())
            {
                //Check locking user
                $ac_u = Users::model()->findBySql('SELECT uid, access_user, locking_user FROM users WHERE email = :username',array('username'=>$_POST['LoginForm']['username']));
                if($ac_u->locking_user == 0)
                {
                    //Check access user
                    if($ac_u->access_user == 0) {
                        Yii::app()->user->setFlash('failed-enter',"Ваш аккаунт еще не подтвержден");
                    }
                    else {

                        if($model->login()) {
                            $this->redirect('/users/default/index');
                        }
                    }
                }
                else {
                    Yii::app()->user->setFlash('failed-enter',"Ваш аккаунт заблокирован");
                }
            }
        }

        if(Yii::app()->user->isGuest){
            $this->render('index',array(
                'model' => $model
            ));
        }else{
            $this->redirect(Yii::app()->user->returnUrl);
        }
	}


    public function actionExit()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}