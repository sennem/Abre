<?php

	/*
	* Copyright (C) 2016-2017 Abre.io LLC
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
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once(dirname(__FILE__) . '/../../core/abre_dbconnect.php');

	//Display customized apps for staff
	if($_SESSION['usertype']=="staff")
	{

		//Display Staff Apps
		echo "<div class='row'><p style='text-align:center; font-weight:600;'>Staff Apps</p><hr style='margin-bottom:20px;'>";
		$sql = "SELECT * FROM apps WHERE staff = 1 AND required = 1 order by sort";
		$result = $db->query($sql);
		$item=array();
		while($row = $result->fetch_assoc())
		{
			$title=htmlspecialchars($row["title"], ENT_QUOTES);
			$image=htmlspecialchars($row["image"], ENT_QUOTES);
			$link=htmlspecialchars($row["link"], ENT_QUOTES);
			$minor_disabled=htmlspecialchars($row["minor_disabled"], ENT_QUOTES);
			echo "<ul class='appssort'>";
			if((studentaccess()!=false) or ($minor_disabled!=1))
			{
				$required=array();

				//Get App preference settings (if they exist)
				$sql2 = "SELECT * FROM profiles where email='".$_SESSION['useremail']."'";
				$result2 = $db->query($sql2);
				$apps_order=NULL;
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

				if($apps_order!=NULL)
				{
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
								echo "<li id='item_$id' class='col s4 app' style='display:block; height:110px; overflow:hidden; word-wrap: break-word; margin:0 0 10px 0 !important;'>";
									echo "<img src='$portal_root/core/images/$image' class='appicon_modal'>";
									echo "<span><a href='$link' class='applink truncate' style='display:block;'>$title</a></span>";
								echo "</li>";
							}

					}
				}
				else
				{
						$sql = "SELECT * FROM apps order by sort";
						$result = $db->query($sql);

							while($row = $result->fetch_assoc())
							{
								$id=htmlspecialchars($row["id"], ENT_QUOTES);
								$title=htmlspecialchars($row["title"], ENT_QUOTES);
								$image=htmlspecialchars($row["image"], ENT_QUOTES);
								$link=htmlspecialchars($row["link"], ENT_QUOTES);
								echo "<li id='item_$id' class='col s4 app' style='display:block; height:110px; overflow:hidden; word-wrap: break-word; margin:0 0 10px 0 !important;'>";
									echo "<img src='$portal_root/core/images/$image' class='appicon_modal'>";
									echo "<span><a href='$link' class='applink truncate' style='display:block;'>$title</a></span>";
								echo "</li>";
							}
				}
			}
	    }
	    echo "</ul>";
	    echo "</div>";
	}

	//Display student apps
	if($_SESSION['usertype'] == 'parent'){
		echo "<div class='row'><p style='text-align:center; font-weight:600;'>Parent Apps</p><hr style='margin-bottom:20px;'>";
		$sql2 = "SELECT * FROM apps WHERE parent = 1 AND required = 1 order by sort";
		$result2 = $db->query($sql2);
		while($row2 = $result2->fetch_assoc())
		{
			$id=htmlspecialchars($row2["id"], ENT_QUOTES);
			$title=htmlspecialchars($row2["title"], ENT_QUOTES);
			$image=htmlspecialchars($row2["image"], ENT_QUOTES);
			$link=htmlspecialchars($row2["link"], ENT_QUOTES);
			echo "<div class='col s4 app' style='display:block; height:110px; overflow:hidden; word-wrap: break-word; margin:0 0 10px 0 !important;'><div><img src='$portal_root/core/images/$image' class='appicon_modal'></div><span><a href='$link' class='applink truncate' style='display:block;'>$title</a></span></div>";
		}
		echo "</div>";
	}else{
		echo "<div class='row'><p style='text-align:center; font-weight:600;'>Student Apps</p><hr style='margin-bottom:20px;'>";
		$sql2 = "SELECT * FROM apps WHERE student = 1 AND required = 1 order by sort";
		$result2 = $db->query($sql2);
		while($row2 = $result2->fetch_assoc())
		{
			$id=htmlspecialchars($row2["id"], ENT_QUOTES);
			$title=htmlspecialchars($row2["title"], ENT_QUOTES);
			$image=htmlspecialchars($row2["image"], ENT_QUOTES);
			$link=htmlspecialchars($row2["link"], ENT_QUOTES);
			echo "<div class='col s4 app' style='display:block; height:110px; overflow:hidden; word-wrap: break-word; margin:0 0 10px 0 !important;'><div><img src='$portal_root/core/images/$image' class='appicon_modal'></div><span><a href='$link' class='applink truncate' style='display:block;'>$title</a></span></div>";
		}
		echo "</div>";
	}

	//Display Apps Editor if superadmin
	if(superadmin() && $_SESSION['usertype'] == 'staff')
	{
		echo "<div class='row center-align'><a href='#appeditor' class='modal-editapps waves-effect btn-flat white-text' style='background-color: "; echo sitesettings("sitecolor"); echo "'>Manage</a></div>";
	}

?>

<script>

	$(function()
	{

		//Load Masonry
		function checkWidthapps()
		{
			if ($(window).width() > 600)
			{
				//Sortable settings
				$( ".appssort" ).sortable({
					cursorAt: { top: 25, left: 45 },
					update: function(event, ui){
						var postData = $(this).sortable('serialize');
						<?php
							echo "$.post('$portal_root/modules/apps/apps_save_order.php', {list: postData})";
						?>
						.done(function()
						{
							if (typeof loadOtherCardsApps == 'function')
							{
								loadOtherCardsApps();
							}
						});
					}
				});
			}
		}
		checkWidthapps();

		//Make the Icons Clickable
		$(".app").unbind().click(function(event) {
			event.preventDefault();
			window.open($(this).find("a").attr("href"), '_blank');

		    $("#viewapps_arrow").hide();
		    $('#viewapps').closeModal({ in_duration: 0, out_duration: 0, });
		});

		//Hide truncate on hover
		$(".app").hover(function() {
			$(this).find('.applink').toggleClass("truncate");
		});

		//Apps Modal
		<?php
		if(superadmin())
		{
		?>
		    $('.modal-editapps').leanModal({
				in_duration: 0,
				out_duration: 0,
				ready: function() {
					$('.modal-content').scrollTop(0);
			    	$("#viewapps_arrow").hide();
					$('#viewapps').closeModal({ in_duration: 0, out_duration: 0, });
			    },
			});
		<?php
		}
		?>

	});

</script>
