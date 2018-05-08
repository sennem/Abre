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
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once("functions.php");

	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{
?>

		<div class='fixed-action-btn buttonpin'>
			<?php
			echo "<a class='modal-studentgroup btn-floating btn-large waves-effect waves-light' style='background-color:".getSiteColor()."' id='create_button' href='#' data-formid=''><i class='large material-icons'>add</i></a>";
			echo "<div class='mdl-tooltip mdl-tooltip--left' for='create_button'>Create New Form</div>";
			?>
		</div>

<?php
	}
?>

<script>

	$(function()
	{

		//Create Button
		$("#create_button").unbind().click(function(event){

			event.preventDefault();
			var formid = $(this).data("formid");

			$.post("/modules/Abre-Forms/action_saveform.php", { formid: formid }, function(data){
				var FormID = data.formid;
				window.location.href = '#forms/builder/'+FormID;
			}, "json");

		});

	});

</script>