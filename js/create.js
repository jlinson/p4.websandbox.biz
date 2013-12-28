/*!
 * JavaScript file: create.js
 * - responsible for game grid saving;  associated with <div id="game-btns">
 * - modification of game.js - specific to game creation.
 * - create default functionality is equivalent of "?load=blank" in game.js
 * Date: 2013-12-20
 *
 * references: grid.js  --> undoStack[]   (declared in grid.js; see gameClear() below.)
 */

/**************************************************************************************************
 * This event captures any URL parameters for game load direction -
 */
$( document ).ready( function() {

    // Enable the 'grid-save' button normally disabled in _grid view html -
    $("#grid-save").css("visibility", "visible").prop( "disabled", false);

    // Hide the 'load' button normally enabled in _grid view html -
    $("button[name=load]").css("visibility", "hidden").prop( "disabled", true);

    // In case page refreshed because the save failed - reload game grid from the game-form data -
    // - yii adds class "error" to all form fields in error and adds <div class='errorSummary'> at top of form -
    if ($("> .errorSummary", "#game-form").text().length != 0  ) {
        gameReLoad();
    }

    // Now initialize any 'Preferences' in localStorage -
    initPreferences();

    // Disable the game-level select - enable with rating-override checkbox -
    // - also sync the rating-override checkbox - required if user hits browser 'back' function -
    $("select[name='level']").prop( "disabled", true );
    $("#rating-override").prop( "checked", false);
});

/****************************************************************************************************
 *  initPreferences() - routine to initialize the keyboard and tooltips preferences on document.ready -
 *  - pulled into this routine to simplify the document.ready logic
 */
function initPreferences() {

    if (hasLocalStorage()) {
        // check local storage for keyboard settings -
        var keyboardEnabled = localStorage.SudoSudokuKeyboardEnabled;
        if (keyboardEnabled == "false") {
            // remove the text inputs (only in #grid), change .cell.input class -
            $("input[type='text']").remove();
            $(".cell.input").removeClass( "input" ).addClass( "noinput" );
        }

        // check local storage for tooltips settings -
        var tooltipsEnabled = localStorage.SudoSudokuTooltipsEnabled;

        // initialize the jui-tooltips REGARDLESS - then disable if necessary -
        // - this code executes prior to anything placed in  CClientScript::POS_END or CClientScript::POS_READY -
        $( document ).tooltip({ track: true });

        if (tooltipsEnabled == "false") {
            // this has benefit of disabling native tooltips as well (except for "disabled" buttons) -
            $( document ).tooltip( "option", "disabled", true );
        }
    }
    // Address jui-tooltip bug: doesn't handle disabled buttons - had to leave out 'disabled' in html (view) -
    // - now disable 'Undo' and 'Erase' -
    $("button[name=undo]").prop("disabled", true);
    $("button[name=erase]").prop("disabled", true);
}

/****************************************************************************************************
 *  getGetValue() - function to parse a key=value array and return value based on key requested
 *  @param searchArray - array of key=value strings (already .split('&') - or whatever delimiter)
 *  @param keyString - key to find value for
 */
function getGetValue( searchArray, keyString ) {

    for(var i = 0; i < searchArray.length; i++){
        var keyValuePair = searchArray[i].split('=');
        if(keyValuePair[0] == keyString){
            return keyValuePair[1];
        }
    }
    // nothing found, return empty
    return '';
}

/****************************************************************************************************
 *  getInputMode() - function to return the input mode of the game grid.
 *  - computer default is "input"; may be set to "noinput" for small screen / mobile devices
 *  - selected on longer "noinput" just to ensure no substring match of "input" in "noinput".
 *  @return inputMode
 */
function getInputMode() {

    var inputMode = "";

    if ($("#c00").hasClass( "noinput" )) {
        // if #c00 has "noinput" they all should have "noinput" -
        inputMode = "noinput";
    } else {
        // default mode
        inputMode = "input";
    }
    return inputMode;
}

/***************************************************************************************************
 * hasLocalStorage() - simple check for existence of localStorage for current browser -
 * @return boolean
 */
function hasLocalStorage() {

    return (typeof(localStorage) !== "undefined");
}

// **************************************************************************************************
// Button click listeners -

// 'Reset' button -
$("button[name=reset]").click( function() {
    var confirmYes = confirm( "Are you sure you want to clear the game and start over?" );
    if (confirmYes) {
        gameClear();
        ratingClear();

        // Issue: can't reset the #game-form once yii has returned from a failed submit -
        // - if yii flagged error - reset with page reload from server - (otherwise, just do standard reset) -
        if ($("> .errorSummary", "#game-form").text().length != 0  ) {

            // window.location.href = window.location.href; // works, but seems kludgy - jbl
            window.location.reload(true);

        } else {
            $("#game-form")[0].reset();
        }
    }
});

