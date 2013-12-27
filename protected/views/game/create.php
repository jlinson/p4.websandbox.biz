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

<div id="sidebar">
    <!-- <hr> -->
    <h5 id="game-validation">Level Ranges:</h5>
    <ul id="level-ranges">
        <li id="max">Maximum - 38 to 50 cells<br>(303 - 400 char)</li>
        <li id="beg">Beginner - 34 to 37 cells<br>(271 - 295 char)</li>
        <li id="ezy">Easy - 31 to 33 cells<br>(247 - 263 char)</li>
        <li id="med">Medium - 28 to 30 cells<br>(223 - 239 char)</li>
        <li id="hrd">Hard - 25 to 27 cells<br>(199 - 215 char)</li>
        <li id="exp">Expert - 22 to 24 cells<br>(175 - 191 char)</li>
        <li id="min">Minimum - 17 to 21 cells<br>(135 - 167 char)</li>
    </ul>
    <div>Cells:&nbsp;<span id="cells">0</span>&nbsp;&nbsp;(chars: <span id="chars">0</span>)</div>
    <br>
    <div id="override">
        <?php echo CHtml::checkBox("rating-override", false); ?>
        <?php echo CHtml::label("Override Auto-rating?", "rating-override"); ?>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>