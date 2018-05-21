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

	if(superadmin() && !isAppInstalled("Abre-Conduct")){

		//Check for conduct_colors table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM conduct_colors LIMIT 1")){
			$sql = "CREATE TABLE `conduct_colors` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `conduct_colors` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `conduct_colors` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for studentid field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT StudentID FROM conduct_colors LIMIT 1")){
			$sql = "ALTER TABLE `conduct_colors` ADD `StudentID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for color field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Color FROM conduct_colors LIMIT 1")){
			$sql = "ALTER TABLE `conduct_colors` ADD `Color` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for time field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT `Time` FROM conduct_colors LIMIT 1")){
			$sql = "ALTER TABLE `conduct_colors` ADD `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for course group field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT CourseGroup FROM conduct_colors LIMIT 1")){
			$sql = "ALTER TABLE `conduct_colors` ADD `CourseGroup` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for section field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Section FROM conduct_colors LIMIT 1")){
			$sql = "ALTER TABLE `conduct_colors` ADD `Section` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for staff id field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT StaffID FROM conduct_colors LIMIT 1")){
			$sql = "ALTER TABLE `conduct_colors` ADD `StaffID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for conduct_discipline table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM conduct_discipline LIMIT 1")){
			$sql = "CREATE TABLE `conduct_discipline` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `conduct_discipline` ADD PRIMARY KEY (`id`);";
			$sql .= "ALTER TABLE `conduct_discipline` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for submission time field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Submission_Time FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Submission_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for incident date field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Incident_Date FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Incident_Date` date DEFAULT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for incident time field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Incident_Time FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Incident_Time` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for owner field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Owner FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Owner` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for owner name  field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Owner_Name FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Owner_Name` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for building field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Building FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Building` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for school code field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT SchoolCode FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `SchoolCode` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for type field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Type FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Type` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for student id field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT StudentID FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `StudentID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for student iep field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Student_IEP FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Student_IEP` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for student first name field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Student_FirstName FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Student_FirstName` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for student middle name field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Student_MiddleName FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Student_MiddleName` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for student last name field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Student_LastName FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Student_LastName` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for offence field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Offence FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Offence` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for location field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Location FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Location` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for description field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Description FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Description` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for information field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Information FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Information` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for served field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Served FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Served` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for archived field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Archived FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Archived` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Offence_Codes Thru field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Offence_Codes FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Offence_Codes` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for SIS_Reported
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT SIS_Reported FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `SIS_Reported` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for DisciplineIncidentRefId
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT DisciplineIncidentRefId FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `DisciplineIncidentRefId` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Duplicate Incident ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT dupIncidentId FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `dupIncidentId` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Last_Modified field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Last_Modified FROM conduct_discipline LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline` ADD `Last_Modified` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for conduct_offences table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM conduct_offences LIMIT 1")){
			$sql = "CREATE TABLE `conduct_offences` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `conduct_offences` ADD PRIMARY KEY (`id`);";
			$sql .= "ALTER TABLE `conduct_offences` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for offence field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Offence FROM conduct_offences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_offences` ADD `Offence` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for code number field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT ViolationNumber FROM conduct_offences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_offences` ADD `ViolationNumber` DOUBLE NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for priority field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Priority FROM conduct_offences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_offences` ADD `Priority` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for conduct_consquences table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM conduct_consequences LIMIT 1")){
			$sql = "CREATE TABLE `conduct_consequences` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `conduct_consequences` ADD PRIMARY KEY (`id`);";
			$sql .= "ALTER TABLE `conduct_consequences` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for consequence field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Consequence FROM conduct_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_consequences` ADD `Consequence` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for reportable field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Reportable FROM conduct_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_consequences` ADD `Reportable` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for conduct_colors table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM conduct_discipline_consequences LIMIT 1")){
			$sql = "CREATE TABLE `conduct_discipline_consequences` (`Consequence_ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `conduct_discipline_consequences` ADD PRIMARY KEY (`Consequence_ID`);";
			$sql .= "ALTER TABLE `conduct_discipline_consequences` MODIFY `Consequence_ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Incident ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Incident_ID FROM conduct_discipline_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline_consequences` ADD `Incident_ID` int(11) NOT NULL;";
			$sql .= "ALTER TABLE `conduct_discipline_consequences` ADD FOREIGN KEY (`Incident_ID`) REFERENCES conduct_discipline(`ID`);";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for consquence_name field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Consequence_Name FROM conduct_discipline_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline_consequences` ADD `Consequence_Name` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Serve_Date Serve field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Serve_Date FROM conduct_discipline_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline_consequences` ADD `Serve_Date` date DEFAULT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Thru_Date Thru field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Thru_Date FROM conduct_discipline_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline_consequences` ADD `Thru_Date` date DEFAULT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Total_Days Thru field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Total_Days FROM conduct_discipline_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline_consequences` ADD `Total_Days` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for served field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Consequence_Served FROM conduct_discipline_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline_consequences` ADD `Consequence_Served` int(11) NOT NULL DEFAULT '0';";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Last_Modified field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Last_Modified FROM conduct_discipline_consequences LIMIT 1")){
			$sql = "ALTER TABLE `conduct_discipline_consequences` ADD `Last_Modified` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for conduct_log table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM conduct_log LIMIT 1")){
			$sql = "CREATE TABLE `conduct_log` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `conduct_log` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `conduct_log` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for submission time field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Submission_Time FROM conduct_log LIMIT 1")){
			$sql = "ALTER TABLE `conduct_log` ADD `Submission_Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Incident_ID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Incident_ID FROM conduct_log LIMIT 1")){
			$sql = "ALTER TABLE `conduct_log` ADD `Incident_ID` int(11) NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for User field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT User FROM conduct_log LIMIT 1")){
			$sql = "ALTER TABLE `conduct_log` ADD `User` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for Action field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Action FROM conduct_log LIMIT 1")){
			$sql = "ALTER TABLE `conduct_log` ADD `Action` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for User field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT Details FROM conduct_log LIMIT 1")){
			$sql = "ALTER TABLE `conduct_log` ADD `Details` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for conduct_settings table
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT * FROM conduct_settings LIMIT 1")){
			$sql = "CREATE TABLE `conduct_settings` (`ID` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
			$sql .= "ALTER TABLE `conduct_settings` ADD PRIMARY KEY (`ID`);";
			$sql .= "ALTER TABLE `conduct_settings` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for districtID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT districtID FROM conduct_settings LIMIT 1")){
			$sql = "ALTER TABLE `conduct_settings` ADD `districtID` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Check for districtID field
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		if(!$db->query("SELECT pdf_options FROM conduct_settings LIMIT 1")){
			$sql = "ALTER TABLE `conduct_settings` ADD `pdf_options` text NOT NULL;";
			$db->multi_query($sql);
		}
		$db->close();

		//Mark app as installed
		require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
		$sql = "UPDATE apps_abre SET installed = 1 WHERE app = 'Abre-Conduct'";
		$db->multi_query($sql);
		$db->close();
	}
?>