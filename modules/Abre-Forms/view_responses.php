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
	require(dirname(__FILE__) . '/../../configuration.php');
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('functions.php');

	//Get Variables Passed to Page
	if(isset($_GET["id"])){ $id=htmlspecialchars($_GET["id"], ENT_QUOTES); }else{ $id=""; }

	if(($_SESSION['usertype'] == "staff" || admin() || isFormsAdministrator()) && (hasResponseAccess($id) || hasEditAccess($id)))
	{

		$sql = "SELECT COUNT(*) FROM forms_responses WHERE FormID = '$id'";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$numrows = $row["COUNT(*)"];

		if($numrows > 0){
			echo "<div class='page_container'>";
				echo "<div class='row'>";
					echo "<div class='col l12 m12 s12' style='padding:0'>";
						echo "<nav style='background-color:"; echo getSiteColor(); echo ";'>";
								echo "<div class='nav-wrapper'>";
									echo "<form id='form-search' method='post' action='modules/Abre-Forms/view_responses_display.php'>";
										echo "<div class='input-field'>";
											echo "<input id='searchquery' type='search' placeholder='Search' autocomplete='off'>";
											echo "<label class='label-icon' for='searchquery'><i class='material-icons'>search</i></label>";
										echo "</div>";
									echo "</form>";
								echo "</div>";
						echo "</nav>";
					echo "</div>";
				echo "</div>";
			echo "</div>";

			echo "<div id='displayforms'>";

				include "view_responses_display.php";

			echo "</div>";

		}else{
			echo "<div class='row center-align'>";
					echo "<div class='widget' style='padding:30px; text-align:center; width:100%;'><p style='font-size: 22px; font-weight:700;'>No Responses Yet</p></div>";
			echo "</div>";
		}
		
	}
	else
	{

		echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>You Do Not Have Response Access</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Please request access from the form owner.</p></div>";

	}
?>

<script>

		//Process the profile form
		$(function(){

			var formid = "<?php echo $id ?>";

			//when clicking pagination button reload table with next page's results
			$('#displayforms').off('.pagebutton').on('click', '.pagebutton', function(){
				event.preventDefault();
				$('.mdl-layout__content').animate({scrollTop:0}, 0);
				var currentPage = $(this).data('page');
				var formid = $(this).data('formid');
				var searchQuery = $('#searchquery').val();
				$.post( "modules/Abre-Forms/view_responses_display.php", {page: currentPage, searchquery: searchQuery, formid: formid})
				.done(function(data){
					$("#displayforms").html(data);
					mdlregister();
				});
			});

			//view entry
			$('#displayforms').off('.viewentry').on('click', '.viewentry', function(){
				event.preventDefault();
				var title = $(this).data('title');
				var formid = $(this).data('formid');
				var entryid = $(this).data('entryid');
				$("#formentryloader").show();
				$("#entrymodaltitle").text(title);
				$('#formentry').openModal({
				in_duration: 0,
				out_duration: 0,
					ready: function() {

						//load the response
						$( "#entrymodalbody" ).load('/modules/Abre-Forms/view_entry.php?id='+formid+'&entryid='+entryid, function() {
							mdlregister();
							$("#formentryloader").hide();
						});

				    }
				});
			});

			//Press the search data
			var form = $('#form-search');
			$(form).submit(function(event) {
				event.preventDefault();
				var searchQuery = $('#searchquery').val();
				$.ajax({
				    type: 'POST',
				    data: {searchquery: searchQuery, formid: formid},
				    url: $(form).attr('action'),
				    success: function(data) {
				    	$('#displayforms').html(data);
						mdlregister();
				    }
				});
			});

			//Delete entry
			$('#displayforms').off('.deleteentry').on('click', '.deleteentry', function(event){
				event.preventDefault();
				var formresponseid = $(this).data("formresponseid");
				var formid = $(this).data("formid");
				var formholder = $(this).closest('.formholder');

				//Delete the Form with confirmation
				var result = confirm("Are you sure you want to delete this response?");
				if (result) {

					$.post("/modules/Abre-Forms/action_deleteresponse.php", { id: formresponseid })

					.done(function(data){

						$("#responseCount").load("modules/<?php echo basename(__DIR__); ?>/response_count.php", {formid: formid}, function(){ });

						$.post("/modules/Abre-Forms/view_responses_display.php", { formid: formid })
						.done(function( data ){
							$("#displayforms").html(data);
							mdlregister();
						});
					});
				}
			});

		});

</script>