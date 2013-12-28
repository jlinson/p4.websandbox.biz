<?php
/* @var $this GameController */
/* @var $model Game */

$this->breadcrumbs=array(
	'Manage',
);

$this->menu=array(
	array('label'=>'Play Game', 'url'=>array('/game/index')),
	array('label'=>'Create Game', 'url'=>array('/game/create')),
    array('label'=>'Manage Users', 'url'=>Yii::app()->getModule('user')->adminUrl),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#game-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Games</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'game-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'level_cd',
		array( 'name' => 'grid_string',
            'htmlOptions' => array('class'=>'game-grid_c2'),
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
