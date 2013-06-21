<?php

/**
 * This is the model class for table "serverinfo".
 *
 * The followings are the available columns in table 'serverinfo':
 * @property integer $id
 * @property string $date
 * @property integer $server_id
 *
 * The followings are the available model relations:
 * @property Playeractiveitem[] $playeractiveitems
 * @property Server $server
 */
class ServerInfo extends CActiveRecord
{
    const MAX_TIMEFRAME = 3600;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServerInfo the static model class
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
		return 'serverinfo';
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
			array('date, server_id', 'required'),
			array('server_id, timeframe', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, timeframe, server_id', 'safe', 'on'=>'search'),
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
			'playeractiveitems' => array(self::HAS_MANY, 'PlayerActiveItem', 'serverInfo_id'),
            'playercount'=>array(self::STAT, 'PlayerActiveItem', 'serverInfo_id'),
			'server' => array(self::BELONGS_TO, 'Server', 'server_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('model','ID'),
			'date' => Yii::t('model','Date'),
            'timeframe' => Yii::t('model','Gebuchte Zeit'),
			'server_id' => Yii::t('model','Server'),
            'playercount' => Yii::t('model','Spielerzahl'),
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
        $criteria->compare('timeframe',$this->timeframe);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('server_id',$this->server_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function delete(){
        //We need to go through all the item and not call deleteAll as we have to use the correspondending delete() function
        foreach ( $this->playeractiveitems as $playeractiveitem ){
            $playeractiveitem->delete();
        }
        parent::delete();
    }
}