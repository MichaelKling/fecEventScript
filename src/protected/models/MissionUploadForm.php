<?php
/**
 * Created by Ascendro S.R.L.
 * User: Michael
 * Date: 22.06.13
 * Time: 10:57
 */
class MissionUploadForm extends CFormModel
{
    const ALG_FAST = "fast";
    const ALG_SMALL = "small";
    const ALG_C = "c";

    public $missionFile;
    public $algorithm;
    public function rules()
    {
        return array(
            array('algorithm','in','range'=>array(MissionUploadForm::ALG_FAST,MissionUploadForm::ALG_SMALL,MissionUploadForm::ALG_C),'allowEmpty'=>false),
            array('missionFile', 'file', 'types'=>'sqm, pbo'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'missionFile'=>Yii::t('model','Missions Datei'),
            'algorithm'=>Yii::t('model','Auslese Algorithmus'),
        );
    }

    public function algorithmLabels() {
        return array(
            MissionUploadForm::ALG_SMALL => Yii::t('model','PHP - Etwas langsamer Algorithmus, jedoch sehr Speicherfreundlich'),
            MissionUploadForm::ALG_FAST => Yii::t('model','PHP - Schneller Algorithmus, jedoch sehr Speicherhungring'),
            MissionUploadForm::ALG_C => Yii::t('model','C - Algorithmus implementiert in C, sehr schnell.'),
        );
    }

    public function getAlgorithmLabel($label) {
        $labels = $this->algorithmLabels();
        if (isset($labels[$label])) {
            return $labels[$label];
        }
        return null;
    }

    public function parseSlotInformations()
    {
        $now = microtime(true);
        $nowMemory = memory_get_usage();

        if (!$this->validate()) {
            return false;
        }
        $fileType = $this->missionFile->getExtensionName();

        if ($this->algorithm == MissionUploadForm::ALG_C) {
            chdir('./protected/extensions');
            $output = "";
            $fileLocation = $this->missionFile->getTempName();
            if ($fileType == "pbo") {
                $output = shell_exec('./cpboExtractor/pboExtractor  --file "'.$fileLocation.'"  mission.sqm | ./csqmparser/sqmParser');
            } else {                
                $output = shell_exec('./csqmparser/sqmParser --file "'.$fileLocation.'"');                       
            }
            chdir('../..');        
            
            $slots = eval($output);
        } else {
            $sqmHandler = null;
            if ($fileType == "pbo") {
                    Yii::import('ext.pboextractor.PBOExtractor');
                    $pboFileEntry = PBOExtractor::extract("mission.sqm",$this->missionFile->getTempName());
                    $sqmHandler = $pboFileEntry->content;
                    if (!PBOExtractor::lastRunSuccesfull()) {
                        $this->addError("missionFile",PBOExtractor::getLastErrorMessage());
                        return false;
                    }
            } else {
                $sqmHandler = fopen($this->missionFile->getTempName(),'r');
            }
            
            if ($this->algorithm == MissionUploadForm::ALG_FAST) {
                Yii::import('ext.sqmparser.SQMFastParser');
                $sqmFile = SQMFastParser::parseStream($sqmHandler);
            } else if ($this->algorithm == MissionUploadForm::ALG_SMALL) {
                Yii::import('ext.sqmparser.SQMParser');
                $sqmFile = SQMParser::parseStream($sqmHandler);
            } else {
                Yii::import('ext.sqmparser.SQMFastParser');
                $sqmFile = SQMFastParser::parseStream($sqmHandler);
            }

            $sqmFile->parse();
            $slots = $sqmFile->searchPlayableSlots(true);
            unset($sqmFile);     

        }

        $then = microtime(true);
        $thenMemory = memory_get_usage();
        $peakMemory = memory_get_peak_usage();
        $memory = $thenMemory - $nowMemory;
        $time = $then-$now;

        Yii::app()->user->setFlash('success', Yii::t("model","Datei erfolgreich eingelesen. Ausführungszeit: {time} Sekunden. Speicherverbrauch: {memory} Bytes. Grösster Speicherverbrauch: {memoryPeak} Bytes",
            array("{time}" => $time, "{memory}" => $memory, "{memoryPeak}" => $peakMemory)));


        return $slots;
    }

    public function saveSlotInformations($mission,$slotInformation) {
        $mission->deleteAllSlots();
        $groupWeightCounter = 0;
        foreach ($slotInformation as $sideName => $side) {
            foreach ($side as $squad) {
                $group = new MissionSlotGroup();
                $group->mission_id = $mission->getPrimaryKey();
                $group->name = "1-1-".$squad['name'];
                $group->group = $sideName;
                $group->weight = $groupWeightCounter++;
                if (!$group->save()) {
                    throw new CHttpException(404,'Group could not be saved.'.CHtml::errorSummary($group));
                }
                $slotWeightCounter = 0;
                foreach ($squad['slots'] as $player) {
                    $slot = new MissionSlot();
                    if ($player['description']) {
                        $slot->name = ($player['groupId']+1).": ".$player['description'];
                    } else {
                        $slot->name = ($player['groupId']+1).": ".$player['classname']." [".$player['rankShortName']."]" ;
                    }
                    if ($player['position']) {
                        $slot->name .= " ".$player['position'];
                    }
                    if ($player['isLeader']) {
                        $slot->name .= " ".Yii::t("slots",", Anführer");
                    }
                    //Cutting string to database size
                    $slot->name = substr($slot->name,0,45);
                    $slot->missionSlotGroup_id = $group->getPrimaryKey();
                    $slot->weight = $slotWeightCounter++;
                    if (!$slot->save()) {
                        throw new CHttpException(404,'Slot could not be saved.'.CHtml::errorSummary($slot));
                    }
                }
            }
        }
    }
}
