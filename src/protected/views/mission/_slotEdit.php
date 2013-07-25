<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michael
 * Date: 25.07.13
 * Time: 13:58
 * To change this template use File | Settings | File Templates.
 */

Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');

$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl.'/js/jquery.editinplace.js');
?>
<div class="form">

    <b><?php echo Yii::t("model","Slots editieren:") ?></b>

    <?php $form=$this->beginWidget('CActiveForm', array(
                                                       'id'=>'missionSlotEditForm-form',
                                                       'enableAjaxValidation'=>false,
                                                       'htmlOptions' => array('enctype' => 'multipart/form-data'),
                                                  )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="slotSidesAccordion">
    </div>

    <div class="row">
        <?php echo $form->hiddenField($model,'serializedSlots',array('value'=>"")); ?>
        <?php echo CHtml::submitButton(Yii::t('model','Änderungen speichern')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>

<style>
    .ui-state-highlight { height:20px; background-color:yellow;}
    .btn-delete { display:inline; float:right; height:15px; width:15px;margin-top:5px;margin-right:8px;}
    .btn-move { display:inline; float:right; height:15px; width:15px;margin-top:5px;margin-right:8px;}
    .accordionName { margin-left:50px;}
    .ui-accordion-header {height:26px;line-height:24px;}
    .slotEntry {height: 26px;line-height:24px;display:block;font-weight: bold;border:1px solid #CCCCCC;margin:1px;padding-left:20px;}
</style>

<script>

    $("#missionSlotEditForm-form").submit(function(event){
        $('#SlotForm_serializedSlots').val(serializeSlots());
    });

    $(function() {
    var localSquad = null;
    <?php
    $built['BLUFOR'] = false;
    $built['OPFOR'] = false;
    $built['Independend'] = false;
    $built['Civil'] = false;

    //Running all through translator to guarantee availability in translation files
    Yii::t("model","BLUFOR");
    Yii::t("model","OPFOR");
    Yii::t("model","Independend");
    Yii::t("model","Civil");

    foreach ($mission->missionslotgroups as $slotgroup) {
        if (!$built[$slotgroup->group]) {
            echo 'var '.strtolower($slotgroup->group).'  = slotSidesAccordionAddElement("'.Yii::t("model",$slotgroup->group).'",true);'."\n";
            $built[$slotgroup->group] = true;
        }

        echo 'localSquad = slotSquadsAccordionAddElement('.strtolower($slotgroup->group).',"'.($slotgroup->name).'",true);'."\n";
        foreach ($slotgroup->missionslots as $slot) {
           echo 'slotSlotsAccordionAddElement(localSquad,"'.$slot->name.'",true);'."\n";
        }
    }

    foreach ($built as $side => $value) {
        if (!$value) {
            echo 'var '.strtolower($side).'  = slotSidesAccordionAddElement("'.Yii::t("model",$side).'",true);'."\n";
        }
    }
?>


        rebuildSideAccordion(".slotSidesAccordion",false);
        rebuildSquadsAccordion(".slotSquadsAccordion",false);
        rebuildSlotsAccordion(".slotSlotsAccordion");
        createButtons();

        //Overwriting key down function of accordion, so people can use the textbox freely.
        delete($.ui.accordion.prototype._keydown);
        $.ui.accordion.prototype._keydown = function( event ) {
        };

    });

    function createButtons() {
        $( ".btn-delete" ).button({
            icons: {
                primary: "ui-icon-trash"
            },
            text: false
        });
        $( ".btn-move" ).button({
            icons: {
                primary: "ui-icon-arrowthick-2-n-s"
            },
            text: false
        });

        $(".inlineEdit").editInPlace({
            callback: function(unused, enteredText) { return enteredText; },
            show_buttons: true,
            value_required: true,
            save_button:		'<button class="inplace_save"><?php echo Yii::t("model","Übernehmen"); ?></button>',
            cancel_button:		'<button class="inplace_cancel"><?php echo Yii::t("model","Abbrechen"); ?></button>'
        });

        $('.inlineEdit, .btn-move, .btn-delete').click(function(e) {
            e.stopPropagation();
        });
    }

    function slotSidesAccordionAddElement(name,noRefresh) {
        var active = $('.slotSidesAccordion').accordion('option', 'active');
        var panelCount = $(".slotSidesAccordion").children().length;
        $( ".slotSidesAccordion" ).append('<div class="group">' +
                '<h3><span class="accordionName">'+name+'</span><span class="counter">(0)</span><span class="btn-move"><?php echo Yii::t("model","Verschieben"); ?></span></h3>' +
                '<div>' +
                    '<button type="button" onclick="slotSquadsAccordionAddElement(\'slotSquadsAccordion_'+panelCount+'\',\'<?php echo Yii::t("model","Neuer Squad"); ?>\')"><?php echo Yii::t("model","Squad hinzuzügen"); ?></button>' +
                    '<div id="slotSquadsAccordion_'+panelCount+'" class="slotSquadsAccordion">' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '');
            if (noRefresh != true) {
                rebuildSideAccordion(".slotSidesAccordion",active);
                createButtons();
            }
        return 'slotSquadsAccordion_'+panelCount;
    }


    function slotSquadsAccordionAddElement(id,name,noRefresh) {
        var active = $('#'+id).accordion('option', 'active');
        var panelCount = $('#'+id).children().length;
        $( '#'+id ).append('<div class="group" id="'+id+'slotSlotsAccordion_'+panelCount+'_container">' +
            '<h3><span class="accordionName inlineEdit">'+name+'</span><span class="counter">(0)</span><span class="btn-delete" onclick="slotSquadsAccordionRemoveElement(\''+id+'slotSlotsAccordion_'+panelCount+'_container\')"><?php echo Yii::t("model","Löschen"); ?></span><span class="btn-move"><?php echo Yii::t("model","Verschieben"); ?></span></h3>' +
                '<div>' +
                    '<button type="button" onclick="slotSlotsAccordionAddElement(\''+id+'slotSlotsAccordion_'+panelCount+'\',\'<?php echo Yii::t("model","Neuer Slot"); ?>\')"><?php echo Yii::t("model","Slot hinzuzügen"); ?></button>' +
                    '<div id="'+id+'slotSlotsAccordion_'+panelCount+'" class="slotSlotsAccordion">' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '');
        $( '#'+id ).parent().prev().children(".counter").text("("+(panelCount+1)+")");
        if (noRefresh != true) {
            rebuildSquadsAccordion('#'+id,active);
            createButtons();
        }
        return id+'slotSlotsAccordion_'+panelCount;
    }


    function slotSlotsAccordionAddElement(id,name,noRefresh) {
        var active = $('#'+id).accordion('option', 'active');
        var panelCount = $('#'+id).children().length;
        $( '#'+id ).append('<div class="group" id="'+id+'slot_'+panelCount+'_container">' +
            '<div class="slotEntry"><span class="slotName inlineEdit">'+name+'</span><span class="btn-delete" onclick="slotSlotsAccordionRemoveElement(\''+id+'slot_'+panelCount+'_container\')"><?php echo Yii::t("model","Löschen"); ?></span><span class="btn-move"><?php echo Yii::t("model","Verschieben"); ?></span></div>' +
            '</div>' +
            '');
        $( '#'+id ).parent().prev().children(".counter").text("("+(panelCount+1)+")");
        if (noRefresh != true) {
            rebuildSlotsAccordion('#'+id);
            createButtons();
        }
        return false;
    }

    function slotSquadsAccordionRemoveElement(containerId) {
        if(confirm("<?php echo Yii::t("model","Soll der Squad wirklich gelöscht werden?"); ?>")) {
            var accordion = $('#'+containerId).parent();
            $('#'+containerId).remove();
            accordion.parent().prev().children(".counter").text("("+accordion.children().length+")");
        }
    }

    function slotSlotsAccordionRemoveElement(containerId) {
        if(confirm("<?php echo Yii::t("model","Soll der Slot wirklich gelöscht werden?"); ?>")) {
            var accordion = $('#'+containerId).parent();
            $('#'+containerId).remove();
            accordion.parent().prev().children(".counter").text("("+accordion.children().length+")");
        }
    }

    function rebuildSideAccordion(id,active) {
        $(id).sortable('destroy').accordion('destroy').accordion({
            autoHeight: false,
            collapsible: true,
            header: '> div > h3',
            active: active
        }).sortable({
                axis: "y",
                handle: ".btn-move",
                placeholder: "ui-state-highlight",
                stop: function( event, ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( "h3" ).triggerHandler( "focusout" );
                }
            });
    }

    function rebuildSquadsAccordion(id,active) {
        $(id).sortable('destroy').accordion('destroy').accordion({
            autoHeight: false,
            collapsible: true,
            header: '> div > h3',
            active: active
        }).sortable({
                axis: "y",
                handle: ".btn-move",
                placeholder: "ui-state-highlight",
                stop: function( event, ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( "h3" ).triggerHandler( "focusout" );
                }
            });
    }

    function rebuildSlotsAccordion(id) {
        $(id)
            .sortable('destroy').sortable({
                axis: "y",
                handle: ".btn-move",
                placeholder: "ui-state-highlight",
                stop: function( event, ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( "h3" ).triggerHandler( "focusout" );
                }
            });
    }


    function serializeSlots() {
        var sides = [];
        var curSide = null;
        var curSquad = null;
        $(".slotSidesAccordion > .group").each(function(idx,el) {
            var side = $(el).children("h3").children(".accordionName").text();
            curSide = {
                'name' : side,
                'squads' : []
            };
            $(el).children("div").children(".slotSquadsAccordion").children(".group").each(function(idx,el) {
               var squad = $(el).children("h3").children(".accordionName").text();
               curSquad = {
                   'name' : squad,
                   'slots' : []
               }
                $(el).children("div").children(".slotSlotsAccordion").children(".group").each(function(idx,el) {
                    var slot = $(el).children(".slotEntry").children(".slotName").text();
                    curSquad.slots.push(slot);
                });

                curSide.squads.push(curSquad);
            });

            sides.push(curSide);
        });

        return JSON.stringify(sides);
    }
</script>