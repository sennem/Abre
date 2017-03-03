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
	
	//Required configuration files
	require(dirname(__FILE__) . '/../../configuration.php');
	require_once(dirname(__FILE__) . '/../../core/abre_verification.php');
	require_once('permissions.php');
	
	//Display Search Results
	if($pageaccess==1 or $_SESSION['usertype']=="staff")
	{
		
		require_once('../../core/abre_functions.php');
		
		echo "<div class='row'><div class='col s12'>";
		
		include "../../core/abre_dbconnect.php";
		$searchquery=mysqli_real_escape_string($db, $_POST["searchquery"]);
		if($searchquery!=""){ $searchqueryuppercase=encrypt(ucwords($searchquery), ""); $searchquerylowercase=encrypt(strtolower($searchquery), ""); }
		
		if($searchquery=="")
		{
			$sql = "SELECT *  FROM directory where archived=0 order by firstname";
		}
		else
		{
			$sql = "SELECT *  FROM directory where (lastname='$searchqueryuppercase' or firstname='$searchqueryuppercase' or email='$searchqueryuppercase' or location='$searchqueryuppercase' or classification='$searchqueryuppercase' or lastname='$searchquerylowercase' or firstname='$searchquerylowercase' or email='$searchquerylowercase' or location='$searchquerylowercase' or classification='$searchquerylowercase') and archived=0 order by firstname";
		}
		$result = $db->query($sql);
		$resultcount=0;
		while($row = $result->fetch_assoc())
		{		
			$resultcount++;
		}
		
		if($resultcount>=1)
		{
			if($resultcount==1){ echo "<h4>$resultcount Employee Found</h4>"; }else{ echo "<h4>$resultcount Employees Found</h4>"; }
			
			echo "<table id='myTable' class='tablesorter'>";
			echo "<thead>";
		    echo "<tr class='pointer'>";
				echo "<th></th>";
				echo "<th>Name</th>";
				echo "<th class='hide-on-small-only'>Email</th>";
				echo "<th class='hide-on-small-only'>Building</th>";
				echo "<th class='hide-on-med-and-down'>Title</th>";
		    echo "</tr>";
		    echo "</thead>";
			echo "<tbody>";
		}
	
	
		include "../../core/abre_dbconnect.php";
		if($searchquery=="")
		{
			$sql = "SELECT *  FROM directory where archived=0 order by firstname";
		}
		else
		{
			$sql = "SELECT *  FROM directory where (lastname='$searchqueryuppercase' or firstname='$searchqueryuppercase' or email='$searchqueryuppercase' or location='$searchqueryuppercase' or classification='$searchqueryuppercase' or lastname='$searchquerylowercase' or firstname='$searchquerylowercase' or email='$searchquerylowercase' or location='$searchquerylowercase' or classification='$searchquerylowercase') and archived=0 order by firstname";

		}
		$result = $db->query($sql);
		$resultcount=0;
		while($row = $result->fetch_assoc())
		{
			$resultcount=1;
			$firstname=htmlspecialchars($row["firstname"], ENT_QUOTES);
			$firstname=stripslashes(htmlspecialchars(decrypt($firstname, ""), ENT_QUOTES));
			$lastname=htmlspecialchars($row["lastname"], ENT_QUOTES);
			$lastname=stripslashes(htmlspecialchars(decrypt($lastname, ""), ENT_QUOTES));
			$location=htmlspecialchars($row["location"], ENT_QUOTES);
			$location=stripslashes(htmlspecialchars(decrypt($location, ""), ENT_QUOTES));
			$email=htmlspecialchars($row["email"], ENT_QUOTES);
			$email=stripslashes(htmlspecialchars(decrypt($email, ""), ENT_QUOTES));
			$title=htmlspecialchars($row["title"], ENT_QUOTES);
			$title=stripslashes(htmlspecialchars(decrypt($title, ""), ENT_QUOTES));
			$picture=htmlspecialchars($row["picture"], ENT_QUOTES);
			if($picture==""){ 
				$picture=$portal_root."/modules/directory/images/user.png";
			}
			else
			{
				$picture=$portal_root."/modules/directory/serveimage.php?file=$picture";
			}
			$id=htmlspecialchars($row["id"], ENT_QUOTES);
			if($pageaccess==1  or $pageaccess==2){ echo "<tr class='clickrow'>"; }else{ echo "<tr class='clickrowemail'>"; }
				echo "<td width='60px'><img src='$picture' class='profile-avatar-small demoimage'></td>";
				echo "<td><strong class='demotext_dark'>$firstname $lastname</strong>";
					if($_SESSION['usertype']=="staff" && $pageaccess!=1)
					{
						if($pageaccess==2)
						{
							echo "<a href='$portal_root/#directory/$id' class='hidden'></a>";
						}
						else
						{
							echo "<a href='https://mail.google.com/mail/u/0/?view=cm&fs=1&to=$email&tf=1' class='hidden'></a>";
						}
					}
					else
					{
						echo "<a href='$portal_root/#directory/$id' class='hidden'></a>";
					}
				echo "</td>";
				echo "<td class='hide-on-small-only demotext_dark'>$email</td>";
				echo "<td class='hide-on-small-only demotext_dark'>$location</td>";
				echo "<td class='hide-on-med-and-down demotext_dark'>$title</td>";
			echo "</tr>";
		}
		if($resultcount==0){ 
			echo "<h4>No Results Found</h4>"; 
		}
		else
		{
			echo "</tbody></table>";
		}
		?>
		<script>
			
			$(document).ready(function() 
			{ 
				$("#myTable").tablesorter({ 
					sortList: [[1,0],[3,0]]
    			});
			}); 
			
			$("tr.clickrow").click(function() {
				window.location.href = $(this).find("a").attr("href");
			});
			
			//Email Send click
			$("tr.clickrowemail").click(function() {
				 window.open($(this).find("a").attr("href"), '_blank');
			});
		</script>
		<?php
	}
	
?>