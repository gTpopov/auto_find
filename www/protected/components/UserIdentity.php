<?php


class UserIdentity extends CUserIdentity {

    protected $_id;

    public function authenticate(){

        $user = Users::model()->find('LOWER(email)=?', array(strtolower($this->username)));

        //Activation with post mail -> (no md5())
        if(isset(Yii::app()->request->cookies['__utId']->value))
        {
            if(($user === null) || ($this->password !== $user->password)) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }
            else {
                $this->_id       = $user->uid;
                $this->username  = $user->email;
                $this->setState('full_name', $user->full_name);
                $this->errorCode = self::ERROR_NONE;
            }
        }
        else {

            if(($user === null) || (md5('alex_2014'.$this->password) !== $user->password)) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else {
                $this->_id      = $user->uid;
                $this->username = $user->email;
                $this->setState('full_name', $user->full_name);
                $this->errorCode = self::ERROR_NONE;
            }

        }

        return !$this->errorCode;

    }

    public function getId(){
        return $this->_id;
    }
}