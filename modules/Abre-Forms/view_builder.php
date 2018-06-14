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
	if(isset($_GET["id"])){ $id=htmlspecialchars($_GET["id"], ENT_QUOTES); }else{ $id=""; }

	if(($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator()) && hasEditAccess($id))
	{

		//Look up form data
		$sql = "SELECT Name, FormFields, Session FROM forms where ID = '$id'";
		$result = $db->query($sql);
		while($row = $result->fetch_assoc())
		{
			$FormName = htmlspecialchars($row["Name"], ENT_QUOTES);
			$FormFields = $row["FormFields"];
			$Session = $row["Session"];
			if($FormFields == ''){
				$FormFields = "[]";
			}
		}

		//Add Button
		require "button_save.php";

		//Builder Holder
		echo "<div class='page_container page_container_limit'>";

			$Form_Link="$portal_root/?url=forms/session/$id/$Session";

			//Form Menu
			echo "<div class='row' style='margin-top:30px;'>";
				echo "<div class='col m10 s12'>";
					echo "<input type='text' style='font-size:32px;' name='formname' id='formname' placeholder='Form Name' value='$FormName'>";
				echo "</div>";

				echo "<div class='col m2 s2 right-align'>";
					echo "<a class='waves-effect waves-light btn save' id='sendformlink' style='margin-top:8px; background-color: ".getSiteColor()."' href='#' data-formlink='$Form_Link'>Send</a>";
				echo "</div>";

			echo "</div>";

			//Jquery Form Builder
			echo "<div class='row'>";
				echo "<div class='col s12'>";
					echo "<div id='formbuilder'></div>";
				echo "</div>";
			echo "</div>";

		echo "</div>";

	}
	else
	{

		echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>You Do Not Have Edit Access</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Please request access from the form owner.</p></div>";

	}

?>

<script src="/modules/Abre-Forms/js/form-builder.min.js"></script>

<script>

	$(function()
	{

		var saveneeded = 0;

		//Custom Fields
		var fields = [

			{ label: "Description", type: "paragraph", subtype: "p", icon: "<i class='material-icons'>description</i>" },
			{ label: "Title/Subtitle", type: "header", subtype: "header", icon: "<i class='material-icons'>title</i>" },
			{ label: "Short Answer", type: "text", subtype: "text", icon: "<i class='material-icons'>short_text</i>" },
			{ label: "Paragraph", type: "textarea", subtype: "textarea", icon: "<i class='material-icons'>subject</i>" },
			{ label: "Multiple Choice", type: "radio-group", subtype: "radio-group", icon: "<i class='material-icons'>radio_button_checked</i>" },
			{ label: "Checkboxes", type: "checkbox-group", subtype: "checkbox-group", icon: "<i class='material-icons'>check_box</i>" },
			{ label: "Dropdown", type: "select", subtype: "select", icon: "<i class='material-icons'>arrow_drop_down_circle</i>" },
			{ label: "Date", type: "date", subtype: "date", icon: "<i class='material-icons'>date_range</i>" },
			{ label: "Number", type: "number", subtype: "number", icon: "<i class='material-icons'>exposure_zero</i>" },
			{ label: "File Upload", type: "file", subtype: "file", icon: "<i class='material-icons'>file_upload</i>" },

		];

		//Start Form Builder
		var options = {
			showActionButtons: false,
			fields: fields,
			controlOrder: ['header', 'paragraph', 'text', 'textarea', 'radio-group', 'checkbox-group', 'select', 'date', 'number', 'file'],
			disableFields: ['autocomplete', 'button', 'file', 'hidden', 'paragraph', 'text', 'textarea', 'radio-group', 'header', 'select', 'checkbox-group', 'date', 'number'],
			disabledAttrs: ['access', 'className','placeholder', 'name', 'description', 'inline', 'toggle', 'value', 'maxlength', 'rows'],
			typeUserDisabledAttrs: {
				'textarea': [
						'subtype'
				]
			}
		};
		var formBuilder = $('#formbuilder').formBuilder(options);

		//Set Variables
		function saveform(notify, drag){

			var formid = $(".save").data("formid");
			var formfields = formBuilder.actions.getData();
			formfields.forEach(function(element){
				if(element['label'].indexOf("style") >= 0){
					element['name'] = $(element['label']).text().replace(/[^\w\s]|_/g, "");
					element['label'] = $(element['label']).text();
				}else{
					element['name'] = element['label'].replace(/[^\w\s]|_/g, "");
					element['label'] = element['label'];
				}
			});
			var formname = $("#formname").val();

			$.post("/modules/Abre-Forms/action_saveform.php", { formid: formid, formfields: JSON.stringify(formfields), formname: formname, reorder: drag })
			.done(function(response) {
				mdlregister();

				if(notify==1){
					var data;
					if(response.status == "Error"){
						data = { message: response.message };
					}else{
						saveneeded = 0;
						var data = { message: "Form Saved" };
					}
					var notification = document.querySelector('.mdl-js-snackbar');
					notification.MaterialSnackbar.showSnackbar(data);
				}
			});
		}

		function updateRequiredCheckboxes(){
			$(":checkbox").addClass("filled-in");
			$(".required-wrap label").each(function(){
				var label = $(this);
				$(this).remove();
				$("#"+label.attr('for')).after(label);
			});
		}

		//Set the Form Builder Data
		var formData = <?php echo $FormFields; ?>;
		formData = JSON.stringify(formData);
		formBuilder.promise.then(formBuilder => {

			//Load Form with Data
			formBuilder.actions.setData(formData);

			updateRequiredCheckboxes();

			$('.stage-wrap').off().on('mousedown', '.form-field', function(e) {
				$(this).data('p0', { x: e.pageX, y: e.pageY });
			}).on('mouseup', '.form-field', function(e) {
				var p0 = $(this).data('p0'),
						p1 = { x: e.pageX, y: e.pageY },
						d = Math.sqrt(Math.pow(p1.x - p0.x, 2) + Math.pow(p1.y - p0.y, 2));

				if (d >= 50) {
					setTimeout(saveform, 500, 1, 1);
				}
			});

			$('.frmb-control').on('mouseup', function(e) {
				setTimeout(updateRequiredCheckboxes, 500);
			});

		});

		//Detect if Saving
		$(".page_container").unbind().click(function(event){

			saveneeded = 1;

		});


		$(".formmenu").unbind().click(function(event){

			var object = event.currentTarget.id;

			if(object != "save" && saveneeded == 1)
			{

				var result = confirm("You have not saved your changes. Are you sure you want to continue?");
				if (!result) {
					event.stopImmediatePropagation();
					return false;
				}

			}

		});

		//Json Button
		$(".save").unbind().click(function(event){

			event.preventDefault();

			saveform(1, 0);

		});

    	$("#sendformlink").unbind().click(function(event){

	    	event.preventDefault();

	    	var FormLink = $(this).data('formlink');


	    	saveform(0, 0);

	    	$('#sendform').openModal({
				in_duration: 0,
				out_duration: 0,
				ready: function() {
					$(".modal-content #SendLink").val(FormLink);
			    }
			});


		});


	});

</script>