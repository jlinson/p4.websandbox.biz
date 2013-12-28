<?php
/* @var $this GameController */
/* @var $model Game */

$cs=Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
/* --Required for _grid view-in-view ------------------------------------------------------------------- */
$cs->registerScriptFile($baseUrl . '/js/create.js', CClientScript::POS_END);
/* --End _grid view-in-view ---------------------------------------------------------------------------- */

$this->breadcrumbs=array(
	'Manage Games'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'View Game', 'url'=>array('index')),
	array('label'=>'Manage Games', 'url'=>array('admin')),
);
?>

<h1>Create Game</h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>

<div id="sidebar">
    <!-- <hr> -->
    <h5 id="game-validation">Level Ranges:</h5>
    <ul id="level-ranges">
        <li id="max">Maximum - 38 to 66 cells<br>(227 - 400 char)</li>
        <li id="beg">Beginner - 34 to 37 cells<br>(203 - 221 char)</li>
        <li id="ezy">Easy - 31 to 33 cells<br>(185 - 197 char)</li>
        <li id="med">Medium - 28 to 30 cells<br>(167 - 179 char)</li>
        <li id="hrd">Hard - 25 to 27 cells<br>(149 - 161 char)</li>
        <li id="exp">Expert - 22 to 24 cells<br>(131 - 143 char)</li>
        <li id="min">Minimum - 17 to 21 cells<br>(101 - 125 char)</li>
    </ul>
    <div><strong>Cells:&nbsp;<span id="cells">0</span></strong>&nbsp;&nbsp;(chars: <span id="chars">0</span>)</div>
    <br>
    <div id="override">
        <?php echo CHtml::checkBox("rating-override", false); ?>
        <?php echo CHtml::label("Override Auto-rating?", "rating-override"); ?>
    </div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>