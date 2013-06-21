<?php

/**
 * This is the model class for table "member".
 *
 * The followings are the available columns in table 'member':
 * @property integer $id
 * @property string $name
 * @property integer $extId
 *
 * The followings are the available model relations:
 * @property Playeractiveitem[] $playeractiveitems
 * @property Registration[] $registrations
 */
class Member extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Member the static model class
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
		return 'member';
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
            array('playername, extId', 'unique'),
			array('extId', 'numerical', 'integerOnly'=>true),
			array('name, playername', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, playername, extId', 'safe', 'on'=>'search'),
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
			'playeractiveitems' => array(self::HAS_MANY, 'Playeractiveitem', 'member_id'),
			'registrations' => array(self::HAS_MANY, 'Registration', 'member_id'),
            'totalplaytime' => array(self::STAT, 'ServerInfo', 'playeractiveitem(member_id, serverInfo_id)',
                                                 'select' => 'SUM(timeframe)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('model','ID'),
			'name' => Yii::t('model','Name'),
			'extId' => Yii::t('model','Ext.ID'),
            'playername' => Yii::t('model','Spielername'),
            'totalplaytime' => Yii::t('model','Totale Spielzeit'),
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

		$criteria=new CDbCriteria();

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
        $criteria->compare('playername',$this->playername,true);
		$criteria->compare('extId',$this->extId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function searchWithPlayerCount($serverId) {
        $criteria=new CDbCriteria(array('with' => 'totalplaytime'));
        $criteria->select = 't.*, SUM(serverInfo.timeframe) as totalplaytime';
        $criteria->join = 'INNER JOIN playeractiveitem ON t.id = playeractiveitem.member_id '.
                          'INNER JOIN serverInfo ON serverInfo.id = playeractiveitem.serverInfo_id AND serverInfo.server_id='.(int)$serverId;
        $criteria->group = 't.id';

        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('playername',$this->playername,true);
        $criteria->compare('extId',$this->extId);

        $sort = new CSort();
        $sort->attributes = array(
            'totalplaytime'=>array(
                'asc'=>'totalplaytime ASC',
                'desc'=>'totalplaytime DESC',
            ),
            '*', // add all of the other columns as sortable

        );
        $sort->defaultOrder = 'totalplaytime DESC';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => $sort,
        ));
    }
}