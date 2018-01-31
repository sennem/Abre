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
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once('permissions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');

	if($pageaccess == 1){

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=licenseExpiring.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('Last Name', 'First Name', 'Middle Name', 'State Educator ID', 'License 1 Type', 'License 1 Expiration Date', 'License 2 Type', 'License 2 Expiration Date', 'License 3 Type', 'License 3 Expiration Date', 'License 4 Type', 'License 4 Expiration Date', 'License 5 Type', 'License 5 Expiration Date', 'License 6 Type', 'License 6 Expiration Date'));
		include "../../core/abre_dbconnect.php";
		$rows = mysqli_query($db, 'SELECT firstname, lastname, middlename, stateeducatorid, licensetype1, licenseexpirationdate1, licensetype2, licenseexpirationdate2, licensetype3, licenseexpirationdate3, licensetype4, licenseexpirationdate4, licensetype5, licenseexpirationdate5, licensetype6, licenseexpirationdate6 FROM directory WHERE archived = 0 ORDER BY lastname');

		while($row = mysqli_fetch_assoc($rows)){
			$firstname = htmlspecialchars($row["firstname"], ENT_QUOTES);
			$firstname = stripslashes($firstname);
			$lastname = htmlspecialchars($row["lastname"], ENT_QUOTES);
			$lastname = stripslashes($lastname);
			$middlename = htmlspecialchars($row["middlename"], ENT_QUOTES);
			$middlename = stripslashes($middlename);
			$stateeducatorid = htmlspecialchars($row["stateeducatorid"], ENT_QUOTES);
			$stateeducatorid = stripslashes(decrypt($stateeducatorid, ""));
			$l1_1 = htmlspecialchars($row["licensetype1"], ENT_QUOTES);
			$l1_1 = stripslashes(decrypt($l1_1, ""));
			$l1_3 = htmlspecialchars($row["licenseexpirationdate1"], ENT_QUOTES);
			$l1_3 = stripslashes(decrypt($l1_3, ""));
			$l2_1 = htmlspecialchars($row["licensetype2"], ENT_QUOTES);
			$l2_1 = stripslashes(decrypt($l2_1, ""));
			$l2_3 = htmlspecialchars($row["licenseexpirationdate2"], ENT_QUOTES);
			$l2_3 = stripslashes(decrypt($l2_3, ""));
			$l3_1 = htmlspecialchars($row["licensetype3"], ENT_QUOTES);
			$l3_1 = stripslashes(decrypt($l3_1, ""));
			$l3_3 = htmlspecialchars($row["licenseexpirationdate3"], ENT_QUOTES);
			$l3_3 = stripslashes(decrypt($l3_3, ""));
			$l4_1 = htmlspecialchars($row["licensetype4"], ENT_QUOTES);
			$l4_1 = stripslashes(decrypt($l4_1, ""));
			$l4_3 = htmlspecialchars($row["licenseexpirationdate4"], ENT_QUOTES);
			$l4_3 = stripslashes(decrypt($l4_3, ""));
			$l5_1 = htmlspecialchars($row["licensetype5"], ENT_QUOTES);
			$l5_1 = stripslashes(decrypt($l5_1, ""));
			$l5_3 = htmlspecialchars($row["licenseexpirationdate5"], ENT_QUOTES);
			$l5_3 = stripslashes(decrypt($l5_3, ""));
			$l6_1 = htmlspecialchars($row["licensetype6"], ENT_QUOTES);
			$l6_1 = stripslashes(decrypt($l6_1, ""));
			$l6_3 = htmlspecialchars($row["licenseexpirationdate6"], ENT_QUOTES);
			$l6_3 = stripslashes(decrypt($l6_3, ""));
			$data = [$lastname,$firstname,$middlename,$stateeducatorid,$l1_1,$l1_3,$l2_1,$l2_3,$l3_1,$l3_3,$l4_1,$l4_3,$l5_1,$l5_3,$l6_1,$l6_3];
			fputcsv($output, $data);
		}
		fclose($output);
		mysqli_close($db);
		exit();
	}
?>