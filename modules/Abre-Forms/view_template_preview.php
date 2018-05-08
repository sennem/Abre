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
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');

	//Get Variables Passed to Page
	if(isset($_GET["id"])){ $id = htmlspecialchars($_GET["id"], ENT_QUOTES); }else{ $id = ""; }

	$sql = "SELECT FormFields FROM forms WHERE ID = $id LIMIT 1";
	$result = $db->query($sql);
	$numrows = $result->num_rows;
	$row = $result->fetch_assoc();
	$formFields = $row['FormFields'];

	if($formFields == ''){
		$formFields = "[]";
	}

	//Display the rendered form
	echo "<form id='my-form'>";

		echo "<div class='fb-render'></div>";

	echo "</form>";

?>

<script src="/modules/Abre-Forms/js/form-render.min.js"></script>
<script>

	$(function()
	{
		//Render Form
		$('.fb-render').formRender({ dataType: 'json', formData: <?php echo $formFields ?>, notify: { success: function(message) { $('input:checkbox').removeAttr('checked'); $('select').material_select(); mdlregister(); }} });

	});

</script>