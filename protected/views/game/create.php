<?php
/* @var $this GameController */
/* @var $model Game */

$cs=Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
/* --Required for _grid view-in-view ------------------------------------------------------------------- */
$cs->registerScriptFile($baseUrl . '/js/create.js', CClientScript::POS_END);
/* --End _grid view-in-view ---------------------------------------------------------------------------- */

$this->breadcrumbs=array(
	'Games'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Game', 'url'=>array('index')),
	array('label'=>'Manage Game', 'url'=>array('admin')),
);
?>

<h1>Create Game</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>