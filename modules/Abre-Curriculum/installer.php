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

	if(superadmin() && !isAppInstalled("Abre-Curriculum"))
	{
		//Check for curriculum_course table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM curriculum_course LIMIT 1"))
		{
			$sql = "CREATE TABLE `curriculum_course` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `curriculum_course` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `curriculum_course` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Hidden field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Hidden FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Hidden` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Title field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Title FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Title` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Description field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Description FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Description` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Level field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Level FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Level` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Subject field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Subject FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Subject` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Grade field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Grade FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Grade` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Image field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Image FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Image` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Editors field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Editors FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Editors` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Learn_Course field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Learn_Course FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Learn_Course` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Restrictions field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Restrictions FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Restrictions` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Tags field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Tags FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Tags` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Learn_Course field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Sequential FROM curriculum_course LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_course` ADD `Sequential` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for curriculum_lesson table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "CREATE TABLE `curriculum_lesson` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `curriculum_lesson` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `curriculum_lesson` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for TopicID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT TopicID FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `TopicID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Title field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Title FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Title` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Number field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Number FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Number` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Body field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Body FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Body` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Standards_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Standards_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Standards_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Standards field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Standards FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Standards` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Resources_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Resources_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Resources_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Resources field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Resources FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Resources` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Anticipatory_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Anticipatory_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Anticipatory_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Anticipatory field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Anticipatory FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Anticipatory` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Objectives_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Objectives_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Objectives_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Objectives field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Objectives FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Objectives` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for DirectInstruction_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT DirectInstruction_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `DirectInstruction_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for DirectInstruction field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT DirectInstruction FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `DirectInstruction` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for GuidedPractice_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT GuidedPractice_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `GuidedPractice_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for GuidedPractice field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT GuidedPractice FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `GuidedPractice` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for IndependentPractice_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT IndependentPractice_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `IndependentPractice_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for IndependentPractice field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT IndependentPractice FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `IndependentPractice` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for FormativeAssessment_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT FormativeAssessment_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `FormativeAssessment_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for FormativeAssessment field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT FormativeAssessment FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `FormativeAssessment` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Closure_WYSIWYG field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Closure_WYSIWYG FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Closure_WYSIWYG` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Closure field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Closure FROM curriculum_lesson LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_lesson` ADD `Closure` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for curriculum_libraries table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM curriculum_libraries LIMIT 1"))
		{
			$sql = "CREATE TABLE `curriculum_libraries` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `curriculum_libraries` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `curriculum_libraries` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for User_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT User_ID FROM curriculum_libraries LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_libraries` ADD `User_ID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Course_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Course_ID FROM curriculum_libraries LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_libraries` ADD `Course_ID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for curriculum_libraries table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM curriculum_resources LIMIT 1"))
		{
			$sql = "CREATE TABLE `curriculum_resources` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `curriculum_resources` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `curriculum_resources` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for TopicID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT TopicID FROM curriculum_resources LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_resources` ADD `TopicID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Type field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Type FROM curriculum_resources LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_resources` ADD `Type` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Title field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Title FROM curriculum_resources LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_resources` ADD `Title` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Link field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Link FROM curriculum_resources LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_resources` ADD `Link` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Text field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Text FROM curriculum_resources LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_resources` ADD `Text` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for curriculum_libraries table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM curriculum_standards LIMIT 1"))
		{
			$sql = "CREATE TABLE `curriculum_standards` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `curriculum_standards` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `curriculum_standards` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Subject field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Subject FROM curriculum_standards LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_standards` ADD `Subject` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Standard_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Standard_ID FROM curriculum_standards LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_standards` ADD `Standard_ID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Category field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Category FROM curriculum_standards LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_standards` ADD `Category` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Sub_Category field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Sub_Category FROM curriculum_standards LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_standards` ADD `Sub_Category` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for State_Standard field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT State_Standard FROM curriculum_standards LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_standards` ADD `State_Standard` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for curriculum_unit table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM curriculum_unit LIMIT 1"))
		{
			$sql = "CREATE TABLE `curriculum_unit` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `curriculum_unit` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `curriculum_unit` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Course_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Course_ID FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Course_ID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Title field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Title FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Title` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Start_Time field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Start_Time FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Start_Time` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Start_Time_Month field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Start_Time_Month FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Start_Time_Month` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Start_Time_Day field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Start_Time_Day FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Start_Time_Day` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Length field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Length FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Length` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Description field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Description FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Description` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Standards field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Standards FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Standards` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Resources field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Resources FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Resources` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Assessments field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Assessments FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Assessments` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Lessons field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Lessons FROM curriculum_unit LIMIT 1"))
		{
			$sql = "ALTER TABLE `curriculum_unit` ADD `Lessons` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		if(!file_exists($portal_path_root . "/../$portal_private_root/Abre-Curriculum/")){
			if(mkdir($portal_path_root . "/../$portal_private_root/Abre-Curriculum/", 0775)){
				mkdir($portal_path_root . "/../$portal_private_root/Abre-Curriculum/images", 0775);
			}
		}

		//Mark app as installed
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "UPDATE apps_abre SET installed = 1 WHERE app = 'Abre-Curriculum'";
		$db->multi_query($sql);
		$db->close();

	}

?>
