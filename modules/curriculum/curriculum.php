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
	
	require_once(dirname(__FILE__) . '/../../core/portal_verification.php'); 
	
	echo "<div id='displaylibrary'>"; include "curriculum_display.php"; echo "</div>";	

?>
												
			<script>
				
				$(function() {					
					
					//Save Form Data
					var form = $('#form-addbook');
					var formMessages = $('#form-messages');
					
					//Add Book to Library
					$(form).submit(function(event) {
					    event.preventDefault();
					    $('#addbook').closeModal();
					    $(formMessages).text('Adding Book...');	
					    $( ".notification" ).slideDown();	
						var formData = $(form).serialize();
						$.ajax({
						    type: 'POST',
						    url: $(form).attr('action'),
						    data: formData
						})
						
						//Show the notification
						.done(function(response) {
							
							$( "#displaylibrary" ).load( "modules/books/books_display.php", function() {

								//Register MDL Components
								var html = document.createElement('content_wrapper');
								$(document.body).append(html);      
								componentHandler.upgradeAllRegistered();

								$("input").val('');
								$('#form-messages').text(response);
								$( ".notification" ).slideDown( "fast", function() {
									$( ".notification" ).delay( 2000 ).slideUp();	
								});
							});			
						})
						
					});
					
					//Remove Book from Library
					$('#displaylibrary').on('click','.removebook',function(){
						event.preventDefault();
						var address = $(this).find("a").attr("href");
						$('#form-messages').text( "Removing Book..." );
						$( ".notification" ).slideDown();	
						$.ajax({
							type: 'POST',
							url: address,
							data: '',
						})
															
						//Show the notification
						.done(function(response) {
							$( "#displaylibrary" ).load( "modules/books/books_display.php", function() {
																	
							//Register MDL Components
							var html = document.createElement('content_wrapper');
							$(document.body).append(html);      
							componentHandler.upgradeAllRegistered();
																	
							$('#form-messages').text(response);	
							$( ".notification" ).slideDown( "fast", function() {
								$( ".notification" ).delay( 2000 ).slideUp();	
							});		
						});	
						})
					});    
					    								
				});

				
			</script>