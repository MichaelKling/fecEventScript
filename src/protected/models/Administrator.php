<?php

/**
 * This is the model class for table "administrator".
 *
 * The followings are the available columns in table 'administrator':
 * @property integer $id
 * @property string $username
 * @property string $password
 */
class Administrator extends CActiveRecord
{
    //will hold the encrypted password for update actions.
    public $initialPassword;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Administrator the static model class
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
		return 'administrator';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('username, password', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('model','ID'),
			'username' => Yii::t('model','Nutzername'),
			'password' => Yii::t('model','Passwort'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function checkPassword($password) {
        return self::hashPassword($password ) === $this->initialPassword;
    }

    public static function hashPassword( $value )
    {
        return sha1($value);
    }

    public function beforeSave() {
        $valid = !$this->hasErrors();

        // in this case, we will use the old hashed password.
        if (empty($this->password) && !empty($this->initialPassword)){
            $this->password = $this->initialPassword;
        }elseif( $valid && !empty($this->password) && !$this->checkPassword( $this->password )) {
            $this->password = self::hashPassword($this->password);
        }

        return parent::beforeSave();
    }

    public function afterFind() {
        //reset the password to null because we don't want the hash to be shown.
        $this->initialPassword = $this->password;
        $this->password        = NULL;

        parent::afterFind();
    }
}