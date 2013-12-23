<?php
/* @var $this GameController */
/* @var $model Game */

/* --Required for _grid view-in-view ------------------------------------------------------------------- */
$cs=Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
$cs->registerScriptFile($baseUrl . '/js/grid.js', CClientScript::POS_END);
$cs->registerScriptFile($baseUrl . '/js/game.js', CClientScript::POS_END);
$cs->registerCssFile($baseUrl . '/css/grid.css');
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
<?php /* --Required for _grid view-in-view ------------------------------------------------------------------- */ ?>
    <h5 id="game-caption"></h5>
    <div id="game">
        <form name="game" method="post" action="index.php">
            <div id="grid" class="block-wrapper" title="Enter a number from 1 to 9. Red&nbsp;=&nbsp;conflict. Blue&nbsp;=&nbsp;current&nbsp;#.">
                <?php for ($i=0; $i < 3; $i++): ?>
                    <?php for ($j=0; $j < 3; $j++): ?>
                        <div class="block" id="b<?php echo (($i*3) + $j); ?>">
                            <?php for ($k=0; $k < 3; $k++): ?>
                                <?php for ($l=0; $l < 3; $l++): ?>
                                    <div class="cell input row<?php echo (string) (($i*3)+($k+1)); ?> col<?php echo (string) (($j*3)+($l+1)); ?>" id="c<?php echo (string) (($i*3)+$j) . (($k*3)+$l); ?>">
                                        <input type="text" maxlength="1" class="input-cell" name="c<?php echo (string) (($i*3)+$j) . (($k*3)+$l); ?>">
                                    </div>
                                <?php endfor; ?>
                            <?php endfor; ?>
                        </div>
                    <?php endfor; ?>
                <?php endfor; ?>
            </div>
        </form>
        <div id="grid-btns">
            <button name="undo" type="button" title="Click to undo entries in reverse order of entry.">Undo &#8634;</button>
            <button name="erase" type="button" title="Click to erase any entry independent of undo order.">Erase &#10008;</button>
        </div>
        <div id="tracker" class="block-wrapper" title="If input cell selected -&nbsp;click&nbsp;enters&nbsp;number in cell. If&nbsp;no&nbsp;cell&nbsp;selected -&nbsp;click&nbsp;highlights&nbsp;all matching #s.">
            <?php for ($t=0; $t < 9; $t++): ?>
                <div class="cell pickem" id="t<?php echo ($t + 1); ?>"><?php echo ($t + 1); ?></div>
            <?php endfor; ?>
        </div>
    </div>
    <div id="game-btns">
        <hr>
        <strong>Game Level:</strong>
        <select name="level" size="1">
            <option value="1">Beginner</option>
            <option value="2">Easy</option>
            <option value="3">Medium</option>
            <option value="4">Hard</option>
            <option value="5">Expert</option>
        </select>
        <button name="load" type="button" title="Select a game level and click here for new game.">New Game</button>
        <button name="reset" type="button" title="Click here to reset timer and re-start the game.">Reset</button>
        <hr>
        <!-- <button name="save" type="button">Save</button> -->
        <!--   hidden   -->
        <button name="grid-save" id="grid-save" type="button" disabled>Preview Grid</button>
        <!-- end of hidden -->
    </div>
<hr>
<?php /* --End _grid view-in-view ---------------------------------------------------------------------------- */ ?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>