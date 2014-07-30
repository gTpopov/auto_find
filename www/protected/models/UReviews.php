<?php

/**
 * This is the model class for table "u_reviews".
 *
 * The followings are the available columns in table 'u_reviews':
 * @property string $review_id
 * @property string $date_make
 * @property string $message
 * @property double $rating
 * @property string $author
 * @property string $fk_u_review
 *
 * The followings are the available model relations:
 * @property Users $fkUReview
 */
class UReviews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UReviews the static model class
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
		return 'u_reviews';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_make, message, rating, author, fk_u_review', 'required'),
			array('rating', 'numerical'),
			array('author', 'length', 'max'=>100),
			array('fk_u_review', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('review_id, date_make, message, rating, author, fk_u_review', 'safe', 'on'=>'search'),
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
			'fkUReview' => array(self::BELONGS_TO, 'Users', 'fk_u_review'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'review_id' => 'Review',
			'date_make' => 'Date Make',
			'message' => 'Message',
			'rating' => 'Rating',
			'author' => 'Author',
			'fk_u_review' => 'Fk U Review',
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

		$criteria->compare('review_id',$this->review_id,true);
		$criteria->compare('date_make',$this->date_make,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('fk_u_review',$this->fk_u_review,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}