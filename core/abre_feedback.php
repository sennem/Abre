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
				<div class='modal-content'>
					<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
					<div class='row'>
						<div class='col s12'>
							<h4>Send Feedback</h4>
							<p>We welcome problem reports, feature ideas and general comments.</p>
							<textarea id='textarea' name='textarea' class='materialize-textarea' placeholder="Write a brief description" required></textarea>
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