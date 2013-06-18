<?php

/**
 * This is the model class for table "server".
 *
 * The followings are the available columns in table 'server':
 * @property integer $id
 * @property string $name
 * @property string $ip
 * @property integer $mission_id
 * @property string $hostname
 * @property integer $maxPlayer
 * @property integer $passwordProtected
 *
 * The followings are the available model relations:
 * @property Event[] $events
 * @property Mission $mission
 * @property Addon[] $addons
 * @property Serverinfo[] $serverinfos
 */
class Server extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Server the static model class
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
		return 'server';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('mission_id, maxPlayer, passwordProtected', 'numerical', 'integerOnly'=>true),
			array('name, hostname', 'length', 'max'=>255),
			array('ip', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, ip, mission_id, hostname, maxPlayer, passwordProtected', 'safe', 'on'=>'search'),
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
			'events' => array(self::HAS_MANY, 'Event', 'server_id'),
			'mission' => array(self::BELONGS_TO, 'Mission', 'mission_id'),
			'addons' => array(self::MANY_MANY, 'Addon', 'server_has_addon(server_id, addon_id)'),
			'serverinfos' => array(self::HAS_MANY, 'Serverinfo', 'server_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'ip' => 'Ip',
			'mission_id' => 'Mission',
			'hostname' => 'Hostname',
			'maxPlayer' => 'Max Player',
			'passwordProtected' => 'Password Protected',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('mission_id',$this->mission_id);
		$criteria->compare('hostname',$this->hostname,true);
		$criteria->compare('maxPlayer',$this->maxPlayer);
		$criteria->compare('passwordProtected',$this->passwordProtected);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}