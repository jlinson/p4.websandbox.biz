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
    project P4 for the Harvard Extension class, Dynamic Web Applications (DWA E-15). The app was built using the
    <a href="http://www.yiiframework.com/" class="external">Yii Framework v.1.1.14</a>. The Yii Framework has a
    default CSS framework developed by <a href="http://blueprintcss.org/" class="external">Blueprint</a>. That CSS
    framework was replaced with <a href="http://getbootstrap.com/" class="external"> Twitter Bootstrap</a> for use
    on this project.
</p><p>
    All the game grid styling is in a custom grid.css file. All the application javascript is sub-divided into three
    script files, grid.js (handles grid input), game.js (handles game loading and saving), and preferences.js (handles
    preferences selections).
</p>
    The following jQuery libraries were also used:
    <ul>
        <li><a href="http://jquery.com/" class="external">jQuery</a> - v.1.10.2</li>
        <li><a href="http://jqueryui.com/" class="external">jQuery.ui</a> - v.1.10.3</li>
    </ul>
<br>