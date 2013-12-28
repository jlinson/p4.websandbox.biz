<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - About';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>About</h1>

<p>
    This application was created as the final dynamic web application in fulfillment of the requirements for
    project P4 for the Harvard Extension class, <strong>Dynamic Web Applications (DWA E-15)</strong>. The app was built
    using the <a href="http://www.yiiframework.com/" class="external">Yii Framework v.1.1.14</a>. The Yii Framework has
    a default CSS framework developed by <a href="http://blueprintcss.org/" class="external">Blueprint</a>. For this
    project, that framework was adapted and extended with custom game grid styling in <kbd>css/grid.css</kbd>.
    No <kbd>&lt;table&gt;</kbd> elements were used in any of the game grid layout. None of the grid is hard-coded; the
    entire grid is generated using php for loops.  All the game level drop-downs are populated from the database
    to avoid hard-coded game level information outside the model construct.
</p><p>
    Both <strong>jQuery</strong> and <strong>jQuery.ui</strong> were used in this application. The application
    javascript is sub-divided into four script files, <kbd>js/grid.js</kbd> (handles grid input), <kbd>js/game.js</kbd>
    (handles game loading and saving), <kbd>js/preferences.js</kbd> (handles preferences selections), and
    <kbd>js/create.js</kbd> handles game grid creation and game rating logic.
</p>
    The following jQuery libraries were also used:
    <ul>
        <li><a href="http://jquery.com/" class="external">jQuery</a> - v.1.10.2</li>
        <li><a href="http://jqueryui.com/" class="external">jQuery.ui</a> - v.1.10.3</li>
    </ul>
<p>
    The <a href="http://yii-user.2mx.org/en" class="external">Yii-User</a> module was cloned from Github and migrated
    into this application. It also expected the Blueprint CSS framework. User registration and login were included
    in the application both to demonstrate the capabilities and in anticipation of adding more user-specific
    functionality (e.g. saved games, play history and statistics, etc.) in the future.
</p><p>
    Most of the code for the application (aside from the js/ and the css/ mentioned above) resides in the following files:
    <ul>
        <li>/protected/config
            <ul><li>main.php</li></ul>
        </li>
        <li>/protected/controllers
            <ul><li>GameController.php</li>
            <li>SiteController</li></ul>
        </li>
        <li>/protected/models
            <ul><li>ContactForm.php</li>
            <li>Game.php</li>
            <li>Levels.php</li></ul>
        </li>
        <li>/protected/views
            <ul><li>game/
                <ul><li>_form.php</li>
                    <li>_grid.php</li>
                    <li>_search.php</li>
                    <li>admin.php</li>
                    <li>create.php</li>
                    <li>index.php</li>
                    <li>update.php</li>
                    <li>view.php [not used - index.php handles this]</li>
                </ul>
            </li></ul>
            <ul><li>site/
                <ul><li>contact.php</li>
                    <li>error.php</li>
                    <li>index.php [not on menu tree - site/ default]</li>
                    <li>login.php</li>
                    <li>pages/about.php [this page]</li>
                </ul>
            </li></ul>
            <ul><li>layouts/
                <ul><li>column1.php [not used]</li>
                    <li>column2.php</li>
                    <li>main.php  [master template]</li>
                </ul>
             </li></ul>
        </li>
        <li>/protected/modules/user
            <ul><li>Yii-User module has own controller, model & view directories</li>
                <li>essentially a project within a project</li>
                <li>(minor customizations & integration for this project)</li>
            </ul>
         </li>
    </ul>
</p>
