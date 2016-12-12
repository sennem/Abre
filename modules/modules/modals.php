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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
?>

	<!-- Book Code Modal -->
	<div id="addmodule" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id="form-addmodule" method="post" action="modules/<?php echo basename(__DIR__); ?>/githubmoduleadd_process.php">
		<div class="modal-content">
			<h4>Enter a Github Repository</h4>
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class="input-field col s6">
				<input id="repoaddress" name="repoaddress" type="text" placeholder="Example: https://github.com/abreio/Abre-Books" required>
			</div>
    	</div>
	    <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Add</button>
		</div>
		</form>
	</div>
	
<script>
				
	$(function()
	{					
					
		//Add a module
		var formaddmodule = $('#form-addmodule');					
		$(formaddmodule).submit(function(event) {
			event.preventDefault();
			$('button').html("Installing...");
			var formData = $(formaddmodule).serialize();
			$.ajax({
				type: 'POST',
				url: $(formaddmodule).attr('action'),
				data: formData
			})
						
			//Show the notification
			.done(function(response) {		
				location.reload();
			});						
		});
					    								
	});
	
</script>