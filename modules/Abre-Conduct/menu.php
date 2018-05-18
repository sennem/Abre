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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');

?>

    <div class="col s12">
		<ul class="tabs_2" style='background-color: <?php echo getSiteColor(); ?>'>
			<?php
				echo "<li class='tab col s3 tab_1 curriculummenu pointer' data='#conduct/discipline/open'><a href='#conduct/discipline/open' class='mdl-color-text--white'><span class='hide-on-small-only'>Open</span><i class='material-icons hide-on-med-and-up'>lock_open</i></a></li>";

				//Check to see if District Adminstrator
				if(admin() or conductAdminCheck($_SESSION['useremail'])){
					echo "<li class='tab col s3 tab_2 curriculummenu pointer' data='#conduct/discipline/queue'><a href='#conduct/discipline/queue' class='mdl-color-text--white'><span class='hide-on-small-only'>Queue</span><i class='material-icons hide-on-med-and-up'>edit</i></a></li>";
				}
				//check for conduct monitor. They should have access to verification page
				if(admin() or conductAdminCheck($_SESSION['useremail']) or conductMonitor($_SESSION['useremail'])){
					echo "<li class='tab col s3 tab_3 curriculummenu pointer' data='#conduct/discipline/verification'><a href='#conduct/discipline/verification' class='mdl-color-text--white'><span class='hide-on-small-only'>Verification</span><i class='material-icons hide-on-med-and-up'>report</i></a></li>";
				}
			?>

			<li class="tab col s3 tab_4 curriculummenu pointer" data="#conduct/discipline/closed">
				<a href="#conduct/discipline/closed" class='mdl-color-text--white'>
					<span class='hide-on-small-only'>Closed</span>
					<i class='material-icons hide-on-med-and-up'>done</i>
				</a>
			</li>
			<?php

				//Check to see if District Adminstrator
				if(admin() or conductAdminCheck($_SESSION['useremail']) or conductMonitor($_SESSION['useremail'])){
					echo "<li class='tab col s3 tab_5 curriculummenu pointer' data='#conduct/discipline/reports'><a href='#conduct/discipline/reports' class='mdl-color-text--white'><span class='hide-on-small-only'>Reports</span><i class='material-icons hide-on-med-and-up'>get_app</i></a></li>";
				}
				if(superadmin()){
					echo "<li class='tab col s3 tab_6 curriculummenu pointer' data='#conduct/discipline/settings'><a href='#conduct/discipline/settings' class='mdl-color-text--white'><span class='hide-on-small-only'>Settings</span><i class='material-icons hide-on-med-and-up'>settings</i></a></li>";
				}
			?>
		</ul>
	</div>

<script>

	$(function(){
		$( ".curriculummenu" ).click(function(){
			window.open($(this).attr("data"), '_self');
		});
	});

</script>