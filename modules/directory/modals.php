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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');	
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');	

?>

	<!-- Employee Modal -->
	<div id="employeeprofile" class="modal modal-fixed-footer modal-mobile-full">
		<form class="col s12" id='form-hr' method='post' enctype='multipart/form-data' action='modules/directory/updateuser.php'>
		<div class="modal-content">
			<a class="modal-close black-text" style='position:absolute; right:20px; top:25px;'><i class='material-icons'>clear</i></a>
			<div class="row">
				<div id="employeedata"></div>
				<input type="hidden" id="searchquerysave" name="searchquerysave">
			</div>
    	</div>
	    <div class="modal-footer">
			<button type="submit" class="modal-action waves-effect btn-flat white-text" style='margin-left:5px; background-color: <?php echo sitesettings("sitecolor"); ?>'>Save</button>
			<a class="modal-close waves-effect btn-flat white-text"  style='background-color: <?php echo sitesettings("sitecolor"); ?>'>Cancel</a>
		</div>
		</form>
	</div>
	
		<script>
			
			$(document).ready(function() 
			{ 
    			
	    		//Open Modal
				$(document).off().on("click", ".employeeview", function ()
				{
					event.preventDefault();
					$("#employeedata").hide();
					var EmployeeID= $(this).data('employeeid');
					var SearchQuerySaved= $(this).data('searchquerysaved');
					$("#searchquerysave").val(SearchQuerySaved);
					
					$("#employeedata").load( "modules/<?php echo basename(__DIR__); ?>/profile.php?id="+EmployeeID, function()
					{	
						$("#employeedata").show();
					});
					
					$('#employeeprofile').openModal({ in_duration: 0, out_duration: 0, ready: function() { } });
				}); 
				
				//Archive the User
				$(document).on("click", "#archiveuser", function ()
				{
					event.preventDefault();
					var result = confirm("Are you sure you want to archive this user?");
					if (result)
					{
						var userid = $('#userid').val();
					    $.ajax({
						    type: 'POST',
						    url: 'modules/directory/archiveuser.php',
						    data: { id : userid }
						})
	
						//Show the notification
						.done(function(response) {
							$('#employeeprofile').closeModal({ in_duration: 0, out_duration: 0, ready: function() { } });
							var SearchQuery = $("#searchquerysave").val();
							$.post("modules/<?php echo basename(__DIR__); ?>/searchresults.php", { searchquery: SearchQuery })
							.done(function( data ) {
						    	$('#searchresults').html(data);
						  	});						
						})
					}

				});
				
    			
			}); 
			
		</script>