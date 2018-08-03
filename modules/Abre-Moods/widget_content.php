<?php
	/*
	* Copyright (C) 2016-2018 Abre.io Inc.
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the Affero General Public License version 3
    * as published by the Free Software Foundation.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU Affero General Public License for more details.
	*
    * You should have received a copy of the Affero General Public License
    * version 3 along with this program.  If not, see https://www.gnu.org/licenses/agpl-3.0.en.html.
    */

	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');
  require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
  //require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

?>


<?php
	//different icons and text for staff vs students
	$pagerestrictions="staff";
	//if($_SESSION['usertype']=="student")
	if($pagerestrictions=="student")
	{
		echo "<hr class='widget_hr'>";
		echo "<div class='widget_holder'>";
			echo "<div class='widget_container widget_body' style='color:#666;'>Menu<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_menu_or_roster.php' data-reload='true'>menu</i></div>";
			echo "<div class='widget_container widget_body' style='color:#666;'>History<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_history_or_overview.php' data-reload='true'>history</i></div>";
		echo "</div>";
	}
	else {
		echo "<hr class='widget_hr'>";
		echo "<div class='widget_holder'>";
			echo "<div class='widget_container widget_body' style='color:#666;'>Roster<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_menu_or_roster.php' data-reload='true'>group</i></div>";
			echo "<div class='widget_container widget_body' style='color:#666;'>Overview<i class='right material-icons widget_holder_refresh pointer' data-path='/modules/Abre-Moods/widget_history_or_overview.php' data-reload='true'>table_chart</i></div>";
		echo "</div>";
	}
?>

<!--<div class="col s12">
<ul class="tabs_2" style='background-color: <?php //echo getSiteColor(); ?>'>
	<li class="tab col s3 tab_1 booksmenu pointer" ><a href="" >Menu</a></li>
	<li class='tab col s3 tab_2 booksmenu pointer' ><a href="" >History</a></li>
</ul>
</div>-->

<?php
	echo '<br>';
	//if ($widgetchoice==1)
	//{
	//require('widget_menu_or_roster.php');
	//}
?>
