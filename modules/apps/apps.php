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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php'); 
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php'); 
	
?>

	<!--Display relivant apps for user-->
	<div class='page_container'>
		<div class='row'>
		
			<?php
			//Display both staff and student apps for staff
			if (!empty($_GET["mode"])){ $mode=htmlspecialchars($_GET["mode"], ENT_QUOTES); }else{ $mode=""; }
			if($mode=="")
			{
				//Customized View
				$sql = "SELECT * FROM apps WHERE ".$_SESSION['usertype']." = 1 AND required = 1 order by sort";
				$result = $db->query($sql);
				$item=array();
				while($row = $result->fetch_assoc())
				{
					$title=htmlspecialchars($row["title"], ENT_QUOTES);
					$image=htmlspecialchars($row["image"], ENT_QUOTES);
					$link=htmlspecialchars($row["link"], ENT_QUOTES);
					$minor_disabled=htmlspecialchars($row["minor_disabled"], ENT_QUOTES);
					if((studentaccess()!=false) or ($minor_disabled!=1))
					{
						$required=array();
							
						//Get App preference settings (if they exist)
						$sql2 = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
						$result2 = $db->query($sql2);
						while($row2 = $result2->fetch_assoc()) {
							$apps_order=htmlspecialchars($row2["apps_order"], ENT_QUOTES);
						}
								
						//Build Array of Required Apps
						$sql = "SELECT * FROM apps WHERE ".$_SESSION['usertype']." = 1 AND required = 1";
						$result = $db->query($sql);
						while($row = $result->fetch_assoc())
						{
							$id=htmlspecialchars($row["id"], ENT_QUOTES);									
							array_push($required, $id);
						}
							
						//Display default order, unless they have saved prefrences
						if($apps_order!=NULL)
						{
							$order = explode(',', $apps_order);
						}
						else
						{
							$order=array();
						}
								
						//Compare 
						foreach($required as $key => $requiredvalue)
						{
							$hit=NULL;	
							foreach($order as $key => $ordervalue)
							{
								if($requiredvalue==$ordervalue)
								{
									$hit="yes";
								}
							}
									
							if($hit==NULL)
							{
								array_push($order, $requiredvalue);
							}
						}
								
						foreach($order as $key => $value)
						{
							$sql = "SELECT * FROM apps WHERE id='$value'";
							$result = $db->query($sql);
							while($row = $result->fetch_assoc())
							{
								$id=htmlspecialchars($row["id"], ENT_QUOTES);
								$title=htmlspecialchars($row["title"], ENT_QUOTES);
								$image=htmlspecialchars($row["image"], ENT_QUOTES);
								$link=htmlspecialchars($row["link"], ENT_QUOTES);
								echo "<div class='col l2 m3 s6 app'><div><img src='$portal_root/core/images/$image' class='appicon'></div><span><a href='$link' class='applink truncate'>$title</a></span></div>";
							}
						}	
					}
	    		}
				$db->close();
				
				//Toggle Mode Button
				if($_SESSION['usertype']=="staff")
				{
					echo "<div class='fixed-action-btn buttonpin'>";
						echo "<a class='btn-floating btn-large waves-effect waves-light blue darken-3' href='#apps/student'><i class='large material-icons'>autorenew</i></a>"; 
					echo "</div>";
				}
			}
			else
			{
				$sql2 = "SELECT * FROM apps WHERE student = 1 AND required = 1";
				$result2 = $db->query($sql2);
				while($row2 = $result2->fetch_assoc())
				{
					$id=htmlspecialchars($row2["id"], ENT_QUOTES);
					$title=htmlspecialchars($row2["title"], ENT_QUOTES);
					$image=htmlspecialchars($row2["image"], ENT_QUOTES);
					$link=htmlspecialchars($row2["link"], ENT_QUOTES);
					echo "<div class='col l2 m3 s6 app'><div><img src='$portal_root/core/images/$image' class='appicon'></div><span><a href='$link' class='applink truncate'>$title</a></span></div>";
				}
				
				if($_SESSION['usertype']=="staff")
				{
					echo "<div class='fixed-action-btn buttonpin'>";
						echo "<a class='btn-floating btn-large waves-effect waves-light blue darken-3' href='#apps'><i class='large material-icons'>autorenew</i></a>"; 
					echo "</div>";
				}
			}
			?>
	
		</div>
	</div>

<script>
	
	$(document).ready(function(){	
		
		//Make the Icons Clickable
		$(".app").click(function() {
			 window.open($(this).find("a").attr("href"), '_blank');
		});
		
	});
	
</script>