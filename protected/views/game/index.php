<?php
/* @var $this GameController */
/* @var $dataProvider CActiveDataProvider - OVERRIDDEN */
/* @var $model Game - if called by actionView($id)    */

$cs=Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
/* --Required for _grid view-in-view ------------------------------------------------------------------- */
$cs->registerScriptFile($baseUrl . '/js/game.js', CClientScript::POS_END);
/* --End _grid view-in-view ---------------------------------------------------------------------------- */
$cs->registerScriptFile($baseUrl . '/js/preferences.js', CClientScript::POS_END);
$cs->registerScript('juiAccordian','$("#sidebar").accordion();', CClientScript::POS_READY);

// Next line overrides default behavior that appends "- <controller_name>" to the page title - jbl
$this->pageTitle=Yii::app()->name;
$headerName = substr(Yii::app()->name, 0, strpos(Yii::app()->name, "("));
?>

<h1>Welcome to <i><?php echo CHtml::encode($headerName); ?></i></h1>

<?php $this->renderPartial('_grid', array('model'=>$model)); ?>

<div id="sidebar" title="Turn off tooltips in 'Preferences'.">
    <h3>Instructions</h3>
    <div>
        <h5>Game Rules:</h5>
        <p>Solve the Su Doku puzzle by entering a number from 1 to 9 in the empty cells. Each number can only
        appear once in a row, once in a column and once in each 3x3 grid.</p>
        <h5>Sudo Sudoku Instructions:</h5>
        <p>To start a game, click 'New Game'. You can select the game difficulty from the 'Game Level'
        drop-down. On large screens, both keyboard and mouse/touch entry work. Click on a cell, then type a
        number, or select a number from the number bar below the grid. You can turn off keyboard input in the
        <strong>Preferences</strong> section.</p>
    </div>
    <h3>Preferences</h3>
    <div>
        <form name="preferences" method="post" action="index.php">
            <input type="checkbox" name="keyboard" value="enabled" checked>Keyboard Entry<br>
            <input type="checkbox" name="tooltips" value="enabled" checked>Tooltips<br>
        </form>
        <br>
        <button name="pref-apply" type="button" disabled>Apply</button>
    </div>
    <h3>Additional Information</h3>
    <div>
        <p>See the <strong>Preferences</strong> section for additional game settings.</p>
        <p>Click the <strong>About</strong> option in the top menu to learn more about this program.</p>
        <p>If you have any questions, comments, or encounter any problems, please feel free to fill out a
        <strong>Contact</strong> form.</p>
        <p>Thank you.</p>
    </div>
    <h3>Yii Framework Info</h3>
    <div>
        <p>For more details regarding the framework used to develop this application, please read
        the <a href="http://www.yiiframework.com/doc/">documentation</a>.
        Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
        should you have any questions.</p>
    </div>
</div>
