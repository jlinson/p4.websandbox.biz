/*!
 * JavaScript file: preferences.js
 * - responsible for preferences processing and loading;  associated with <div id="sidebar">
 *
 * Date: 2013-11-30
 *
 * requires: game.js -->  hasLocalStorage()
 */

// Default status in case no local storage -
var useKeyboard = true;  // html default
var useTooltips = true;
/**************************************************************************************************
 * This event captures any URL parameters for game load direction -
 */
$( document ).ready( function() {

    if (hasLocalStorage()) {
        // check local storage for keyboard settings -
        var keyboardEnabled = localStorage.SudoSudokuKeyboardEnabled;
        if (keyboardEnabled == "false") {
            // uncheck the keyboard entry checkbox -
            $("input[name='keyboard']").prop( "checked", false );
            useKeyboard = false;

        } else {
            // leave default 'checked' setting -
            localStorage.SudoSudokuKeyboardEnabled = "true";
            useKeyboard = true;
        }

        // check local storage for tooltips settings -
        var tooltipsEnabled = localStorage.SudoSudokuTooltipsEnabled;
        if (tooltipsEnabled == "false") {
            // uncheck the tooltips checkbox -
            $("input[name='tooltips']").prop( "checked", false );
            useTooltips = false;

        } else {
            // leave default 'checked' setting -
            localStorage.SudoSudokuTooltipsEnabled = "true";
            useTooltips = true;
        }
    }
});

/***************************************************************************************************
 * disabledButtonToggle() - work-around to handle jui-tooltip bug - can't handle disabled buttons -
 * - ensure buttons enabled during tooltip change, then return them to start state.
 * - simple alternative is to blow-away the "title=" in the html (but that's a one-way change)
 *
 * @param toggleArray  - toggleArray[0] == boolean indicating start (true) of tooltip setting change.
 *                       toggleArray[1 thru x] == initial button state; null on initial call.
 *
 *  NOTE: Relies on javascript arrays passing BY REFERENCE (therefore, no return) - jbl
 */
function disabledButtonToggle( toggleArray ) {

    if (toggleArray[0]) {
        // determine starting button state -
        toggleArray[1] = $("button[name=undo]").prop("disabled");
        toggleArray[2] = $("button[name=erase]").prop("disabled");

        if (toggleArray[1]) {
            $("button[name=undo]").prop("disabled", false);
        }
        if (toggleArray[2]) {
            $("button[name=erase]").prop("disabled", false);
        }

    } else {
        // reset the original button state -
        $("button[name=undo]").prop("disabled", toggleArray[1]);
        $("button[name=erase]").prop("disabled", toggleArray[2]);
    }
}

/***************************************************************************************************
 * preferenceChange() - called to ensure the __Status vars are in sync with the useXXXX vars -
 * @return boolean array() of property elements  [0] == change, [1] = keyboard change, [2] = tooltip change
 */

function preferenceChange() {

    var keyboardStatus = $("input[name='keyboard']").prop( "checked" );
    var tooltipsStatus = $("input[name='tooltips']").prop( "checked" );
    var prefChange = [];

    if ((keyboardStatus != useKeyboard) || (tooltipsStatus != useTooltips)) {
        prefChange[0] = true;
        prefChange[1] = (keyboardStatus != useKeyboard);
        prefChange[2] = (tooltipsStatus != useTooltips);

    } else {
        prefChange[0] = false;
        prefChange[1] = false;
        prefChange[2] = false;
    }
    return prefChange;
}

// **************************************************************************************************
// Button click listeners -

$("button[name='pref-apply']").click( function() {

    var prefChange = preferenceChange();

    if (prefChange[0]) {
        // we have a preference change to apply -
        var storageYes = true;
        var hasStorage = hasLocalStorage();

        if (!hasStorage) {
            storageYes = confirm( "Your browser does not support local storage.  Preference changes will only apply until next page refresh.")
        }

        // Check for keyboard preference change -
        if (prefChange[1]) {
            var confirmYes = confirm( "Changing keyboard support requires reloading the game?  Are you sure you want to reset the game?" );

            if (confirmYes && storageYes) {
                var keyboardStatus = $("input[name='keyboard']").prop( "checked" );

                if (keyboardStatus) {
                    // just reload the page to recover <input>s - "checked" is default - useKeyboard = true is default -
                    if (hasStorage) {
                        localStorage.SudoSudokuKeyboardEnabled = "true";
                    }
                    location.reload();

                } else {
                    // remove the text inputs (only in #grid), change .cell.input classes and reset -
                    $( "input[type='text']").remove();
                    $( ".cell.input").removeClass( "input" ).addClass( "noinput" );

                    if (hasStorage) {
                        localStorage.SudoSudokuKeyboardEnabled = "false";
                    }
                    useKeyboard = false;
                    $("button[name='reset']").click();
                    $("input[type='checkbox']").change();
                }
            }
        }
        // Check for tooltips preference change -
        if (prefChange[2] && storageYes) {
            var tooltipsStatus = $("input[name='tooltips']").prop( "checked" );

            // Address jui-tooltip bug: doesn't handle disabled buttons - now disable 'Undo' and 'Erase' -
            var toggleArray = [];
            toggleArray[0] = true;
            disabledButtonToggle( toggleArray );

            if (tooltipsStatus) {
                // turn on jui tooltips
                if (hasStorage) {
                    localStorage.SudoSudokuTooltipsEnabled = "true";
                }
                // tooltips should ALWAYS be initialized (see game.js (document).ready()) -
                // - this syntax ONLY works for initialized jui-tooltips()
                $( document ).tooltip( "option", "disabled", false ).tooltip( "option", "track", true );
                useTooltips = true;

            } else {
                // turn off jui tooltip  - TODO: may need to address .title on disabled buttons (not handled by jui) - jbl
                if (hasStorage) {
                    localStorage.SudoSudokuTooltipsEnabled = "false";
                }
                $( document ).tooltip( "option", "disabled", true );
                useTooltips = false;
            }
            // Address jui-tooltip bug: doesn't handle disabled buttons - now disable 'Undo' and 'Erase' -
            toggleArray[0] = false;
            disabledButtonToggle( toggleArray );
        }

    } else {
        // no preference change found -
        // - 'Apply' button enable/disable on 'change' should prevent us getting here, but if we do -
        alert("No preference changes to be applied.")
    }
    // preference apply completed -
    $("button[name='pref-apply']").prop( "disabled", true );
});

$("input[type='checkbox']").change( function() {

    // toggle the apply based on checked status -
    var prefChange = preferenceChange();

    if (prefChange[0]) {
        // change registered - enable Apply -
        $("button[name='pref-apply']").prop( "disabled", false );

    } else {
        // change unregistered - disable Apply -
        $("button[name='pref-apply']").prop( "disabled", true );
    }
});
