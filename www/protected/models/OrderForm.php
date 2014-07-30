<?php

class OrderForm extends CFormModel {


    public $name;
    public $country;
    public $city;
    public $email;
    public $phone;
    public $message;
    public $fk_u_order;

    public function rules()
    {
        return array(
            array('name, city, email, phone, country', 'required','message' => 'Поле «{attribute}» не должно быть пустое.'),
            array('email','email','message'=>'Введите корректный адрес Email.'),
            array('message', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'    => 'ФИО',
            'country' => 'Страна',
            'city'    => 'Город',
            'email'   => 'Email',
            'phone'   => 'Телефон',
            'message' => 'Сообщение',
        );
    }

} 