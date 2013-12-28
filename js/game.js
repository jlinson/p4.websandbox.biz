/*!
 * JavaScript file: game.js
 * - responsible for game grid loading;  associated with <div id="game-btns">
 *
 * - prior implementation (P3) held demo game arrays in gameStore multi-dimensional array.
 * - current implementation uses ajax calls to the MySQL db as game grid source.
 *
 * Date: 2013-11-30
 *
 * references: grid.js  --> undoStack[]   (declared in grid.js; see gameClear() below.)
 */

/**************************************************************************************************
 * This event captures any URL parameters for game load direction -
 * - first - trap if URL has Yii parameter - anticipate /game/<param>, /game/view/<param>, and /game/index/<param>
 *   - only access to file '/views/game/index.php' is through /game/ (index default), /game/index/, or /game/view/
 *   - the URL may have .html or .php appended (cosmetic).
 * - second - trap if URL has ?load='<param>'
 * - third - trap if user has saved game (TODO: 'saved games' not implemented for P4.)
 * - fourth - trap for localStorage game info
 * - else: load default
 */
$( document ).ready( function() {

    /* First - see if we got a Yii game load parameter in the page request:  */
    // location.pathname is subset of window.location.href - yields /game/<gameId>.html without search string!!!
    var gameRequested = false;
    var gameId = window.location.pathname.replace('/game/', '')
                                         .replace('index/', '').replace('view/', '')
                                         .replace('.html', '').replace('.php', '');

    // use jQuery $.isNumeric() instead of native isNaN() based on this wonderful jFiddle: http://jsfiddle.net/eghE9/ - jbl
    if ($.isNumeric( gameId )) {
        gameRequested = requestLoad( gameId, 0 );

    } else {
        /* Second - see if we got a ?load= custom game load parameter in the page request:  */
        // - check the $_GET value (minus the leading '?') -
        var searchString = window.location.search.substring(1);

        if (searchString.length > 0) {
            var searchArray = searchString.split('&');
            var loadValue = getGetValue( searchArray, "load" );

            if (loadValue == 'blank') {
                // call gameLoad w/ 'blank' params and enable 'grid-save' button - used for game grid entry
                gameRequested = true;
                $("#grid-save").css("visibility", "visible").prop("disabled", false);
                gameLoad( [ 0, 0, '' ] );

            } else if ($.isNumeric( loadValue )) {
                // try to load the requested game
                gameRequested = requestLoad( loadValue, 0 );
            }
        }
    }

    /* If no game in the page request - check localStorage:  */
    if (!gameRequested && hasLocalStorage()) {
        // check local storage for a prior game
        var localGameId = localStorage.SudoSudokuGameId;
        var localGameLvl = localStorage.SudoSudokuGameLvl;

        if (localGameId !== "undefined" && localGameId > 0) {
            // re-load the prior game -
            gameRequested = requestLoad( localGameId, 0 );

            // then see if any entries were saved -
            // TODO: next version

        } else if ((localGameLvl !== "undefined") && (localGameLvl > 0) && (localGameLvl < 6)) {
            // load the next game at the saved level
            gameRequested = requestLoad( 0, localGameLvl);
        }
    }

    /* If still no game after localStorage check - just load default game:  */
    if (!gameRequested) {
            // no game found - load default game -
        gameRequested = requestLoad( 0, 0 );
    }

    // Now initialize any 'Preferences' in localStorage -
    initPreferences();
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

$("button[name=load]").click( function() {
    var confirmYes = confirm( "Are you sure you want to clear the game and load the next one?  Have you selected a difficulty level?" );
    if (confirmYes) {
        gameClear();
        requestLoad( 0, 0 );  // default behavior = next game at level selected
    }
});

$("button[name=reset]").click( function() {
    var confirmYes = confirm( "Are you sure you want to clear the game and start over?" );
    if (confirmYes) {
        gameClear();
        requestLoad( gameIdCurrent, 0 );
    }
});

$("button[name=pause]").click( function(){
    gamePause();
});

$("button[name=save]").click( function(){
    gameSave();
});

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
    var value = $( this ).val();
});

var gameIdCurrent = 1;   // auto-increment starts at 1 [blank game in db], regular grids are 2 and up - jbl
/**********************************************************************************************************
 * requestLoad() - requests an ajax retrieve for callback (asynchronous)
 * - called from document.ready (above)
 * - called from 'load' (New Game) and 'reset' (Reset) buttons
 *
 * @param gameId  - number/id of game to load
 * @param gameLevel - level of game to load
 *       ( id > 0  && level == 0               => request load of requested gameId [default for 'view' - $_GET])
 *       ( id == 0 && level == 0               => request next game (per global gameIdCurrent) at level in select dropdown [default])
 *       ( id == 0 && level == <1 thru 5>      => request next game (per localStorage) at level requested)
 *       ( id > 0  && level == <1 thru 5>      => request next game (no need to check localStorage) at level requested)
 *       ( id < 0 || level !<0 or 1 thru 5>    => return false)
 *
 * @return boolean  - indicating game request success
 */
