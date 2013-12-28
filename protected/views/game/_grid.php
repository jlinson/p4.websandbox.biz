<?php
/**
 *  Sudoku grid for use in both index.php and create.php (and anywhere desired).
 *
 *  @var $this GameController
 *  @var $model Game
 *
 *  Declare in page that includes this _grid:
 *  $cs->registerScriptFile($baseUrl . '/js/game.js', CClientScript::POS_END);
 *  or, $cs->registerScriptFile($baseUrl . '/js/create.js', CClientScript::POS_END);
 *  or, similar appropriate script.
 */
$cs=Yii::app()->clientScript;
$baseUrl = Yii::app()->baseUrl;
$cs->registerScriptFile($baseUrl . '/js/grid.js', CClientScript::POS_END);
$cs->registerCssFile($baseUrl . '/css/grid.css');

// Get data for 'Game Level' drop-down -
// - coordinate findAll params w/ dropDownList array - pulled [, 'empty' => 'Select Level'] due to initial load confusion - jbl
$levels = Levels::model()->findAll( 'level_cd > 0', array( 'order' => 'level_cd'));
$list = CHtml::listData( $levels, 'level_cd', 'level_nm' );
?>
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
    <strong><?php echo $model->getAttributeLabel('level_cd'); ?>:</strong>
    <?php echo CHtml::dropDownList( 'level', 'level_cd', $list, array('id' => '1')); ?>
    <button name="load" type="button" title="Select a game level and click here for new game.">New Game</button>
    <button name="reset" type="button" title="Click here to reset timer and re-start the game.">Reset</button>
    <hr>
    <!-- <button name="save" type="button">Save</button> -->
    <!--   hidden   -->
    <button name="grid-save" id="grid-save" type="button" disabled>Preview Grid</button>
    <!-- end of hidden -->
    <hr>
</div>
