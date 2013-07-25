<?php

/**
 * This is the model class for table "slotgroup".
 *
 * The followings are the available columns in table 'slotgroup':
 * @property integer $id
 * @property string $name
 * @property integer $event_id
 * @property integer $weight
 * @property enum $group
 *
 * The followings are the available model relations:
 * @property Slot[] $slots
 * @property Event $event
 */
class SlotGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SlotGroup the static model class
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
		return 'slotgroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, event_id', 'required'),
			array('event_id, weight', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
            array( 'group', 'in', 'range' => SlotGroupEnum::getValidValues() ),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, event_id, weight, group', 'safe', 'on'=>'search'),
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
			'slots' => array(self::HAS_MANY, 'Slot', 'slotGroup_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
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
			'event_id' => 'Event',
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
		$criteria->compare('event_id',$this->event_id);
        $criteria->compare('weight',$this->weight);
        $criteria->compare('group',$this->group);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function deleteAllSlots() {
        foreach ($this->slots as $slot) {
            $slot->delete();
        }
    }

    public function delete(){
        $this->deleteAllSlots();
        parent::delete();
    }
}