<?php

/**
 * This is the model class for table "addon".
 *
 * The followings are the available columns in table 'addon':
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property string $hash
 * @property string $shortname
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Event[] $events
 * @property Server[] $servers
 */
class Addon extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Addon the static model class
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
		return 'addon';
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
			array('name', 'length', 'max'=>100),
			array('link', 'length', 'max'=>255),
			array('hash, shortname', 'length', 'max'=>45),
			array('type', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, link, hash, shortname, type', 'safe', 'on'=>'search'),
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
			'events' => array(self::MANY_MANY, 'Event', 'event_has_addon(addon_id, event_id)'),
			'servers' => array(self::MANY_MANY, 'Server', 'server_has_addon(addon_id, server_id)'),
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
			'link' => 'Link',
			'hash' => 'Hash',
			'shortname' => 'Shortname',
			'type' => 'Type',
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
		$criteria->compare('link',$this->link,true);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('shortname',$this->shortname,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}