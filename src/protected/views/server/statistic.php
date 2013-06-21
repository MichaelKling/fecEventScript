<?php
/**
 * Created by Ascendro S.R.L.
 * User: Michael
 * Date: 21.06.13
 * Time: 11:21
 */
$this->breadcrumbs=array(
    'Servers'=>array('index'),
    $model->name=>array('view','id'=>$model->id),
    'Statistic',
);

$this->menu=array(
    array('label'=>'Create Server', 'url'=>array('create')),
    array('label'=>'View Server', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Update Server', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Query Server', 'url'=>array('query', 'id'=>$model->id)),
    array('label'=>'Delete Server', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage Server', 'url'=>array('admin')),
);
?>


<h1>View Server Statistics #<?php echo $model->id; ?> - <?php echo $model->name; ?></h1>

<?php
  //LazyLoading Chards
  Yii::app()->chartjs;
?>
<p>
<h2>Spieleranzahl in den letzten 24h</h2>

<?php $this->widget(
            'chartjs.widgets.ChLine',
            array(
                'width' => 750,
                'height' => 300,
                'htmlOptions' => array(),
                'labels' => $last24Labels,
                'datasets' => array(
                    array(
                        "fillColor" => "rgba(183, 214, 231,0.5)",
                        "strokeColor" => "rgba(111, 172, 207, 1)",
                        "pointColor" => "#EFFDFF",
                        "pointStrokeColor" => "rgba(111, 172, 207, 1)",
                        "data" => $last24Data
                    ),
                ),
                'options' => array(
                    'scaleOverride' => true,
                    'scaleStartValue' => (min($last24Data)-2>0)?min($last24Data)-2:0,
                    'scaleSteps' => floor(((max($last24Data)+2<$model->maxPlayer)?max($last24Data)+2:max($last24Data))/2),
                    'scaleStepWidth' => 2,
                )
            )
        );
    ?>
</p>
<p>
<h2>Spieleranzahl in den letzten 30 Tagen</h2>

<?php $this->widget(
    'chartjs.widgets.ChLine',
    array(
        'width' => 750,
        'height' => 300,
        'htmlOptions' => array(),
        'labels' => $last30Labels,
        'datasets' => array(
            array(
                "fillColor" => "rgba(183, 214, 231,0.5)",
                "strokeColor" => "rgba(111, 172, 207, 1)",
                "pointColor" => "#EFFDFF",
                "pointStrokeColor" => "rgba(111, 172, 207, 1)",
                "data" => $last30Data
            ),
        ),
        'options' => array(
            'scaleOverride' => true,
            'scaleStartValue' => (min($last30Data)-2>0)?min($last30Data)-2:0,
            'scaleSteps' => floor(((max($last30Data)+2<$model->maxPlayer)?max($last30Data)+2:max($last30Data))/2),
            'scaleStepWidth' => 2,
        )
    )
);
?>
</p>
<p>
<h2>Spieleranzahl in den letzten 12 Monaten</h2>

<?php $this->widget(
    'chartjs.widgets.ChLine',
    array(
        'width' => 750,
        'height' => 300,
        'htmlOptions' => array(),
        'labels' => $last12Labels,
        'datasets' => array(
            array(
                "fillColor" => "rgba(183, 214, 231,0.5)",
                "strokeColor" => "rgba(111, 172, 207, 1)",
                "pointColor" => "#EFFDFF",
                "pointStrokeColor" => "rgba(111, 172, 207, 1)",
                "data" => $last12Data
            ),
        ),
        'options' => array(
            'scaleOverride' => true,
            'scaleStartValue' => (min($last12Data)-2>0)?min($last12Data)-2:0,
            'scaleSteps' => floor(((max($last12Data)+2<$model->maxPlayer)?max($last12Data)+2:max($last12Data))/2),
            'scaleStepWidth' => 2,
        )
    )
);
?>
</p>
<p>
<h2>Spieler nach meister Spielzeit</h2>
</p>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'player-grid',
    'dataProvider'=>$memberDataprovider,
    'filter'=>$member,
    'columns'=>array(
        array(
            'name' => 'id',
            'value' => 'CHtml::link($data->id,array("member/view", "id" => $data->id))',
            'type' => 'raw',
        ),
        'playername',
        'name',
        array(
            'name' => 'totalplaytime',
            'header'=> $member->getAttributeLabel('totalplaytime'),
            'value' => '$data->totalplaytime',
            'filter' => "",
        ),
    ),
)); ?>