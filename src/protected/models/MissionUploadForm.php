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


    public $missionFile;
    public $algorithm;
    public function rules()
    {
        return array(
            array('algorithm','in','range'=>array(MissionUploadForm::ALG_FAST,MissionUploadForm::ALG_SMALL),'allowEmpty'=>false),
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
            MissionUploadForm::ALG_SMALL => Yii::t('model','Etwas langsamer Algorithmus, jedoch sehr Speicherfreundlich'),
            MissionUploadForm::ALG_FAST => Yii::t('model','Schneller Algorithmus, jedoch sehr Speicherhungring'),
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
        } else {
            Yii::import('ext.sqmparser.SQMParser');
            $sqmFile = SQMParser::parseStream($sqmHandler);
        }
        $sqmFile->parse();
        $slots = $sqmFile->searchPlayableSlots(true);


        $then = microtime(true);
        $thenMemory = memory_get_usage();
        $peakMemory = memory_get_peak_usage();
        $memory = $thenMemory - $nowMemory;
        $time = $then-$now;

        Yii::app()->user->setFlash('success', Yii::t("model","Datei erfolgreich eingelesen. Ausführungszeit: {time} Sekunden. Speicherverbrauch: {memory} Bytes. Grösster Speicherverbrauch: {memoryPeak} Bytes",
            array("{time}" => $time, "{memory}" => $memory, "{memoryPeak}" => $peakMemory)));


        return $slots;
    }
}
