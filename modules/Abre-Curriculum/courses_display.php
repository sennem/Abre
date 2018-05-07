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
	require(dirname(__FILE__) . '/../../core/abre_dbconnect.php');
	require_once('permissions.php');

	if($pagerestrictions=="")
	{
		$sql = "SELECT COUNT(*) FROM curriculum_course";
		$result = $db->query($sql);
		$resultrow = $result->fetch_assoc();
		$numCurriculums = $resultrow["COUNT(*)"];

		if($numCurriculums > 0){
			echo "<div class='page_container'>";
				echo "<div class='row'>";
					echo "<div class='col l12 m12 s12' style='padding:0'>";
						echo "<nav style='background-color:"; echo getSiteColor(); echo ";'>";
								echo "<div class='nav-wrapper'>";
									echo "<form id='form-search' method='post' action='modules/Abre-Curriculum/courses_display_all.php'>";
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

			echo "<div id='displaycourses'>";
				include "courses_display_all.php";
			echo "</div>";
		}else{
			echo "<div class='row' style='padding:56px; text-align:center; width:100%;'><span style='font-size: 22px; font-weight:700'>No Courses Yet</span><br><p style='font-size:16px; margin:20px 0 0 0;'>Click the '+' in the bottom right to create a course.</p></div>";
		}
		include "course_button.php";

		$db->close();
	}
?>

<script>

		//Process the profile form
		$(function(){

			//when clicking pagination button reload table with next page's results
			$('#displaycourses').off('.pagebutton').on('click', '.pagebutton', function(){
				event.preventDefault();
				$('.mdl-layout__content').animate({scrollTop:0}, 0);
				var currentPage = $(this).data('page');
				var searchQuery = $('#searchquery').val();
				$.post( "modules/Abre-Curriculum/courses_display_all.php", {page: currentPage, searchquery: searchQuery})
				.done(function(data){
					$("#displaycourses").html(data);
					mdlregister();
				});
			});

			//Press the search data
			var form = $('#form-search');
			$(form).submit(function(event) {
				event.preventDefault();
				var searchQuery = $('#searchquery').val();
				$.ajax({
				    type: 'POST',
				    data: {searchquery: searchQuery},
				    url: $(form).attr('action'),
				    success: function(data) {
				    	$('#displaycourses').html(data);
							mdlregister();
				    }
				});
			});

		});

</script>