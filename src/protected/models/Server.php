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
			array('name, ip, port, type', 'required'),
			array('mission_id, maxPlayer, passwordProtected, port', 'numerical', 'integerOnly'=>true),
			array('name, hostname', 'length', 'max'=>255),
			array('ip, type', 'length', 'max'=>45),
            array('country', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, ip, port, type, country, mission_id, hostname, maxPlayer, passwordProtected', 'safe', 'on'=>'search'),
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
			'serverinfos' => array(self::HAS_MANY, 'ServerInfo', 'server_id', 'with' => array('playercount')),
            'lastServerInfo'=>array(self::HAS_MANY, 'ServerInfo', 'server_id', 'order' => 'lastServerInfo.date DESC', 'limit' => 1, 'with' => array('playercount')),
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
            'country' => Yii::t('module','Land'),
			'mission_id' => Yii::t('module','Mission'),
			'hostname' => Yii::t('module','Hostname'),
			'maxPlayer' => Yii::t('module','Max. Spielerzahl'),
			'passwordProtected' => Yii::t('module','Passwort geschützt'),
            'lastUpdate' => Yii::t('module','Letztes Update'),
            'playercount' => Yii::t('module','Spieler'),
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
        $criteria->compare('country',$this->country,true);
		$criteria->compare('mission_id',$this->mission_id);
		$criteria->compare('hostname',$this->hostname,true);
		$criteria->compare('maxPlayer',$this->maxPlayer);
        if ($this->passwordProtected == null) {
            $criteria->compare('passwordProtected',null);
        } else if ($this->passwordProtected) {
            $criteria->compare('passwordProtected','>0');
        } else {
            $criteria->compare('passwordProtected',0);
        }


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function updateServer() {
        Yii::import('ext.gameq.GameQ');
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
        $servers = Server::model()->with('mission','addons','lastServerInfo')->findAll();
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

        $oldAddons = $this->addons;
        $oldAddonsNames = array();
        $oldAddonsIds = array();
        foreach ($oldAddons as $addon) {
            $oldAddonsNames[$addon->shortname] = $addon->shortname;
            $oldAddonsIds[$addon->shortname] = $addon;
        }

        $addons = explode(";",$data['gq_mod']);
        $diff = array_diff($oldAddonsNames,$addons) + array_diff($addons,$oldAddonsNames);
        if (!empty($diff)) {
            $existingAddons = Addon::model()->findAllByAttributes(array('shortname'=>$diff));


            $changed = true;

            $newAddons = array();
            foreach ($addons as $addon) {
                if (isset($oldAddonsIds[$addon])) {
                    $newAddons[] = $oldAddonsIds[$addon];
                } else {
                    //Is it in existing addons?
                    $existingAddon = $this->findObjectById($existingAddons,"shortname",$addon);
                    if ($existingAddon) {
                        $newAddons[] = $existingAddon;
                    } else {
                        $newAddon = new Addon();
                        $newAddon->name = $addon;
                        $newAddon->shortname = $addon;
                        $newAddon->type = Addon::TYPE_OTHER;
                        $newAddons[] = $newAddon;
                    }
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
        } else if (!isset($data['mission']) && ($this->mission != null)) {
            $changed = true;
            $this->mission_id = null;
        }


        if ($changed) {
            $this->withRelated->save(true,$relationsToSave);
        }

        //Regardless of what happened, creation of an serverInfo item:
        $serverInfo = new ServerInfo();
        $serverInfo->server_id = $this->id;

        $loggableTime = ServerInfo::MAX_TIMEFRAME;
        $now = date('Y-m-d H:i:s');

        if (!empty($this->lastServerInfo)) {
            $diffToLast = time() - strtotime($this->lastServerInfo[0]->date);
            if ($diffToLast < ServerInfo::MAX_TIMEFRAME) {
                $loggableTime = $diffToLast;
            }
        }
        $serverInfo->date = $now;
        $serverInfo->timeframe = $loggableTime;

        $playerNames = array();
        if (isset($data['players']) && !empty($data['players'])) {
            foreach ($data['players'] as $player) {
                if (isset($player['player_'])) {
                    $playerNames[] = $player['player_'];
                }
            }
        }

        $existingPlayers = Member::model()->findAllByAttributes(array('playername'=>$playerNames));

        $playerActiveItems = array();
        foreach ($playerNames as $playerName) {
            $player = null;
            $existingPlayer = $this->findObjectById($existingPlayers,"playername",$playerName);
            if ($existingPlayer !== false) {
                $player = $existingPlayer;
            } else {
                $newPlayer = new Member();
                $newPlayer->extId = null;
                $newPlayer->name = $playerName;
                $newPlayer->playername = $playerName;
                $player = $newPlayer;
            }

            $playerActiveItem = new PlayerActiveItem();
            $playerActiveItem->member = $player;
            $playerActiveItems[] = $playerActiveItem;
        }

        if (!empty($playerActiveItems)) {
            $serverInfo->playeractiveitems = $playerActiveItems;
            $serverInfo->withRelated->save(false,array('playeractiveitems' => array('member')));
        } else {
            $serverInfo->save(true);
        }
    }


    public function findObjectById($array,$property,$id){
        if (!is_array($array)) {
            return false;
        }
        foreach ( $array as $element ) {
            if ( $id == $element->$property ) {
                return $element;
            }
        }
        return false;
    }

    public function findArrayById($array,$attribute,$id){
        if (!is_array($array)) {
            return false;
        }
        foreach ( $array as $element ) {
            if ( $id == $element[$attribute] ) {
                return $element;
            }
        }
        return false;
    }


    public function getCommulatedPlayerCounts($startDate,$endDate,$interval,$intervalType = "days",$labelFormat = "Y-m-d H:i:s") {
        //Create intervals:
        $endDateStamp = strtotime($endDate);
        $startDateStamp = strtotime($startDate);
        $i = 0;
        $distances = array();
        $subQuery = "";
        while (strtotime("+".(($i+1)*$interval)." ".$intervalType,$startDateStamp) < $endDateStamp) {
            $distance = array();
            $distance['fromTimestamp'] = strtotime("+".($i*$interval)." ".$intervalType,$startDateStamp);
            $distance['toTimestamp'] = strtotime("+".(($i+1)*$interval)." ".$intervalType,$startDateStamp);
            $distance['from'] = date($labelFormat, $distance['fromTimestamp']);
            $distance['to'] = date($labelFormat, $distance['toTimestamp']);
            $distances[] = $distance;

            //Special care here! Injections could be possible by not using DAO
            if ($i > 0) {
                $subQuery = $subQuery." UNION ALL ";
            }
            $subQuery = $subQuery." SELECT '".((int)$distance['fromTimestamp'])."' fromDate, '".((int)$distance['toTimestamp'])."' toDate, ".((int)$i)." intervalNumber ";
            $i++;
        }

        //Run the query
        $sql = "SELECT COUNT(DISTINCT member_id) AS commulatedPlayerCount, intervals.intervalNumber as intervalNumber  FROM serverInfo
                LEFT JOIN playeractiveitem ON playeractiveitem.serverInfo_id = serverInfo.id
                LEFT JOIN ( $subQuery ) intervals ON intervals.fromDate <= UNIX_TIMESTAMP(serverInfo.date) AND intervals.toDate > UNIX_TIMESTAMP(serverInfo.date)
                WHERE
                  server_id = :server_id
                GROUP BY intervalNumber";
        $command = Yii::app()->db->createCommand($sql);
        $server_id = $this->id;
        $command->bindParam(":server_id", $server_id, PDO::PARAM_INT);
        $rawData = $command->queryAll();
        $command->reset();

        //Format the results
        $result = array();
        $result['distances'] = $distances;
        $result['raw'] = $rawData;
        $result['labels'] = array();
        $result['playercounts'] = array();
        foreach ($distances as $key => $distance) {
            $result['labels'][] = $distance['from'];
            $item = $this->findArrayById($rawData,'intervalNumber',$key);
            $result['playercounts'][] = ($item)?$item['commulatedPlayerCount']:0;
        }

        return $result;
    }
}