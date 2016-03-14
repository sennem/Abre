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
	require(dirname(__FILE__) . '/../../configuration.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php'); 
	require_once('permissions.php');
	
	if($pageaccess==1)
	{		
		
		echo "<div class='row'><div class='col s12'>";
			if($superadmin==1)
			{
				echo "<form action='modules/directory/csvimportfile.php' method='post' enctype='multipart/form-data' name='form-upload' id='form-upload'>"; 
				echo "<input name='csv_data' type='file' id='csv_data' />";
				echo "<br><br><input type='submit' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--blue-800' name='Submit' value='Import' />";
				echo "</form>";
			}
			echo "<br><a href='$portal_root/modules/directory/csvexportfile.php' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-color--blue-800'>Export</a>";
		echo "</div><div>";
		
		?>
		
			<script>
			
				//Process the Form
				$(function() {
					
					var form = $('#form-upload');
					var formMessages = $('#form-messages');
					$(form).submit(function(event) {
						
						event.preventDefault();
					    $(formMessages).text('Uploading...');	
					    $( ".notification" ).slideDown();	
					    
					    var file_data = $('#csv_data').prop('files')[0];
					    var form_data = new FormData();
					    form_data.append('file', file_data)
					    $.ajax({
							url: $(form).attr('action'),
							dataType: 'text',
							cache: false,
							contentType: false,
							processData: false,
							data: form_data,
							type: 'post'
					     })
					     
						.done(function(form_data) {
							$( "#content_holder" ).load( "modules/directory/export.php", function() {
								$(formMessages).text(form_data);	
								$( ".notification" ).slideDown( "fast", function() {
									$( ".notification" ).delay( 2000 ).slideUp();	
								});	
							});		
						})

			
					});


				});
				
			</script>		
		
		<?php
		
		
	}		
					
?>