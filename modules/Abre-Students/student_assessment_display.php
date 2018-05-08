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
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions=="" || $isParent)
	{

		$AIRFound = 0;
		$ACTFound = 0;
		$APFound = 0;

		//AIR Data
		$query = "SELECT AssessmentArea, TestDate, Accommodations, ScaledScore, PerformanceLevel FROM (SELECT * FROM Abre_StudentAssessments WHERE StudentID = '$Student_ID' AND PerformanceLevel REGEXP '^[0-9]+$' ORDER BY PerformanceLevel DESC) AS sub GROUP BY AssessmentArea";
		$dbreturn = databasequery($query);
		$dbreturncount = count($dbreturn);
		$AirCount=0;
		foreach ($dbreturn as $value)
		{
			$AirCount++;
			$AIRFound=1;
			if($AirCount==1){
				echo "<div class='row'>";
					echo "<div style='float:left; width:50%;'><h4 style='margin:0;'>AIR</h4></div>";
					echo "<div class='right-align' style='float:left; width:50%;'><a class='modal-assessmentlook assessmentdetailsbutton waves-effect btn-flat white-text' data-studentid='$Student_ID' data-assessment='air' href='#assessmentlook' style='background-color:"; echo getSiteColor(); echo "'>AIR Subscores</a></div>";
				echo "</div>";
			}
			$AssessmentArea=htmlspecialchars($value['AssessmentArea'], ENT_QUOTES);

			//Administration Date
			$TestDate=htmlspecialchars($value['TestDate'], ENT_QUOTES);
			if (strpos($TestDate, '07/01') !== false){  $TestDateVerbaige = substr($TestDate, 0, 4); $TestDateVerbaige="Summer $TestDateVerbaige"; }
			if (strpos($TestDate, '04/01') !== false){  $TestDateVerbaige = substr($TestDate, 0, 4); $TestDateVerbaige="Spring $TestDateVerbaige"; }
			if (strpos($TestDate, '11/01') !== false){  $TestDateVerbaige = substr($TestDate, 0, 4); $TestDateVerbaige="Fall $TestDateVerbaige"; }
			if (strpos($TestDate, '12/01') !== false){  $TestDateVerbaige = substr($TestDate, 0, 4); $TestDateVerbaige="Fall $TestDateVerbaige"; }

			$aircolor="";
			$Accommodations=htmlspecialchars($value['Accommodations'], ENT_QUOTES);
			$ScaledScore=htmlspecialchars($value['ScaledScore'], ENT_QUOTES);
			$ScaledScore=round($ScaledScore);
			$PerformanceLevel=htmlspecialchars($value['PerformanceLevel'], ENT_QUOTES);
			if($PerformanceLevel==" "){ $PerformanceLevel="0"; }
			if($PerformanceLevel!="1"){ $PerformanceLevelText="$PerformanceLevel Points"; }else{ $PerformanceLevelText="$PerformanceLevel Point"; }
			$AIRBarPercentage=($PerformanceLevel/5)*100;
			if($PerformanceLevel=="1" or $PerformanceLevel=="2"){ $aircolor="#F44336"; }
			if($PerformanceLevel=="3"){ $aircolor="#FFC107"; }
			if($PerformanceLevel=="4" or $PerformanceLevel=="5"){ $aircolor="#4CAF50"; }

			echo "<div class='row' style='margin:5px 0 5px 0;'>";
				echo "<div style='float:left; width:50%;'><b>$AssessmentArea / $TestDateVerbaige</b></div><div class='right-align' style='float:left; width:50%;'><b>$ScaledScore / $PerformanceLevelText</b></div>";
				echo "<div class='progress' style='padding:8px 0 8px 0;'><div class='determinate' style='width: $AIRBarPercentage%; background-color:$aircolor !important;'></div></div>";
			echo "</div>";
		}

		if($AIRFound != 0) { echo "<hr><br>"; }

		//ACT Data
		$query = "SELECT CategoryName, TestingDate, Score  FROM Abre_StudentACT WHERE StudentID = '$Student_ID' AND CategoryName='Composite Score' ORDER BY Score DESC";
		$dbreturn = databasequery($query);
		$dbreturncount = count($dbreturn);
		$ACTCount=0;
		foreach ($dbreturn as $value)
		{
			$ACTCount++;
			$ACTFound=1;
			if($ACTCount==1)
			{
				echo "<div class='row'>";
					echo "<div style='float:left; width:50%;'><h4 style='margin:0;'>ACT</h4></div>";
					echo "<div class='right-align' style='float:left; width:50%;'><a class='modal-assessmentlook assessmentdetailsbutton waves-effect btn-flat white-text' data-studentid='$Student_ID' data-assessment='act' href='#assessmentlook' style='background-color:"; echo getSiteColor(); echo "'>ACT Subscores</a></div>";
				echo "</div>";
			}
			$CategoryName=htmlspecialchars($value['CategoryName'], ENT_QUOTES);
			$TestingDate=htmlspecialchars($value['TestingDate'], ENT_QUOTES);
			$Score=htmlspecialchars($value['Score'], ENT_QUOTES);
			$TestingDate=str_replace(" 00:00:00","",$TestingDate);
			$ACTcolor="";
			$CategoryNameSubArea=htmlspecialchars($value['CategoryName'], ENT_QUOTES);
			$ScoreSubArea=htmlspecialchars($value['Score'], ENT_QUOTES);
			$ScoreSubArea = ltrim($ScoreSubArea, '0');
			if($ScoreSubArea==""){ $ScoreSubArea="0"; }
			if($ScoreSubArea!="1"){ $ScoreSubAreaLevelText="$ScoreSubArea Points"; }else{ $ScoreSubAreaLevelText="$ScoreSubArea Point"; }
			$ACTBarPercentage=($ScoreSubArea/36)*100;
			if($ScoreSubArea<"12"){ $ACTcolor="#F44336"; }
			if($ScoreSubArea>="12" && $ScoreSubArea<="24"){ $ACTcolor="#FFC107"; }
			if($ScoreSubArea>"24"){ $ACTcolor="#4CAF50"; }

			echo "<div class='row' style='margin:5px 0 5px 0;'>";
				echo "<div style='float:left; width:50%;'><b>$CategoryNameSubArea / $TestingDate</b></div><div class='right-align' style='float:left; width:50%;'><b>$ScoreSubAreaLevelText</b></div>";
				echo "<div class='progress' style='padding:8px 0 8px 0;'><div class='determinate' style='width: $ACTBarPercentage%; background-color:$ACTcolor !important;'></div></div>";
			echo "</div>";

		}

		if($ACTFound != 0){ echo "<hr><br>"; }

		//AP Data
		$query = "SELECT APExamSubject, TestingDate, Score FROM Abre_StudentAP WHERE StudentID = '$Student_ID' ORDER BY APExamSubject";
		$dbreturn = databasequery($query);
		$dbreturncount = count($dbreturn);
		$APCount=0;
		foreach ($dbreturn as $value)
		{
			$APCount++;
			$APcolor="";
			$APFound=1;
			if($APCount==1)
			{
				echo "<div class='row'><h4 style='margin:0;'>AP</h4></div>";
			}
			$APExamSubject=htmlspecialchars($value['APExamSubject'], ENT_QUOTES);
			$TestingDate=htmlspecialchars($value['TestingDate'], ENT_QUOTES);
			$APScore=htmlspecialchars($value['Score'], ENT_QUOTES);
			if($APScore==" "){ $APScore="0"; }
			if($APScore!="1"){ $APScoreText="$APScore Points"; }else{ $APScoreText="$APScore Point"; }
			$APBarPercentage=($APScore/5)*100;
			if($APScore=="0" or $APScore=="1" or $APScore=="2"){ $APcolor="#F44336"; }
			if($APScore=="3"){ $aircolor="#FFC107"; }
			if($APScore=="4" or $APScore=="5"){ $APcolor="#4CAF50"; }

			echo "<div class='row' style='margin:5px 0 5px 0;'>";
				echo "<div style='float:left; width:50%;'><b>$APExamSubject / $TestingDate</b></div><div class='right-align' style='float:left; width:50%;'><b>$APScoreText</b></div>";
				echo "<div class='progress' style='padding:8px 0 8px 0;'><div class='determinate' style='width: $APBarPercentage%; background-color:$APcolor !important;'></div></div>";
			echo "</div>";

		}

		if($APFound != 0){ echo "<hr><br>"; }

		$query = "SELECT TermName FROM Abre_MAPData WHERE StudentID = '$Student_ID'";
		$dbreturn = databasequery($query);
		$MAPFound = 0;
		$MAPCount = 0;
		$lastTermFound = "";
		if(count($dbreturn) > 0){
			foreach ($dbreturn as $value){
				$MAPFound = 1;
				$MAPCount++;
				if($MAPCount == 1){
					echo "<div class='row'><h4 style='margin:0;'>MAP</h4></div><div class='row'>";
				}
				$TermName = $value["TermName"];
				if($TermName != $lastTermFound){
					echo "<div style='float:left; padding-right: 5px; padding-bottom: 5px;'><a class='modal-assessmentlook assessmentdetailsbutton waves-effect btn-flat white-text' data-studentid='$Student_ID' data-term='$TermName' data-assessment='map' href='#assessmentlook' style='background-color:"; echo getSiteColor(); echo "'>$TermName</a></div>";
					$lastTermFound = $TermName;
				}
			}
			if($MAPFound == 1){
				echo "</div>";
			}
		}else{
			$query = "SELECT SSID FROM Abre_Students WHERE StudentId = '$Student_ID'";
			$sql = $db->query($query);
			$row = $sql->fetch_assoc();
			$ssid = $row["SSID"];

			$query = "SELECT TermName FROM Abre_MAPData WHERE StudentID = '$ssid'";
			$dbreturn = databasequery($query);
			$MAPFound = 0;
			$MAPCount = 0;
			$lastTermFound = "";
			foreach ($dbreturn as $value){
				$MAPFound = 1;
				$MAPCount++;
				if($MAPCount == 1){
					echo "<div class='row'><h4 style='margin:0;'>MAP</h4></div><div class='row'>";
				}
				$TermName = $value["TermName"];
				if($TermName != $lastTermFound){
					echo "<div style='float:left; padding-right: 5px; padding-bottom: 5px;'><a class='modal-assessmentlook assessmentdetailsbutton waves-effect btn-flat white-text' data-studentid='$ssid' data-term='$TermName' data-assessment='map' href='#assessmentlook' style='background-color:"; echo getSiteColor(); echo "'>$TermName</a></div>";
					$lastTermFound = $TermName;
				}
			}
			if($MAPFound == 1){
				echo "</div>";
			}
		}

		if($APFound == 0 && $ACTFound == 0 && $AIRFound == 0 && $MAPFound == 0){ echo "<div class='row center-align'><div class='col s12'><h6>No testing data found</h6></div></div>"; }

	}

