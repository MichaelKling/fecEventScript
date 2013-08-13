<?php

/**
 * This is the model class for table "playeractiveitem".
 *
 * The followings are the available columns in table 'playeractiveitem':
 * @property integer $id
 * @property string $name
 * @property integer $serverInfo_id
 * @property integer $member_id
 *
 * The followings are the available model relations:
 * @property Serverinfo $serverInfo
 * @property Member $member
 * @property Registration[] $registrations
 * @property Registration[] $registrations1
 */
class PlayerActiveItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PlayerActiveItem the static model class
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
		return 'playerActiveItem';
	}

    public function behaviors()
    {
        return array(
            'withRelated'=>array(
                'class'=>'ext.wr.WithRelatedBehavior',
            ),
        );
    }


    /**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serverInfo_id, member_id', 'required'),
			array('serverInfo_id, member_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, serverInfo_id, member_id', 'safe', 'on'=>'search'),
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
			'serverInfo' => array(self::BELONGS_TO, 'Serverinfo', 'serverInfo_id'),
			'member' => array(self::BELONGS_TO, 'Member', 'member_id'),
			'registrations' => array(self::HAS_MANY, 'Registration', 'firstSeen'),
			'registrations1' => array(self::HAS_MANY, 'Registration', 'lastSeen'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('model','ID'),
			'serverInfo_id' => Yii::t('model','Server Info'),
			'member_id' => Yii::t('model','Spieler'),
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
		$criteria->compare('serverInfo_id',$this->serverInfo_id);
		$criteria->compare('member_id',$this->member_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function delete(){
        Registration::model()->updateAll(array('firstSeen' => null),"firstSeen = :id",array(':id' => $this->id));
        Registration::model()->updateAll(array('lastSeen' => null),"lastSeen = :id",array(':id' => $this->id));
        parent::delete();
    }
}