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
    require_once('abre_verification.php');
    require_once('abre_functions.php');
	
	//Display feedback modal for staff
	if($_SESSION['usertype']=="staff")
	{	
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
					<button type='submit' class='modal-action waves-effect btn-flat white-text' style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Submit</button>
				</div>
			</form>
		</div>
	<?php
	}
?>
	          
	          
<script>
	
	$(document).ready(function(){
    	
    	$('.modal-trigger').leanModal({
	    	in_duration: 0,
			out_duration: 0,
	    	ready: function() { $("#textarea").focus(); }
	   	}
	   	);
    	
    	
		//Save Form Data
		var form = $('#form-feedback');
		var formMessages = $('#form-messages');
		
		$(form).submit(function(event) {
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
			
			//Show the notification
			.done(function(response) {
				$("#textarea").val('');
				var notification = document.querySelector('.mdl-js-snackbar');
				var data = { message: response };
				notification.MaterialSnackbar.showSnackbar(data);	
			})
			
		});
    	
    	
  	});
  
  
</script> 