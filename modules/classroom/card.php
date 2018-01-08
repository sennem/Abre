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
	require_once(dirname(__FILE__) . '/../../core/abre_google_login.php');

	try{

		//Set access token
		if(isset($_SESSION['access_token']) && $_SESSION['access_token']){ $client->setAccessToken($_SESSION['access_token']); }

		//Get classroom information
		if($client->getAccessToken()){

			$_SESSION['access_token'] = $client->getAccessToken();
?>

			<div class='mdl-card__title'>
				<div class='valign-wrapper'>
					<a href='https://classroom.google.com' target='_blank'><img src='core/images/icon_classroom.png' class='icon_small'></a>
					<?php
						if($_SESSION['usertype'] == "staff"){ echo "<div><div class='mdl-card__title-text'>Classroom</div><div class='card-text-small'>Classes You Teach</div></div>"; }
						if($_SESSION['usertype'] == "student"){ echo "<div><div class='mdl-card__title-text'>Classroom</div><div class='card-text-small'>Classes You Are Taking</div></div>"; }
					?>
				</div>
			</div>
			<div class='hide-on-small-only'>
				<div class='row' style='margin-bottom:0;'>
					<?php
					if($_SESSION['usertype'] == "staff"){
						$optParams = array('pageSize' => 7, 'teacherId' => 'me');
					}
					if($_SESSION['usertype'] == "student"){
						$optParams = array('pageSize' => 7, 'studentId' => 'me');
					}
					$results = $Service_Classroom->courses->listCourses($optParams);

					if (count($results->getCourses()) != 0){
						foreach ($results->getCourses() as $course){
							$courseName = $course->getName();
				    	$courseSection = $course->getSection();
				    	$courseId = $course->getId();
				    	$courseEnrollmentCode = $course->getenrollmentCode();
				    	$courseAlternateLink = $course->getalternateLink();
				    	$courseCourseState = $course->getcourseState();
							if($courseCourseState == "ACTIVE"){
								echo "<hr>";
								echo "<div class='valign-wrapper'>";
									echo "<div class='col s10'>";
										echo "<div class='mdl-card__supporting-text subtext truncate demotext_dark'><b>$courseName</b>";
										if($courseSection != ""){ echo "<br>$courseSection"; }
										echo "<br>Code: $courseEnrollmentCode</div>";
									echo "</div>";
									echo "<div class='col s2'>";
										echo "<a href='$courseAlternateLink' target='_blank'><i class='material-icons mdl-color-text--grey-600'>play_circle_filled</i></a>";
									echo "</div>";
								echo "</div>";
							}
						}
					}
					?>
				</div>
			</div>
<?php
		}
	}catch(Exception $e){ }
?>