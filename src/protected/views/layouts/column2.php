<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
    <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
    ?>

	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<div class="span-5 last">
	<div id="sidebar">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();

        $this->beginWidget('zii.widgets.CPortlet', array(
            'title'=>'Administration',
        ));
        $this->widget('zii.widgets.CMenu', array(
            'items'=>array(
                array('label'=>'Administratoren', 'url'=>array('/administrator/admin')),
                array('label'=>'Server', 'url'=>array('/server/admin')),
                array('label'=>'Addons', 'url'=>array('/addon/admin')),
            ),
            'htmlOptions'=>array('class'=>'operations'),
        ));
        $this->endWidget();
	?>
	</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>