// 'Preview Grid' button -
$("button[name=grid-save]").click( function(){
    gameGridPreview();
});

// ***************************************************************************************************
// Game level drop-down change listener -
// - 1 == beginner (default)
// - 2 == easy
// - 3 == medium
// - 4 == hard
// - 5 == expert

$( "select[name='level']" ).change( function() {
    // ensure that hidden field is always in-sync with drop-down -
    $("#Game_level_cd").val( $( this ).val() );
});

// ***************************************************************************************************
// Rating-override change listener -
// - let rateGame() logic set the game level (select disabled by default) unless changed here -

$( "input[name='rating-override']" ).change( function() {
    // just toggle the select disabled based on the checkbox checked -
    $("select[name='level']").prop( "disabled", !($( this).prop( "checked")) );
});

// ***************************************************************************************************
// Game grid textarea change listener -
// - picks up manual changes to the textarea -
// - note: does NOT fire when gameGridPreview() sets value into the textarea -
$( "#Game_grid_string" ).change( function() {
   gameRateLevel( $(this).val(), true );
});

/****************************************************************************************************
 * gameReLoad() - reloads game grid data in #Game_grid_string textarea on page refresh after save fails -
 * - jQuery note: use .prop(), NOT .attr() to set disabled & readonly to <input> - jbl
 */
function gameReLoad() {

    var gridString = $("#Game_grid_string").val();
    var $levelSelect = $("select[name='level']");

    if (gridString == null || gridString.length == 0) {
        // Go home - there's nothing to see here -
        $levelSelect.val(0);
        return;
    }

    $levelSelect.val( $("#Game_level_cd").val() );

    var gridStrArray = gridString.split( "," );

    var gridArrayLen = gridStrArray.length;
    var inputMode = getInputMode();

    for (var i= 0; i < gridArrayLen; i++) {

        var cellValue = gridStrArray[i];
        var cvArray = [];
        cvArray = cellValue.split(":");

        if (inputMode == "input") {
            $("> input","#" + cvArray[0]).val( cvArray[1] ).prop("readonly",true).prop("disabled",true).addClass("valid");
            $("#" + cvArray[0]).addClass("readonly");  // add here for .css; the .js relies on prop("readonly") - jbl

        } else {
            // no keyboard "noinput" mode
            $("#" + cvArray[0]).text( cvArray[1] ).addClass("readonly valid");
        }
    }
    gameRateLevel( gridString, false );
}

/****************************************************************************************************
 * gameClear() - clears the grid for game reset or new game reload.
 * - references the undoStack[] declared in grid.js
 */
function gameClear() {

    var inputMode = getInputMode();
    var $inputCells = $([]);

    if (inputMode == "input") {
        $inputCells = $(".cell.input");
        $inputCells.removeClass("selected");
        $("> input", $inputCells).val('').prop("readonly",false).prop("disabled",false).removeClass("valid invalid current");
        $inputCells.removeClass("readonly"); // also remove "readonly" in parent div.cell - applied for styling in gameLoad() - jbl

    } else {
        $inputCells = $(".cell.noinput");
        $inputCells.text('').removeClass("valid invalid current selected readonly");
    }

    // truncate the undoStack - we're clearing the deck
    undoStack.length = 0;
    $("button[name=undo]").prop("disabled", true);
}

/****************************************************************************************************
 * ratingClear() - clears the grid for game reset or new game reload.
 * - references the undoStack[] declared in grid.js
 */
function ratingClear() {

    $( "#cells" ).text( '0' );
    $( "#chars" ).text( '0');
    $( "> .selected", "#level-ranges" ).removeClass( 'selected' );
    $( "> .warning", "#level-ranges" ).removeClass( 'warning' );
}

/****************************************************************************************************
 * htmlEscape() - sanitize any entries (e.g. textarea) to ensure no stray formatting.
 * - create should be limited to admins, but just to cover all bases, sanitize the input - jbl
 * @param str  - string
 * @return safeStr  - sanitized string.
 */
