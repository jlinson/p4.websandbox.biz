<?php
/* @var $this SiteController */

$cs=Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;

// Next line overrides default behavior that appends "- <controller_name>" to the page title - jbl
$this->pageTitle=Yii::app()->name . ' - Index';
$headerName = substr(Yii::app()->name, 0, strpos(Yii::app()->name, "("));
$this->breadcrumbs=array(
    'Index',
);
?>

<h1><i><?php echo CHtml::encode($headerName); ?></i>&nbsp;Site Index</h1>

<p>Click on the "Home" link above to play Sudo Sudoku.</p>

<?php
//echo '<pre>'; print_r(Yii::app()->user); echo '</pre>';
?>
