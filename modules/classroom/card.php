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
	require_once(dirname(__FILE__) . '/../../core/portal_google_login.php'); 
	
	//Set Access Token
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']){ $client->setAccessToken($_SESSION['access_token']); }
	
	//Get Classroom Information
	if ($client->getAccessToken()){

		$_SESSION['access_token'] = $client->getAccessToken();

		//Card Title
		echo "<div class='mdl-card__title'>";
			echo "<div class='valign-wrapper'>";
				echo "<a href='https://classroom.google.com' target='_blank'><img src='core/images/icon_classroom.png' class='icon_small'></a>";
				if($_SESSION['usertype']=="staff"){ echo "<div><div class='mdl-card__title-text'>Classroom</div><div class='card-text-small'>Classes You Teach</div></div>"; }
				if($_SESSION['usertype']=="student"){ echo "<div><div class='mdl-card__title-text'>Classroom</div><div class='card-text-small'>Classes You Are Taking</div></div>"; }
			echo "</div>";
		echo "</div>";			
	
		//Display Classes
		echo "<div class='hide-on-small-only'>";
		echo "<div class='row' style='margin-bottom:0;'>";
		
			if($_SESSION['usertype']=="staff")
			{ 
				$optParams = array('pageSize' => 7, 'teacherId' => 'me');
			}
			if($_SESSION['usertype']=="student")
			{ 
				$optParams = array('pageSize' => 7, 'studentId' => 'me');
			}
			$results = $Service_Classroom->courses->listCourses($optParams);
			
			if (count($results->getCourses()) != 0)
			{
				foreach ($results->getCourses() as $course)
				{
					$courseName=$course->getName();
			    	$courseSection=$course->getSection();
			    	$courseId=$course->getId();
			    	$courseEnrollmentCode=$course->getenrollmentCode();
			    	$courseAlternateLink=$course->getalternateLink();
			    	$courseCourseState=$course->getcourseState();
					if($courseCourseState=="ACTIVE")
					{
						echo "<hr>";
						echo "<div class='valign-wrapper'>";
							echo "<div class='col s10'>";
								echo "<div class='mdl-card__supporting-text subtext truncate'><b>$courseName</b>";
								if($courseSection!=""){ echo "<br>$courseSection"; }
								echo "<br>Code: $courseEnrollmentCode</div>";
							echo "</div>";
							echo "<div class='col s2'>";
								echo "<a href='$courseAlternateLink' target='_blank'><i class='material-icons mdl-color-text--grey-400'>play_circle_filled</i></a>";
							echo "</div>";
						echo "</div>";
					}
				}
			}
		
		echo "</div>";
		echo "</div>";
		
	}

?>