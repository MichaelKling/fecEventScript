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
    const TYPE_OFP = "flashpoint";
    const TYPE_ARMA = "armedassault";
    const TYPE_ARMA2 = "arma2";
    const TYPE_ARMA3 = "arma3";
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
			array('name', 'required'),
			array('mission_id, maxPlayer, passwordProtected, port', 'numerical', 'integerOnly'=>true),
			array('name, hostname', 'length', 'max'=>255),
			array('ip, type', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, ip, port, type, mission_id, hostname, maxPlayer, passwordProtected', 'safe', 'on'=>'search'),
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
			'id' => Yii::t('module','ID'),
			'name' => Yii::t('module','Name'),
			'ip' => Yii::t('module','IP'),
            'port' => Yii::t('module','Port'),
            'type' => Yii::t('module','Typ'),
			'mission_id' => Yii::t('module','Mission'),
			'hostname' => Yii::t('module','Hostname'),
			'maxPlayer' => Yii::t('module','Max. Spielerzahl'),
			'passwordProtected' => Yii::t('module','Passwort geschützt'),
		);
	}

    public function typeLabels() {
        return array(
           Server::TYPE_OFP => Yii::t("model","Operation Flashpoint"),
           Server::TYPE_ARMA => Yii::t("model","Armed Assault"),
           Server::TYPE_ARMA2 => Yii::t("model","ArmA II"),
           Server::TYPE_ARMA3 => Yii::t("model","ArmA III"),
        );
    }

    public function getTypeLabel($type) {
        $labels = $this->typeLabels();
        return $labels[$type];
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
        $criteria->compare('port',$this->port);
        $criteria->compare('type',$this->type,true);
		$criteria->compare('mission_id',$this->mission_id);
		$criteria->compare('hostname',$this->hostname,true);
		$criteria->compare('maxPlayer',$this->maxPlayer);
		$criteria->compare('passwordProtected',$this->passwordProtected);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function updateServer() {
        $serversConf = array(
            $this->id => array($this->type, $this->ip, $this->port),
        );
        $serverList = array ($this->id => $this);

        $gq = new GameQ();
        $gq->addServers($serversConf);
        $gq->setOption('timeout', 5000);
        $gq->setFilter('normalise');
        $gq->setFilter('sortplayers', 'gq_ping');
        $results = $gq->requestData();

        foreach ($results as $id => $data) {
            $serverList[$id]->processServerUpdate($data);
        }

        return true;
    }

    public static function updateAllServer() {
        Yii::import('ext.gameq.GameQ');
        $servers = Server::model()->with('mission','addons')->findAll();
        $serversConf = array();
        $serverList = array();
        foreach($servers as $server) {
            $serversConf[$server->id] = array($server->type,$server->ip,$server->port);
            $serverList[$server->id] = $server;
        }

        $gq = new GameQ();
        $gq->addServers($serversConf);
        $gq->setOption('timeout', 2000);
        $gq->setFilter('normalise');
        $gq->setFilter('sortplayers', 'gq_ping');
        $results = $gq->requestData();

        foreach ($results as $id => $data) {
            $serverList[$id]->processServerUpdate($data);
        }

        return true;
    }

    public function processServerUpdate($data) {
        $changed = false;
        $relationsToSave = array();

        if ($data['gq_hostname'] != $this->hostname) {
            $changed = true;
            $this->hostname = $data['gq_hostname'];
        }

        if ($data['gq_maxplayers'] != $this->maxPlayer) {
            $changed = true;
            $this->maxPlayer = $data['gq_maxplayers'];
        }

        if ($data['gq_password'] != $this->passwordProtected) {
            $changed = true;
            $this->passwordProtected = $data['gq_password'];
        }

        $existingAddons = $this->addons;
        $existingAddonsNames = array();
        $existingAddonsIds = array();
        foreach ($existingAddons as $addon) {
            $existingAddonsNames[$addon->shortname] = $addon->shortname;
            $existingAddonsIds[$addon->shortname] = $addon;
        }

        $addons = explode(";",$data['gq_mod']);
        $diff = array_diff($existingAddonsNames,$addons) + array_diff($addons,$existingAddonsNames);
        if (!empty($diff)) {
            $changed = true;

            $newAddons = array();
            foreach ($addons as $addon) {
                if (isset($existingAddonsIds[$addon])) {
                    $newAddons[] = $existingAddonsIds[$addon];
                } else {
                    $newAddon = new Addon();
                    $newAddon->name = $addon;
                    $newAddon->shortname = $addon;
                    $newAddon->type = Addon::TYPE_OTHER;
                    $newAddons[] = $newAddon;
                }
            }
            $this->addons = $newAddons;
            $relationsToSave[] = 'addons';
        }

        if (isset($data['mission']) && (($this->mission == null) || ($data['mission'] != $this->mission->name))) {
            $changed = true;

            $newMission = Mission::model()->findByAttributes(array('name' => $data['mission']));

            if (!$newMission) {
                $newMission = new Mission();
                $newMission->name = $data['mission'];
            }
            $this->mission = $newMission;
            $relationsToSave[] = 'mission';
        }


        if ($changed) {
            $this->withRelated->save(true,$relationsToSave);
        }

        /*
        player
        $criteria->compare('mission_id',$this->mission_id);
        */
    }
}