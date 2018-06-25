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

    //Required configuration files
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{
		?>

		<div class='page_container'>
		<div class='row'>

		<?php

			$userid=finduseridcore($_SESSION['useremail']);
			$sql = "SELECT Course_ID, ID FROM curriculum_libraries WHERE User_ID='$userid'";
			$result = $db->query($sql);
			$numrows = $result->num_rows;
			$coursecount=0;
			while($row = $result->fetch_assoc())
			{
				$Course_ID=htmlspecialchars($row["Course_ID"], ENT_QUOTES);
				$Library_ID=htmlspecialchars($row["ID"], ENT_QUOTES);
				$sqllookup = "SELECT Title, Level, Subject, Grade, Image FROM curriculum_course WHERE ID='$Course_ID' AND Hidden='0'";
				$result2 = $db->query($sqllookup);
				$setting_preferences=mysqli_num_rows($result2);
				while($row = $result2->fetch_assoc())
				{
					$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
					$Level=htmlspecialchars($row["Level"], ENT_QUOTES);
					$Subject=htmlspecialchars($row["Subject"], ENT_QUOTES);
					$Grade=htmlspecialchars($row["Grade"], ENT_QUOTES);
					$Image=htmlspecialchars($row["Image"], ENT_QUOTES);
					if($Image == ""){
						$Image = "generic.jpg";
					}else{
						$imageCheck = $portal_path_root."/modules/".basename(__DIR__)."/images/".$Image;
						if(file_exists($imageCheck)){
							$Image = "/modules/".basename(__DIR__)."/images/".$Image;
						}else{
							$Image = $portal_root."/modules/Abre-Curriculum/serveimage.php?file=$Image&ext=png";
						}
					}

					echo "<div class='mdl-card mdl-shadow--2dp card_courses'>";
						echo "<div class='mdl-card__media mdl-color--grey-100 mdl-card--expand' style='height:120px; background-image: url($Image);'></div>";
						echo "<div class='mdl-card__title'><div class='mdl-card__title-text truncate'><span class='truncate'>$Title</span></div></div>";
						echo "<div class='mdl-card__supporting-text truncate'>Grade Level: $Grade</div>";
						echo "<div class='mdl-card__actions'>";
							echo "<a class='mdl-button mdl-js-button mdl-js-ripple-effect' style='color: ".getSiteColor()."' href='#curriculum/0/$Course_ID'>Explore</a>";
							echo "<div class='mdl-layout-spacer'></div>";
							echo "<div class='removecourse'><a class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600' href='modules/".basename(__DIR__)."/course_remove_process.php?librarycourseid=".$Library_ID."'><i class='material-icons'>delete</i></a></div>";
						echo "</div>";
					echo "</div>";
					$coursecount++;
				}
			}

			if($coursecount==0)
			{
				echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Courses Yet</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the 'All Courses' at the top to browse the course catalog.</p></div>";
			}

		?>

		</div>
		</div>

		<?php

	}

?>