<?php

/**
 * This is the model class for table "registration".
 *
 * The followings are the available columns in table 'registration':
 * @property integer $id
 * @property integer $member_id
 * @property integer $event_id
 * @property integer $slot_id
 * @property string $registrationDate
 * @property string $cancellationDate
 * @property integer $firstSeen
 * @property integer $lastSeen
 *
 * The followings are the available model relations:
 * @property Member $member
 * @property Event $event
 * @property Slot $slot
 * @property Playeractiveitem $firstSeen0
 * @property Playeractiveitem $lastSeen0
 */
class Registration extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Registration the static model class
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
		return 'registration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, event_id, registrationDate', 'required'),
			array('member_id, event_id, slot_id, firstSeen, lastSeen', 'numerical', 'integerOnly'=>true),
			array('cancellationDate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, member_id, event_id, slot_id, registrationDate, cancellationDate, firstSeen, lastSeen', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'slot' => array(self::BELONGS_TO, 'Slot', 'slot_id'),
			'firstSeen0' => array(self::BELONGS_TO, 'Playeractiveitem', 'firstSeen'),
			'lastSeen0' => array(self::BELONGS_TO, 'Playeractiveitem', 'lastSeen'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'member_id' => 'Member',
			'event_id' => 'Event',
			'slot_id' => 'Slot',
			'registrationDate' => 'Registration Date',
			'cancellationDate' => 'Cancellation Date',
			'firstSeen' => 'First Seen',
			'lastSeen' => 'Last Seen',
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
		$criteria->compare('member_id',$this->member_id);
		$criteria->compare('event_id',$this->event_id);
		$criteria->compare('slot_id',$this->slot_id);
		$criteria->compare('registrationDate',$this->registrationDate,true);
		$criteria->compare('cancellationDate',$this->cancellationDate,true);
		$criteria->compare('firstSeen',$this->firstSeen);
		$criteria->compare('lastSeen',$this->lastSeen);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}