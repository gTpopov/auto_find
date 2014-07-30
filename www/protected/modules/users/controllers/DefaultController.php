<?php

class DefaultController extends Controller
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
        /*
        //check if state exists
        if(Yii::app()->user->hasState("full_name")) {
           //get session variable
           Yii::app()->user->getState("full_name");
        }*/
        $model = new Users();

        $user = Users::model()->findBySql('SELECT
                                            full_name,
                                            company,
                                            country,
                                            city,
                                            address,
                                            email,
                                            password,
                                            phone,
                                            skype,
                                            site,
                                            deliver,
                                            access_user
                                          FROM users
                                          WHERE uid = :uid',array('uid'=>Yii::app()->user->id));

        $this->render('index',array(
            'model' => $model,
            'user'  => $user,
        ));
	}
}