function htmlEscape(str) {

    // now handle any individual chars left -
    safeStr = str.replace(/[&<>\/\\"']/g, ""); // eliminate: $amp;, &lt;, &gt;, &#47;, &#92;, $quot and single quote &#39;

    //return String( safeStr );  // original implementation - jbl
    return safeStr;
}

var gridStringFlaw = false;
/****************************************************************************************************
 * cellCntFormat() - formats the gridCells calculation for special display.
 * - used instead of gridCells.toFixed( 1 ) - jbl
 * - sets the global gridStringFlaw boolean if cellCnt is not an integer
 *
 * @param cellCnt  - calculated cell count
 * @return cellStr  - sanitized string.
 */
function cellCntFormat( cellCnt ) {

    var cellStr = cellCnt.toString();
    var decPnt = cellStr.indexOf( '.' );

    if (decPnt > -1) {
        cellStr = cellStr.substring( 0, decPnt ) + '+';
        gridStringFlaw = true;

    } else {
        gridStringFlaw = false;
    }
    return cellStr;
}

/****************************************************************************************************
 * gameRateLevel() - determines the estimated game level based on string length (cells given)
 * @param gameString
 * @param alertOn    - boolean to indicate whether to display (true - default) or suppress (false - on refresh) alert.
 * @return proceedOK  - boolean true for OK and false for hold.
 *
 * - called by gameGridPreview() and the #Game_grid_string textarea .change event -
 * - issue: gameRateLevel sets select to levelCd = 0, but "Undefined" is not retrieved into drop-down => 'blank' - jbl
 */
function gameRateLevel( gameString, alertOn ) {

    var levelCd = 0;
    var proceedOK = false;
    var alertText = "";
    var safeString = htmlEscape( gameString );
    var strlen = safeString.length;
    var gridCells = (strlen + 1)/6;   //conversion: chars/cell == 8 w/ quotes - or - 6 w/o quotes

    // Clear the game-level rating attributes before resetting things -
    ratingClear();
    $( "#cells" ).text( cellCntFormat( gridCells ) );
    $( "#chars" ).text( strlen);

    if (strlen != gameString.length) {
        alertText = "\n\nWarning:\n(Invalid characters were detected and replaced in the grid string.)";
    }

    if (gridCells > 37) {
        $("#max").addClass( 'warning');

        // Are we at a crazy easy level or over the top -
        if (gridCells > 66) {
            levelCd = 0;
            alertText = "Game grid exceeds maximum savable string length by " + (gridCells - 66) + " grid cells.  " +
                        "The game grid will be truncated. Please shorten the entry to prevent truncation." +
                        alertText;
        } else {
            levelCd = 1;
            alertText = "Wow, that's a really easy game. Consider eliminating some cells to reach beginner level." +
                        alertText;
        }

    } else if (gridCells > 33) {
        levelCd = 1;
        proceedOK = true;
        $("#beg").addClass( 'selected');

    } else if (gridCells > 30) {
        levelCd = 2;
        proceedOK = true;
        $("#ezy").addClass( 'selected');

    } else if (gridCells > 27) {
        levelCd = 3;
        proceedOK = true;
        $("#med").addClass( 'selected');

    } else if (gridCells > 24) {
        levelCd = 4;
        proceedOK = true;
        $("#hrd").addClass( 'selected');

    } else if (gridCells > 21) {
        levelCd = 5;
        proceedOK = true;
        $("#exp").addClass( 'selected');

    } else {
        $("#min").addClass( 'warning');

        // Are we at extremely difficult or unsolvable / non-unique -
        if (gridCells < 17) {
            levelCd = 0;
            alertText = "This game is below the minimum cell count. Unique solutions are not possible. The game grid " +
                "cannot be saved without adding more cell data." + alertText;

        } else {
            levelCd = 5;
            alertText = "This game is crazy difficult, and possibly has non-unique solutions. Consider adding cells " +
                "to fall within the expert range." + alertText;
        }
    }

    // Set both the visible select and the hidden game_level_cd field -
    // - setting the select does not trigger a .change event that would otherwise set the hidden field - jbl
    $("select[name='level']").val( levelCd );
    $("#Game_level_cd").val( levelCd );
    $("#Game_grid_string").val( safeString );

    if ((alertText.length > 0) && alertOn) {
        alert( alertText );
    }

    return proceedOK;
}

/****************************************************************************************************
 * gameGridPreview() - formats a game grid for rating and preview prior to final save.
 * - similar demo functionality in game.js just places string in console.log.
 */
function gameGridPreview() {

    var gameString = '';
    var inputMode = getInputMode();

    $(".valid").each( function() {
        // if not first pass, add comma value separator -
        if (gameString != '') {
            gameString += ',';
        }

        // Ensure that all cell values are single quoted within larger double quoted string
        // - db should only have single quotes saved to avoid JSON parsing issues.
        if (inputMode == "input") {
            gameString += $(this).attr("name") + ":" + $(this).val();
        } else {
            gameString += $(this).attr("id") + ":" + $(this).text();
        }
    });

    // Set formatted string into textarea (does not fire .change event) -
    $("#Game_grid_string").val( gameString );

    // Now rate the game and set the Game Level select and hidden
    var rateOK = gameRateLevel( gameString, true );

    if (rateOK) {
        var elForm =  document.getElementById('game-form');
        elForm.scrollIntoView();
    }
}
