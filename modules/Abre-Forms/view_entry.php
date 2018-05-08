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
	if(isset($_GET["entryid"])){ $entryid = htmlspecialchars($_GET["entryid"], ENT_QUOTES); }else{ $entryid = ""; }
	if(isset($_GET["id"])){ $id = htmlspecialchars($_GET["id"], ENT_QUOTES); }else{ $id = ""; }

	if(($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator()) && (hasEditAccess($id) || hasResponseAccess($id)))
	{

			$sql = "SELECT forms.Name, forms.FormFields, forms_responses.Response FROM forms_responses LEFT JOIN forms ON forms_responses.FormID = forms.ID WHERE forms_responses.ID = '$entryid' LIMIT 1";
			$result = $db->query($sql);
			$numrows = $result->num_rows;
			while($row = $result->fetch_assoc()){
				$response = $row['Response'];
				$formFields = $row['FormFields'];
				$formName = $row['Name'];

				if($formFields == ''){
					$formFields = "[]";
				}

			}

				//Display the rendered form
				echo "<h5>$formName</h5>";
				echo "<form id='my-form'>";

					echo "<div class='fb-render'></div>";

				echo "</form>";


	}
	else
	{

		echo "<div class='row center-align'>";
			echo "<div style='padding:30px; text-align:center; width:100%;'><p style='font-size:16px;'>You do not have access to this form.</p></div>";
		echo "</div>";

	}

?>

<script src="/modules/Abre-Forms/js/form-render.min.js"></script>
<script>

	$(function()
	{
		//Render Form
		$('.fb-render').formRender({ dataType: 'json', formData: <?php echo $formFields ?>, notify: { success: function(message) { $('#my-form input').prop('disabled', true); $('input:checkbox').removeAttr('checked'); mdlregister(); }} });

		var frm = $('#my-form');
		var data = <?php echo $response ?>;
    $.each(data, function (key, value) {
        var $ctrl = $('[name="' + key + '"]', frm);
        switch ($ctrl.attr("type")) {
            case "text":
            case "hidden":
                $ctrl.val(value);
                break;
            case "radio":
                $ctrl.each(function () {
                    if ($(this).attr('value') == value) {
                        $(this).attr("checked", value);
                    }
                });
                break;
            case "checkbox":
								if(typeof(value) == "object"){
									$("[type=checkbox]").attr('checked', false);
									for (var i = 0; i < value.length; i++) {
											$ctrl.each(function () {
													if ($(this).attr('value') == value[i]) {
															$(this).attr("checked", value[i]);
													}
											});
									}
								}else{
									$ctrl.each(function() {
										if($(this).attr('value') == value){
											$(this).attr("checked", value);
										}else{
											$(this).attr("checked", false);
										}
									});
								}
                break;
						case "file":
								$ctrl.replaceWith("<br><a href='/modules/Abre-Forms/action_serve_file.php?formid="+<?php echo $id ?>+"&filename="+Object.keys(value)[0]+"&hash="+value[Object.keys(value)[0]]+"' style='color: <?php echo getSiteColor(); ?>; font-weight:500;'> "+Object.keys(value)[0]+"</a>");
								break;
            default:
                $ctrl.val(value);
        }
				$ctrl.prop('disabled', true);
    });
		$('select').prop('disabled', true);
		$('select').material_select();

	});

</script>