?>

<script>

	$(function()
	{

	   	//Assessment Details Button
	   	$(".assessmentdetailsbutton").unbind().click(function(event){

		   	event.preventDefault();

		   	var StudentID = $(this).data('studentid');
				var Assessment = $(this).data('assessment');
				var termName = encodeURIComponent($(this).data('term'));


	   		$('#assessmentlook').openModal({ in_duration: 0, out_duration: 0,
		   		ready: function(){

			    	$("#assessmentdetailsloader").show();
			    	$("#assessmentdetails").html('');

			    	if(Assessment === "air"){
			    		$("#assessmentdetails").load('modules/<?php echo basename(__DIR__); ?>/assessmentdetails.php?StudentID='+StudentID, function(){ $("#assessmentdetailsloader").hide(); mdlregister(); });
			    	}
			    	if(Assessment === "act"){
			    		$("#assessmentdetails").load('modules/<?php echo basename(__DIR__); ?>/assessmentdetails_act.php?StudentID='+StudentID, function(){ $("#assessmentdetailsloader").hide(); mdlregister(); });
			    	}
						if(Assessment == "map"){
							$("#assessmentdetails").load('modules/<?php echo basename(__DIR__); ?>/assessmentdetails_map.php?StudentID='+StudentID+'&termName='+termName, function(){
								$("#assessmentdetailsloader").hide();
								mdlregister();
								$(document).ready(function(){
									$('ul.tabs').tabs();
								});
							});
						}

		   		}
		   	});
		});


	});

</script>