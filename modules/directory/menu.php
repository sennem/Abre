<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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
	require_once('permissions.php');

	if($pageaccess==1)
	{
?>
	    <div class="col s12">
			<ul class="tabs_2" style='background-color: <?php echo sitesettings("sitecolor"); ?>'>
				<li class="tab col s3 tab_1 directorymenu pointer" data="#directory"><a href="#directory" class='mdl-color-text--white'>Active</a></li>
				<li class="tab col s3 tab_2 directorymenu pointer" data="#directory/archived"><a href="#directory/archived" class='mdl-color-text--white'>Archived</a></li>
				<li class="tab col s3 tab_3 directorymenu pointer" data="#directory/settings"><a href="#directory/settings" class='mdl-color-text--white'>Settings</a></li>
			</ul>
		</div>
<?php
	}
?>

<script>

	$(function()
	{
		$( ".directorymenu" ).click(function()
		{
			window.open($(this).attr("data"), '_self');
		});
	});

</script>
