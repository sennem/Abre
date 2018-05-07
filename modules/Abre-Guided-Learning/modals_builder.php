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

	require_once('permissions.php');

	if($pagerestrictions=="")
	{
?>

	<!-- New Guided Learning Session -->
	<div id="newguidedlearningsession" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id="form-newguidedlearningsession" method="post" action="modules/<?php echo basename(__DIR__); ?>/addlesson_process.php">
		<div class="modal-content" style="padding: 0px !important;">
			<div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
				<div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Guided Lesson</span></div>
				<div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
			</div>
			<div style='padding: 0px 24px 0px 24px;'>
				<div class="row">
					<div class="input-field col s12">
						<b>Lesson Title</b>
						<input id="lesson_title" name="lesson_title" type="text" maxlength="50" placeholder="Enter a Guided Learning Title" required>
					</div>
				</div>
					<?php
						for ($x = 0; $x <= 7; $x++)
						{
							$lessonnumber=$x+1;
							echo "<div class='row'>";
								echo "<div class='input-field col s6'>";
									echo "<input id='website_link_$x' name='website_link_$x' type='url' placeholder='Enter or Paste a Link' autocomplete='off'>";
									echo "<label class='active' for='website_link_$x'>Lesson $lessonnumber Link</label>";
								echo "</div>";
								echo "<div class='input-field col s6'>";
									echo "<input id='website_title_$x' name='website_title_$x' type='text' placeholder='Enter a Description' autocomplete='off'>";
									echo "<label class='active' for='website_title_$x'>Lesson $lessonnumber Description</label>";
								echo "</div>";
							echo "</div>";
						}
						echo "<div class='row'>";
							echo "<div class='input-field col s12'>";
								echo "<input id='favorite_link' name='favorite_link' type='url' placeholder='Enter or Paste a Favorite Link'>";
								echo "<label class='active' for='favorite_link'>Favorite Link (available as split screen)</label>";
							echo "</div>";
						echo "</div>";
						echo "<div class='row'>";
							echo "<div class='col s12'>";
								echo "<label class='row'>Restriction Settings </label>";
								echo "<select class='browser-default' id='restrictionsetting' name='restrictionsetting'>";
							    echo "<option value=''>No restrictions</option>";
							    echo "<option value='Low'>Only content available on above websites</option>";
							    echo "<option value='High'>Only the specific links on above websites</option>";
								echo "</select>";
							echo "</div>";
						echo "</div>";

					?>
				<input type="hidden" name="lesson_id" id="lesson_id" value="">
			</div>
    </div>
	  <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text submitbutton" style='margin-left:5px; background-color: <?php echo getSiteColor(); ?>'>Save</button>
			<a class="modal-close waves-effect btn-flat white-text cancelbutton"  style='background-color: <?php echo getSiteColor(); ?>'>Cancel</a>
		</div>
		</form>
	</div>

  <div id="guidedlearningcode" class="modal modal-mobile-full" style='max-width:600px; background-color: <?php echo getSiteColor(); ?>'>
  	<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons' style='color:#fff;'>clear</i></a>
    <div class="modal-content">
	  	<div class="row" style='margin-top:50px;'>
		  	<div class="col s12 center-align">
	  			<h2 id="codeHolder" style="color:#fff; font-size: 110px; font-weight:700;"></h2>
	  		</div>
		</div>
    </div>
  </div>

<script>

	$(function() {

		//Add a Lesson
		var formaddbook = $('#form-newguidedlearningsession');
		var formMessages = $('#form-messages');

		$(formaddbook).submit(function(event) {
			event.preventDefault();
			var formData = $(formaddbook).serialize();
			$.ajax({
				type: 'POST',
				url: $(formaddbook).attr('action'),
				data: formData
			})

			//Show the notification
			.done(function(responseprocess) {

				var entryid=responseprocess.queryid;
					$('#newguidedlearningsession').closeModal({ in_duration: 0, out_duration: 0, });
					$( "#lessonbuilderdiv" ).load( "modules/<?php echo basename(__DIR__); ?>/lessonbuilder.php", function(response)
					{
						//Register MDL Components
						mdlregister();
						$("input").val('');
						$('select>option:eq(0)').attr('selected', true);
						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: responseprocess.message };
						notification.MaterialSnackbar.showSnackbar(data);
					});
			})
		});

	});

</script>

<?php

	}

?>