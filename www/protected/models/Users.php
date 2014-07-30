<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $uid
 * @property string $full_name
 * @property string $company
 * @property string $country
 * @property string $city
 * @property string $address
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $skype
 * @property string $site
 * @property string $deliver
 * @property string $date_of_registration
 * @property string $access_user
 * @property string $locking_user
 *
 * The followings are the available model relations:
 * @property UOrder[] $uOrders
 * @property UReviews[] $uReviews
 */
class Users extends CActiveRecord
{

    const SCENARIO_REGISTRATION   = 'registration';
    const SCENARIO_EDIT_BASE_INFO = 'editBaseinfo';
    const SCENARIO_EDIT_SECURITY  = 'editSecurity';
    const SCENARIO_EDIT_EMAIL     = 'editEmail';


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            // for edit data in registry user
            array(
                'full_name, company, country, city, email, password', 'required',
                'on'      =>  self::SCENARIO_REGISTRATION,
                'message' => Yii::t('userForm','{attribute} has not filled')
            ),
            array('email', 'unique',
                'on'      => self::SCENARIO_REGISTRATION,
                'message' => Yii::t('userForm','This {attribute} is already in use')
            ),
            array('email', 'email',
                'on'      => self::SCENARIO_REGISTRATION,
                'message' => Yii::t('userForm','{attribute} contains an error')
            ),
            array('password', 'length',
                'on'    => self::SCENARIO_REGISTRATION,
                'min'   => 7, 'max' => 32,
                'message' => Yii::t('userForm','{attribute} should consist of 7 to 32 characters')
            ),
            // for edit data in profile user
            array(
                'full_name, company, country, city', 'required',
                'on'      =>  self::SCENARIO_EDIT_BASE_INFO,
                'message' => Yii::t('userForm','{attribute} has not filled')
            ),
            // for edit data in security user
            array(
                'password', 'required',
                'on'      =>  self::SCENARIO_EDIT_SECURITY,
                'message' => Yii::t('userForm','{attribute} has not filled')
            ),
            array('password', 'length',
                'on'    => self::SCENARIO_EDIT_SECURITY,
                'min'   => 7, 'max' => 32,
                'message' => Yii::t('userForm','{attribute} should consist of 7 to 32 characters')
            ),
            // for edit data in email user
            array(
                'email', 'required',
                'on'      =>  self::SCENARIO_EDIT_EMAIL,
                'message' => Yii::t('userForm','{attribute} has not filled')
            ),
            array('email', 'unique',
                'on'      => self::SCENARIO_EDIT_EMAIL,
                'message' => Yii::t('userForm','This {attribute} is already in use')
            ),
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
			'uOrders' => array(self::HAS_MANY, 'UOrder', 'fk_u_order'),
			'uReviews' => array(self::HAS_MANY, 'UReviews', 'fk_u_review'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'full_name' => Yii::t('userForm','Full name'),
			'company'   => Yii::t('userForm','Company'),
			'country'   => Yii::t('userForm','Country'),
			'city'      => Yii::t('userForm','City'),
			'address'   => Yii::t('userForm','Address'),
			'email'     => Yii::t('userForm','Email'),
			'password'  => Yii::t('userForm','Password'),
			'phone'     => Yii::t('userForm','Phone'),
			'skype'     => Yii::t('userForm','Skype'),
			'site'      => Yii::t('userForm','Site'),
			'deliver'   => Yii::t('userForm','Deliver'),
			'date_of_registration' => Yii::t('userForm','Date of registration'),
			'access_user' => Yii::t('userForm','access_user'),
			'locking_user' => Yii::t('userForm','locking_user'),
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

		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('skype',$this->skype,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('deliver',$this->deliver,true);
		$criteria->compare('date_of_registration',$this->date_of_registration,true);
		$criteria->compare('access_user',$this->access_user,true);
		$criteria->compare('locking_user',$this->locking_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave() {
        $this->password = md5('alex_2014'.$this->password);
        return parent::beforeSave();
    }
}