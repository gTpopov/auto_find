<?php

class AjaxController extends Controller {


    public function filters() {
        return array(
            'ajaxOnly + info, query, order, city, idcountry',
        );
    }

    /**
     * Return info about user in windows
     */
    public function actionInfo() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $connection = Yii::app()->db;
            $q = Yii::app()->request->getQuery('q');

            $command = $connection->createCommand("
                SELECT
                    users.uid,
                    users.full_name,
                    users.company,
                    users.country,
                    users.city,
                    users.address,
                    users.email,
                    users.phone,
                    users.skype,
                    users.site,
                    users.deliver,
                    avg(u_reviews.rating) as reit
                FROM users,u_reviews WHERE users.uid = ".(int) $q." AND users.uid = u_reviews.fk_u_review");
            $result = $command->queryRow();
            if($result)
            {
                $commandReview = $connection->createCommand("
                SELECT date_make,message,rating,author FROM u_reviews WHERE fk_u_review = ".(int) $q." ORDER BY date_make DESC");
                $resultReview = $commandReview->queryAll();

                if(count($resultReview))
                {
                    foreach($resultReview as $val)
                    {
                        if(mb_strlen($val['message'],'utf-8')>30) {
                            $message = mb_substr($val['message'],0,mb_strrpos(mb_substr($val['message'],0,50,'utf-8'),' ','utf-8'),'utf-8').
                            '... <small onclick="$(this).siblings(\'span\').slideDown(); $(this).hide();">читать</small>
                            <span style="display:none;">'.mb_substr($val['message'],47,mb_strlen($val['message'],'utf-8'),'utf-8').'</span>';
                        }
                        else {$message = $val['message'];}

                        $arrRev[] = "<li>
                                     <b>Дата:</b>&nbsp; ".implode('-',array_reverse(explode('-',$val['date_make'])))."<br>
                                     <b>Рейтинг:</b>&nbsp; <span class='stars stars-".$val['rating']."'>".$val['rating']."</span><br>
                                     <b>Отзывы:</b>&nbsp; ".$message."<br>
                                     <b>Автор:</b>&nbsp; ".$val['author']."</li>";
                    }
                }

                $arr = array(
                    "uid"       => (int) $result['uid'],
                    "full_name" => $result['full_name'],
                    "company"   => $result['company'],
                    "country"   => $result['country'],
                    "city"      => $result['city'],
                    "address"   => $result['address'],
                    "mail"      => $result['email'],
                    "phone"     => $result['phone'],
                    "skype"     => $result['skype'],
                    "site"      => $result['site'],
                    "deliver"   => $result['deliver'],
                    "review"    => isset($arrRev)?implode("",$arrRev):0,
                    "reit"      => (int) $result['reit'],
                    "result"   => 1,
                );
            } else {
                $arr = array('result'=>0);
            }

            echo json_encode($arr);
            Yii::app()->end();
        }
    }

    /**
     * Return list queries users in table list_of_tables
     */
    public function actionQuery() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $q = trim(Yii::app()->request->getQuery('q'));

            $connection = Yii::app()->db;

            $command = $connection->createCommand("
                        SELECT query as q, amount_items as ac
                    	FROM list_of_tables
						WHERE query LIKE '".$q."%' AND
						      amount_items > 0
						ORDER BY amount_items DESC");

            $result = $command->queryAll();
            foreach($result as $val) {
                echo $val['q']."|".$val['ac']."\r\n";
            }
            Yii::app()->end();
        }

    }

    /**
     * Order good user
     * Send order on email seller and client
     */
    public function actionOrder() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $model = new OrderForm;

            if(isset($_POST['OrderForm']))
            {
                $model->attributes=$_POST['OrderForm'];
                $valid = $model->validate();
                if($valid)
                {

                   ### --- Save data in table --- ###
                   $model_Order = new UOrder;
                   $model_Order->name    = $_POST['OrderForm']["name"];
                   $model_Order->country = $_POST['OrderForm']["country"];
                   $model_Order->city    = $_POST['OrderForm']["city"];
                   $model_Order->email   = $_POST['OrderForm']["email"];
                   $model_Order->phone   = $_POST['OrderForm']["phone"];
                   $model_Order->fk_u_order = $_POST['OrderForm']["uid"];
                   $message = strip_tags(htmlspecialchars($_POST['OrderForm']["message"]));

                    if(mb_strlen($message,'utf-8')>500) {
                       $message = mb_substr($message,0,500,'utf-8');
                   }
                   $model_Order->message = $message;

                   if($model_Order->save())
                   {
                       $ID_last = Yii::app()->db->getLastInsertId();

                       ### --- Send email --- ###
                       # --- Send message letter for seller ---
                       Yii::app()->mailer->From = "info@1caas.com.ua - Delphis";
                       Yii::app()->mailer->FromName = "SEARCH PRICE";
                       Yii::app()->mailer->AddAddress("admin@admin.com", 'Имя');
                       Yii::app()->mailer->IsHTML(true);
                       Yii::app()->mailer->Subject = "[Поступил новый заказ #".$ID_last."]";
                       Yii::app()->mailer->Body = "
                       Name:    ".$_POST['OrderForm']["name"]."
                       Country: ".$_POST['OrderForm']["country"]."
                       City:    ".$_POST['OrderForm']["city"]."
                       Email:   ".$_POST['OrderForm']["email"]."
                       Phone:   ".$_POST['OrderForm']["phone"]."
                       Massage: ".$_POST['OrderForm']["message"]."";

                       if(!Yii::app()->mailer->Send()) die ('Mailer Error: '.Yii::app()->mailer->ErrorInfo);

                       # --- Send letter for user ---
                       Yii::app()->mailer->ClearAddresses();

                       Yii::app()->mailer->From = "info@1caas.com.ua - Delphis";
                       Yii::app()->mailer->FromName = "Delphis";
                       Yii::app()->mailer->AddAddress("".$_POST['OrderForm']["email"]."", 'Имя');
                       Yii::app()->mailer->IsHTML(true);
                       Yii::app()->mailer->Subject = "Отправка сообщение клиенту...";

                       if(!Yii::app()->mailer->Send()) die ('Mailer Error: '.Yii::app()->mailer->ErrorInfo);

                       ### --- Send SMS on phone --- ###


                       echo json_encode(array('result'=>'success'));
                   } else {
                       echo json_encode(array('result'=>'error_save'));
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
     * Return list cities
     */
    public function actionCity() {

        if(Yii::app()->request->isAjaxRequest)
        {
            $q = Yii::app()->request->getQuery('q');

            $country_id = !empty(Yii::app()->session['country_id'])?Yii::app()->session['country_id']:9908;
            $connection = Yii::app()->db;
            $command = $connection->createCommand("
                        SELECT city.name AS n, region.name AS r
                    	FROM city,region
						WHERE city.name LIKE '".$q."%' AND
						      city.region_id=region.region_id AND
						      city.country_id = ".$country_id."
						ORDER BY city.name ASC");

            $result = $command->queryAll();
            foreach($result as $val) {
                echo $val['n']."|".$val['r']."\r\n";
            }
            Yii::app()->end();
        }
    }

    /*
     * Save var ID country in session
     */
    public function actionIdcountry() {

        if(Yii::app()->request->isAjaxRequest) {
            $country_id = Yii::app()->request->getQuery('country_id');
            !empty($country_id)?Yii::app()->session->add("country_id",(int) $country_id):null;
        }
    }



} 