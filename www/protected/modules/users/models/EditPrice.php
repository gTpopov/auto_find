<?php
/**
 * Edit price users.
 * The followings are the available columns in table 'import_puID':
 * @property string $pid
 * @property string $brend
 * @property string $model
 * @property string $name
 * @property string $article
 * @property string $units
 * @property string $price
 * @property string $valuta
 * @property string $status
 * @property string $availability
 * @property string $uid
 */

class EditPrice extends CFormModel {

    public $brend;
    public $model;
    public $name;
    public $article;
    public $units;
    public $price;
    public $valuta;
    public $status;
    public $rate;
    public $availability;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array(
                'brend, model, name, article, units, price, valuta, rate',
                'required',
                'message' => '{attribute} не заполнен(а)'),
            array(
                'price, rate',
                'numerical',
                'numberPattern'=>'/^[+]?\d+\.?\d*$/',
                'message' => '{attribute} должно быть числом')
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'brend'    => 'Производитель',
            'model'    => 'Модельный ряд',
            'name'     => 'Название товара',
            'article'  => 'Код товара',
            'units'    => 'Ед. измерения',
            'price'    => 'Цена',
            'valuta'   => 'Валюта',
            'rate'     => 'Цена за клик',
        );
    }




} 