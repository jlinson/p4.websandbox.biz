p4.websandbox.biz
=================

Project 4 for DWA E-15: Final dynamic web application demonstration web app. 

## App Description ##
This application is a Sudoku game that anyone can play. The application validates all input (red means conflict) and announces when the user has solved the Sudoku. Standard Sudoku rules are presented in the right jui-accordian. Tooltips are enabled to provide additional help. Tooltips can be disabled in 'Preferences'; they can get annoying very quickly.

The application also allows for entry of new Sudoku grids, however, you need to have admin priveledges to create games. (For testing `use: admin pwd: adminTest`) Unregistered users can play the game. Registered users can see their profile and a list of other users. To facilitate testing, I have turned off email validation of registrations (however, registration still enforces unique emails). Admins can manage users (including creating and banning users), manage games (including creating games). To test game creation, I'd recommend grabbing a Sudoku game out of a newspaper and entering the grid. Hit preview to see the game string generated and then click save to commit to the database. You will be redirected to the main playing grid where the entered game will appear for play.

## Features ##
**Game Play:**   
- keeps track of valid and invalid (red) cell entries.  
- identifies numbers in the grid that match the selected number (blue).  
- identifies when the user has completed the grid successfully.  
- allows numbers to be entered via keyboard into cells or by selecting a cell and clicking on the number bar below the grid.  
- prevents entries of anything other than integers from 1 to 9 (and clears invalid pasted entries upon leaving cell).  
- flags original game grid entries as read-only, preventing players from overwriting or erasing those cells.  
- uses HTML localStorage to record the current game id and preference settings so that users returning will automatically see the same game and settings (but not with any entries they may have made; next version).  
- undo - provides unlimited number of undo steps.  
- erase - erases the current selection regardless of undo order.  
- reset - completely removes all entries and resets the grid.

**Game Creation:**  
-when logged-in as admin, a "Games" menu option is shown. Click that option to view a list of all game strings. The upper right-hand menu has the option to go to "Create Games".  
- in "Create Games", admins can enter values in the Sudoku grid and then click "Preview" to see the grid string in an edit window with a calculation of the cell count and estimated difficulty.  
- the admin can override the calculated difficulty, but must check an override box to enable the game level drop-down.  
- any invalid cells (flagged in red) will be excluded from the game grid string generated.
- attempts to save duplicate game grid strings are prevented by the database.    
 
**Profiles / User Management**  
- logged-in users can see a profile page showing signup date and last access. The upper right-hand menu provides options to edit your profile, change your password and see a list of users.  
- when logged-in as admin, the upper right-hand menu on the profile page also has a "Manage Users" option that allows creation, promotion and banning of users.  
- admins also have the ability to add fields to the "Profile" and the database supports this dynamic profile field management.  
(Most of the user management features were built into the Yii-User module that I git cloned, incorporated and tweaked.)

## Javascript ##
Four script files (in /js directory) hold the javascript that I wrote for the app: 

**grid.js** - works with grid.css (in the /css directory) and the _grid.php form to provide all the game play validations and manipulations.  

**game.js** - adds to grid.js to handle game loading and reset functionality. Game.js also interacts with the "Game Level" drop-down to select games from the database. All game grid loading occurs via $.ajax() with JSON encoding happening in the GameController.php and JSON decoding and parsing happening in game.js.  

**preferences.js** - adds to game.js to handle setting and unsetting of preferences. For P4, two preferences, keyboard on/off and tooltips on/off, are available. The `<input>` elements greatly complicated jQuery manipulations and limiting invalid cell entries was a challenge. However, the main reason to remove the `<input>` elements was to allow play on mobile devices without having a virtual keyboard cover the game grid.

**create.js** - replaces game.js in the game create page. Grid.js and _grid.php are reused for game creation. Create.js validates the entered game, tracks the cell entries and estimates the game difficulty.

## Database ##
[MySQL Workbench](http://dev.mysql.com/downloads/tools/workbench/ "MySQL Workbench") was used to model the database.  
A PDF of the datamodel for P4 (`P4_data_model.pdf`) is available in the project root.  
The DDL for the database (`database.sql`) is also available in the project root.

## Other Info ##
See the application 'About' page for additional application technical information. This application was built using the [Yii Framework](http://www.yiiframework.com/ "yii framework"). The Github history should indicate the key files, but a list of the files I created appears in the app 'About' page.

The application config file (`/protected/config/main.php`) was excluded (.gitignore'd) due to both security reasons and the fact that dev and prod passwords were different. However, I've included a sanitized version of the config (`config_main(sanitized).php`) in the root for viewing if desired.

The 'Contact' page works, so if you have any questions, feel free to contact me (goes to my g.harvard.edu inbox).