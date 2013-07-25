<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michael
 * Date: 25.07.13
 * Time: 13:39
 * To change this template use File | Settings | File Templates.
 */
class SlotForm extends CFormModel {

    public $serializedSlots;
    public function rules()
    {
        return array(
            array('serializedSlots','required'),
        );
    }

    public function saveSlotInformations($mission) {
        $slotInformation = json_decode($this->serializedSlots);
        if (!$slotInformation) {
            throw new CHttpException(404,'Something was wrong with the JSON encoded string.');
        }
        $mission->deleteAllSlots();
        $groupWeightCounter = 0;
        foreach ($slotInformation as $side) {
            foreach ($side->squads as $squad) {
                $group = new MissionSlotGroup();
                $group->mission_id = $mission->getPrimaryKey();
                $group->name = $squad->name;
                $group->group = $side->name;
                $group->weight = $groupWeightCounter++;
                if (!$group->save()) {
                    throw new CHttpException(404,'Group could not be saved.'.CHtml::errorSummary($group));
                }
                $slotWeightCounter = 0;
                foreach ($squad->slots as $player) {
                    $slot = new MissionSlot();
                    $slot->name = $player;
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
