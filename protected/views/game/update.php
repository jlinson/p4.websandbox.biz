<?php
/* @var $this GameController */
/* @var $model Game */

$this->breadcrumbs=array(
	'Admin'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Play Game', 'url'=>array('index')),
	array('label'=>'Create Game', 'url'=>array('create')),
	array('label'=>'View Game', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Game', 'url'=>array('admin')),
);
?>

<h1>Update Game <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>