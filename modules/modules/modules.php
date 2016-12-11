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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	
	//Modules
	$sql = "SELECT *  FROM users where email='".$_SESSION['useremail']."' and superadmin=1";
	$result = $db->query($sql);
	while($row = $result->fetch_assoc())
	{	
		echo "<div class='page_container page_container_limit mdl-shadow--4dp'>";
			echo "<div class='page'>";
				
				//Modules				
				echo "<div class='row'>";	
					echo "<div class='col s12'>";	
						echo "<table id='myTable'>";
							echo "<thead>";
								echo "<tr>";
								echo "<th>Title</th>";
								echo "<th>Description</th>";
								echo "<th>Version</th>";
								//echo "<th style='width:30px'></th>";
								echo "</tr>";
							echo "</thead>";
							echo "<tbody>";
						
						//List all modules
						$modules = array();
						$modulecount=0;
						$moduledirectory = '../../modules/';
						$modulefolders = scandir($moduledirectory);
						foreach ($modulefolders as $result)
						{	
							if ($result == '.' or 
								$result == '..' or 
								$result == '.DS_Store' or 
								$result == 'apps' or
								$result == 'calendar' or
								$result == 'classroom' or
								$result == 'directory' or
								$result == 'drive' or
								$result == 'mail' or
								$result == 'modules' or
								$result == 'profile' or
								$result == 'settings' or
								$result == 'stream' or
								$result == 'startup'
								) continue;
								
							$pagetitle=NULL;
							$description=NULL;
							$version=NULL;
							$repo=NULL;
							require_once('../../modules/'.$result.'/config.php');
							
							if($description==NULL){ $description="No Description"; }
							if($version==NULL){ $version="No Version"; }

							echo "<tr>";
								echo "<td>$pagetitle</td>";
								echo "<td>$description</td>";
								echo "<td>$version</td>";
								
								//Update Module if new version available
								if($repo!=NULL)
								{
									$opts = ['http' => ['method' => 'GET','header' => ['User-Agent: PHP']]];
									$context = stream_context_create($opts);
									$content = file_get_contents("https://api.github.com/repos/$repo/releases/latest", false, $context);
									$json = json_decode($content, true);
									$currentversion = $json['name'];
									if($version<$currentversion)
									{
										$currentlink = "https://github.com/$repo/archive/".$currentversion.".zip";
										echo "<td width=30px><button class='updatemodule mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600' data-version='$currentlink' data-repo='$repo'><i class='material-icons'>update</i></button></td>";
									}
									else
									{
										echo "<td width=30px></td>";
									}
								}
								else
								{
									echo "<td width=30px></td>";
								}
							echo "</tr>";
	
						}

						echo "</tbody>";
						echo "</table>";
					echo "</div>";
					echo "</div>";
													
				echo "</div>";
			echo "</div>";
			?>
			
			<script>
				
				//Update module
				$(".updatemodule").click(function(event) {
					event.preventDefault();
					var Link = $(this).data('version');
					var Repo = $(this).data('repo');
					$(this).html("<i class='material-icons'>file_download</i>");
					$.post("modules/modules/update.php", { link: Link, repo: Repo }, function(){ })
					.done(function() {
						location.reload();
			  		})
			  	});
			  	
			</script>
			
			<?php
	}
	
?>