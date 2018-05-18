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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('functions.php');
	require_once('permissions.php');

	if($pagerestrictions == "" || $isParent)
	{

		//Office Referrals
		echo "<h4>Office Referrals</h4>";
		$query = "SELECT ID, Incident_Date, Offence FROM conduct_discipline WHERE StudentID='$Student_ID' AND Type='Office' AND Archived!='1' ORDER BY Submission_Time DESC";
		$dbreturn = databasequery($query);
		$returncountoffice = count($dbreturn);
		$count=0;
		foreach ($dbreturn as $value)
		{
			$count++;

			if($count==1)
			{
				echo "<table class='bordered'>";
				echo "<thead>";
					echo "<tr>";
						echo "<th>Incident Date</th>";
						echo "<th>Offense</th>";
						echo "<th></th>";
					echo "</tr>";
				echo "</thead>";
				echo "<tbody>";
			}

			$ConductID=htmlspecialchars($value['ID'], ENT_QUOTES);
			$MisconductIncidentDate=htmlspecialchars($value['Incident_Date'], ENT_QUOTES);
			$OffenseTypeDescription=htmlspecialchars($value['Offence'], ENT_QUOTES);
			$Offence_Display = str_replace(array("'", "\"", "&quot;"), "", $OffenseTypeDescription);

			echo "<tr>";
				echo "<td>$MisconductIncidentDate</td>";
				echo "<td>$Offence_Display</td>";
				if($pagerestrictions == ""){
					echo "<td style='text-align:right'><a class='modal-conductlook waves-effect btn-flat white-text' href='#conductlook' data-conductid='$ConductID' style='background-color:"; echo getSiteColor(); echo "'>Details</a></td>";
				}else{
					echo "<td></td>";
				}
			echo "</tr>";

			if($count==$returncountoffice)
			{
				echo "</tbody></table>";

				if($pagerestrictions == ""){
					echo "<div class='row'><a class='waves-effect btn-flat white-text' href='/modules/Abre-Students/conduct_download.php?StudentID=$Student_ID' style='background-color:"; echo getSiteColor(); echo "'>Download Report</a></div>";
				}
			}


		}
		if($returncountoffice==0){ echo "<div class='row'><h6>No reported office referrals</h6></div>"; }

		//Personal Referrals
		if(AdminCheck($_SESSION['useremail']) or admin()){
			echo "<h4>Documentation Reports</h4>";
			$query = "SELECT ID, Owner_Name, Incident_Date, Offence FROM conduct_discipline WHERE StudentID='$Student_ID' AND Type='Personal' AND Archived!='1' ORDER BY Submission_Time DESC";
			$dbreturn = databasequery($query);
			$returncountpersonal = count($dbreturn);
			$count=0;
			foreach ($dbreturn as $value)
			{
				$count++;

				if($count==1)
				{
					echo "<table class='bordered'>";
					echo "<thead>";
						echo "<tr>";
							echo "<th>Incident Date</th>";
							echo "<th>Owner</th>";
							echo "<th>Offense</th>";
							echo "<th></th>";
						echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
				}

				$ConductID=htmlspecialchars($value['ID'], ENT_QUOTES);
				$Owner_Name=htmlspecialchars($value['Owner_Name'], ENT_QUOTES);
				$MisconductIncidentDate=htmlspecialchars($value['Incident_Date'], ENT_QUOTES);
				$OffenseTypeDescription=htmlspecialchars($value['Offence'], ENT_QUOTES);
				$Offence_Display = str_replace(array("'", "\"", "&quot;"), "", $OffenseTypeDescription);

				echo "<tr>";
					echo "<td>$MisconductIncidentDate</td>";
					echo "<td>$Owner_Name</td>";
					echo "<td>$Offence_Display</td>";
					if($pagerestrictions == ""){
						echo "<td style='text-align:right'><a class='modal-conductlook waves-effect btn-flat white-text' href='#conductlook' data-conductid='$ConductID' style='background-color:"; echo getSiteColor(); echo "'>Details</a></td>";
					}else{
						echo "<td></td>";
					}
				echo "</tr>";

				if($count==$returncountpersonal)
				{
					echo "</tbody></table>";

				}


			}
			if($returncountpersonal==0){ echo "<div class='row'><h6>No documentation reports</h6></div>"; }
		}

	}

?>

<script>

	$(function()
	{

		$(".modal-conductlook").unbind().click(function(event)
		{
			event.preventDefault();
			var ConductID = $(this).data('conductid');

	    	$('#conductlook').openModal({
		    	in_duration: 0,
				out_duration: 0,
		    	ready: function()
		    	{
			    	$("#conductdetailsloader").show();
			    	$("#conductdetails").html('');
			    	$("#conductdetails").load('modules/<?php echo basename(__DIR__); ?>/conductdetails.php?ConductID='+ConductID, function(){ $("#conductdetailsloader").hide(); mdlregister(); });

				},
		   	});

		});

	});

</script>
