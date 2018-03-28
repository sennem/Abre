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

  //Include required files
  require_once('abre_verification.php');
  require_once('abre_functions.php');

	//Display feedback modal for staff
	if($_SESSION['usertype'] == "staff"){
?>
		<!--Feedback modal-->
		<div id='feedback' class='modal modal-fixed-footer modal-mobile-full'>
			<form class='col s12' id='form-feedback' method='post' action='core/abre_feedback_submit.php'>
				<div class='modal-content' style="padding: 0px !important;">
          <div class="row" style='background-color: <?php echo getSiteColor(); ?>; padding: 24px;'>
            <div class='col s11'><span class="truncate" style="color: #fff; font-weight: 500; font-size: 24px; line-height: 26px;">Send Feedback</span></div>
            <div class='col s1 right-align'><a class="modal-close"><i class='material-icons' style='color: #fff;'>clear</i></a></div>
          </div>
          <div style='padding: 0px 24px 0px 24px;'>
  					<div class='row'>
  						<div class='input-field col s12'>
  							<textarea id='textarea' name='textarea' class='materialize-textarea' placeholder="Write a brief description" required></textarea>
                <label class="active" for="textarea">We welcome problem reports, feature ideas and general comments!</label>
  					    </div>
  					</div>
          </div>
			  </div>
			  <div class='modal-footer'>
					<button type='submit' class='modal-action waves-effect btn-flat white-text' style='background-color: <?php echo getSiteColor(); ?>'>Submit</button>
				</div>
			</form>
		</div>
<?php
	}
?>

<script>

	$(function(){
		//Load feedback modal
    $('.modal-trigger').leanModal({
			in_duration: 0,
			out_duration: 0,
			ready: function() {
				$("#textarea").focus();
			}
		});

		//Submit feedback form
		var form = $('#form-feedback');
		$(form).submit(function(event){
			event.preventDefault();
		  $('#feedback').closeModal({
				in_duration: 0,
				out_duration: 0,
		  });

			var formData = $(form).serialize();
			$.ajax({
				type: 'POST',
			  url: $(form).attr('action'),
			  data: formData
			})
			.done(function(response){
				$("#textarea").val('');
				var notification = document.querySelector('.mdl-js-snackbar');
				var data = { message: response };
				notification.MaterialSnackbar.showSnackbar(data);
			})
		});
	});

</script>