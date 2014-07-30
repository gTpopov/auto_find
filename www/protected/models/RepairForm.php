<?php

class RepairForm extends CFormModel
{
	public $email;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
            array('email','required','message' => Yii::t('repairPage','{attribute} is empty')),
            array('email','email','message' => Yii::t('repairPage','{attribute} contains an error')),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
            'email' => Yii::t('repairPage','Mailbox'),
		);
	}
}
