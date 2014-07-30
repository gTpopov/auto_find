<?php

/**
 * This is the model class for table "u_order".
 *
 * The followings are the available columns in table 'u_order':
 * @property string $order_id
 * @property string $name
 * @property string $country
 * @property string $city
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property string $status
 * @property string $fk_u_order
 *
 * The followings are the available model relations:
 * @property Users $u
 */
class UOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'u_order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, country, city, email, phone', 'required'),
			array('message', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'u' => array(self::BELONGS_TO, 'Users', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'Order',
			'name' => 'ФИО',
			'country' => 'ID_country',
			'city' => 'Город',
			'email' => 'Email',
			'phone' => 'Телефон',
			'message' => 'Сообщение',
			'status' => 'Статус заказа',
			'fk_u_order' => 'uid',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('fk_u_order',$this->uid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}