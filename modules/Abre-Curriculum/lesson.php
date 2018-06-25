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
	require_once('permissions.php');

	//Display lesson
	if($pagerestrictions=="")
	{

		$Course_ID=htmlspecialchars($_GET["cid"], ENT_QUOTES);
		$Lesson_ID=htmlspecialchars($_GET["lid"], ENT_QUOTES);

		//Get Course Information
		include "../../core/abre_dbconnect.php";
		$sqllookup = "SELECT Title, Standards, Resources, Anticipatory, Objectives, DirectInstruction, GuidedPractice, IndependentPractice, FormativeAssessment, Closure FROM curriculum_lesson WHERE ID='$Lesson_ID'";
		$result2 = $db->query($sqllookup);
		$setting_preferences=mysqli_num_rows($result2);
		while($row = $result2->fetch_assoc())
		{

			$Title=htmlspecialchars($row["Title"], ENT_QUOTES);
			$Standards=$row["Standards"];
			$Resources=linkify(nl2br($row["Resources"]));
			$Anticipatory=nl2br($row["Anticipatory"]);
			$Objectives=nl2br($row["Objectives"]);
			$DirectInstruction=nl2br($row["DirectInstruction"]);
			$GuidedPractice=nl2br($row["GuidedPractice"]);
			$IndependentPractice=nl2br($row["IndependentPractice"]);
			$FormativeAssessment=nl2br($row["FormativeAssessment"]);
			$Closure=nl2br($row["Closure"]);

			echo "<div class='page_container page_container_limit lesson'>";

				echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Standards</h5>";
		            echo $Standards;
		        echo "</div><br>";

		        echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Resources & Materials</h5>";
		            echo "<p>$Resources</p>";
		        echo "</div><br>";

		        echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Anticipatory Set</h5>";
		            echo "<p>$Anticipatory</p>";
		        echo "</div><br>";

		        echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Learning Objectives/Goals</h5>";
		            echo "<p>$Objectives</p>";
		        echo "</div><br>";

		        echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Direct Instruction</h5>";
		            echo "<p>$DirectInstruction</p>";
		        echo "</div><br>";

		        echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Guided Practice</h5>";
		            echo "<p>$GuidedPractice</p>";
		        echo "</div><br>";

		        echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Independent Practice</h5>";
		            echo "<p>$IndependentPractice</p>";
		        echo "</div><br>";

		        echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Formative Assessment(s)</h5>";
		            echo "<p>$FormativeAssessment</p>";
		        echo "</div><br>";

		        echo "<div class='page_container page_container_limit mdl-color--white mdl-shadow--2dp' style='padding: 30px;'>";
		            echo "<h5 style='color:".getSiteColor().";'>Closure</h5>";
		            echo "<p>$Closure</p>";
		        echo "</div><br>";

			echo "</div>";

		}

		include "lesson_button.php";

	}

?>