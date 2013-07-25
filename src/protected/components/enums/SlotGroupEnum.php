<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michael
 * Date: 25.07.13
 * Time: 11:38
 * To change this template use File | Settings | File Templates.
 */
class SlotGroupEnum extends DBEnum
{
    const BLUFOR = "BLUFOR";
    const OPFOR = "OPFOR";
    const Independend = "Independend";
    const Civil = "Civil";
    
    protected function getDBField()
    {
        return 'group';
    }

    protected function getDBTable()
    {
        return 'slotgroup';
    }

    // Optionally define a condition if only some values of
    //the table are to be taken into consideration
    /*
    protected function getDBCondition()
    {
        return "other_field=value";
    }*/

}