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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('../../core/abre_functions.php');

	if($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator())
	{

		if(isset($_POST["formid"])){ $id=$_POST["formid"]; }

		//get the current page the user is on
		if(isset($_POST["page"])){
			if($_POST["page"] == ""){
				$PageNumber = 1;
			}else{
				$PageNumber = $_POST["page"];
			}
		}else{
			$PageNumber = 1;
		}

		$PerPage = 10;

		//set bounds for pagination
		$LowerBound = $PerPage * ($PageNumber - 1);
		$UpperBound = $PerPage * $PageNumber;

		if(isset($_POST["searchquery"])){
			$searchquery = strtolower(mysqli_real_escape_string($db, $_POST["searchquery"]));
		}else{
			$searchquery = "";
		}

		if($searchquery == ""){
			$querycount = "SELECT COUNT(*) FROM forms_responses WHERE FormID='$id'";
			$sql = "SELECT ID, Submitter, FirstName, LastName, SubmissionTime FROM forms_responses WHERE FormID='$id' ORDER BY SubmissionTime DESC LIMIT $LowerBound, $PerPage";
		}else{
			$querycount = "SELECT COUNT(*) FROM forms_responses WHERE FormID='$id' AND (LOWER(Submitter) LIKE '%$searchquery%' OR LOWER(FirstName) LIKE '%$searchquery%' OR LOWER(LastName) LIKE '%$searchquery%')";
			$sql = "SELECT ID, Submitter, FirstName, LastName, SubmissionTime FROM forms_responses WHERE FormID='$id' AND (LOWER(Submitter) LIKE '%$searchquery%' OR LOWER(FirstName) LIKE '%$searchquery%' OR LOWER(LastName) LIKE '%$searchquery%') ORDER BY SubmissionTime DESC LIMIT $LowerBound, $PerPage";
		}

		$result = $db->query($sql);
		$totalformscount=mysqli_num_rows($result);
		$formscounter=0;
		while($row = $result->fetch_assoc()){

			$formscounter++;

			if($formscounter == 1){
			?>
				<div class='page_container mdl-shadow--4dp'>
				<div class='page'>
				<div class='row'>
				<div class='col s12'>

				<table id='myTable' class='highlight'>
				<thead>
				<tr>
				<th class='hide-on-med-and-down'></th>
				<th>Name</th>
				<th class='hide-on-med-and-down'>Submission Time</th>
				<th class='hide-on-med-and-down'>Email</th>
				<th style='width:30px'></th>
				</tr>
				</thead>
				<tbody>
			<?php
			}

			$ResponseID = htmlspecialchars($row["ID"], ENT_QUOTES);
			$Submitter = htmlspecialchars($row["Submitter"], ENT_QUOTES);
			$FirstName = htmlspecialchars($row["FirstName"], ENT_QUOTES);
			$LastName = htmlspecialchars($row["LastName"], ENT_QUOTES);
			$SubmissionTime = htmlspecialchars($row["SubmissionTime"], ENT_QUOTES);
			if(strtotime($SubmissionTime) < strtotime('-7 days')){
				$SubmissionTime = date( "F j", strtotime($SubmissionTime))." at ".date( "g:i A", strtotime($SubmissionTime));
			}else{
				$SubmissionTime = date( "l", strtotime($SubmissionTime))." at ".date( "g:i A", strtotime($SubmissionTime));
			}
			$firstCharacter = $Submitter[0];
			$firstCharacter = strtoupper($firstCharacter);

			if($FirstName!='' && $LastName!=''){ $title="$FirstName $LastName"; }else{ $title="$Submitter"; }

			echo "<tr class='formsrow pointer'>";

					echo "<td width='70px' class='hide-on-med-and-down exploreform' data-href='#forms/responses/entry/$id/$ResponseID'>";
						echo "<div style='padding:8px; text-align:center; background-color:"; echo getSiteColor(); echo "; color:#fff; width:36px; height:36px; border-radius: 18px;'>$firstCharacter</div>";
					echo "</td>";
					echo "<td class='viewentry' data-formid='$id' data-entryid='$ResponseID' data-title='$title'>$FirstName $LastName</td>";
					echo "<td class='viewentry hide-on-med-and-down' data-formid='$id' data-entryid='$ResponseID' data-title='$title'>$SubmissionTime</td>";
					echo "<td class='viewentry hide-on-med-and-down' data-formid='$id' data-entryid='$ResponseID' data-title='$title'>$Submitter</td>";
					echo "<td style='width:30px;'>";

						echo "<div class='morebutton' style='position:relative;'>";
							echo "<button id='demo-menu-bottom-left-$ResponseID' class='mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--grey-600'><i class='material-icons'>more_vert</i></button>";
							echo "<ul class='mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect' for='demo-menu-bottom-left-$ResponseID'>";

								echo "<li class='mdl-menu__item deleteentry' data-formresponseid='$ResponseID' data-formid='$id'>Delete</li>";

							echo "</ul>";
						echo "</div>";

				echo "</td>";
			echo "</tr>";
		}

		if($totalformscount == $formscounter && $formscounter > 0){

			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			echo "</div>";

			//getting count for pagination
			$result = $db->query($querycount);
			$dbreturnpossible = $result->fetch_assoc();
			$totalpossibleresults = $dbreturnpossible["COUNT(*)"];

			//Paging
			$totalpages = ceil($totalpossibleresults / $PerPage);
			if($totalpossibleresults > $PerPage){
				$previouspage = $PageNumber-1;
				$nextpage = $PageNumber+1;
				if($PageNumber > 5){
					if($totalpages > $PageNumber + 5){
						$pagingstart = $PageNumber - 5;
						$pagingend = $PageNumber + 5;
					}else{
						$pagingstart = $PageNumber - 5;
						$pagingend = $totalpages;
					}
				}else{
					if($totalpages >= 10){ $pagingstart = 1; $pagingend = 10; }else{ $pagingstart = 1; $pagingend = $totalpages; }
				}

				echo "<div class='row'><br>";
					echo "<ul class='pagination center-align'>";
						if($PageNumber != 1){ echo "<li class='pagebutton' data-page='$previouspage' data-formid='$id'><a href='#'><i class='material-icons'>chevron_left</i></a></li>"; }
						for($x = $pagingstart; $x <= $pagingend; $x++){
							if($PageNumber == $x){
								echo "<li class='active pagebutton' style='background-color: ".getSiteColor().";' data-page='$x' data-formid='$id'><a href='#'>$x</a></li>";
							}else{
								echo "<li class='waves-effect pagebutton' data-page='$x' data-formid='$id'><a href='#'>$x</a></li>";
							}
						}
						if($PageNumber != $totalpages){ echo "<li class='waves-effect pagebutton' data-page='$nextpage' data-formid='$id'><a href='#'><i class='material-icons'>chevron_right</i></a></li>"; }
					echo "</ul>";
				echo "</div>";
			}
			echo "</div>";
			echo "</div>";

			include 'button_resultsexport.php';
		}

		if($totalformscount == 0){
			echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Responses Found</span></div>";
		}

	}

?>
