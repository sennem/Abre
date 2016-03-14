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
	require(dirname(__FILE__) . '/../../configuration.php');
	
	echo "<div id='displayguide'>"; include "pacingguide_display.php"; echo "</div>";
?>
	
	<script>
		
		$(document).ready(function(){
			
			
			//Save Form Data
			var form = $('#form-addtopic');
			var formMessages = $('#form-messages');
						
			$(form).submit(function(event) {
				event.preventDefault();
				$('#curriculumtopic').closeModal();
				var formData = $(form).serialize() + "&courseid=" + <?php echo $Course_ID; ?>;
				$.ajax({
					type: 'POST',
					url: $(form).attr('action'),
					data: formData
				})
							
				//Show the notification
				.done(function(response) {
							$("input").val('');
				<?php
					$Course_ID=htmlspecialchars($_GET["id"], ENT_QUOTES);
					echo "$( '#displayguide' ).load( 'modules/curriculum/pacingguide_display.php?id=$Course_ID', function() {";
				?>
					
					//Go to Unit Based on Active Month
			var content = $(".mdl-layout__content");
			content.stop().animate({ scrollTop: $(".active").offset().top - 150 }, 500);	
					
							
							$('#form-messages').text(response);
							$( ".notification" ).slideDown( "fast", function() {
								$( ".notification" ).delay( 2000 ).slideUp();	
							});
				
				});
			
			})						
			});
			
			$('.tooltipped').tooltip({delay: 0});
			
		});
		
	</script>