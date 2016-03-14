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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once('permissions.php');
	
	//Display my courses
	if($pagerestrictions=="")
	{
		?>
		
		<div class='page_container'>
		<div class='row'><div class='col s12'><h5>My Courses</h5></div></div>
		<div class='row'>
			
		<?php
				
			$userid=finduseridcore($_SESSION['useremail']);
			include "../../core/abre_dbconnect.php";
			$sql = "SELECT * FROM curriculum_libraries where User_ID='$userid'";
			$result = $db->query($sql);
			$numrows = $result->num_rows;
			$coursecount=0;
			while($row = $result->fetch_assoc())
			{
				$Course_ID=htmlspecialchars($row["Course_ID"], ENT_QUOTES);
				$Library_ID=htmlspecialchars($row["ID"], ENT_QUOTES);
				$sqllookup = "SELECT * FROM curriculum_course where ID='$Course_ID'";
				$result2 = $db->query($sqllookup);
				$setting_preferences=mysqli_num_rows($result2);
				while($row = $result2->fetch_assoc())
				{
					$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
					$Level=htmlspecialchars($row["Level"], ENT_QUOTES);
					$Subject=htmlspecialchars($row["Subject"], ENT_QUOTES);
					$Grade=htmlspecialchars($row["Grade"], ENT_QUOTES);
					$Image=htmlspecialchars($row["Image"], ENT_QUOTES);
					
					echo "<div class='mdl-card mdl-shadow--2dp card_courses'>";
						echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand' style='height:110px; background-image: url(modules/curriculum/images/$Image);'></div>";
						echo "<div class='mdl-card__title'><div class='mdl-card__title-text truncate'>$Title</div></div>";
						echo "<div class='mdl-card__supporting-text mdl-card__supporting-text-standalone truncate'>Grade Level: $Grade</div>";
						echo "<div class='mdl-card__actions'>";
							echo "<a class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-800' href='#curriculum/$Course_ID'>View Course</a>";
							echo "<div class='mdl-layout-spacer'></div>";
							echo "<button id='demo-menu-top-right-$coursecount' class='mdl-button mdl-js-button mdl-button--icon mdl-button--colored mdl-js-ripple-effect mdl-color-text--blue-800'><i class='material-icons'>more_vert</i></button>";
							echo "<ul class='mdl-menu mdl-menu--top-right mdl-js-menu mdl-js-ripple-effect' for='demo-menu-top-right-$coursecount'><li class='mdl-menu__item removecourse'><a href='modules/curriculum/removecourse.php?librarycourseid=".$Library_ID."' class='mdl-color-text--black'>Remove Course</a></li></ul>";
							echo "</div>";
					echo "</div>";	
					$coursecount++;
				}
			}
			
			if($numrows==0)
			{
				echo "<div class='col s12'>Click the 'All Courses' to add a course to your library.</div>";
			}
			
			?>
			
		</div>
		</div>
		
	}
?>