function requestLoad( gameId, gameLevel ) {

    var gameAction = 'load';

    // use jQuery $.isNumeric() instead of native isNaN() based on this wonderful jFiddle: http://jsfiddle.net/eghE9/ - jbl
    if ($.isNumeric( gameId ) && ($.isNumeric( gameLevel ))) {
        // ensure gameId / gameLevel are sanitized (in case of eval()) and a non-negative integer (force the integer) -
        gameId = Math.round( gameId );
        if (gameId < 0) {
            return false;
        }
        gameLevel = Math.round( gameLevel );
        if ((gameLevel < 0) || (gameLevel > 5)) {
            return false;
        }
    } else {
        // return false and let caller decide what to do next (should have validated before call) -
        return false;
    }

    // Address "default" gameId scenario (see logic in f(n) header)  -
    if (gameId == 0) {
        gameAction = 'next';

        if (gameLevel == 0) {
            // just load the default game based on level selected -

            gameId = gameIdCurrent;
            gameLevel = $("select[name='level']").val();

            // if we don't have a defined level, force the lowest level -
            if (gameLevel == '' || gameLevel == 0) {
                alert("No game level requested. Reverting to beginner level.");
                gameLevel = 1;  // "Beginner" default
            }

        } else if (gameLevel > 0) {
            // check localStorage for a gameId to use in 'next' search (else default to gameIdCurrent)

            if (hasLocalStorage()) {
                gameId = localStorage.SudoSudokuGameId;
                if (gameId == "undefined" || gameId == 0) {
                    gameId = gameIdCurrent;
                }
            } else {
                gameId = gameIdCurrent;
            }
        }

    // Address specified gameId scenario (see logic in f(n) header -
    } else if (gameId > 0) {

        if (gameLevel == 0) {
            gameAction = 'load';

        } else if (gameLevel > 0){
            gameAction = 'next';
        }
    }

    // NOTE: based on jQuery deprecation note - $.ajax().success => .done,  $.ajax().error => .fail
    $.ajax({
        type: 'POST',
        url: 'http://p4.websandbox.dev/game/AjaxLoad', // .html
        dataType: 'json',
        beforeSend: function() {
            // Display a loading message while waiting for the ajax call to complete
            $('#game-caption').html( "Loading..." );
        },
        statusCode: {
            403: function() {
                $('#game-caption').html( "Game access forbidden." );
            },
            404: function() {
                $('#game-caption').html( "Game not found." );
            }
        },
        data: {
            ajax: gameAction,
            id: gameId,
            level_cd: gameLevel
        }
    }).done( function( response ) {
        // if 'dataType:' is unspecified, then the response is not automatically parsed as JSON -
        // - ensure no double-quotes get into database or they will get escaped on encode on choke $.parseJSON
        //var data = response.replace(/\\"/g, '');
        //var jsonData = $.parseJSON( data );

        // if 'dataType:' is set to 'json', then the response is automatically parsed as JSON -
        //$('#game-caption').html( response ); // - see gameLoad() for #game-caption setting - jbl
        gameLoad( response );

    }).fail( function( jqXHR, textStatus ) {
        // retrieve failed for whatever reason (e.g. db down) - fall back to plan B
        $('#game-caption').html( "Load failed - retrieving display game." );
        displayLoad();

    }); // end ajax setup
return true;
}

/****************************************************************************************************
 * gameLoad() - parses and loads game_string into the game grid
 * - called by requestLoad() ajax callback f(n) -
 * - no return - just sets global gameIdCurrent.
 *
 * @param jsonArray  - array w/ Game model values: .id, .level, and .grid_string of game to load
 *                    (array properties are defined in GameController->AjaxLoad())
 */
