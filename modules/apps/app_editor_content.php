<?php

	/*
	* Copyright 2015 Hamilton City School District
	*
	* This program is free software: you can redistribute it and/or modify
    * it under the terms of the GNU General Public License as published by
    * the Free Software Foundation, either version 3 of the License, or
    * (at your option) any later version.
	*
    * This program is distributed in the hope that it will be useful,
    * but WITHOUT ANY WARRANTY; without even the implied warranty of
    * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    * GNU General Public License for more details.
	*
    * You should have received a copy of the GNU General Public License
    * along with this program.  If not, see <http://www.gnu.org/licenses/>.
    */

	//Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	if(superadmin())
	{

		echo "<table class='bordered' id='appsort'>";
			$query = "SELECT * FROM apps order by sort";
			$dbreturn = databasequery($query);
			foreach ($dbreturn as $value)
			{
				$id=$value['id'];
				$title=$value['title'];
				$titleencoded=base64_encode($title);
				$link=$value['link'];
				$linkencoded=base64_encode($link);
				$icon=$value['icon'];
				$icon_end = substr($icon, 5);
				$icon_final="icon_thumb_$icon_end";
				$staff=$value['staff'];
				$student=$value['student'];
				$parent=$value['parent'];
				$permissions = array();
				if($staff == 1){
					array_push($permissions,'Staff');
				}
				if($student == 1){
					array_push($permissions,'Students');
				}
				if($parent == 1){
					array_push($permissions,'Parents');
				}
				$permissionsList = implode(", ", $permissions);
				$minor_disabled=$value['minor_disabled'];
				echo "<tr id='item-$id' style='background-color:#f9f9f9'>";
					echo "<td style='width:60px'><img src='$portal_root/core/images/$icon' style='width:35px; height:35px;'></td>";
					echo "<td><b>$title</b> (".$permissionsList.")<td>";
					echo "<td style='width:30px'><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 passappdata' data-apptitle='$titleencoded' data-applink='$linkencoded' data-appicon='$icon_final' data-appid='$id' data-appstaff='$staff' data-appstudents='$student' data-appminors='$minor_disabled' data-appparents='$parent'><i class='material-icons'>mode_edit</i></button></td>";
					echo "<td style='width:30px'><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 deleteapp' data-appid='$id'><i class='material-icons'>delete</i></button></td>";
					echo "<td style='width:30px'><div class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 handle'><i class='material-icons'>reorder</i></div></td>";
				echo "</tr>";
			}
		echo "</table>";

	}

?>

	<script>

		$(function()
		{

		   	<?php
			if(superadmin())
			{
			?>

				//Save Default App Order
				var fixHelper = function(e, ui) {
				ui.children().each(function() {
					$(this).width($(this).width());
				});
				return ui;
				};
			   	$( "#appsort tbody" ).sortable({
					axis: 'y',
					handle: '.handle',
					helper: fixHelper,
					update: function(event, ui){

						//Sent Form Data
						var data = $(this).sortable('serialize');
						$.ajax({
					        data: data,
					        type: 'POST',
					        url: '/modules/<?php echo basename(__DIR__); ?>/apps_save_default_order.php'
					    })

					    .done(function(){
						    $('#loadapps').load('modules/<?php echo basename(__DIR__); ?>/apps.php');
							if (typeof loadOtherCardsApps == 'function')
							{
								loadOtherCardsApps();
							}
						});

					}
				});

				//Delete assessment
				$(".deleteapp").unbind().click(function() {
					event.preventDefault();
					var result = confirm("Are you sure you want to delete this app?");
					if (result) {

						$(this).closest("tr").hide();
						var appid = $(this).data('appid');

						//Make the post request
						$.ajax({
							type: 'POST',
							url: 'modules/apps/app_delete.php?id='+appid,
							data: '',
						})

						.done(function(){
							$('#loadapps').load('modules/apps/apps.php');
						});

					}
				});

				//Get App Data
				$(".passappdata").unbind().click(function() {

					//Fill Modal with Data
					var apptitle = atob($(this).data('apptitle'));
					$("#editmodaltitle").text(apptitle);
					$("#app_name").val(apptitle);
					var applink = atob($(this).data('applink'));
					$("#app_link").val(applink);
					var appicon = $(this).data('appicon');
					$('[name=app_icon]').val(appicon);
					$("select").imagepicker();

					var appid = $(this).data('appid');
					$("#app_id").val(appid);
					var appstaff = $(this).data('appstaff');
					if(appstaff==1)
					{
						$('#app_staff').prop('checked', true);
					}
					else
					{
						$('#app_staff').prop('checked', false);
					}
					var appstudents = $(this).data('appstudents');
					if(appstudents==1)
					{
						$('#app_students').prop('checked', true);
					}
					else
					{
						$('#app_students').prop('checked', false);
					}
					var appparents = $(this).data('appparents');
					if(appparents==1)
					{
						$('#app_parents').prop('checked', true);
					}
					else
					{
						$('#app_parents').prop('checked', false);
					}
					var appminors = $(this).data('appminors');
					if(appminors==1)
					{
						$('#app_minors').prop('checked', true);
					}
					else
					{
						$('#app_minors').prop('checked', false);
					}

					$('#addeditapp').openModal({
						in_duration: 0,
						out_duration: 0,
						ready: function() {
							$('.modal-content').scrollTop(0);
					    },
					});

				});

			<?php
			}
			?>

		});

	</script>
