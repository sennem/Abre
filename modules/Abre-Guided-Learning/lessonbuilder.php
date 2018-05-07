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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once(dirname(__FILE__) . '/../../core/abre_functions.php');
	require_once('permissions.php');

	if($pagerestrictions == ""){
		$currentuser = $_SESSION['useremail'];
		$sql3 = "SELECT COUNT(*) FROM guide_boards WHERE creator = '$currentuser' ORDER BY ID";
		$result3 = $db->query($sql3);
		$resultrow = $result3->fetch_assoc();
		$numrows3 = $resultrow["COUNT(*)"];
		if($numrows3 != 0){
?>
			<div class='page_container mdl-shadow--4dp'>
			<div class='page'>
				<div id='searchresults'>
						<div class='row'><div class='col s12'>
							<table id='myTable' class='tablesorter'>
								<thead>
									<tr class='pointer'>
										<th>Lesson Title</th>
										<th>Coupon Code</th>
										<th style='width:30px'></th>
										<th style='width:30px'></th>
										<th style='width:30px'></th>
									</tr>
								</thead>
								<tbody>

								<?php
								$sql = "SELECT ID, Title, Code FROM guide_boards WHERE creator = '$currentuser' ORDER BY ID";
								$result = $db->query($sql);
								while($row = $result->fetch_assoc()){
									$Board_ID = htmlspecialchars($row["ID"], ENT_QUOTES);
									$Title = html_entity_decode($row["Title"]);
									$Code = htmlspecialchars($row["Code"], ENT_QUOTES);
										echo "<tr>";
											echo "<td>$Title</td>";
											echo "<td> <a class='modal-guidedlearningcode' href='#guidedlearningcode' style='color:".getSiteColor().";' data-code='$Code'>$Code</a></td>";

											$sql2 = "SELECT Data FROM guide_links WHERE Board_ID = '$Board_ID' LIMIT 1";
											$result2 = $db->query($sql2);
											while($row2 = $result2->fetch_assoc()){
												$data = $row2["Data"];
												$json = json_decode($data, true);

												$website_1 = html_entity_decode($json['Website 1']); $website_2 = html_entity_decode($json['Website 2']);
												$website_3 = html_entity_decode($json['Website 3']); $website_4 = html_entity_decode($json['Website 4']);
												$website_5 = html_entity_decode($json['Website 5']); $website_6 = html_entity_decode($json['Website 6']);
												$website_7 = html_entity_decode($json['Website 7']); $website_8 = html_entity_decode($json['Website 8']);

												$link_1 = $json['Link 1']; $link_2 = $json['Link 2'];
												$link_3 = $json['Link 3']; $link_4 = $json['Link 4'];
												$link_5 = $json['Link 5']; $link_6 = $json['Link 6'];
												$link_7 = $json['Link 7']; $link_8 = $json['Link 8'];
												$favorite = $json['Favorite'];
												$RestrictionMode = $json['RestrictionMode'];

												echo "<td width=30px><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 modal-newguidedlearningsession' href='#newguidedlearningsession' data-lessontitle='$Title' data-lessonid='$Board_ID' data-website_1='$website_1' data-website_2='$website_2' data-website_3='$website_3' data-website_4='$website_4' data-website_5='$website_5' data-website_6='$website_6' data-website_7='$website_7' data-website_8='$website_8' data-link_1='$link_1' data-link_2='$link_2' data-link_3='$link_3' data-link_4='$link_4' data-link_5='$link_5' data-link_6='$link_6' data-link_7='$link_7' data-link_8='$link_8' data-favorite='$favorite' data-restriction='$RestrictionMode'><i class='material-icons'>mode_edit</i></button></td>";
											}

											echo "<td width=30px><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 deletebook'><a href='modules/".basename(__DIR__)."/deletelesson.php?id=$Board_ID'></a><i class='material-icons'>delete</i></button></td>";
											echo "<td width=30px><button class='mdl-button mdl-js-button mdl-button--icon mdl-color-text--grey-600 activity' data='#guide/users/$Code'><i class='material-icons'>info_outline</i></button></td>";
										echo "</tr>";
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
			</div>
			</div>
		</div>
		<?php
		}else{
			echo "<div style='padding:30px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Guided Lessons</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the '+' in the bottom right to create a guided lesson.</p></div>";
		}

		echo "<div class='row center-align'><div class='col s12'>Want to watch a demo? Check out the demo video <a href='https://abre.io/resources/guidedlearning/' target='_blank' style='color: ".getSiteColor()."'>here</a>.</div></div>";

		?>

<script>

		$('.modal-newguidedlearningsession').leanModal({ in_duration: 0, out_duration: 0, ready: function() { $('.modal-content').scrollTop(0); } });
		$('.modal-guidedlearningcode').leanModal({ in_duration: 0, out_duration: 0, ready: function() { $('.modal-content').scrollTop(0); } });

	   	$("#myTable").tablesorter({
			//sortList: [[1,0],[3,0]]
    	});

			$(document).on("click", ".modal-newguidedlearningsession", function () {
				var Lesson_ID= $(this).data('lessonid');
				$(".modal-content #lesson_id").val(Lesson_ID);
				var Lesson_Title= $(this).data('lessontitle');
			    $(".modal-content #lesson_title").val(Lesson_Title);
			    var Website_Title_1 = $(this).data('website_1'); $(".modal-content #website_title_0").val(Website_Title_1);
			    var Website_Title_2 = $(this).data('website_2'); $(".modal-content #website_title_1").val(Website_Title_2);
			    var Website_Title_3 = $(this).data('website_3'); $(".modal-content #website_title_2").val(Website_Title_3);
			    var Website_Title_4 = $(this).data('website_4'); $(".modal-content #website_title_3").val(Website_Title_4);
			    var Website_Title_5 = $(this).data('website_5'); $(".modal-content #website_title_4").val(Website_Title_5);
			    var Website_Title_6 = $(this).data('website_6'); $(".modal-content #website_title_5").val(Website_Title_6);
			    var Website_Title_7 = $(this).data('website_7'); $(".modal-content #website_title_6").val(Website_Title_7);
			    var Website_Title_8 = $(this).data('website_8'); $(".modal-content #website_title_7").val(Website_Title_8);
			    var Website_Link_1 = $(this).data('link_1'); $(".modal-content #website_link_0").val(Website_Link_1);
			    var Website_Link_2 = $(this).data('link_2'); $(".modal-content #website_link_1").val(Website_Link_2);
			    var Website_Link_3 = $(this).data('link_3'); $(".modal-content #website_link_2").val(Website_Link_3);
			    var Website_Link_4 = $(this).data('link_4'); $(".modal-content #website_link_3").val(Website_Link_4);
			    var Website_Link_5 = $(this).data('link_5'); $(".modal-content #website_link_4").val(Website_Link_5);
			    var Website_Link_6 = $(this).data('link_6'); $(".modal-content #website_link_5").val(Website_Link_6);
			    var Website_Link_7 = $(this).data('link_7'); $(".modal-content #website_link_6").val(Website_Link_7);
			    var Website_Link_8 = $(this).data('link_8'); $(".modal-content #website_link_7").val(Website_Link_8);
			    var Favorite = $(this).data('favorite'); $(".modal-content #favorite_link").val(Favorite);
			    var RestrictionMode = $(this).data('restriction');
			    if(RestrictionMode === ""){ $('select>option:eq(0)').attr('selected', true); }
			    if(RestrictionMode === "Low"){ $('select>option:eq(1)').attr('selected', true); }
			    if(RestrictionMode === "High"){ $('select>option:eq(2)').attr('selected', true); }
			    $('#restrictionsetting').val(RestrictionMode);
			});

			$(document).on("click", ".modal-guidedlearningcode", function () {
				var code = $(this).data('code');
				$(".modal-content #codeHolder").text(code);
			});

			//Permanently Delete User
			$(".deletebook").click(function(){
				var result = confirm("Want to permanently delete this lesson?");
				if(result){
					//$(this).closest( "tr" ).hide();
					var address = $(this).find("a").attr("href");
					$.ajax({
						type: 'POST',
						url: address,
						data: '',
					})

					//Show the notification
					.done(function(response) {
						var notification = document.querySelector('.mdl-js-snackbar');
						var data = { message: response };
						notification.MaterialSnackbar.showSnackbar(data);
						$("#lessonbuilderdiv").load( "modules/<?php echo basename(__DIR__); ?>/lessonbuilder.php", function(response)
						{
							mdlregister();
						});
					})
				}
			});

			//Permanently Delete User
			$(".activity").click(function(){
				window.open($(this).attr("data"), '_self');
			});

</script>

<?php
	include "newlessonbutton.php";
}
?>