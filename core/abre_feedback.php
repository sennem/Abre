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
    
    require_once('abre_verification.php');
	
	if($_SESSION['usertype']!="student")
	{	
		
		//Feedback Icon
		echo "<a class='modal-trigger mdl-button mdl-js-button mdl-button--icon feedbackbutton mdl-cell--hide-phone' href='#feedback'><i class='material-icons'>help</i></a>";
	
		//Feedback Modal
		echo "<div id='feedback' class='modal modal-fixed-footer'>";
			echo "<form class='col s12' id='form-feedback' method='post' action='core/abre_feedback_submit.php'>";
				echo "<div class='modal-content'>";
					echo "<div class='row'>";
						echo "<div class='col s12'>";
							echo "<h4>Feedback</h4>";
							echo "<p>We welcome problem reports, feature ideas and general comments.</p><br>";
						echo "</div>";
						echo "<div class='input-field col s12'>";
							echo "<textarea id='textarea' name='textarea' class='materialize-textarea'></textarea>";
							echo "<label for='textarea'>Write a brief description:</label>";
					    echo "</div>";
					echo "</div>";
			    echo "</div>";
			    echo "<div class='modal-footer'>";
					echo "<button type='submit' class='modal-action waves-effect btn-flat blue darken-3 white-text'>Submit</button>";
				echo "</div>";
			echo "</form>";
		echo "</div>";
	
	}
?>
	          
	          
<script>
	
	$(document).ready(function(){
    	$('.modal-trigger').leanModal();
    	
    	
		//Save Form Data
		var form = $('#form-feedback');
		var formMessages = $('#form-messages');
		
		$(form).submit(function(event) {
		    event.preventDefault();
		    $('#feedback').closeModal();
		    $(formMessages).text('Submitting feedback...');	
		    $( ".notification" ).slideDown();	
			var formData = $(form).serialize();
			$.ajax({
			    type: 'POST',
			    url: $(form).attr('action'),
			    data: formData
			})
			
			//Show the notification
			.done(function(response) {
				$(formMessages).text(response);	
				$("#textarea").val('');
				$( ".notification" ).slideDown( "fast", function() {
					$( ".notification" ).delay( 2000 ).slideUp();	
				});			
			})
			
		});
    	
    	
  	});
  
  
</script> 