function gameLoad( jsonArray ) {

    // get jQuery 'select' object for use below -
    var $levelSelect = $("select[name='level']");
    var caption = '';

    // See if we have anything in the game_string -
    if (jsonArray.grid_string == null || jsonArray.grid_string.length == 0) {
        // a blank grid can be valid -
        caption = "Blank game grid:";
        $levelSelect.val('');

    } else {
        // Set the level_cd, then get the level name and set the caption text -
        $levelSelect.val( jsonArray.level );
        var gameLevelNm = $("select[name='level'] option:selected").text();
        caption = gameLevelNm + " Game: " + jsonArray.id;

        // Parse the grid_string into array -
        var gridStrArray = jsonArray.grid_string.split( "," );

        var gridArrayLen = gridStrArray.length;
        var inputMode = getInputMode();

        for (var i= 0; i < gridArrayLen; i++) {

            var cellValue = gridStrArray[i];
            var cvArray = [];
            cvArray = cellValue.split(":");

            if (inputMode == "input") {
                // jQuery note: use .prop(), NOT .attr() to set disabled & readonly to <input> - jbl
                $("> input","#" + cvArray[0]).val( cvArray[1] ).prop("readonly",true).prop("disabled",true).addClass("valid");
                $("#" + cvArray[0]).addClass("readonly");  // add here for .css; the .js relies on prop("readonly") - jbl

            } else {
                // no keyboard "noinput" mode
                $("#" + cvArray[0]).text( cvArray[1] ).addClass("readonly valid");
            }
        }
    }
    gameIdCurrent = jsonArray.id;
    $("#game-caption").text( caption );

    // now save the current game in localStorage (if available) for reload next time -
    // - if no localStorage, don't mention it, just move on -
    if (hasLocalStorage()) {
        localStorage.SudoSudokuGameId = gameIdCurrent;
        localStorage.SudoSudokuGameLvl = jsonArray.level;
    }
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
 * gameSave() - saves a user game to localStorage.
 * - checks existence of localStorage on current browser
 * - serializes the game grid to local storage
 */
function gameSave() {

    if (!hasLocalStorage()) {
        alert("Game cannot be saved.  The game requires browser supported local storage that is not supported by your current browser.");
        return;
    }

    // if we're here - go ahead and save the game -
    localStorage.SudoSudokuGameId = gameIdCurrent;
}

/****************************************************************************************************
 * gameGridPreview() - formats a game grid into a savable string.
 * - for demo, just places string in console.log to manually add to gameStore
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

    console.log( gameString );
    alert("Game string ready to preview in console log.");
}

/****************************************************************************************************
 * displayLoad() -
 * - called by requestLoad() ajax callback f(n) - on ajax 'fail' (e.g. db is down) -
 * - just displays a hard-coded game of the level indicated in select dropdown.
 */
function displayLoad() {

    var selectLevel = $("select[name='level']").val();

    var displayArray = [-1, selectLevel, gameStore[ selectLevel ]];
    gameLoad( displayArray );

    $("#game-caption").text( $("#game-caption").text( ) + " [Demo Display - Regular game retrieval failed.]" );
}

/***************************************************************************************************
 * Game Store
 * - this should coordinate ajax calls to the db, however due to time constraints ...
 * - ... several demo games are pre-loaded into arrays.
 * - since javascript doesn't have associative arrays, the cellId => value is concatenated (similar to undoStack[])
 */

// Blank grid string -
var game0 = "";

// Beginner grid_string -
var game1 = "c03:2,c04:4,c05:1,c06:8,c07:3,c10:4,c12:2,c16:5,c20:6,c23:5,c25:7,c27:4,c28:1,c32:4,c37:5,c41:8,c42:1,c43:9,c45:5,c46:3,c47:4,c51:2,c56:8,c60:6,c61:9,c63:4,c65:5,c68:3,c72:7,c76:2,c78:4,c81:3,c82:2,c83:7,c84:1,c85:6";

// Easy grid_string -
var game2 = "c01:5,c04:2,c06:7,c07:6,c13:1,c14:6,c16:9,c18:4,c22:7,c27:2,c28:1,c32:1,c34:3,c35:9,c36:4,c38:5,c44:8,c50:8,c52:9,c53:6,c54:7,c56:2,c60:3,c61:4,c66:5,c70:7,c72:8,c74:1,c75:2,c81:5,c82:2,c84:3,c87:9";

// Medium grid string -
var game3 = "c00:4,c04:6,c08:9,c12:5,c14:7,c16:8,c20:1,c24:2,c28:3,c32:5,c34:3,c36:2,c40:6,c41:1,c44:2,c47:8,c48:3,c52:4,c54:5,c56:7,c60:6,c64:9,c68:1,c72:4,c74:5,c76:7,c80:9,c84:6,c88:8";

// Hard grid string -
var game4 = "c01:9,c03:2,c05:6,c08:1,c10:6,c13:1,c18:3,c27:4,c30:4,c32:5,c38:9,c41:7,c43:3,c45:5,c47:6,c50:6,c56:7,c58:8,c61:3,c70:2,c75:9,c78:8,c80:1,c83:8,c85:3,c87:2";

// Expert grid string -
var game5 = "c00:1,c01:5,c04:8,c11:4,c15:9,c27:8,c28:1,c31:3,c35:2,c43:7,c44:5,c45:8,c53:6,c57:5,c60:7,c61:6,c64:9,c71:1,c73:5,c77:3,c84:7,c87:2,c88:8";

// Source of demo 'display' games if ajax load fails -
// Array of game grid values organized by difficulty level -
var gameStore = [game0, game1, game2, game3, game4, game5];
