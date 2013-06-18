<?php

/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
 * @property integer $id
 * @property integer $eventType_id
 * @property integer $server_id
 * @property string $name
 * @property string $date
 * @property integer $duration
 * @property string $description
 * @property integer $mission_id
 * @property integer $slotFreeRegistration
 *
 * The followings are the available model relations:
 * @property Eventtype $eventType
 * @property Server $server
 * @property Mission $mission
 * @property Addon[] $addons
 * @property Registration[] $registrations
 * @property Slotgroup[] $slotgroups
 */
class Event extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Event the static model class
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
		return 'event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eventType_id, server_id, name, date', 'required'),
			array('eventType_id, server_id, duration, mission_id, slotFreeRegistration', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, eventType_id, server_id, name, date, duration, description, mission_id, slotFreeRegistration', 'safe', 'on'=>'search'),
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
			'eventType' => array(self::BELONGS_TO, 'Eventtype', 'eventType_id'),
			'server' => array(self::BELONGS_TO, 'Server', 'server_id'),
			'mission' => array(self::BELONGS_TO, 'Mission', 'mission_id'),
			'addons' => array(self::MANY_MANY, 'Addon', 'event_has_addon(event_id, addon_id)'),
			'registrations' => array(self::HAS_MANY, 'Registration', 'event_id'),
			'slotgroups' => array(self::HAS_MANY, 'Slotgroup', 'event_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'eventType_id' => 'Event Type',
			'server_id' => 'Server',
			'name' => 'Name',
			'date' => 'Date',
			'duration' => 'Duration',
			'description' => 'Description',
			'mission_id' => 'Mission',
			'slotFreeRegistration' => 'Slot Free Registration',
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
		$criteria->compare('eventType_id',$this->eventType_id);
		$criteria->compare('server_id',$this->server_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('mission_id',$this->mission_id);
		$criteria->compare('slotFreeRegistration',$this->slotFreeRegistration);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}