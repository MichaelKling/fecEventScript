<?php

/**
 * This is the model class for table "missionslotgroup".
 *
 * The followings are the available columns in table 'missionslotgroup':
 * @property integer $id
 * @property string $name
 * @property integer $mission_id
 *
 * The followings are the available model relations:
 * @property Missionslot[] $missionslots
 * @property Mission $mission
 */
class MissionSlotGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MissionSlotGroup the static model class
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
		return 'missionSlotGroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, mission_id', 'required'),
			array('id, mission_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, mission_id', 'safe', 'on'=>'search'),
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
			'missionslots' => array(self::HAS_MANY, 'MissionSlot', 'missionSlotGroup_id'),
			'mission' => array(self::BELONGS_TO, 'Mission', 'mission_id'),
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
			'mission_id' => 'Mission',
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
		$criteria->compare('mission_id',$this->mission_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}